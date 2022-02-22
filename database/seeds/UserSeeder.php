<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\Roles;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();

        $adminRoles = Roles::where('name','admin')->first();
        $staffRoles = Roles::where('name','staff')->first();
        $userRoles = Roles::where('name','user')->first();

        $admin = Admin::create([
            'admin_name' => 'NetNguyen Admin',
            'admin_email' => 'netnguyenadmin@gmail.com',
            'admin_phone' => '0363319416',
            'admin_password' => md5('123456')

        ]);
        
        $admin = Admin::create([
            'admin_name' => 'NetNguyen Admin 2',
            'admin_email' => 'netnguyenadmin2@gmail.com',
            'admin_phone' => '0363319416',
            'admin_password' => md5('123456')

        ]);

        $staff = Admin::create([
            'admin_name' => 'NetNguyen Staff',
            'admin_email' => 'netnguyenstaff@gmail.com',
            'admin_phone' => '0363319416',
            'admin_password' => md5('123456')

        ]);

        $user = Admin::create([
            'admin_name' => 'NetNguyen User',
            'admin_email' => 'netnguyenuser@gmail.com',
            'admin_phone' => '0363319416',
            'admin_password' => md5('123456')

        ]);

        $admin->roles()->attach($adminRoles);
        $staff->roles()->attach($staffRoles);
        $user->roles()->attach($userRoles);

    }
}
