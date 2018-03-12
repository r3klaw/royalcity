<?php

use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_employee=Role::where('name','admin')->first();

        $employee=new User();
        $employee->name="Admin";
        $employee->email="admin@example.com";
        $employee->password=bcrypt('secret');
        $employee->save();
        $employee->roles()->attach($role_employee);
    }
}
