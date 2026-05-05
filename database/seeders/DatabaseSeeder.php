<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Admin;
use App\Models\Permission;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Super admin
        $admin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'admin@app.com',
            'role' => 'suber_admin',
            'phone' => '01157012640',
            'password' => Hash::make('password'),
        ]);

        // Seed all permissions
        $permissionNames = [
            'create_admins',
            'read_admins',
            'update_admins',
            'delete_admins',
            'create_users',
            'read_users',
            'update_users',
            'delete_users',
            'create_orders',
            'read_orders',
            'update_orders',
            'delete_orders',
            'create_categories',
            'read_categories',
            'update_categories',
            'delete_categories',
            'create_products',
            'read_products',
            'update_products',
            'delete_products',
            'create_brands',
            'read_brands',
            'update_brands',
            'delete_brands',
            'create_cars',
            'read_cars',
            'update_cars',
            'delete_cars',
        ];

        foreach ($permissionNames as $name) {
            Permission::create(['name' => $name]);
        }

        // Default settings
        Setting::create([
            'name' => 'AutoParts Store',
            'address' => '123 Main St',
            'phone' => '01157012640',
            'tax' => 14,
            'shipping' => 0,
            'image' => 'default.png',
            'payment_url' => 'https://accept.paymob.com/api/',
            'payment_token' => 'your-token-here',
            'payment_integration_id' => '3160861',
        ]);
    }
}
