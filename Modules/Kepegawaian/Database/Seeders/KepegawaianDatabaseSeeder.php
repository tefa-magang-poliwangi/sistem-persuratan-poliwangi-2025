<?php

namespace Modules\Kepegawaian\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Modules\Kepegawaian\Entities\Pegawai;

class KepegawaianDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Data user dan role
        $users = [
            [
                "id"=> 1,
                "nip"=> "195602221988111001",
                "nama"=> "Direktur",
                "id_staff"=> 4,
                "id_jurusan"=> 4,
                "id_prodi"=> null,
                "jenis_kelamin"=> "L",
                "gelar_dpn"=> null,
                "gelar_blk"=> null,
                "username"=> "direktur"
            ],
            [
                "id"=> 2,
                "nip"=> "195602221988111002",
                "nama"=> "Wakil Direktur Bidang Akademik",
                "id_staff"=> 4,
                "id_jurusan"=> 4,
                "id_prodi"=> null,
                "jenis_kelamin"=> "L",
                "gelar_dpn"=> null,
                "gelar_blk"=> null,
                "username"=> "wadir1"
            ],
            [
                "id"=> 3,
                "nip"=> "195602221988111003",
                "nama"=> "Wakil Direktur Bidang Umum dan Keuangan",
                "id_staff"=> 4,
                "id_jurusan"=> 4,
                "id_prodi"=> null,
                "jenis_kelamin"=> "L",
                "gelar_dpn"=> null,
                "gelar_blk"=> null,
                "username"=> "wadir2"
            ],
            [
                "id"=> 4,
                "nip"=> "195602221988111004",
                "nama"=> "Wakil Direktur Bidang Kemahasiswaan dan Alumni",
                "id_staff"=> 4,
                "id_jurusan"=> 4,
                "id_prodi"=> null,
                "jenis_kelamin"=> "L",
                "gelar_dpn"=> null,
                "gelar_blk"=> null,
                "username"=> "wadir3"
            ],[
                "id"=> 5,
                "nip"=> "195602221988111005",
                "nama"=> "Sekdir",
                "id_staff"=> 4,
                "id_jurusan"=> 4,
                "id_prodi"=> null,
                "jenis_kelamin"=> "L",
                "gelar_dpn"=> null,
                "gelar_blk"=> null,
                "username"=> "sekdir"
            ],[
                "id"=> 6,
                "nip"=> "195602221988111006",
                "nama"=> "Ketua Jurusan Bisnis dan Informatika",
                "id_staff"=> 4,
                "id_jurusan"=> 1,
                "id_prodi"=> null,
                "jenis_kelamin"=> "L",
                "gelar_dpn"=> null,
                "gelar_blk"=> null,
                "username"=> "kbi"
            ],[
                "id"=> 7,
                "nip"=> "195602221988111007",
                "nama"=> "Ketua Jurusan Teknik Sipil",
                "id_staff"=> 4,
                "id_jurusan"=> 2,
                "id_prodi"=> null,
                "jenis_kelamin"=> "L",
                "gelar_dpn"=> null,
                "gelar_blk"=> null,
                "username"=> "kts"
            ]
        ];

        // Menyimpan data ke tabel user
        DB::table('pegawais')->insert($users);
    }
}
