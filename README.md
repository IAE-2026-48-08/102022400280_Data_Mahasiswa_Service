# 102022400280_service_data_mahasiswa

## Deskripsi

Project ini merupakan implementasi **Service Data Mahasiswa** menggunakan framework Laravel 12 sebagai bagian dari tugas mata kuliah Integrasi Aplikasi Enterprise.

Service ini menyediakan REST API dan GraphQL untuk mengakses data mahasiswa serta melakukan validasi kuota SKS.

---

## Teknologi yang Digunakan

* Laravel 12
* PHP 8.2
* MySQL
* L5-Swagger
* Lighthouse GraphQL
* Postman

---

## REST API

### 1. Mengambil seluruh data mahasiswa

```
GET /api/v1/students
```

### 2. Mengambil detail mahasiswa berdasarkan ID

```
GET /api/v1/students/{id}
```

### 3. Validasi kuota SKS

```
POST /api/v1/students/validate-quota
```

Body Request

```json
{
    "student_id": 1,
    "requested_sks": 4
}
```

---

## Authentication

Semua endpoint REST API menggunakan API Key.

Header:

```
X-API-KEY: 102022400280-HANS
```

---

## Swagger Documentation

Dokumentasi API dapat diakses melalui:

```
http://127.0.0.1:8000/api/documentation
```

---

## GraphQL

Endpoint:

```
POST /graphql
```

Contoh Query:

```graphql
query {
  students {
    id
    nama
    nim
    status
    quota_sks
    used_sks
  }
}
```

---

## Menjalankan Project

Install dependency

```
composer install
```

Copy file environment

```
cp .env.example .env
```

Generate key

```
php artisan key:generate
```

Migrasi database

```
php artisan migrate
```

Menjalankan server

```
php artisan serve
```

---

## Author

Hans Dhika Slamet

NIM : 102022400280
