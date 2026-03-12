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
        // Clean up existing permissions/roles with empty guard
        Permission::where('guard_name', '')->delete();
        Role::where('guard_name', '')->delete();

        // Get guard from Spatie config
// Get guard from Spatie config
        $guardName = config('permission.guard_name', 'web');
        
        // If still empty, use 'web'
        if (empty($guardName)) {
            $guardName = 'web';
        }

        // Create permissions without specifying guard (let Spatie use config default)
        $permissions = [
            'manage categories',
            'manage products',
            'manage sales',
            'view reports',
            'manage users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create admin role
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $adminRole->syncPermissions($permissions);

        // Create kasir role
        $kasirRole = Role::firstOrCreate(['name' => 'kasir']);
        $kasirRole->syncPermissions(['manage sales', 'view reports']);

// No user creation - users can register and auto get admin role


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

