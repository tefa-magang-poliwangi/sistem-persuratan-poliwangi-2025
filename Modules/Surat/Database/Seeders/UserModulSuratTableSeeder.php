<?php

namespace Modules\Surat\Database\Seeders;

use App\Models\Core\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserModulSuratTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Artisan::call('permission:create-permission-routes-sync');

        $roleAdmin = Role::updateOrCreate(['name' => 'admin']);
        $rolePimpinan = Role::updateOrCreate(['name' => 'direktur']);
        $roleWadir1 = Role::updateOrCreate(['name' => 'wadir1']);
        $roleWadir2 = Role::updateOrCreate(['name' => 'wadir2']);
        $roleWadir3 = Role::updateOrCreate(['name' => 'wadir3']);

        $permissions = Permission::whereIn('name', [
            'adminlte.darkmode.toggle',
            'logout.perform',
            'home.index',
            'login.show',
            'beralih.peran',
            'disposisi-surat.index',
            'disposisi-surat.create',
            'disposisi-surat.store',
            'disposisi-surat.show',
            'disposisi-surat.edit',
            'disposisi-surat.update',
            'disposisi-surat.destroy',
            'disposisi-surat.edit-disposisi',
            'disposisi-surat.update-disposisi',
            'disposisi-surat.detail',
        ])->pluck('id')->all();

        $permissionsWadir = Permission::whereIn('name', [
            'adminlte.darkmode.toggle',
            'logout.perform',
            'home.index',
            'login.show',
            'beralih.peran',
            'wadir.index',
            'wadir.create',
            'wadir.store',
            'wadir.show',
            'wadir.edit',
            'wadir.update',
            'wadir.destroy',
            'wadir.acc',
            'wadir.update-disposisi',
            'wadir.detail',
        ])->pluck('id')->all();

        $permissionsAdmin = Permission::whereIn('name', [
            'surat-masuk.diagram',
            'surat-masuk.arsip',
            'surat-masuk.selesai',
            'surat-masuk.detail',
            'surat-masuk.disposisi',
            'surat-masuk.lembar-disposisi',
            'surat-masuk.acc',
            'disposisi-surat.edit-disposisi',
            'disposisi-surat.update-disposisi',
            'disposisi-surat.detail',
            'wadir.acc',
            'wadir.update-disposisi',
            'wadir.detail',
        ])->pluck('id')->all();

        // $pimpinan->assignRole($rolePimpinan);
        // $rolePimpinan->syncPermissions($permissions);
        $roleAdmin->givePermissionTo($permissionsAdmin);
        $rolePimpinan->givePermissionTo($permissions);
        $roleWadir1->givePermissionTo($permissionsWadir);
        $roleWadir2->givePermissionTo($permissionsWadir);
        $roleWadir3->givePermissionTo($permissionsWadir);
    }
}
