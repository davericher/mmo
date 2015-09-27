<?php namespace Irony\Search;
    use Irony\Entities\User;
    use Irony\Entities\Item;

    /**
     * Class Search
     * Search Provider
     * todo: Implement site wide search functionality via laracast lesson 73
     * @package Irony\Search
     *
     */

    class Search
    {
        /** User Entity search
         * @param $search
         * @return mixed
         */
        public function users($search)
        {
            return User::search($search)->get();

        }

        /** Item Entity Search
         * @param $search
         * @return mixed
         */
        public function items($search)
        {
            return Item::search($search)->get();
        }

    }

