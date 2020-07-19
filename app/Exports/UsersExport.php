<?php

namespace App\Exports;

use App\User;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class UsersExport implements FromView
{
    protected $columnas;

    public function __construct($data = null)
    {
        $this->columnas = $data;
    }
    public function view(): View
    {
        return view('excel.excel_datos', [
            'columnas' => $this->columnas
        ]);
    }
}
