<?php

namespace Modules\Kinerja\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\Core\Menu;

class MenuModulKinerjaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Menu::where('modul','Kinerja')->delete();
        $menu = Menu::create([
            'modul' => 'Kinerja',
            'label' => 'Kinerja',
            'url' => '',
            'can' => serialize(['admin']),
            'icon' => 'far fa-circle',
            'urut' => 1,
            'parent_id' => 0,
            'active' => serialize(['kepegawaian']),
        ]);
        if($menu){
            Menu::create([
                'modul' => 'Kinerja',
                'label' => 'IKU',
                'url' => 'kinerja/iku',
                'can' => serialize(['admin']),
                'icon' => 'far fa-circle',
                'urut' => 1,
                'parent_id' => $menu->id,
                'active' => serialize(['kinerja/iku','kinerja/iku*']),
            ]);
        }
    }
}
