<?php

namespace App\Exports;

use App\Imports\ExcelFile;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class EmailExport implements FromView {

    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        return view('exports.email', [
            'emails' => $this->data
        ]);
    }
}
