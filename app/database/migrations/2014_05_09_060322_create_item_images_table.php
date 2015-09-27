<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateItemImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('item_images', function(Blueprint $table)
		{
            $table->increments('id');
            $table->integer('item_id')->unsigned();
            $table->string("image_file_name")->nullable();
            $table->integer("image_file_size")->nullable();
            $table->string("image_content_type")->nullable();
            $table->text("image_description")->nullable();
            $table->timestamp("image_updated_at")->nullable();
            $table->timestamps();
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade')->onUpdate('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('item_images');
	}

}
