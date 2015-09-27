<?php

/**
 * Class BaseController
 * Controls static based pages
 */
class BaseController extends Controller {

    /**
     * Construct with built in CSRF and AJAX filters
     */
    public function __construct()
    {
        $this->beforeFilter('csrf', [
        'on' => [
            'post',
            'put',
            'patch',
            'delete'
        ],
        'except' => [
            'postBack'
        ]
    ]);
    }

    /**
     * Dynamically create a breadcrumb
     * @param $route
     * @param $label
     * @param $id
     * @param null $parentRoute
     * @param null $parentId
     */
    protected static function buildCrumbByID(
        $route,
        $label,
        $id,
        $parentRoute = null,
        $parentId = null
    )
    {
        Breadcrumbs::register($route, function ($breadcrumbs) use ($route, $label, $id, $parentRoute, $parentId) {
            if (!is_null($parentRoute) and is_null($parentId))
                $breadcrumbs->parent($parentRoute);
            if (!is_null($parentRoute) and !is_null($parentId))
                $breadcrumbs->parent($parentRoute, $parentId);
            $breadcrumbs->push($label, route($route, $id));
        });
    }

    /**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
			$this->layout = View::make($this->layout);
	}

    /**
     * Redirect post loop for Session From Inputs functionality
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postBack()
    {
        return Redirect::back();
    }

}