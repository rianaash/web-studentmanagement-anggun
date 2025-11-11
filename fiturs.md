# 🚀 PROYEK: [Nama Proyek, misal: Web Jual Beli Rumah]

---

## 1. Ikhtisar Proyek

- **Tujuan Utama:**  
  [Tujuan utama proyek, misal: Membangun marketplace properti yang memungkinkan agen memamerkan listing secara detail, dan memiliki fokus utama pada lead generation (mengumpulkan data kontak calon pembeli yang serius via form inquiry).]

- **Tumpukan Teknologi:**  
  **TALL Stack (Laravel 12, Livewire 3/Volt, Alpine.js, Tailwind CSS versi 4, Vite)**  
  Laravel 12 membawa beberapa perubahan besar dari Laravel 10, termasuk:
  - **Pemindahan struktur service provider & middleware:** Banyak pendaftaran default kini diatur otomatis oleh kernel baru `@bootstrap/app.php` tanpa perlu deklarasi manual di `@config/app.php`.
  - **Registrasi Service Provider Otomatis:** Tidak perlu lagi menambahkan provider bawaan ke `@config/app.php`; sistem autodiscovery kini lebih pintar dan efisien.
  - **Routing & Middleware Modernized:** Middleware pipeline kini lebih modular, mendukung deklarasi berbasis class closure dan auto-injection yang lebih bersih.
  - **Fitur Bootstrap Application:** Laravel kini memisahkan bootstrap logic agar startup aplikasi lebih cepat dan lebih mudah di-custom.
  - **Peningkatan performa di container dan serialization**, membuat aplikasi microservice dan job queue lebih efisien.
  
  Sementara itu, **Tailwind CSS versi 4** memperkenalkan:
  - **Zero-runtime CSS:** Build engine baru sepenuhnya menggantikan PostCSS, menghasilkan CSS 30–40% lebih kecil.
  - **Mode `design tokens` bawaan:** Token warna, spacing, dan typography kini dideklarasikan secara global tanpa konfigurasi manual.
  - **Peningkatan Theme API:** Bisa override skema warna atau varian mode (light/dark/system) langsung di file konfigurasi.
  - **Auto-class pruning:** Tailwind otomatis menghapus class yang tidak digunakan saat proses build tanpa konfigurasi tambahan.
  - **Integrasi native dengan Vite:** Kompilasi lebih cepat dengan caching yang lebih efisien untuk proyek TALL Stack.

- **Arsitektur:**  
  Service Layer, Form Objects, Volt (untuk komponen kecil), Class Livewire (untuk komponen besar)


## 2. Peran Pengguna (Aktor)

- **[Peran Publik, misal: Pencari Rumah]:**  
  [Deskripsi singkat peran publik, misal: Pengguna anonim atau terdaftar yang mencari properti.]

- **[Peran Internal, misal: Admin/Agen]:**  
  [Deskripsi singkat peran internal, misal: Pengguna internal yang mengelola listing dan prospek.]

---

## 3. Fitur Wajib (Core/Pondasi)

- **Autentikasi:** Login, Register, Lupa Password  
- **Manajemen Role:** Pembeda antara [Peran Publik] dan [Peran Internal]  
- **Manajemen CRUD [Konten Utama]:** [Deskripsi CRUD utama, misal: Agen dapat menambah, mengedit, menghapus listing properti]  
- **Dasbor Admin:** Halaman utama untuk [Peran Internal]  
- **Halaman Profil:** Halaman utama untuk [Peran Publik]  

---

## 4. Fitur Unik (10 Fitur Utama)

1. **[Fitur Unik 1, misal: Pencarian & Filter Lanjutan]:** Menyaring listing berdasarkan lokasi, harga, jumlah kamar, dll.  
2. **[Fitur Unik 2, misal: Sistem "Simpan Favorit"]:** Pengguna (member) menandai listing yang disukai.  
3. **[Fitur Unik 3, misal: Halaman "Properti Favorit Saya"]:** Halaman profil yang menampilkan semua listing yang disimpan.  
4. **[Fitur Unik 4, misal: Form Inquiry (Lead Generation)]:** Form untuk calon pembeli menghubungi agen, mengirim data ke admin.  
5. **[Fitur Unik 5, misal: Kalkulator KPR Sederhana]:** Alat bantu menghitung estimasi cicilan bulanan.  
6. **[Fitur Unik 6, misal: Tampilan Peta Interaktif (Map View)]:** Menampilkan hasil pencarian sebagai pin di peta.  
7. **[Fitur Unik 7, misal: Fitur Bandingkan Properti]:** Membandingkan 2–3 properti secara berdampingan.  
8. **[Fitur Unik 8, misal: Galeri Foto Properti]:** Slider foto di halaman detail.  
9. **[Fitur Unik 9, misal: Notifikasi Prospek Baru (Admin/Agen)]:** Notifikasi (email/dasbor) untuk agen saat ada inquiry baru.  
10. **[Fitur Unik 10, misal: Ekspor Laporan Prospek (Admin/Agen)]:** Agen mengunduh data prospek (leads) dalam format Excel/CSV.  

---

## 5. Skema Database (ERD - DBML)
> Ini adalah sumber kebenaran untuk semua query dan model, jika ada tambahan migrasi atau perubahan skema DB pastikan untuk memperbarui skema DBML ini.

```dbml
// --- Skema Database untuk [Nama Proyek] ---

Table users {
  id int [pk, increment]
  name varchar(255) [not null]
  email varchar(255) [unique, not null]
  password varchar(255) [not null]
  role enum_user_role [not null, default: 'pencari']
  created_at timestamp [default: `now()`, not null]
  updated_at timestamp [default: `now()`, not null]
}

Table listings {
  id int [pk, increment]
  agent_id int [ref: > users.id, not null] // Relasi ke Agen
  title varchar(255) [not null]
  slug varchar(255) [unique, not null]
  description text
  price decimal(15, 2) [not null, default: 0]
  bedrooms int [not null, default: 1]
  bathrooms int [not null, default: 1]
  luas_bangunan int [not null, default: 0]
  luas_tanah int [not null, default: 0]
  address varchar(255)
  city varchar(100)
  latitude varchar(50)
  longitude varchar(50)
  status enum_listing_status [not null, default: 'published']
  created_at timestamp [default: `now()`, not null]
  updated_at timestamp [default: `now()`, not null]
}

Table listing_images {
  id int [pk, increment]
  listing_id int [ref: > listings.id, not null]
  image_path varchar(255) [not null]
  is_featured boolean [default: false]
  created_at timestamp [default: `now()`, not null]
}

Table inquiries {
  id int [pk, increment]
  listing_id int [ref: > listings.id, not null]
  user_id int [ref: > users.id] // Bisa null jika guest
  name varchar(255) [not null]
  phone varchar(20) [not null]
  message text
  status enum_inquiry_status [not null, default: 'baru']
  created_at timestamp [default: `now()`, not null]
  updated_at timestamp [default: `now()`, not null]
}

// Tabel pivot untuk Fitur Favorit (Many-to-Many)
Table user_favorites {
  user_id int [ref: > users.id]
  listing_id int [ref: > listings.id]
  indexes { (user_id, listing_id) [unique] }
}

Enum enum_user_role {
  pencari
  agen
  admin
}

Enum enum_listing_status {
  published
  draft
  sold
}

Enum enum_inquiry_status {
  baru
  dihubungi
  deal
  batal
}
```