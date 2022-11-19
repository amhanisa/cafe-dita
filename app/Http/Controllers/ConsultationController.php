<?php

namespace App\Http\Controllers;

use App\Imports\ConsultationsImport;
use App\Models\Consultation;
use App\Models\Patient;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

class ConsultationController extends Controller
{
    public function showListConsultationPage(Request $request)
    {
        return view('consultation.index');
    }

    public function showImportPage()
    {
        return view('consultation.import');
    }

    public function storeImportedConsultations(Request $request)
    {
        Excel::import(new ConsultationsImport(), $request->file('import_file'));

        return redirect('consultation')->with('toast_success', 'Data konsultasi berhasil diimpor');
    }

    public function showAddConsultationPage($patient_id)
    {
        $data['patient'] = Patient::find($patient_id);

        return view('consultation.add', $data);
    }

    public function storeConsultation(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'systole' => 'required|numeric|integer',
            'diastole' => 'required|numeric|integer',
        ]);

        $consultation = new Consultation();
        $consultation->patient_id = $request->patient_id;
        $consultation->date = $request->date;
        $consultation->systole = $request->systole;
        $consultation->diastole = $request->diastole;
        $consultation->medicine = $request->medicine;
        $consultation->note = $request->note;
        $consultation->save();

        return redirect("/patient/" . $request->patient_id)->with('toast_success', 'Data konsultasi berhasil ditambah');
    }

    public function showEditConsultationPage($consultation_id)
    {
        $data['consultation'] = Consultation::getConsultationWithPatient($consultation_id);

        return view('consultation.edit', $data);
    }

    public function updateConsultation(Request $request)
    {
        $request->validate([
            'date' => 'required',
            'systole' => 'required|numeric|integer',
            'diastole' => 'required|numeric|integer',
        ]);

        $consultation = Consultation::find($request->consultation_id);
        $consultation->date = $request->date;
        $consultation->systole = $request->systole;
        $consultation->diastole = $request->diastole;
        $consultation->medicine = $request->medicine;
        $consultation->note = $request->note;
        $consultation->save();

        return redirect("/patient/" . $consultation->patient_id)->with('toast_success', 'Data konsultasi berhasil diubah');
    }

    public function destroyConsultation(Request $request)
    {
        $consultation = Consultation::find($request->consultation_id);

        $consultation->delete();

        return redirect("patient/" . $consultation->patient_id)->with('toast_success', 'Data konsultasi berhasil dihapus');
    }

    public function getAjaxDatatable()
    {
        $consultations = Consultation::with('patient')
            ->orderBy('date', 'desc');

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
}
