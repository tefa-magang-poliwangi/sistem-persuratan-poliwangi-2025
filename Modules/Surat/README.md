# Surat

Sistem tata kelola persuratan internal Politeknik Negeri Banyuwangi merupakan sistem pengelolaan surat dan disposisi surat yang ada di Politeknik Negeri Banyuwangi. Sistem ini dilengkapi beberapa fitur untuk mengelola surat masuk seperti penyimpanan surat, pencarian surat, disposisi surat serta tracking surat yang dapat membantu sekretaris pimpinan untuk melihat dan melacak proses distribusi surat.

## Library

library yang digunakan antara lain :

-   Datatables
-   Select2
-   Go Js

## Langkah Langkah Seeder

-   php artisan migrate:fresh --seed
-   php artisan module:seed Blog (jika ada)
-   php artisan module:seed Jabatan (jika ada)
-   php artisan module:seed Kepegawaian (jika ada)
-   php artisan module:seed Kinerja (jika ada)
-   php artisan module:seed Surat (jika ada)
-   php artisan module:seed --class=SeederJabatanPegawaiTableSeederTableSeeder Surat (opsional, untuk update pegawai_id di tabel pejabats)
