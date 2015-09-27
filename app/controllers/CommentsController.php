<?php
use Irony\Entities\Comment;
use Irony\Entities\Item;


class CommentsController extends \BaseController {

    /** Constructor*/
    public function __construct()
    {
        parent::__construct();

        $this->beforeFilter('auth', [
            'except' => [
                'create',
                'destroy'
            ]
        ]);
        $this->beforeFilter('canManageComments',[
            'only' => [
                'create',
                'destroy'
            ]
        ]);

    }

    /**
     * Store a newly created resource in storage.
     * POST /comments
     *
     * @param $item_id
     * @return Response
     */
	public function store($item_id = null)
	{
        // Grab the Item to associate to comment
        if (is_null($item_id) or empty($item = Item::find($item_id,['id'])) )
            return Redirect::back()->withError('Cannot find required Item to attach comment');

        // Create Comment
        $comment = new Comment;
        $comment->user()->associate(Auth::user());
        $comment->item()->associate($item);
        $comment->body = Input::get('body');

        // Attempt save
        if ($comment->save())
        {
            // Generate Url with Hash link
            $url = hash_link(route('items.show',$item->id),'comments',true);
            return Redirect::to($url)->withMessage('Your comment has been posted');
        }

        //Redirect with errors
        return Redirect::back()->withErrors($comment->errors()->all());
	}

	/**
	 * Remove the specified resource from storage.
	 * DELETE /comments/{id}
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id = null)
	{
        // Grab the Item to associate to comment
        if (is_null($id) or empty($comment = Comment::find($id)) )
            return Redirect::back()->withError('Cannot find required Item to attach comment');

        $comment->delete();
        return Redirect::back()->withMessage('Comment Deleted');
	}

}