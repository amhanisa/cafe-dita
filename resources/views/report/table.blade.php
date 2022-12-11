<p class="text-center font-bold">
    Laporan Penderita Hipertensi di Cafe DITA Puskesmas Karangan, Trenggalek <br>
    {{ $startDate }} - {{ $endDate }} <br>
</p>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">
                    Nama Desa
                </th>
                <th colspan="3">
                    Jumlah Pasien Tidak Berobat Teratur
                </th>
                <th colspan="3">
                    Jumlah Pasien Berobat Teratur
                </th>
                <th colspan="3">
                    Jumlah Pasien Hipertensi Tidak Terkendali
                </th>
                <th colspan="3">
                    Jumlah Pasien Hipertensi Terkendali
                </th>
            </tr>
            <tr>
                <th>L</th>
                <th>P</th>
                <th>Total</th>
                <th>L</th>
                <th>P</th>
                <th>Total</th>
                <th>L</th>
                <th>P</th>
                <th>Total</th>
                <th>L</th>
                <th>P</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($villages as $key => $village)
                <tr>
                    <td>{{ $village->name }}</td>
                    <td>{{ isset($village->treatment[0]['L']) ? $village->treatment[0]['L']->count() : 0 }}
                    </td>
                    <td>{{ isset($village->treatment[0]['P']) ? $village->treatment[0]['P']->count() : 0 }}
                    </td>
                    <td>{{ (isset($village->treatment[0]['L']) ? $village->treatment[0]['L']->count() : 0) + (isset($village->treatment[0]['P']) ? $village->treatment[0]['P']->count() : 0) }}
                    </td>
                    <td>{{ isset($village->treatment[1]['L']) ? $village->treatment[1]['L']->count() : 0 }}
                    </td>
                    <td>{{ isset($village->treatment[1]['P']) ? $village->treatment[1]['P']->count() : 0 }}
                    </td>
                    <td>{{ (isset($village->treatment[1]['L']) ? $village->treatment[1]['L']->count() : 0) + (isset($village->treatment[1]['P']) ? $village->treatment[1]['P']->count() : 0) }}
                    </td>
                    <td>{{ isset($village->hypertension[1]['L']) ? $village->hypertension[1]['L']->count() : 0 }}
                    </td>
                    <td>{{ isset($village->hypertension[1]['P']) ? $village->hypertension[1]['P']->count() : 0 }}
                    </td>
                    <td>{{ (isset($village->hypertension[1]['L']) ? $village->hypertension[1]['L']->count() : 0) + (isset($village->hypertension[1]['P']) ? $village->hypertension[1]['P']->count() : 0) }}
                    </td>
                    <td>{{ isset($village->hypertension[0]['L']) ? $village->hypertension[0]['L']->count() : 0 }}
                    </td>
                    <td>{{ isset($village->hypertension[0]['P']) ? $village->hypertension[0]['P']->count() : 0 }}
                    </td>
                    <td>{{ (isset($village->hypertension[0]['L']) ? $village->hypertension[0]['L']->count() : 0) + (isset($village->hypertension[0]['P']) ? $village->hypertension[0]['P']->count() : 0) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>{{ $notRoutineTreatmentCountMale }}</td>
                <td>{{ $notRoutineTreatmentCountFemale }}</td>
                <td>{{ $notRoutineTreatmentCount }}</td>
                <td>{{ $routineTreatmentCountMale }}</td>
                <td>{{ $routineTreatmentCountFemale }}</td>
                <td>{{ $routineTreatmentCount }}</td>
                <td>{{ $hypertensionCountMale }}</td>
                <td>{{ $hypertensionCountFemale }}</td>
                <td>{{ $hypertensionCount }}</td>
                <td>{{ $notHypertensionCountMale }}</td>
                <td>{{ $notHypertensionCountFemale }}</td>
                <td>{{ $notHypertensionCount }}</td>
            </tr>
            <tr>
                <td>Persentase</td>
                <td>{{ $notRoutineTreatmentCount == 0 ? '0%' : round(($notRoutineTreatmentCountMale / $notRoutineTreatmentCount) * 100, 2) . '%' }}
                </td>
                <td>{{ $notRoutineTreatmentCount == 0 ? '0%' : round(($notRoutineTreatmentCountFemale / $notRoutineTreatmentCount) * 100, 2) . '%' }}
                </td>
                <td>{{ $notRoutineTreatmentCount == 0 ? '0%' : round(($notRoutineTreatmentCount / ($notRoutineTreatmentCount + $routineTreatmentCount)) * 100, 2) . '%' }}
                </td>
                <td>{{ $routineTreatmentCount == 0 ? '0%' : round(($routineTreatmentCountMale / $routineTreatmentCount) * 100, 2) . '%' }}
                </td>
                <td>{{ $routineTreatmentCount == 0 ? '0%' : round(($routineTreatmentCountFemale / $routineTreatmentCount) * 100, 2) . '%' }}
                </td>
                <td>{{ $routineTreatmentCount == 0 ? '0%' : round(($routineTreatmentCount / ($notRoutineTreatmentCount + $routineTreatmentCount)) * 100, 2) . '%' }}
                </td>
                <td>{{ $hypertensionCount == 0 ? '0%' : round(($hypertensionCountMale / $hypertensionCount) * 100, 2) . '%' }}
                </td>
                <td>{{ $hypertensionCount == 0 ? '0%' : round(($hypertensionCountFemale / $hypertensionCount) * 100, 2) . '%' }}
                </td>
                <td>{{ $hypertensionCount == 0 ? '0%' : round(($hypertensionCount / ($notHypertensionCount + $hypertensionCount)) * 100, 2) . '%' }}
                </td>
                <td>{{ $notHypertensionCount == 0 ? '0%' : round(($notHypertensionCountMale / $notHypertensionCount) * 100, 2) . '%' }}
                </td>
                <td>{{ $notHypertensionCount == 0 ? '0%' : round(($notHypertensionCountFemale / $notHypertensionCount) * 100, 2) . '%' }}
                </td>
                <td>{{ $notHypertensionCount == 0 ? '0%' : round(($notHypertensionCount / ($notHypertensionCount + $hypertensionCount)) * 100, 2) . '%' }}
                </td>
            </tr>
        </tfoot>
    </table>
</div>
