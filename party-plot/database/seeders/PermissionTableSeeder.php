<?php

namespace Database\Seeders;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            'user-list',
            'user-create',
            'user-edit',
            'user-delete',
            'setting-list',
            'role-list',
            'role-create',
            'role-edit',
            'role-delete',
            'permission-list',
            'permission-create',
            'permission-edit',
            'permission-delete',
        ];

        foreach ($data as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }
    }
}
