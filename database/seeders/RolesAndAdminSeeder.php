<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RolesAndAdminSeeder extends Seeder
{
    public function run(): void
    {

        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        
        
        $adminRole = Role::create(['name' => 'Admin']);
        
        $memberRole = Role::create(['name' => 'Member']);
       
        $userRole = Role::create(['name' => 'User']);

        
        $adminUser = User::create([
            'first_name' => 'Admin',
            'last_name' => 'Ritecs',
            'email' => 'admin@ritecs.com',
            'password' => Hash::make('#dt1_d1nu$_polke_2025') 
        ]);
        $adminUser->assignRole($adminRole);
    }
}