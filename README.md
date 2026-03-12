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

2. **Tambahkan HasRoles trait di User Model** (`app/Models/User.php`):

```php
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles;

    // ... rest of your code
}
```

3. Jalankan migration (otomatis membuat semua tabel termasuk Spatie permissions):

```bash
php artisan migrate
```

4. **Publish seeders (optional, untuk membuat seeder tersedia di database/seeders public):**
```bash
php artisan vendor:publish --tag="pos-seeders"
```

5. Seed database dengan data sample:
```bash
php artisan db:seed --class="Herisvanhendra\Pos\Database\Seeders\PosSeeder"
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

## Troubleshooting

Jika terjadi error, coba:

```bash
php artisan migrate:fresh --seed --seeder="Herisvanhendra\Pos\Database\Seeders\PosSeeder"
```

## Lisensi

MIT

