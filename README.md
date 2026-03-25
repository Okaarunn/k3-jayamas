# Jayamas K3 System

Aplikasi manajemen keselamatan kerja (K3) berbasis web yang dibangun menggunakan CodeIgniter 4 dengan sistem autentikasi Myth/Auth. Sistem ini dirancang untuk membantu pengelolaan pengguna, data K3, serta kontrol akses berbasis role.

---

## Fitur Utama

- Autentikasi (Login / Logout)
- Manajemen User (Admin)
- Role-based Access Control (Administrator, Editor, Viewer)
- Validasi form & keamanan password
- UI modern & responsif
- Session-based authentication
- Flash message & error handling

---

## Tech Stack

- Backend: CodeIgniter 4.7
- Authentication: Myth/Auth
- PHP: ^8.2
- Database: MySQL / MariaDB
- Frontend: Bootstrap, jQuery

---

## Instalasi

### 1. Clone Project

```bash
git clone https://github.com/Okaarunn/k3-jayamas.git
cd k3-jayamas
```

### 2. Install Depedency

composer install

### 3. Setup Environment

cp env .env

### 4. Generate keys

php spark key:generate

### 5. Database migration

php spark migrate -all

### 6. Database seeder

php spark db:seed DatabaseSeeder

### Default Seeder Account

Role Administrator
Username aditya
Password aditya12345
