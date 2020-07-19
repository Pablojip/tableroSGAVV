<?php

namespace App\Imports;

use App\Tema;
use Maatwebsite\Excel\Concerns\ToModel;

class TemaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Tema([
            'nombre'     => $row[0],
            'descripcion'     => $row[1],
            'materia_id'     => $row[2]
        ]);
    }
}
