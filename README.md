# POS (Point of Sales) Laravel Package

Aplikasi Point of Sales dengan Laravel Package yang terintegrasi dengan Spatie Permission untuk role dan permission management.

## Fitur

- **Dashboard** - Overview penjualan dan stok
- **Manajemen Kategori** - CRUD kategori produk
- **Manajemen Produk** - CRUD produk dengan kategori
- **Penjualan** - Transaksi POS dengan keranjang
- **Laporan** - Laporan harian dan bulanan
- **Login** - Custom authentication
- **Role & Permission** - Menggunakan Spatie Laravel Permission

## Instalasi

1. Install package via composer:

```bash
composer require herisvanhendra/pos
```

2. Publish config, migrations, dan assets:

```bash
php artisan vendor:publish --provider="Herisvanhendra\Pos\PosServiceProvider"
```

3. Jalankan migration:

```bash
php artisan migrate
```

4. Seed database dengan data sample:

```bash
php artisan db:seed --class="Herisvanhendra\Pos\Database\Seeders\PosSeeder"
```

5. Setup User model (jika menggunakan User model sendiri):

Tambahkan trait pada `app/Models/User.php`:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ...
}
```

## Quick Install (Otomatis)

Package ini menyediakan User model bawaan. Untuk menggunakan, pastikan di `config/auth.php`:

```php
'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => Herisvanhendra\Pos\Models\User::class,
    ],
],
```

## Akun Demo

Setelah seeding, berikut akun yang tersedia:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@pos.com | password |
| Kasir | kasir@pos.com | password |

## Routes

- `/pos/login` - Login
- `/pos/dashboard` - Dashboard
- `/pos/categories` - Manajemen Kategori
- `/pos/products` - Manajemen Produk
- `/pos/sales` - Penjualan
- `/pos/reports` - Laporan

## Customization

### Publish Views Only

```bash
php artisan vendor:publish --tag="pos-views"
```

Views akan dipublish ke `resources/views/vendor/pos`

### Publish Migrations Only

```bash
php artisan vendor:publish --tag="pos-migrations"
```

### Publish Config Only

```bash
php artisan vendor:publish --tag="pos-config"
```

### Publish All

```bash
php artisan vendor:publish --tag="pos-all"
```

## Troubleshooting

Jika terjadi error "no such table: permissions", pastikan:

1. Publish config: `php artisan vendor:publish --provider="Herisvanhendra\Pos\PosServiceProvider"`
2. Jalankan migrate: `php artisan migrate`

## Lisensi

MIT

