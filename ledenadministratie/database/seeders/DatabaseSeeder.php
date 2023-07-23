<?php

namespace Database\Seeders;

use App\Models\User;
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

        $user = User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com'
        ]);

        // On user Admin has admin rights over the 6 families 
        Family::factory(6)->create([
            'user_id' => $user->id
        ]);

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
