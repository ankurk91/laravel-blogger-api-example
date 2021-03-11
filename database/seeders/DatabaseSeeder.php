<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding: Environment - '.config('app.env'));

        $this->call([

        ]);

        // Don't seed these tables when in production
        if (! app()->environment(['production', 'staging', 'testing'])) {
            $this->call([
                UsersTableSeeder::class,
                CategoriesTableSeeder::class,
                PostsTableSeeder::class,
            ]);
        }
    }
}
