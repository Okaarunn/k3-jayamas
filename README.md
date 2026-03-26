# Jayamas K3 System

Aplikasi manajemen produksi berbasis web yang dibangun menggunakan CodeIgniter 4. Sistem ini dirancang untuk membantu pengelolaan barang produksi.

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

### 4. Generate Keys

php spark key:generate

### 5. Database Migration

php spark migrate -all

### 6. Database Seeder

php spark db:seed DatabaseSeeder

### 7. Run project

php spark serve

### Default Seeder Account

Role Editor
Username editor
Password editor12345
