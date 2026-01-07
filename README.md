# 🚀 Materio Admin Dashboard

Aplikasi Admin Dashboard modern berbasis **Laravel 12** dengan template **Materio Bootstrap**. Dilengkapi dengan sistem autentikasi, manajemen user, role-based access control (RBAC), activity logging, dan dashboard analytics.

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel">
  <img src="https://img.shields.io/badge/Bootstrap-7952B3?style=for-the-badge&logo=bootstrap&logoColor=white" alt="Bootstrap">
  <img src="https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP">
  <img src="https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white" alt="MySQL">
  <img src="https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite">
</p>

---

<kbd>[![Materio - Bootstrap 5 HTML Laravel Admin Template Demo Screenshot](https://cdn.themeselection.com/ts-assets/materio/materio-bootstrap-laravel-admin-template-free/banner/banner.png)](https://themeselection.com/item/materio-dashboard-free-laravel/)</kbd>

## ✨ Fitur Utama

### 🔐 Autentikasi
- Login dengan validasi status user
- Registrasi user baru
- Forgot password
- Logout dengan konfirmasi modal
- Middleware check user status (active/inactive/banned)

### 👥 Manajemen User
- CRUD Users dengan soft delete
- Filter berdasarkan status dan role
- Pencarian nama/email
- Avatar upload
- User profile management

### 🛡️ Role & Permission (RBAC)
- Manajemen roles dengan Spatie Permission
- Manajemen permissions
- Assign permissions ke roles
- Role-based middleware

### 📊 Dashboard Analytics
- Statistik user (Total, Active, Inactive, Banned)
- Chart pertumbuhan user (7 hari)
- Chart aktivitas berdasarkan kategori
- Chart user berdasarkan role
- Chart trend aktivitas bulanan
- Recent activities table

### 📝 Activity Logs
- Logging semua aktivitas sistem
- Filter berdasarkan tanggal dan kategori
- Detail activity dengan properties

### ⚙️ Global Settings
- Pengaturan sistem dinamis
- Grouped by category
- Support tipe: text, boolean, json

### 🎨 UI/UX
- Modern & responsive design
- ApexCharts untuk visualisasi data
- Inline SVG icons
- Modal konfirmasi logout
- Indonesian language labels

---

## 🛠️ Tech Stack

| Technology | Version |
|------------|---------|
| PHP | 8.2+ |
| Laravel | 12.x |
| Vite | 6.x |
| Bootstrap | 5.x |
| Spatie Permission | 6.x |
| ApexCharts | Latest |
| MySQL | 8.x |

---

## 📦 Instalasi

### Prerequisites
- PHP >= 8.2
- Composer
- Node.js >= 18
- MySQL/MariaDB

### Steps

```bash
# 1. Clone repository
git clone <repository-url>
cd materio-bootstrap

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install --legacy-peer-deps

# 4. Copy environment file
cp .env.example .env

# 5. Generate application key
php artisan key:generate

# 6. Configure database di .env
# DB_DATABASE=materio_db
# DB_USERNAME=root
# DB_PASSWORD=

# 7. Run migrations & seeders
php artisan migrate:fresh --seed

# 8. Create storage link
php artisan storage:link

# 9. Build assets
npm run build

# 10. Start development server
php artisan serve
npm run dev
```

---

## 👤 Default Users

| Role | Email | Password |
|------|-------|----------|
| Super Admin | superadmin@example.com | password |
| Admin | admin@example.com | password |
| Editor | editor@example.com | password |
| User | user@example.com | password |

---

## 📁 Struktur Database

### Tables

```
users
├── id
├── name
├── email
├── password
├── status (active, inactive, banned)
├── last_login_at
├── created_at
├── updated_at
└── deleted_at

user_profiles
├── id
├── user_id (FK)
├── avatar_path
├── phone_number
├── bio
├── address
├── preferences (JSON)
├── created_at
└── updated_at

activity_logs
├── id
├── log_name
├── description
├── subject_type
├── subject_id
├── causer_type
├── causer_id
├── properties (JSON)
├── created_at
└── updated_at

global_settings
├── id
├── key
├── value
├── type (text, boolean, json)
├── group
├── created_at
└── updated_at

roles (Spatie)
permissions (Spatie)
model_has_roles (Spatie)
model_has_permissions (Spatie)
role_has_permissions (Spatie)
```

---

## 🔗 Routes

### Public Routes
| Method | URI | Description |
|--------|-----|-------------|
| GET | /login | Login page |
| POST | /login | Login action |
| GET | /register | Register page |
| POST | /register | Register action |
| GET | /forgot-password | Forgot password page |

### Authenticated Routes
| Method | URI | Description |
|--------|-----|-------------|
| GET | / | Dashboard |
| POST | /logout | Logout |
| GET | /profile | Edit profile |
| PUT | /profile | Update profile |
| PUT | /profile/avatar | Update avatar |
| PUT | /profile/password | Update password |

### Admin Routes (super-admin/admin only)
| Method | URI | Description |
|--------|-----|-------------|
| GET | /admin/users | Users list |
| GET | /admin/users/create | Create user form |
| POST | /admin/users | Store user |
| GET | /admin/users/{id} | Show user |
| GET | /admin/users/{id}/edit | Edit user form |
| PUT | /admin/users/{id} | Update user |
| DELETE | /admin/users/{id} | Delete user |
| GET | /admin/roles | Roles list |
| GET | /admin/permissions | Permissions list |
| GET | /admin/activity-logs | Activity logs |
| GET | /admin/settings | Settings list |

---

## 📂 Folder Structure

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   │   ├── UserController.php
│   │   │   ├── RoleController.php
│   │   │   ├── PermissionController.php
│   │   │   ├── ActivityLogController.php
│   │   │   └── GlobalSettingController.php
│   │   ├── Auth/
│   │   │   └── AuthController.php
│   │   ├── DashboardController.php
│   │   └── ProfileController.php
│   └── Middleware/
│       └── CheckUserStatus.php
├── Models/
│   ├── User.php
│   ├── UserProfile.php
│   ├── ActivityLog.php
│   └── GlobalSetting.php

resources/
├── views/
│   ├── content/
│   │   ├── dashboard/
│   │   ├── admin/
│   │   │   ├── users/
│   │   │   ├── roles/
│   │   │   ├── permissions/
│   │   │   ├── activity-logs/
│   │   │   └── settings/
│   │   ├── profile/
│   │   └── authentications/
│   └── layouts/
├── menu/
│   └── verticalMenu.json
```

---

## 🔒 Security Features

- ✅ CSRF Protection
- ✅ Password hashing (bcrypt)
- ✅ Role-based access control
- ✅ User status validation
- ✅ Soft deletes for users
- ✅ Activity logging
- ✅ Input validation

---

## 🎯 Menu Navigation

```
Dashboard
├── Admin
│   ├── Manajemen User
│   │   ├── Daftar User
│   │   └── Tambah User
│   ├── Role & Permission
│   │   ├── Roles
│   │   └── Permissions
│   ├── Activity Logs
│   └── Pengaturan
└── Account
    └── Profil Saya
```

---

## 📸 Screenshots

### Dashboard
- Welcome card dengan greeting
- Statistik user cards
- Charts: User growth, Activity by type, Users by role, Monthly trend
- Recent activities table

### Profile
- Avatar upload
- Profile information update
- Password change

---

## 🧪 Testing

```bash
# Run tests
php artisan test

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📝 License

This project is licensed under the MIT License.

---

## 👨‍💻 Author

Built with ❤️ using Laravel & Materio Bootstrap Template

---

## 🙏 Credits

- [Laravel](https://laravel.com)
- [Materio Bootstrap Template](https://themeselection.com/materio-bootstrap-html-admin-template/)
- [Spatie Laravel Permission](https://spatie.be/docs/laravel-permission)
- [ApexCharts](https://apexcharts.com)
