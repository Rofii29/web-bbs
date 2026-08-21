# Planning Sistem Informasi Observasi BBS (Behavior Based Safety)
### Berbasis Web dengan Klasifikasi Risiko Algoritma C4.5

---

## 1. Gambaran Umum

| Item | Keterangan |
|---|---|
| Role pengguna | Admin/HES, Karyawan |
| Metode analitik | C4.5 (Decision Tree) — klasifikasi tingkat risiko: Rendah / Sedang / Tinggi |
| Platform | Web based |

---

## 2. Alur Autentikasi

### 2.1 Register
Karyawan mendaftar akun sendiri (self-registration), status awal **"Menunggu Verifikasi"**, baru bisa login setelah disetujui Admin/HES — ini mencegah orang luar sembarangan daftar.

**Field form register:**
- Nama lengkap
- Email
- No. HP
- Jabatan / Posisi
- Unit / Departemen
- Password + konfirmasi password

**Alur:**
1. Karyawan isi form register → data masuk status `pending`
2. Admin/HES dapat notifikasi ada pendaftar baru
3. Admin/HES verifikasi → approve (jadi `active`) atau reject
4. Karyawan dapat email/notifikasi status akun

> Alternatif lebih simpel (kalau mau kurangi kompleksitas TA): Admin yang membuat akun karyawan langsung dari panel admin (tidak ada self-register). Silakan pilih mana yang lebih sesuai kebutuhan bab metodologi kamu.

### 2.2 Login
- Login pakai Email + Password
- Redirect otomatis sesuai role: Admin/HES → dashboard admin, Karyawan → dashboard karyawan
- Fitur pendukung: "Lupa Password" (reset via email), pembatasan percobaan login (opsional, untuk keamanan)

### 2.3 Manajemen Sesi
- Logout
- (Opsional) Edit profil & ganti password saat sudah login

---

## 3. Halaman Karyawan

| Halaman | Fungsi |
|---|---|
| **Dashboard Karyawan** | Ringkasan: jumlah observasi yang sudah diinput, status terakhir (menunggu verifikasi/terverifikasi) |
| **Form Observasi Baru** | Isi data sesuai form BBS: tanggal, lokasi, unit, Safe/At-Risk, pilih kategori perilaku (checklist 10 kategori seperti di form asli), narasi Ketika/Ditemukan/Sebab/Saran |
| **Riwayat Observasi Saya** | List observasi yang pernah diinput karyawan tsb, dengan filter tanggal & status, bisa lihat detail |
| **Detail Observasi** | Lihat kembali data yang sudah disubmit + hasil klasifikasi risiko (Rendah/Sedang/Tinggi) jika sudah diproses sistem |
| **Profil Saya** | Edit data diri, ganti password |

---

## 4. Halaman Admin / HES

| Halaman | Fungsi |
|---|---|
| **Dashboard Admin** | Ringkasan angka: total observasi, rasio Safe vs At-Risk, distribusi tingkat risiko (pie/bar chart), tren observasi per periode |
| **Verifikasi Akun Karyawan** | Approve/reject pendaftar baru (jika pakai self-register) |
| **Kelola Data Observasi** | Lihat semua observasi masuk dari seluruh karyawan, filter per area/unit/tanggal/tingkat risiko, verifikasi data |
| **Hasil Klasifikasi C4.5** | Tabel observasi + hasil prediksi otomatis (Rendah/Sedang/Tinggi), highlight yang "Tinggi" sebagai prioritas |
| **Manajemen Tindak Lanjut** | Update status tindak lanjut Steering Committee (Open → In Progress → Closed) untuk observasi risiko tinggi |
| **Kelola Master Data** | CRUD kategori perilaku (10 kelompok: Posisi Badan, APD, Mengemudi, dst), area/unit, lokasi |
| **Modul Training Model C4.5** | Kelola data training (label historis), jalankan retraining model, lihat evaluasi model (akurasi, confusion matrix, visual pohon keputusan) |
| **Dashboard Analitik** | Grafik top kategori perilaku berisiko, heatmap area/waktu rawan, performa observasi per karyawan (leading indicator) |
| **Laporan** | Export rekap PDF/Excel per periode (pengganti rekap manual) |
| **Manajemen User** | Kelola seluruh akun karyawan (aktif/nonaktif, reset password, dsb) |

---

## 5. Hak Akses (Role-Based Access)

| Fitur | Karyawan | Admin/HES |
|---|:---:|:---:|
| Register / Login | ✓ | ✓ |
| Input observasi baru | ✓ | ✓ (opsional) |
| Lihat riwayat observasi sendiri | ✓ | — |
| Lihat semua observasi | — | ✓ |
| Verifikasi akun & data | — | ✓ |
| Kelola master data | — | ✓ |
| Kelola & retrain model C4.5 | — | ✓ |
| Dashboard analitik | — | ✓ |
| Export laporan | — | ✓ |
| Kelola tindak lanjut | — | ✓ |

---

## 6. Struktur Menu (Sitemap Sederhana)

```
Landing / Login
├── Register (karyawan)
├── Login
│   ├── → Dashboard Karyawan
│   │     ├── Form Observasi Baru
│   │     ├── Riwayat Observasi
│   │     ├── Detail Observasi
│   │     └── Profil
│   │
│   └── → Dashboard Admin/HES
│         ├── Verifikasi Akun
│         ├── Kelola Observasi
│         ├── Hasil Klasifikasi C4.5
│         ├── Tindak Lanjut
│         ├── Master Data
│         ├── Training Model
│         ├── Dashboard Analitik
│         ├── Laporan
│         └── Manajemen User
```

---

## 7. Catatan untuk Bab Metodologi TA

1. **Metode pengembangan sistem**: sebutkan Waterfall/Agile + alasan pemilihan
2. **Metode analisis data**: jelaskan tahapan C4.5 (hitung entropy → gain ratio → pemilihan atribut akar → split rekursif → pruning)
3. **Pengujian sistem**: Black-box testing per modul (form, login, dashboard) + pengujian model (akurasi, precision, recall, confusion matrix)
4. **Diagram pendukung yang perlu disiapkan**: Use Case Diagram, ERD, Activity Diagram (alur input observasi → klasifikasi → notifikasi), Sequence Diagram

---

## 8. Langkah Selanjutnya (Disarankan)

1. Finalisasi keputusan: register mandiri vs dibuat admin
2. Buat ERD lengkap (termasuk tabel training data & hasil klasifikasi)
3. Buat Use Case Diagram
4. Buat wireframe/mockup halaman utama
