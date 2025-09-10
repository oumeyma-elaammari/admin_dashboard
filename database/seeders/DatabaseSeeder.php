<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(['email'=>'admin@example.com'],[
            'name'=>'Admin',
            'password'=>bcrypt('azerty123'),
            'role'=>'admin',
        ]);
        User::firstOrCreate(['email'=>'subadmin@example.com'],[
            'name'=>'Subadmin',
            'password'=>bcrypt('qwerty123'),
            'role'=>'subadmin',
        ]);
        User::firstOrCreate(['email'=>'client@example.com'],[
            'name'=>'Client',
            'password'=>bcrypt('client123'),
            'role'=>'client',
        ]);
    }
}
