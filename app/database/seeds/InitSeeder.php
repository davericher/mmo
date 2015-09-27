<?php
use Irony\Entities\Item;
use Irony\Entities\User;
use Irony\Entities\Category;


class InitSeeder extends Seeder {
	public function run()
	{

		$user = User::create([
			'username' 	=> Config::get('site.adminLogin'),
		    'firstname' => Config::get('site.adminFirstName'),
		    'lastname' 	=> Config::get('site.adminLastName'),
		    'email' 	=> Config::get('site.adminEmail'),
		    'password' 	=> Config::get('site.adminPassword'),
		    'password_confirmation'	=> Config::get('site.adminPassword'),
		    'active' 	=> true
		]);


		$root = Role::create([
			'name' => 'Root'
		]);

		$admin = Role::create([
			'name' => 'Admin'
		]);

		$moderator = Role::create([
			'name' => 'Moderator'
		]);

		$perm1 = Permission::create([
			'name' => 'manage_users',
			'display_name' => 'Can alter user accounts'
		]);

		$perm2 = Permission::create([
			'name' => 'manage_items',
			'display_name' => 'Can modify items'
		]);

		/* Attach Roles to Permissions */
		$root->attachPermission($perm1);
		$root->attachPermission($perm2);

		$admin->attachPermission($perm1);
		$admin->attachPermission($perm2);

		$moderator->attachPermission($perm2);

		/* Attach user to Role */
		$user->attachRole($root);

        $Categories = [
            'other','art','baby items','bikes','books','business','photography','cds',
            'dvds','blu-ray','clothing','computers','computer accessories','electronics',
            'furniture','health care','crafts','home appliances','building materials',
            'portable music players','jewellery', 'musical instruments','phones',
            'sporting goods','exercise','tools','toys','games','video games','video game consoles',
            'video game accessories', 'cars','trucks','Sport utility vehicles','vans','classic cars',
            'auto parts', 'motorcycles','atvs','snowmobiles','Recreational vehicles','pets'
        ];

        /*Create initial Category*/
        foreach ($Categories as $Category)
        {
            $cat = new Category();
            $cat->name = ucwords($Category);
            $cat->save();
        }
	}

}

