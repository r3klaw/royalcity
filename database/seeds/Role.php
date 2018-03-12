<?php

use Illuminate\Database\Seeder;

class Role extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $role_employee=new Role();
        $role_employee->name='admin';
        $role_employee->description='An Admin User';
        $role_employee->save();

        $role_manager=new Role();
        $role_manager->name='user';
        $role_manager->description='A User user';
        $role_manager->save();

        $role_shop=new Role();
        $role_shop->name='shop';
        $role_shop->description='A Shop user';
        $role_shop->save();
    }
}
