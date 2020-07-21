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
        $userCount = (int)$this->command->ask('How many users would you like do generate?', 20);
        factory(User::class)->state('john-doe')->create();  // is User Model
        factory(User::class, $userCount)->create(); // Is a Collection
    }
}
