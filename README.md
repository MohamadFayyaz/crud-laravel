# CRUD Laravel dengan JWT Authentication

Project ini adalah aplikasi web manajemen user yang dibangun dengan Laravel 13 dan JWT (JSON Web Token) authentication. Aplikasi ini menyediakan dua interface: Web UI untuk manajemen user melalui browser dan REST API untuk integrasi dengan aplikasi lain.

## Fitur Utama

- **Manajemen User Lengkap**: Create, Read, Update, Delete (CRUD) data user
- **Relasi Hobi**: Setiap user dapat memiliki banyak hobi (one-to-many relationship)
- **JWT Authentication**: Sistem autentikasi token untuk API endpoints
- **Web Interface**: UI yang bersih dan user-friendly menggunakan Bootstrap 5
- **REST API**: API endpoints lengkap dengan dokumentasi Postman
- **Pagination**: Data user ditampilkan dengan pagination (10 item per halaman)
- **Validasi**: Input validation untuk semua form

## Teknologi yang Digunakan

- **Backend**: Laravel 13 (PHP 8.3)
- **Authentication**: JWT (php-open-source-saver/jwt-auth)
- **Frontend**: Bootstrap 5.3
- **Database**: MySQL
- **API Testing**: Postman Collection
- **Package Manager**: Composer

## Struktur Project

```
laravel-crud-jwt/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── UserController.php          # Controller untuk Web UI
│   │   │   └── Api/
│   │   │       ├── AuthController.php      # Handle register, login, logout
│   │   │       └── UserController.php      # Handle CRUD API endpoints
│   │   └── Middleware/
│   ├── Models/
│   │   ├── User.php                        # Model user dengan relasi hobbies
│   │   └── Hobby.php                       # Model hobi
│   └── Providers/
├── bootstrap/
│   ├── app.php                             # Bootstrap aplikasi
│   └── providers.php                       # Service providers
├── config/
│   ├── auth.php                            # Konfigurasi autentikasi
│   ├── database.php                       # Konfigurasi database
│   └── jwt.php                             # Konfigurasi JWT
├── database/
│   ├── migrations/
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   └── 2026_05_04_072741_create_hobbies_table.php
│   ├── seeders/
│   │   ├── DatabaseSeeder.php
│   │   └── UserSeeder.php                  # Seed data user dummy
│   └── factories/
│       └── UserFactory.php
├── public/
│   └── index.php                           # Entry point aplikasi
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php               # Layout utama aplikasi
│   │   └── users/
│   │       ├── index.blade.php             # Halaman daftar user
│   │       ├── create.blade.php            # Form tambah user
│   │       └── edit.blade.php              # Form edit user
│   ├── css/
│   └── js/
├── routes/
│   ├── web.php                             # Route untuk Web UI
│   ├── api.php                             # Route untuk API endpoints
│   └── console.php
├── storage/                                # File storage (logs, cache, etc.)
├── tests/                                  # Unit & Feature tests
├── .env                                    # Environment variables
├── .env.example                            # Template environment variables
├── artisan                                 # Laravel CLI tool
├── composer.json                           # PHP dependencies
├── package.json                            # Node dependencies
├── Laravel CRUD JWT.postman_collection.json # Postman collection untuk API testing
└── Laravel JWT Env.postman_environment.json  # Postman environment variables
```

## Penjelasan Folder dan File

### `app/`
Folder utama yang berisi logika aplikasi.

- **`Http/Controllers/`**: Berisi controller yang menangani request dari user
  - `UserController.php`: Menangani CRUD user untuk Web UI
  - `Api/AuthController.php`: Menangani register, login, logout, dan get user info untuk API
  - `Api/UserController.php`: Menangani CRUD user untuk REST API

- **`Models/`**: Berisi model Eloquent untuk representasi database
  - `User.php`: Model user dengan relasi `hasMany` ke hobbies dan implementasi JWT
  - `Hobby.php`: Model hobi dengan relasi `belongsTo` ke user

### `bootstrap/`
Berisi file yang di-load saat aplikasi dimulai.

- `app.php: Bootstrap utama aplikasi
- `providers.php: Daftar service providers

### `config/`
Berisi file konfigurasi aplikasi.

- `auth.php`: Konfigurasi guard dan provider autentikasi
- `database.php`: Konfigurasi koneksi database
- `jwt.php`: Konfigurasi JWT (token expiration, algorithm, dll)

### `database/`
Berisi file terkait database.

