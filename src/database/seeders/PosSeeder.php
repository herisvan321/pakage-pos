<?php

namespace Herisvanhendra\Pos\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Herisvanhendra\Pos\Models\User;
use Herisvanhendra\Pos\Models\Category;
use Herisvanhendra\Pos\Models\Product;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PosSeeder extends Seeder
{
    public function run()
    {
        // Create permissions
        $permissions = [
            'manage categories',
            'manage products',
            'manage sales',
            'view reports',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'web']);
        }

        // Create admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);
        $adminRole->givePermissionTo($permissions);

        // Create kasir role
        $kasirRole = Role::firstOrCreate(['name' => 'kasir', 'guard_name' => 'web']);
        $kasirRole->givePermissionTo(['manage sales', 'view reports']);

        // Create admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@pos.com'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('password'),
            ]
        );
        $admin->assignRole('admin');

        // Create kasir user
        $kasir = User::firstOrCreate(
            ['email' => 'kasir@pos.com'],
            [
                'name' => 'Kasir',
                'password' => Hash::make('password'),
            ]
        );
        $kasir->assignRole('kasir');

        // Create sample categories
        $categories = [
            ['name' => 'Makanan', 'description' => 'Berbagai makanan ringan dan utama'],
            ['name' => 'Minuman', 'description' => 'Minuman ringan dan panas'],
            ['name' => 'Snack', 'description' => ' Camilan dan snack'],
        ];

        foreach ($categories as $category) {
            Category::firstOrCreate(['name' => $category['name']], $category);
        }

        // Create sample products
        $makanan = Category::where('name', 'Makanan')->first();
        $minuman = Category::where('name', 'Minuman')->first();
        $snack = Category::where('name', 'Snack')->first();

        $products = [
            ['name' => 'Nasi Goreng', 'category_id' => $makanan->id, 'price' => 15000, 'stock' => 50],
            ['name' => 'Mie Goreng', 'category_id' => $makanan->id, 'price' => 12000, 'stock' => 50],
            ['name' => 'Ayam Goreng', 'category_id' => $makanan->id, 'price' => 18000, 'stock' => 30],
            ['name' => 'Es Teh', 'category_id' => $minuman->id, 'price' => 5000, 'stock' => 100],
            ['name' => 'Kopi Hitam', 'category_id' => $minuman->id, 'price' => 8000, 'stock' => 80],
            ['name' => 'Jus Jeruk', 'category_id' => $minuman->id, 'price' => 10000, 'stock' => 40],
            ['name' => 'Kerupuk', 'category_id' => $snack->id, 'price' => 3000, 'stock' => 100],
            ['name' => 'Pisang Goreng', 'category_id' => $snack->id, 'price' => 5000, 'stock' => 25],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']], 
                $product
            );
        }
    }
}

