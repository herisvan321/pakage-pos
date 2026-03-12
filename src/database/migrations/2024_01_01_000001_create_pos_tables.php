<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create Spatie permission tables if they don't exist
        $this->createSpatieTablesIfNotExists();

        // POS Tables - Categories
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // POS Tables - Products
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->integer('stock')->default(0);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        // POS Tables - Sales
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['pending', 'completed', 'cancelled'])->default('completed');
            $table->timestamps();
        });

        // POS Tables - Sale Items
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('subtotal', 10, 2);
            $table->timestamps();
        });
    }

    protected function createSpatieTablesIfNotExists()
    {
        // Get table names
        $permissionsTable = 'permissions';
        $rolesTable = 'roles';
        $modelHasPermissionsTable = 'model_has_permissions';
        $modelHasRolesTable = 'model_has_roles';
        $roleHasPermissionsTable = 'role_has_permissions';

        // Create permissions table if not exists
        if (!Schema::hasTable($permissionsTable)) {
            Schema::create($permissionsTable, function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name');
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }

        // Create roles table if not exists
        if (!Schema::hasTable($rolesTable)) {
            Schema::create($rolesTable, function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string('name');
                $table->string('guard_name');
                $table->timestamps();
                $table->unique(['name', 'guard_name']);
            });
        }

        // Create model_has_permissions table if not exists
        if (!Schema::hasTable($modelHasPermissionsTable)) {
            Schema::create($modelHasPermissionsTable, function (Blueprint $table) use ($permissionsTable) {
                $table->unsignedBigInteger('permission_id');
                $table->morphs('model');
                $table->foreign('permission_id')
                    ->references('id')
                    ->on($permissionsTable)
                    ->onDelete('cascade');
            });
        }

        // Create model_has_roles table if not exists
        if (!Schema::hasTable($modelHasRolesTable)) {
            Schema::create($modelHasRolesTable, function (Blueprint $table) use ($rolesTable) {
                $table->unsignedBigInteger('role_id');
                $table->morphs('model');
                $table->foreign('role_id')
                    ->references('id')
                    ->on($rolesTable)
                    ->onDelete('cascade');
            });
        }

        // Create role_has_permissions table if not exists
        if (!Schema::hasTable($roleHasPermissionsTable)) {
            Schema::create($roleHasPermissionsTable, function (Blueprint $table) use ($permissionsTable, $rolesTable) {
                $table->unsignedBigInteger('permission_id');
                $table->unsignedBigInteger('role_id');
                $table->foreign('permission_id')
                    ->references('id')
                    ->on($permissionsTable)
                    ->onDelete('cascade');
                $table->foreign('role_id')
                    ->references('id')
                    ->on($rolesTable)
                    ->onDelete('cascade');
                $table->primary(['permission_id', 'role_id']);
            });
        }
    }

    public function down()
    {
        Schema::dropIfExists('sale_items');
        Schema::dropIfExists('sales');
        Schema::dropIfExists('products');
        Schema::dropIfExists('categories');
    }
};