- **`migrations/`**: File migrasi untuk membuat dan memodifikasi tabel database
  - `create_users_table.php`: Membuat tabel users
  - `create_hobbies_table.php`: Membuat tabel hobbies dengan foreign key ke users

- **`seeders/`**: File untuk mengisi database dengan data dummy
  - `UserSeeder.php`: Mengisi 3 user dummy dengan hobi

- **`factories/`**: Factory untuk membuat data model untuk testing

### `public/`
Folder yang dapat diakses publik via web server.

- `index.php`: Entry point aplikasi (semua request melewati file ini)

### `resources/`
Berisi asset dan view files.

- **`views/`**: File Blade template untuk UI
  - `layouts/app.blade.php`: Layout utama dengan navbar
  - `users/index.blade.php`: Halaman daftar user dengan pagination
  - `users/create.blade.php`: Form tambah user baru
  - `users/edit.blade.php`: Form edit user yang sudah ada

### `routes/`
Berisi definisi route aplikasi.

- `web.php`: Route untuk Web UI (GET /users, POST /users, dll)
- `api.php`: Route untuk REST API dengan middleware JWT auth
- `console.php`: Route untuk artisan commands

### `storage/`
Berisi file yang di-generate aplikasi (logs, cache, uploaded files).

### File Konfigurasi Penting

- **`.env`**: Environment variables (DB credentials, JWT secret, dll)
- **`composer.json`**: Daftar PHP dependencies
- **`package.json`**: Daftar Node.js dependencies
- **Postman Collection/Environment**: File untuk testing API dengan Postman

## Aliran Data

### Web UI Flow

1. **User mengakses halaman** (`GET /users`)
   - Route: `web.php` → `UserController@index`
   - Controller mengambil data user dengan pagination dan relasi hobbies
   - View `users/index.blade.php` dirender dengan data user

2. **Tambah User Baru** (`POST /users`)
   - User mengisi form di `users/create.blade.php`
   - Data dikirim ke `UserController@store`
   - Validasi input (name, email, password, phone, address, hobbies)
   - User disimpan ke database
   - Hobi-hobi disimpan ke tabel `hobbies` dengan relasi ke user
   - Redirect ke halaman index dengan pesan success

3. **Edit User** (`PUT /users/{id}`)
   - User mengklik tombol Edit di halaman index
   - Form `users/edit.blade.php` ditampilkan dengan data user yang ada
   - User mengubah data dan submit
   - Data dikirim ke `UserController@update`
   - Data user di-update, hobi lama dihapus dan diganti dengan hobi baru
   - Redirect ke halaman index dengan pesan success

4. **Hapus User** (`DELETE /users/{id}`)
   - User mengklik tombol Hapus di halaman index
   - Konfirmasi dialog muncul
   - Request dikirim ke `UserController@destroy`
   - User dihapus dari database (hobi terhapus otomatis karena cascade delete)
   - Redirect ke halaman index dengan pesan success

### API Flow

1. **Register** (`POST /api/auth/register`)
   - Client mengirim data (name, email, password, password_confirmation)
   - `AuthController@register` memvalidasi dan membuat user baru
   - JWT token di-generate dan dikirim ke client

2. **Login** (`POST /api/auth/login`)
   - Client mengirim email dan password
   - `AuthController@login` memvalidasi kredensial
   - Jika valid, JWT token di-generate dan dikirim ke client

3. **Protected API Requests** (GET/POST/PUT/DELETE `/api/users`)
   - Client menyertakan JWT token di header `Authorization: Bearer {token}`
   - Middleware `auth:api` memvalidasi token
   - Jika valid, request diteruskan ke controller
   - `Api\UserController` menangani operasi CRUD
   - Response JSON dikirim ke client

4. **Logout** (`POST /api/auth/logout`)
   - Client mengirim request dengan JWT token
   - `AuthController@logout` menginvalidate token
   - Client harus login kembali untuk akses protected routes

## Tahap Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd laravel-crud-jwt
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install
```

### 3. Setup Environment

```bash
# Copy file .env.example ke .env
cp .env.example .env

# Generate application key
php artisan key:generate

# Generate JWT secret
php artisan jwt:secret
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan konfigurasi database:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel_crud_jwt
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 5. Generate JWT Secret

```bash
php artisan jwt:secret
```

### 6. Run Migration

```bash
# Jalankan migrasi untuk membuat tabel database
php artisan migrate
```

