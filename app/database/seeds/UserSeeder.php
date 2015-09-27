<?php
use Irony\Entities\User;

class UserSeeder extends Seeder {
	public function run()
	{
        Eloquent::unguard();
        $faker = Faker\Factory::create();

		foreach(range(2, 100) as $index)
		{
			$password = $faker->text(8);
			User::create([
				'username' 	=> $faker->username,			
			    'firstname' => $faker->firstName,
			    'lastname' 	=> $faker->lastName,
			    'email' 	=> 	$faker->email,
			    'password' 	=> 	$password,
			    'password_confirmation'	=> $password,
			    'active' 	=> $faker->boolean(80),
			    'token'		=> $faker->optional(0.9)->sha256
			]);
		}
	}

}