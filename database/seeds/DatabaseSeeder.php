<?php

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
        /**
         * é necessário chamar as outras seeders neste arquivo, ela é a unica que o laravel chama
         *
         */
         $this->call(AlbumsTableSeeder::class);
    }
}
