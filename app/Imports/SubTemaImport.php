<?php

namespace App\Imports;

use App\SubTema;
use Maatwebsite\Excel\Concerns\ToModel;

class SubTemaImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new SubTema([
            'nombre'     => $row[0],
            'descripcion'     => $row[1],
            'tema_id'     => $row[2]
        ]);
    }
}
