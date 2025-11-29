<?php

namespace Database\Seeders;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::firstOrCreate([
            'name' => 'admin',
            'username' => 'admin',
            'email' => 'admin@gmail.com',
            'mobile' => '09123456789',
            'address' => 'Thai Smily, bangkok',
            'staff_photo' => 'default.png',
            'staff_id_proof' => 'default.png',
            'password' => Hash::make('123'),
        ]);

        $role = Role::find(1);

        $permissions = Permission::pluck('id', 'id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
