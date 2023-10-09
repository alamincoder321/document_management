<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PermissionSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create(['name'=>'SuperAdmin']);
        Role::create(['name'=>'Admin']);
        Role::create(['name'=>'User']);
        Admin::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'role_id' => 1,
            'password' => Hash::make(1)
        ]);

        $permissions = [
            [
                'group_name' => 'Dashboard',
                'permission_name' => [
                    'Dashboard',
                ]
            ],
            [
                'group_name' => 'Setting',
                'permission_name' => [
                    'settingUpdate',
                ]
            ],
            [
                'group_name' => 'Slider',
                'permission_name' => [
                    'sliderEntry',
                ]
            ],
            [
                'group_name' => 'Category',
                'permission_name' => [
                    'categoryEntry',
                ]
            ],
            [
                'group_name' => 'NewsEvent',
                'permission_name' => [
                    'newsandeventEntry',
                ]
            ],
            [
                'group_name' => 'Service',
                'permission_name' => [
                    'serviceEntry',
                ]
            ],
            [
                'group_name' => 'District',
                'permission_name' => [
                    'districtEntry',
                ]
            ],
            [
                'group_name' => 'Thana',
                'permission_name' => [
                    'thanaEntry',
                ]
            ],
            [
                'group_name' => 'Customer',
                'permission_name' => [
                    'customerList',
                ]
            ],
            [
                'group_name' => 'User',
                'permission_name' => [
                    'userEntry',
                    'userAccess',
                ]
            ],
            [
                'group_name' => 'Report',
                'permission_name' => [
                    'reportShow',
                    'paymentShow',
                ]
            ],
        ];
        foreach ($permissions as $permission) {
            foreach ($permission['permission_name'] as $permissionName) {
                Permission::create(['permissions' => $permissionName, 'group_name' => $permission['group_name']]);
            }
        }
    }
}
