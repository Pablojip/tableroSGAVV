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
        // $this->call(UserSeeder::class);

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(CicloEscolarSeeder::class);
        $this->call(GradoSeeder::class);
        $this->call(GrupoSeeder::class);
        $this->call(TurnoSeeder::class);

    }
}
