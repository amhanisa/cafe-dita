<?php

namespace App\Http\Controllers;

use App\Exports\TestImportExport;
use App\Exports\TestRegisterExport;
use App\Models\Patient;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class TestController extends Controller
{
    public function generateImport($count, $skip = 0)
    {
        $data['patients'] = Patient::with(['consultations' => function ($query) {
            $query->whereBetween('date', [Carbon::now()->endOfMonth()->subYear()->format('Y-m-d'), Carbon::now()->format('Y-m-d')]);
        }, 'village'])->skip($skip * $count)->take($count)->get();

        // return view('test.import',  $data);

        $filename = 'test-import-' . $count . '.xlsx';
        return Excel::download(new TestImportExport($data), $filename);
    }

    public function generateRegister($count, $skip = 0)
    {
        $data['patients'] = Patient::with(['consultations' => function ($query) {
            $query->whereBetween('date', [Carbon::now()->endOfMonth()->subYear()->format('Y-m-d'), Carbon::now()->format('Y-m-d')]);
        }, 'village'])->skip($skip * $count)->take($count)->get();

        // return view('test.register', $data);

        $filename = 'test-register-' . $count . '.xlsx';
        return Excel::download(new TestRegisterExport($data), $filename);
    }
}
