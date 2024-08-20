<?php

namespace Database\Seeders;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'Administrator' , 'alias'=>"سوپر ادمین" , "guard_name"=>'api'   ] );
        Role::create(['name' => 'Simple User' , 'alias' => 'یوزر'  , "guard_name"=>'api' ]);
    }
}
