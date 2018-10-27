<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
    	factory(App\User::class, 10)->create();
    	factory(App\Channel::class, 10)->create();
    	factory(App\Thread::class, 50)->create();
        factory(App\Comment::class, 100)->create();
        factory(App\Like::class, 100)->create();
        // $this->call(UsersTableSeeder::class);
    }
}
