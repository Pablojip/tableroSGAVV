<?php

use Illuminate\Database\Seeder;
use App\Grupo;
class GrupoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Grupo();
        $model->grupo = 'A';
        $model->save();

        $model = new Grupo();
        $model->grupo = 'B';
        $model->save();
        
        $model = new Grupo();
        $model->grupo = 'C';
        $model->save();

        $model = new Grupo();
        $model->grupo = 'D';
        $model->save();

        $model = new Grupo();
        $model->grupo = 'E';
        $model->save();

        $model = new Grupo();
        $model->grupo = 'F';
        $model->save();

        $model = new Grupo();
        $model->grupo = 'G';
        $model->save();
        
    }
}
