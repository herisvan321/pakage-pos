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

2. Publish config dan assets:

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

5. Setup User model:

Tambahkan trait pada `app/Models/User.php`:

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;
    // ...
}
```

6. Configure auth guard di `config/auth.php`:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
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

### Publish Views

```bash
php artisan vendor:publish --tag="pos-views"
```

Views akan dipublish ke `resources/views/vendor/pos`

### Publish Migrations

```bash
php artisan vendor:publish --tag="pos-migrations"
```

## Lisensi

MIT

