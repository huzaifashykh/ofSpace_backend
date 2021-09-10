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
        $this->call(CategorySeeder::class);
        $this->call(CountrySeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ScholarshipSeeder::class);
        $this->call(ForumSeeder::class);
        $this->call(CommentSeeder::class);
        $this->call(FavouriteSeeder::class);
    }
}
