<?php

namespace Database\Seeders;

use App\Models\Family;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvent;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(5)->create();

        // In FamilyFactory.php is the code and to quickly make some data for families
        Family::factory(3)->create();

        // Family::create([
        //     'name' => 'Harry Potter',
        //     'tags' => 'laravel, lumos',
        //     'address' => 'Diagonally 4',
        //     'email' => 'h.potter@wizard.uk',
        //     'website' => 'https://www.wizardingworld.com/',
        //     'description' => 'Begin your journey into J.K. Rowlings wizarding world at the Starting Harry Potter hub,
        //      where you can read or listen to the first chapter now. 
        //      The magical world awaits!'
        // ]);
    }
}
