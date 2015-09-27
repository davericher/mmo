<?php
/**
 * Returns a html class insert if current route matches
 * named routes provided
 *
 * @param $paths
 * @param string $active default active
 * @param string $blurred default empty
 * @return string
 */
function set_active($paths, $active='active',$blurred = '')
	{
        if (!is_string($paths) and !is_array($paths))
            return $blurred;
        if (is_string($paths))
            $paths = explode(' ',$paths);
        foreach($paths as $path)
        {
            if (Route::currentRouteName() == $path) $state = true;
        }
        if (isset($state)) return $active;
        return $blurred;
	}


/**
 * Site Wide money format
 *
 * Format money in dollar amount
 * @param $amount Dollar amount
 * @param bool $decimals include decimals, default is false
 * @return string
 */
function money($amount,$decimals = false)
{
    if ($decimals)
        return money_format('$%i', (float) $amount);
    return money_format('$%.0n', (float) $amount);
}

/**
 * Displays money on home page, divides by thousand
 *
 * @param $amount
 * @return string
 */
function moneyToK($amount)
{
    $output = '$';

    if ($amount >= 1000)
    {
        $output .= round($amount / 1000);
        $output .= 'K';
    }
    else
        $output .= $amount;

    return $output;
}

/**
 * Upper case sentences
 * Changes the first letter of every word in a new sentence to a capital.
 *
 * @param $string
 * @return string
 */
function ucsentence($string) {
    $sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE);
    $new_string = '';
    foreach ($sentences as $key => $sentence) {
        $new_string .= ($key & 1) == 0?
            ucfirst(strtolower(trim($sentence))) :
            $sentence.' ';
    }
    //Take care of the lower case single word I's
    $new_string = preg_replace("/\bi\b/", "I", $new_string);
    return trim($new_string);
}

/**
 * Appends a hash anchor to a url
 *
 * @param $url
 * @param $hash
 * @param bool $dropQuery default false Drops the query string
 * @return string
 */
function hash_link($url,$hash,$dropQuery = false)
{
    return $dropQuery ? clear_query_string($url) . '#' . $hash : $url . '#' . $hash;
}

/**
 * Remove the query string
 *
 * @param $url
 * @return string
 */
function clear_query_string($url)
{
    return strtok($url,'?');
}

/**
 * Returns true if user Can edit posts
 *
 * @param $comment_user_id
 * @param $item_user_id
 * @param \Illuminate\Auth\UserInterface $auth_user
 * @return bool
 */
function can_edit_posts( $comment_user_id, $item_user_id, $auth_user)
{
    return
        !is_null($auth_user)
        and ($comment_user_id == $auth_user->id
        or $item_user_id == $auth_user->id
        or $auth_user->can('manage_items'));
}

/**
 * Returns true if a user is logged in, and his Id matches the Id of the object
 *
 * in question.
 * @param $ForeignUserIds
 * @internal param $ForeignUserId
 * @return bool
 */
function authIsOwner($ForeignUserIds)
{
    if (is_array($ForeignUserIds))
        return Auth::check() and authIsOwnerArray($ForeignUserIds);
    return Auth::check() and $ForeignUserIds == Auth::user()->id;
}

/**
 * @inheritdoc
 * @param array $ForeignUserIds
 * @return bool
 */
function authIsOwnerArray(array $ForeignUserIds)
{
    $userId = Auth::user()->id;
    $state = false;
    foreach($ForeignUserIds as $ForeignUserId)
    {
        $ForeignUserId == $userId ? $state = true : $state = false;
    }
    return $state;
}

function avatar_src(Irony\Entities\Item $item,$style = 'original')
{
    return $item->images->first()->image->url($style);
}
