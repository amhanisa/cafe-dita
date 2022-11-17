<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    protected $villages;

    function __construct($villages)
    {
        $this->villages = $villages;
    }

    public function view(): View
    {
        return view('report.table', [
            'villages' => $this->villages
        ]);
    }
}
