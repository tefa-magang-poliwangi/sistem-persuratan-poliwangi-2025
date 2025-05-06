<?php

namespace Modules\Surat\Database\Seeders;

use App\Models\Core\Menu;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class MenuModulSuratTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Menu::where('modul', 'Surat')->delete();
        $menu = Menu::create([
            'modul' => 'Surat',
            'label' => 'Surat',
            'url' => '',
            'can' => serialize(['admin', 'direktur', 'wadir1', 'wadir2', 'wadir3', 'pegawai']),
            'icon' => 'fas fa-envelope',
            'urut' => 1,
            'parent_id' => 0,
            'active' => serialize(['surat']),
        ]);
        if ($menu) {
            Menu::create([
                'modul' => 'Surat',
                'label' => 'Surat Masuk',
                'url' => 'surat/surat-masuk',
                'can' => serialize(['admin', 'pegawai']),
                'icon' => 'far fa-circle',
                'urut' => 1,
                'parent_id' => $menu->id,
                'active' => serialize(['surat/surat-masuk', 'surat-masuk*']),
            ]);
            Menu::create([
                'modul' => 'Surat',
                'label' => 'Arsip Surat',
                'url' => 'surat/arsip',
                'can' => serialize(['admin']),
                'icon' => 'far fa-circle',
                'urut' => 1,
                'parent_id' => $menu->id,
                'active' => serialize(['surat/arsip', 'surat/arsip*']),
            ]);
            Menu::create([
                'modul' => 'Surat',
                'label' => 'Disposisi Surat',
                'url' => 'surat/disposisi-surat',
                'can' => serialize(['admin', 'direktur']),
                'icon' => 'far fa-circle',
                'urut' => 1,
                'parent_id' => $menu->id,
                'active' => serialize(['surat/disposisi-surat', 'surat/disposisi-surat*']),
            ]);
            Menu::create([
                'modul' => 'Surat',
                'label' => 'Surat Wakil Direktur',
                'url' => 'surat/wadir',
                'can' => serialize(['admin', 'wadir1', 'wadir2', 'wadir3']),
                'icon' => 'far fa-circle',
                'urut' => 1,
                'parent_id' => $menu->id,
                'active' => serialize(['surat/wadir', 'surat/wadir*']),
            ]);

            // $this->call("OthersTableSeeder");
        }
    }
}