Tabel yang akan dibuat:
- `users`: id, name, email, password, phone, address, timestamps
- `hobbies`: id, user_id, name, timestamps (dengan foreign key cascade delete)
- `cache`, `jobs`, `sessions` (tabel sistem Laravel)

### 7. Run Seeder

```bash
# Isi database dengan data dummy
php artisan db:seed
```

Data yang akan dibuat:
- Admin (admin@example.com / password123)
- Ahmad Fauzi (ahmad@example.com / password123)
- Siti Rahayu (siti@example.com / password123)

Setiap user memiliki 3 hobi.

### 8. Start Development Server

```bash
# Jalankan development server
php artisan serve
```

Aplikasi akan berjalan di `http://localhost:8000`

## Testing dengan Postman

### Import Postman Collection

1. Buka Postman
2. Klik `Import` dan pilih file:
   - `Laravel CRUD JWT.postman_collection.json`
   - `Laravel JWT Env.postman_environment.json`

3. Set environment `Laravel JWT Env` sebagai active environment

### Test API Endpoints

#### 1. Register User

- **Method**: POST
- **URL**: `{{base_url}}/api/auth/register`
- **Body** (raw JSON):

```json
{
  "name": "Test User",
  "email": "test@example.com",
  "password": "password123",
  "password_confirmation": "password123"
}
```

- **Response**: User data dan JWT token

#### 2. Login

- **Method**: POST
- **URL**: `{{base_url}}/api/auth/login`
- **Body** (raw JSON):

```json
{
  "email": "admin@example.com",
  "password": "password123"
}
```

- **Response**: User data dan JWT token
- **Copy token** dan simpan ke environment variable `token`

#### 3. Get All Users (Protected)

- **Method**: GET
- **URL**: `{{base_url}}/api/users`
- **Header**: `Authorization: Bearer {{token}}`
- **Response**: List user dengan pagination

#### 4. Get Single User (Protected)

- **Method**: GET
- **URL**: `{{base_url}}/api/users/{id}`
- **Header**: `Authorization: Bearer {{token}}`
- **Response**: Detail user dengan hobi

#### 5. Create User (Protected)

- **Method**: POST
- **URL**: `{{base_url}}/api/users`
- **Header**: `Authorization: Bearer {{token}}`
- **Body** (raw JSON):

```json
{
  "name": "New User",
  "email": "newuser@example.com",
  "password": "password123",
  "phone": "08123456789",
  "address": "Jl. Test No. 1",
  "hobbies": ["Membaca", "Coding"]
}
```

- **Response**: User yang baru dibuat dengan hobi

#### 6. Update User (Protected)

- **Method**: PUT
- **URL**: `{{base_url}}/api/users/{id}`
- **Header**: `Authorization: Bearer {{token}}`
- **Body** (raw JSON):

```json
{
  "name": "Updated Name",
  "email": "updated@example.com",
  "phone": "08987654321",
  "hobbies": ["Travelling", "Photography"]
}
```

- **Response**: User yang di-update

#### 7. Delete User (Protected)

- **Method**: DELETE
- **URL**: `{{base_url}}/api/users/{id}`
- **Header**: `Authorization: Bearer {{token}}`
- **Response**: Pesan success

#### 8. Get Current User (Protected)

- **Method**: GET
- **URL**: `{{base_url}}/api/auth/me`
- **Header**: `Authorization: Bearer {{token}}`
- **Response**: Data user yang sedang login

#### 9. Logout (Protected)

- **Method**: POST
- **URL**: `{{base_url}}/api/auth/logout`
- **Header**: `Authorization: Bearer {{token}}`
- **Response**: Pesan logout berhasil

## Akses Web UI

Setelah menjalankan `php artisan serve`, buka browser dan akses:

- **Home/Daftar User**: `http://localhost:8000`
- **Tambah User**: `http://localhost:8000/users/create`
- **Edit User**: `http://localhost:8000/users/{id}/edit`

## Credential Default

Dari seeder yang sudah dijalankan:

- **Email**: admin@example.com
- **Password**: password123

## Troubleshooting

### JWT Secret Error

Jika mendapat error "JWT_SECRET not set", jalankan:

```bash
php artisan jwt:secret
```

### Migration Error

Jika migrasi gagal, pastikan:
1. Database sudah dibuat
2. Kredensial database di `.env` sudah benar
3. Jalankan `php artisan migrate:fresh` untuk reset database

### CORS Error (jika testing dari frontend terpisah)

Install dan konfigurasi package CORS jika perlu mengakses API dari domain berbeda.