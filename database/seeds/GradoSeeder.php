<?php

use Illuminate\Database\Seeder;
use  App\Grado;

class GradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Grado();
        $model->grado = 1;
        $model->save();

        $model = new Grado();
        $model->grado = 2;
        $model->save();

        $model = new Grado();
        $model->grado = 3;
        $model->save();

        $model = new Grado();
        $model->grado = 4;
        $model->save();

        $model = new Grado();
        $model->grado = 5;
        $model->save();

        $model = new Grado();
        $model->grado = 6;
        $model->save();


    }
}
