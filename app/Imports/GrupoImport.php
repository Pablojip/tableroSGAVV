<?php

namespace App\Imports;

use App\Grupo;
use Maatwebsite\Excel\Concerns\ToModel;

class GrupoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Grupo([
            'grupo'     => $row[0]
        ]);
    }
}
