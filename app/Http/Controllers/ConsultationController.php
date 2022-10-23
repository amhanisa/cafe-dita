<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ConsultationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $consultations = Consultation::with('patient')
                ->orderBy('date', 'desc')
                ->get();

            return DataTables::of($consultations)
                ->addIndexColumn()
                ->addColumn('bloodtension', function ($row) {
                    return $row->systole . '/' . $row->diastole;
                })
                ->addColumn('action', function ($row) {
                    $html = "<a href='patient/$row->patient_id' class='btn btn-xs btn-secondary'>View</a> ";
                    return $html;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        return view('consultation.index');
    }
}
