<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $permissions = collect([
            'CREATE.NEWS', 'EDIT.NEWS', 'DELETE.NEWS', 'VIEW.NEWS',
        ]);

        $roleAndPermissions = collect([
            'Administrator' => $permissions,
            'Reader' => collect([
                'VIEW.NEWS',
            ]),
        ]);

        $roleAndPermissions->each(function ($permissions, $role) {
            $role = Role::create([
                'name' => $role,
                'guard_name' => 'api',
            ]);

            $permissions->each(function ($permission) use ($role) {
                Permission::firstOrCreate([
                    'name' => $permission,
                    'guard_name' => 'api',
                ]);
                $role->givePermissionTo($permission);
            });
        });
    }
}
