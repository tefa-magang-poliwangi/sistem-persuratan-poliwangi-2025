<?php

namespace Database\Seeders;

use App\Models\Core\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class UserPegawaiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            // Generate all route permissions if needed
            \Artisan::call('permission:create-permission-routes');
    
            // Permissions umum
            $defaultPermissions = Permission::whereIn('name', [
                'adminlte.darkmode.toggle',
                'logout.perform',
                'home.index',
                'login.show',
            ])->pluck('id')->all();
    
            // Data user dan role
            $users = [
                [
                    'name' => 'Direktur',
                    'nip'=> "195602221988111001",
                    'email' => 'direktur@example.com',
                    'username' => 'direktur',
                    'password' => 'direktur123',
                    'role' => 'direktur',
                ],
                [
                    'name' => 'Wakil Direktur 1',
                    'nip'=> '195602221988111002',
                    'email' => 'wadir1@example.com',
                    'username' => 'wadir1',
                    'password' => 'wadir1123',
                    'role' => 'wadir1',
                ],
                [
                    'name' => 'Wakil Direktur 2',
                    'nip'=> '195602221988111003',
                    'email' => 'wadir2@example.com',
                    'username' => 'wadir2',
                    'password' => 'wadir2123',
                    'role' => 'wadir2',
                ],
                [
                    'name' => 'Wakil Direktur 3',
                    'nip'=> '195602221988111004',
                    'email' => 'wadir3@example.com',
                    'username' => 'wadir3',
                    'password' => 'wadir3123',
                    'role' => 'wadir3',
                ],
            ];
    
            foreach ($users as $data) {
                $user = User::create([
                    'name' => $data['name'],
                    'email' => $data['email'],
                    'username' => $data['username'],
                    'password' => Hash::make($data['password']),
                    'unit' => 0,
                    'staff' => 0,
                    'status' => 2
                ]);
    
                $role = Role::firstOrCreate(['name' => $data['role']]);
                $role->syncPermissions($defaultPermissions);
    
                $user->assignRole($role);
            }
        }
    }
