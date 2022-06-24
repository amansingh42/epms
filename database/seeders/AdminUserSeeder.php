<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::get();
        
        // if(empty($users)){
            $user = User::create([
                'name' => 'Super Admin',
                'email' => 'superadmin@gmail.com',
                'password' => bcrypt('Admin1234')
            ]);

            $role = Role::create(['name' => 'Admin']);

            $permissions = Permission::pluck('id','id');

            $role->syncPermissions($permissions);

            $user->assignRole([$role->id]);
        // }
    }
}
