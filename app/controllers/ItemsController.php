<?php
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Irony\Entities\Item;
use Irony\Entities\Category;

use Irony\Services\Exceptions\ItemNotFoundException;
use Irony\Services\Exceptions\ItemPhotoNotFoundException;
use Irony\Services\Exceptions\ItemServiceException;
use Irony\Services\Exceptions\ImageValidationException;

use Irony\Services\ItemServices;
use Irony\Services\SessionService;
/**
 * Class ItemsController
 * HTML Transport layer between items Model and Views
 */
class ItemsController extends \BaseController {
    protected $ItemServices;
    protected $orderSort;
    protected $orderField;
    protected $categories;
    // Amount of time to cache categories , 24hours
    protected static $categoryCacheTime = 86400;


    /** Constructor with ItemServices dep Injection */
    public function __construct(ItemServices $ItemServices, SessionService $SessionServices)
    {
        parent::__construct();
        $this->ItemServices = $ItemServices;

        // Auto generated Session variables
        $this->orderSort = $SessionServices->setInput('itemsSortOrder','desc','in:asc,desc');
        $this->orderField = $SessionServices->setInput('itemsGroupBy','created_at','in:amount,name,created_at,updated_at');

        // Build Categories from DB and cache
        $this->categories = Category::remember(static::$categoryCacheTime)
            ->get(['id','name'])
            ->sortBy('id');

        $this->beforeFilter('auth',[
            'only' => [
                'create',
                'store',
                'edit',
                'update',
                'destroy'
            ]
        ]);
        $this->beforeFilter('canManageItem',[
            'only' => [
                'update',
                'edit',
                'destroy'
            ]
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @param null $catslug
     * @return Response
     */
	public function index($catslug = null)
	{
        //Get the amount of items per page
        $paginate = ItemServices::$paginate;

        //Begin Query by eager loading Relationships
        $items = Item::with('user','images','category');

        //Check to see if this is a sub market with a category specified
        if (!is_null($catslug))
        {
            if  (is_null($slugID = $this->getCategory($catslug)))
                return Redirect::route('marketplace')->withError('That Market does not exists');
            else
            {
                $items = $items->where('category_id',$slugID->id);
                $submarket = $slugID->name;
                static::buildCrumbByID('submarket',$slugID->name,$slugID->slug,'marketplace');
            }
        }

        //Check to see if there is a query string, if so append it
        if ($search = Input::get('q'))
            $items = $items->search($search);

        //Order by Session variables
        $items = $items->orderBy($this->orderField,$this->orderSort);

        //Paginate the results
        $items = $items->paginate($paginate);

        //Check to see if the user is logged in, if they are check to see if they can manage items
        $is_admin = (Auth::check() and Auth::user()->can("manage_items")) ? true : null ;

        // Return view
        return View::make('items.index')
            ->withIsAdmin($is_admin) // Is able to administer items
            ->withItems($items)
            ->withSubmarket(isset($submarket) ? $submarket : null);
    }

    /**
     * Extract the ID of a category from collection based on its slug attribute
     * @param $slug
     * @return int|null|string
     */
    private function getCategory($slug)
    {
        foreach ($this->categories as $category )
            if ($category->slug == $slug)  return $category;
        return null;
    }

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        Former::withRules(array_merge(Item::$rules,Item::$photoRules));

        // Return view
        return View::make('items.create')->withCategories($this->categories);
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
        try {
            $item = $this->ItemServices->create(
               Auth::user(),
               Input::all()
            );
        } catch (ItemServiceException $e)
        {
            return Redirect::back()->withErrors($e->errors())->withInput();
        } catch (ImageValidationException $e)
        {
            return Redirect::back()->withErrors($e->errors())->withInput();
        }
        return Redirect::route('submarket',$item->category->slug)->withMessage(Lang::get('items.posted'));
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        try
        {
            //Create the item
            $item = Item::with('user','images','category')->findOrFail($id);

            // Dynamically register the breadcrumb
            static::buildCrumbByID('submarket',$item->category->name,$item->category->slug,'marketplace');
            static::buildCrumbByID('items.show',$item->present->name,$item->id,'submarket');

            // Check to see if active user can manage or edit this item
            $is_admin = (Auth::check() and Auth::user()->can("manage_items")) ? true : null ;

            // Grab the comments
            $comments = $item->comments()
                ->with('user')
                ->orderBy('created_at','desc')
                ->paginate(ItemServices::$commentsPaginate);

            return View::make('items.show')
                ->withItem($item)
                ->withComments($comments)
                ->withIsAdmin($is_admin);
        } catch (ModelNotFoundException $e)
        {
            return Redirect::route('items.index')->withError(Lang::get('items.missing'));
        }
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        try {
            // Create the Item
            $item = Item::with(['images','category' => function ($query) {
                    $query->get(['id','name']);
                }])->findOrFail($id);

            // Drill down breadcrumbs
            static::buildCrumbByID('submarket',$item->category->name,$item->category->slug,'marketplace');
            static::buildCrumbByID('items.show',$item->present->name,$item->id,'submarket');
            static::buildCrumbByID('items.edit','Update',$item->id, 'items.show',$item->id);

            // Set Former Rules
            Former::withRules(array_merge(Item::$rules,Item::$photoUpdateRules));

            // Return view
            return View::make('items.edit')
                ->withItem($item)
                ->withCategories($this->categories);
        } catch (ModelNotFoundException $e)
        {
            return Redirect::route('items.show',$id)
                ->withError(Lang::get('items.posted'));
        }
	}


    /**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
        try {
            $this->ItemServices->update(
                $id,
                Input::all()
            );
        } catch (ItemServiceException $e)
        {
            return Redirect::back()->withErrors($e->errors())->withInput();
        } catch (ImageValidationException $e)
        {
            return Redirect::back()->withErrors($e->errors())->withInput();
        } catch (ItemNotFoundException $e)
        {
           return Redirect::back()->withError(Lang::get('items.missing'));
        }

        return Redirect::route('items.show',$id)->withMessage(Lang::get('items.updated'));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
        try {
            $this->ItemServices->destroy($id);
            if (Input::get('_route') == 'items.show')
                return Redirect::to(Input::get('_redirect'))->withMessage(Lang::get('items.deleted'));
            else
                return Redirect::back()->withMessage(Lang::get('items.deleted'));

        } catch (ItemNotFoundException $e)
        {
            //return static::backWithErrors(Lang::get('items.missing'));
            return Redirect::back()->withError(Lang::get('items.missing'));
        }
    }

}