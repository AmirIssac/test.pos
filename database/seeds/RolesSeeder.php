<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = ['مشرف','مالك-مخزن','مدير-مخزن','عامل-مخزن'];
        foreach($roles as $role)
        Role::create(['name' => $role]);
    }
}
