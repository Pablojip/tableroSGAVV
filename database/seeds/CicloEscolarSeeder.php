<?php

use Illuminate\Database\Seeder;
use App\CicloEscolar;

class CicloEscolarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new CicloEscolar();
        $model->inicio = '2020';
        $model->fin = '2021';
        $model->save();
    }
}
