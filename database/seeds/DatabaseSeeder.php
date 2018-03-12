<?php

use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        //Role comes before user seeder heree
        $this->call(Role::class);
        //User seeder will use the roles above created
        $this->call(User::class);
    }
}
