<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {  
        factory(User::class)->state('john-doe')->create();  // is User Model
        factory(User::class, 20)->create(); // Is a Collection
    }
}
