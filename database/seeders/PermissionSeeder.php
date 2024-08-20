<?php

namespace Database\Seeders;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allRoles = Role::all()->keyBy('id');

        $permissions = [
            [
                "name"  =>  "DELETE_USER",
                'alias' => "حذف یوزر",
                'roles' => [Role::ROLE_ADMINISTRATOR],
                'guard_name' => 'api',
            ],
            [
                'name' => 'ADDING_SONG',
                'alias' => "اضافه کردن آهنگ",
                'roles' => [Role::ROLE_USER],
                'guard_name' => 'api',
            ],
        ];
        
        foreach ($permissions as $permissionData) {
            $permission = Permission::create([
                'name' => $permissionData['name'],
                'alias' => $permissionData['alias'],
                'guard_name' => $permissionData['guard_name']
            ]);
        
            foreach ($permissionData['roles'] as $role) {
                $allRoles[$role]->permissions()->attach($permission->id);
            }
        }
    }
}
