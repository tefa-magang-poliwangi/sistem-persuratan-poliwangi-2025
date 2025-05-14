<?php

namespace Database\Seeders;

use App\Models\Core\Menu;
use Illuminate\Database\Seeder;
use Modules\Jabatan\Database\Seeders\JabatanDatabaseSeeder;
use Modules\Kepegawaian\Database\Seeders\KepegawaianDatabaseSeeder;
use Modules\Surat\Database\Seeders\MenuModulSuratTableSeeder;
use Modules\Surat\Database\Seeders\UserModulSuratTableSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(CreateAdminUserSeeder::class);
        $this->call(MenusTableSeeder::class);
        // $this->call(UserModulSuratTableSeeder::class);//modul surat
        $this->call(UserPegawaiSeeder::class);
        // $this->call(MenuModulSuratTableSeeder::class);//modul surat
        // $this->call(KepegawaianDatabaseSeeder::class);//modul kepegawaian
        // $this->call(JabatanDatabaseSeeder::class);//modul jabatan
    }
}
