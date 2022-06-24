<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissiontableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'report-list',
            'report-create',
            'report-edit',
            'report-delete',
            'user-list',
            'user-create',
            'user-edit',
            'user-delete'
        ];

        $per = Permission::get();

        // if(empty($per)){
            foreach($permissions as $permission){
                Permission::create(['name' => $permission]);
            }
        // }
    }
}
