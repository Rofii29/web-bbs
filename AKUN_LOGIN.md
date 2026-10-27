# Kredensial Login Sistem BBS

Simpan dan gunakan akun berikut untuk masuk ke dalam aplikasi:

---

## 1. Akun Admin HES
Akun ini memiliki hak akses penuh ke dashboard Admin HES (Monitoring data, verifikasi kru, analisis risiko & C4.5, input rekomendasi).

* **Role**: `admin`
* **Nama**: `admin`
* **Email**: `admin@gmail.com`
* **Password**: *(Gunakan password minimal 12 karakter yang baru saja Anda buat di terminal)*
* **Status**: `active`

---

## 2. Akun Karyawan (Demo - Siap Pakai)
Akun ini digunakan untuk masuk ke portal Karyawan (Input observasi BBS, riwayat observasi, profil).

* **Role**: `karyawan`
* **Nama**: Budi Santoso
* **Email**: `karyawan@example.com`
* **Password**: `password`
* **Status**: `active` (Langsung aktif tanpa perlu verifikasi)

---

## 3. Akun Karyawan Demo (Uji Status Pending)
Akun ini digunakan untuk menguji alur verifikasi kru baru (akan dicegat sistem dengan keterangan *"Menunggu verifikasi Admin"*).

* **Role**: `karyawan`
* **Nama**: Rizky Pratama
* **Email**: `pending@example.com`
* **Password**: `password`
* **Status**: `pending`

---

## Catatan Tambahan:
Jika ingin membuat akun Admin tambahan di kemudian hari, jalankan perintah di terminal:
```powershell
php artisan hes:admin-create
```
