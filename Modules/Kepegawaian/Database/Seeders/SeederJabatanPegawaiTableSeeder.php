<?php

namespace Modules\Kepegawaian\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class SeederJabatanPegawaiTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
   public function run()
    {
        $pejabats = DB::table('pejabats')->get();

        foreach ($pejabats as $pejabat) {
            $pegawai = DB::table('pegawais')->where('nama', $pejabat->jabatan)->first();

            if ($pegawai) {
                DB::table('pejabats')
                    ->where('id', $pejabat->id)
                    ->update([
                        'pegawai_id' => $pegawai->id,
                        'updated_at' => now(),
                    ]);
            }
        }
    }

}
