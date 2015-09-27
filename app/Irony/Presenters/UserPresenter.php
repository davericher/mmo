<?php namespace Irony\Presenters;

	use  Illuminate\Support\Str;

    /**
     * Class UserPresenter
     * Notes: provides a layer between view and controller
     * @package Irony\Presenters
     */
    class UserPresenter extends Presenter
	{
        /**
         * @return string
         */
        public function roles()
		{
			$return = '';
			foreach ($this->entity->roles as $Role)
			{
				$return .= $Role->name . ' ';
			}
			return $return;
		}

        /**
         * @param bool $plural True for pluralized
         * @return string
         */
        public function username($plural = false)
		{
			if (!$plural)
				return ucwords($this->entity->username);
			else
				return ucwords(Str::plural($this->entity->username));
		}


        /**
         * @return string
         */
        public function fullname()
		{
			return ucfirst($this->entity->firstname). ' ' . ucfirst($this->entity->lastname);
		}

        /**
         * @return string
         */
        public function active()
		{
			switch ($this->entity->active)
			{
				case true:
					return 'Active';
				case false:
					return 'Inactive';
				default:
					return 'Unknown';
			}
		}

        /**
         * @return string
         * todo:this should go somewhere else
         */
        public function showUrl()
		{
			return route('admin.users.show',$this->entity->id);
		}

        public function avatarSrc($style = "original")
        {
            return $this->entity->avatar->url($style);
        }
	}
