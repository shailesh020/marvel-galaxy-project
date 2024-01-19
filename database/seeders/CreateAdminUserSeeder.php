<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateAdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Marvel Galaxy',
            'email' => 'akkisonani157@gmail.com',
            'phone_no' => '8238238650',
            'dob' => '2001/07/15',
            'residential_address' => 'residential address',
            'password' => Hash::make('Akshay@15')
        ]);

        $role = Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Clients']);
        Role::create(['name' => 'Engineers']);

        $permissions = Permission::pluck('id','id')->all();

        $role->syncPermissions($permissions);

        $user->assignRole([$role->id]);
    }
}
