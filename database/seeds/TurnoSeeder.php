<?php

use Illuminate\Database\Seeder;
use App\Turno;
class TurnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $model = new Turno();
        $model->turno = 'Matutino';
        $model->save();

        $model = new Turno();
        $model->turno = 'Vespertino';
        $model->save();
    }
}
