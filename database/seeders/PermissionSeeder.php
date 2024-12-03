<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $role_admin = Role::updateOrCreate(
            [
                'name' => 'admin',
            ],
            ['name' => 'admin']
        );
            
        $role_user = Role::updateOrCreate(
            [
                'name' => 'user',
            ],
            ['name' => 'user']
        );

        $permission = Permission::updateOrCreate(
            [
                'name' => 'dashboard',
            ],
            ['name' => 'dashboard']
        );

        $permission2 = Permission::updateOrCreate(
            [
                'name' => 'view',
            ],
            ['name' => 'view']
        );

        $role_admin->givePermissionTo($permission);
        $role_user->givePermissionTo($permission2);

        $user = User::find(4);
        $user2 = User::find(5);

        $user->assignRole('user');
        $user2->assignRole('admin');
    }
}
