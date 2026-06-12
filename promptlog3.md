# Rekap Log Prompting AI

## Informasi

* Mata Kuliah: Integrasi Aplikasi Enterprise
* Tugas: Tugas 3 – Integrasi SOAP, RabbitMQ, dan SSO
* Project: Data Mahasiswa Service
* AI Assistant: ChatGPT

---

## Log Prompting

### Prompt 1

**Tujuan:**
Membuat service untuk mengambil token dari SSO IAE.

**Prompt:**

> Buatkan service Laravel untuk mengambil access token dari SSO menggunakan endpoint login yang disediakan.

**Hasil:**

* Berhasil membuat `SSOService.php`
* Menggunakan Laravel HTTP Client
* Menghasilkan access token yang digunakan pada SOAP dan RabbitMQ

---

### Prompt 2

**Tujuan:**
Membuat integrasi SOAP Audit Service.

**Prompt:**

> Buatkan service Laravel untuk mengirim audit log ke SOAP Audit Service menggunakan access token dari SSO.

**Hasil:**

* Berhasil membuat `SoapAuditService.php`
* Mengirim data audit transaksi validasi kuota
* Mendapatkan response SUCCESS dari server SOAP

---

### Prompt 3

**Tujuan:**
Membuat integrasi RabbitMQ Publisher.

**Prompt:**

> Buatkan service Laravel untuk mengirim pesan ke RabbitMQ Exchange menggunakan access token dari SSO.

**Hasil:**

* Berhasil membuat `RabbitMQService.php`
* Berhasil melakukan publish event ke RabbitMQ
* Mendapatkan response publish success

---

### Prompt 4

**Tujuan:**
Mengintegrasikan SSO, SOAP, dan RabbitMQ ke endpoint validasi kuota mahasiswa.

**Prompt:**

> Integrasikan SSO, SOAP Audit Service, dan RabbitMQ Service ke method validateQuota pada StudentController.

**Hasil:**

* Endpoint berhasil memvalidasi kuota mahasiswa
* Mengirim audit ke SOAP Service
* Mengirim event ke RabbitMQ
* Mengembalikan response terintegrasi

---

### Prompt 5

**Tujuan:**
Membuat dokumentasi Swagger.

**Prompt:**

> Buatkan anotasi OpenAPI Swagger untuk endpoint Student Service.

**Hasil:**

* Endpoint GET mahasiswa terdokumentasi
* Endpoint detail mahasiswa terdokumentasi
* Endpoint validasi kuota terdokumentasi
* Swagger UI berhasil diakses

---

### Prompt 6

**Tujuan:**
Melakukan troubleshooting Docker dan database.

**Prompt:**

> Analisis error koneksi database Laravel pada Docker dan berikan langkah perbaikannya.

**Hasil:**

* Mengidentifikasi kesalahan konfigurasi database
* Memperbaiki koneksi database
* Memastikan migrasi dan data mahasiswa dapat diakses

---

## Kesimpulan

AI digunakan sebagai alat bantu dalam proses pengembangan layanan Data Mahasiswa Service, terutama untuk:

1. Membantu implementasi integrasi layanan eksternal.
2. Membantu pembuatan dokumentasi API.
3. Membantu proses debugging dan troubleshooting.
4. Membantu penyusunan dokumentasi tugas.

Seluruh implementasi tetap dilakukan, diuji, dan disesuaikan oleh pengembang sesuai kebutuhan tugas.
