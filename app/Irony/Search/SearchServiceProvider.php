<?php namespace Irony\Search;

use Illuminate\Support\ServiceProvider;

class SearchServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind('search','Irony\Search\Search');
    }
}