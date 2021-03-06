<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('user', function($table){
			$table->increments('id');
			$table->string('name');
			$table->string('password');
			$table->string('type');
			$table->timestamps();
		});
		Schema::create('office', function($table){
			$table->string('value',100);
			$table->integer('shared')->unsigned();
			$table->timestamps();
			
			$table->primary('value');
		});
		Schema::create('semester', function($table){
			$table->string('value',100);
			$table->timestamps();
			
			$table->primary('value');
		});
		Schema::create('category', function($table){
			$table->increments('id');
			$table->integer('parent_id')->unsigned();
			$table->string('name');
			$table->string('office',100);
			$table->timestamps();
		});
		Schema::create('data', function($table){
			$table->increments('id');
			$table->integer('category_id')->unsigned();
			$table->string('semester',100);
			$table->integer('year')->unsigned()->nullable();
			$table->integer('month')->unsigned()->nullable();
			$table->string('name');
			$table->timestamps();
		});				
		Schema::create('data_attribute', function($table){
			$table->increments('id');
			$table->integer('data_id')->unsigned();
			$table->string('name');
			$table->string('value')->nullable();
			$table->string('file')->nullable();
			$table->string('url',1023)->nullable();
			$table->string('type');
			$table->timestamps();			
		});		
		Schema::create('user_office', function($table){
			$table->integer('user_id')->unsigned();
			$table->string('office',100);
			$table->timestamps();
			
			$table->primary(['user_id','office']);
		});
		
		// foreign keys
		Schema::table('category', function($table){
			$table->foreign('office')->references('value')->on('office');
		});
		Schema::table('data', function($table){
			$table->foreign('category_id')->references('id')->on('category');
			$table->foreign('semester')->references('value')->on('semester');
		});			
		Schema::table('data_attribute', function($table){
			$table->foreign('data_id')->references('id')->on('data');
		});		
		Schema::table('user_office', function($table){
			$table->foreign('user_id')->references('id')->on('user');
			$table->foreign('office')->references('value')->on('office');
		});
	}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
		Schema::drop('user_office');
		Schema::drop('data_attribute');
		Schema::drop('data');
		Schema::drop('category');
		
		Schema::drop('user');
		Schema::drop('office');
		Schema::drop('semester');
    }
}
