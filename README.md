## Nama           : Aldi Satriya

## Kelas          : TI.23.C1

## NIM            : 312310759

## Mata Kuliah    : Pemrograman Web 2

## Dosen Pengampu : Agung Nugroho, S.Kom., M.Kom

## Universitas    : Universitas Pelita Bangsa


## Hasil Praktikum 1: PHP Framework (Codeigniter)
![xampp](img/xampp.png)

![xampp](img/intl.png)

![xampp](img/1.png)

![xampp](img/2.png)

![xampp](img/3.png)

![xampp](img/4.png)

![xampp](img/5.png)

![xampp](img/6.png)

![xampp](img/7.png)

![xampp](img/8.png)

## Praktikum 2: Framework Lanjutan (CRUD)

![xampp](img/9.png)

![xampp](img/10.png)

![xampp](img/11.png)

![xampp](img/12.png)

![xampp](img/13.png)

![xampp](img/14.png)

![xampp](img/15.png)

## Praktikum 3: View Layout dan View Cell

![xampp](img/16.png)



Penjelasan

1. Manfaat View Layout: memudahkan pembuatan tampilan konsisten dan DRY (Don't Repeat Yourself).

2. Perbedaan View Cell vs View biasa:

  - View Biasa: hanya digunakan langsung di controller.

  - View Cell: bisa digunakan berulang kali seperti komponen/modul.

3. Modifikasi View Cell untuk hanya menampilkan post dengan kategori tertentu.


## Praktikum 4: Modul Login

![xampp](img/Login.png)

## Praktikum 5 : Pagination dan Pencarian
### 1. Pagination
Saya mengedit controller Artikel untuk menampilkan daftar artikel menggunakan paginate(3) dan menampilkan pagination links di view.
**Screenshot:**
![xampp](img/pagination.png)
### 2. Pencarian
Saya menambahkan fitur pencarian dengan query `q`, melakukan filter `like('judul', $q)` dan menyesuaikan tampilan form di view.

**Screenshot:**
![xampp](img/search.png)

### 3. Uji Coba
- Pagination muncul saat data lebih dari 3.
- Pencarian berhasil menampilkan data yang relevan.

**Screenshot:**
![xampp](img/hasil-cari.png)

## Praktikum 6: Upload File Gambar
- Menambahkan input file `gambar` di form `artikel/form_add.php`
![xampp](img/input_file.png)

- Menyesuaikan tag `<form>` dengan `enctype="multipart/form-data"`
![xampp](img/Choose-File.png)  

- Mengupdate method `add()` pada `Artikel.php` untuk menyimpan file gambar ke folder `public/gambar`
![xampp](img/simpan_php.png)

- Menyimpan nama file gambar ke database
![xampp](img/hasil.png)