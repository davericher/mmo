<?php
use Irony\Entities\Item;
use Irony\Entities\User;
use Irony\Entities\Comment;
use Irony\Entities\Category;

/**
 * Class HomeController
 *
 */
class HomeController extends \BaseController
{
    /**
     * The amount of time to cache the frontpage content
     * @var int
     */
    protected static $cacheTime = 3600; //Set Cache time to one hour

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getHome()
	{
        //Recent Items
        $items = Item::with('images')->orderby('created_at','desc')->limit(4)->get();
		return View::make('index')
            ->withItems($items)             // Recent Items
            ->withIsShort(true);                // Short form on recent items
 	}
    public function getStats()
    {

        //Statistical information
        $item_amounts = Item::remember(static::$cacheTime)->get(['amount']);
        $item_count = $item_amounts->count();
        $comment_count = Comment::remember(static::$cacheTime)->count();
        $category_count = Category::remember(static::$cacheTime)->count();
        $moneyToK = moneyToK($item_amounts->sum('amount'));
        $user_count = User::remember(static::$cacheTime)->count();
        return View::make('stats')
            ->withUserCount($user_count)    // Total Users
            ->withHomeMoney($moneyToK)    // Total Market Value
            ->withItemCount($item_count)    // Total amount of items
            ->withCommentCount($comment_count) // Total Comments
            ->withIsShort(true)                // Short form on recent items
            ->withCategoryCount($category_count);

    }
}