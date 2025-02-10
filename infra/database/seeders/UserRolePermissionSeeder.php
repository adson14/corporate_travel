<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserRolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Cria os roles
        $adminRole = Role::create(['name' => 'admin', 'description' => 'Administrator with full access']);
        $standardRole = Role::create(['name' => 'standard', 'description' => 'Standard user with limited access']);

        // Cria a permissão
        $updateOrderStatusPermission = Permission::create([
            'name' => 'approve-order',
            'description' => 'Permission to approve an order',
        ]);

        // Associa a permissão ao role admin
        $adminRole->permissions()->attach($updateOrderStatusPermission);

        $updateOrderStatusPermission = Permission::create([
            'name' => 'cancel-order',
            'description' => 'Permission to cancel an order',
        ]);

        // Associa a permissão ao role admin
        $adminRole->permissions()->attach($updateOrderStatusPermission);

        // Cria o usuário admin
        $adminUser = User::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),  // UUID
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),  // Substitua por uma senha segura
        ]);

        // Associa o role admin ao usuário admin
        $adminUser->roles()->attach($adminRole);

        // Cria o usuário padrão (standard)
        $standardUser = User::create([
            'id' => (string) \Illuminate\Support\Str::uuid(),  // UUID
            'name' => 'Standard User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),  // Substitua por uma senha segura
        ]);

        // Associa o role standard ao usuário padrão
        $standardUser->roles()->attach($standardRole);
    }
}
