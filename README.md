<h1 align="center">Selamat datang di Toko Obat! </h1>

[![](https://img.shields.io/github/issues/fauzan121002/toko-obat-v1?style=flat-square)](https://img.shields.io/github/issues/fauzan121002/toko-obat-v1?style=flat-square) ![](https://img.shields.io/github/stars/fauzan121002/toko-obat-v1?style=flat-square)
![](https://img.shields.io/github/forks/fauzan121002/toko-obat-v1?style=flat-square) ![](https://img.shields.io/github/license/fauzan121002/toko-obat-v1?style=flat-square) [![saythanks](https://img.shields.io/badge/say-thanks-ff69b4.svg?style=flat-square)](https://saythanks.io/to/zaidanline67%40gmail.com) [![PRs Welcome](https://img.shields.io/badge/PRs-welcome-brightgreen.svg?style=flat-square)](http://makeapullrequest.com) [![Maintenance](https://img.shields.io/badge/Maintained%3F-yes-green.svg?style=flat-square)](https://GitHub.com/Naereen/StrapDown.js/graphs/commit-activity) [![GitHub followers](https://img.shields.io/github/followers/fauzan121002.svg?style=flat-square&label=Follow&maxAge=2592000)](https://github.com/fauzan121002?tab=followers)

### Apa itu Toko Obat ?
Web POS Toko Obat yang dibuat oleh <a href="https://github.com/fauzan121002"> Muhammad Fauzan </a>. **Toko Obat adalah Website untuk apotik ataupun toko obat dapat melihat history penjualan , dapat melakukan penjualan menggunakan media digital.**

### Fitur apa saja yang tersedia di Toko Obat?
- Autentikasi Admin & Kasir
- Dashboard
- Kasir
- Kategori 
- Jenis Obat
- Obat
- Kategori Obat
- Alat Kesehatan
- Suplemen 
- Supplier
- Riwayat Transaksi
- Update Pengumuman

### Release Date
**Release date : 12 May 2020**
> Toko Obat merupakan project open source yang dibuat oleh Muhammad Fauzan. Kalian dapat download/fork/clone. Cukup beri stars di project ini agar memberiku semangat. Terima kasih!

------------

 ### Default Account for testing
	
**Admin Default Account**
- Email: admin@smartpharmacy.com
- Password: smartpass

------------

## Install

1. **Clone Repository**
```bash
git clone https://github.com/fauzan121002/toko-obat-v1.git
cd toko-obat-v1
composer install
copy .env.example .env
```

2. **Buka ```.env``` lalu ubah baris berikut sesuai dengan databasemu yang ingin dipakai**
```
DB_PORT=3306
DB_DATABASE=<YOUR DATABASE NAME>
DB_USERNAME=<YOUR DATABASE USERNAME>
DB_PASSWORD=<YOUR DATABASE PASSWORD>
```

3. **Instalasi website**
```bash
php artisan key:generate
php artisan migrate
php artisan db:seed
php artisan storage:link
php artisan config:cache
php artisan config:clear
```

4. **Jalankan website**
```bash
php artisan serve
```

## Contributing
Contributions, issues and feature requests di persilahkan.
Jangan ragu untuk memeriksa halaman masalah jika Anda ingin berkontribusi. **Berhubung Project ini saya sudah selesaikan sendiri, namun banyak fitur yang kalian dapat tambahkan silahkan berkontribusi yaa!**

## License
- Copyright © 2020 Muhammad Fauzan.
- **Toko Obat is open-sourced software licensed under the MIT license.**

