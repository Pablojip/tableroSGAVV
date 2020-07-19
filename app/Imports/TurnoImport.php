<?php

namespace App\Imports;

use App\Turno;
use Maatwebsite\Excel\Concerns\ToModel;

class TurnoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Turno([
            'turno'     => $row[0]
        ]);
    }
}
