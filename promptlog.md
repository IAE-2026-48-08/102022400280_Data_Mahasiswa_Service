# PROMPT_LOG.md

## Riwayat Penggunaan AI

Project : **102022400280_service_data_mahasiswa**

AI digunakan sebagai alat bantu selama proses pengembangan aplikasi untuk membantu memahami konsep, debugging, serta menghasilkan contoh implementasi kode.

---

### Prompt 1

> Buatkan REST API Laravel untuk data mahasiswa dengan endpoint GET semua mahasiswa, GET detail mahasiswa, dan POST validasi kuota SKS.

Hasil:
Berhasil membuat endpoint REST API sesuai kebutuhan.

---

### Prompt 2

> Buatkan StudentController beserta fungsi index(), show(), dan validateQuota().

Hasil:
Controller berhasil dibuat dan dapat mengambil data dari database.

---

### Prompt 3

> Bagaimana cara membuat middleware API Key menggunakan header X-API-KEY di Laravel?

Hasil:
API berhasil diamankan menggunakan middleware ApiKeyMiddleware.

---

### Prompt 4

> Bantu membuat dokumentasi Swagger menggunakan L5-Swagger.

Hasil:
Swagger berhasil dibuat dan dapat digunakan untuk menguji endpoint API.

---

### Prompt 5

> Kenapa muncul error Required @OA\Info() not found saat generate Swagger?

Hasil:
Konfigurasi OpenAPI berhasil diperbaiki sehingga dokumentasi dapat digenerate dengan baik.

---

### Prompt 6

> Implementasikan GraphQL menggunakan Lighthouse pada Laravel.

Hasil:
Endpoint GraphQL berhasil dibuat pada `/graphql`.

---

### Prompt 7

> Buat schema GraphQL untuk data mahasiswa.

Hasil:
Berhasil membuat query `students` dan `student(id)`.

---

### Prompt 8

> Kenapa GraphQL muncul error Cannot return null for non-nullable field?

Hasil:
Masalah terjadi karena nama field pada schema berbeda dengan nama kolom di database dan berhasil diperbaiki.

---

### Prompt 9

> Bagaimana cara testing GraphQL menggunakan Postman?

Hasil:
GraphQL berhasil diuji menggunakan Postman dan dapat mengambil data mahasiswa dari database.

---

## Kesimpulan

AI digunakan sebagai pendamping dalam proses pengembangan aplikasi untuk membantu mencari solusi, debugging, dan referensi implementasi. Seluruh proses penyesuaian, pengujian, dan implementasi akhir dilakukan oleh pengembang sesuai kebutuhan project.
