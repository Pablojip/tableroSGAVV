<?php

namespace App\Imports;

use App\Alumno;
use Maatwebsite\Excel\Concerns\ToModel;

class AlumnoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Alumno([
            'matricula'                => $row[0],
            'nombres'                  => $row[1],
            'apellido_paterno'         => $row[2],
            'apellido_materno'         => $row[3],
        ]);
    }
}
