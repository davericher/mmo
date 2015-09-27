<?php


use Illuminate\Database\Migrations\Migration;

/**
 * Class CreateUsersTable
 * Create the Users table
 */
class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
    		$table->increments('id');
    		$table->string('username', 20)->unique()->index();
    		$table->string('email', 100)->unique();
		    $table->string('firstname', 20);
    		$table->string('lastname', 20);
    		$table->string('password', 64);
    		$table->boolean('active')->default(false);
    		$table->string('token',64)->nullable();
            $table->string('remember_token', 100)->nullable();
    		$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::drop('users');
    }

}
