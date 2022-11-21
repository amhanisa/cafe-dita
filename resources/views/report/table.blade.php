<p class="text-center font-bold">
    Laporan Penderita Hipertensi di Cafe DITA Puskesmas Karangan, Trenggalek <br>
    1 Januari 2020 - 31 Desember 20220 <br>
    Rentang Usia 1 - 100 <br>
</p>
<div class="table-responsive">
    <table class="table table-bordered">
        <thead>
            <tr>
                <th rowspan="2">
                    Nama Desa
                </th>
                <th colspan="3">
                    Jumlah Pasien Berobat Teratur
                </th>
                <th colspan="3">
                    Jumlah Pasien Tidak Berobat Teratur
                </th>
                <th colspan="3">
                    Jumlah Pasien Hipertensi Terkendali
                </th>
                <th colspan="3">
                    Jumlah Pasien Hipertensi Tidak Terkendali
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
                    <td>{{ isset($village->treatment[1]['L']) ? $village->treatment[1]['L']->count() : 0 }}
                    </td>
                    <td>{{ isset($village->treatment[1]['P']) ? $village->treatment[1]['P']->count() : 0 }}
                    </td>
                    <td>{{ (isset($village->treatment[1]['L']) ? $village->treatment[1]['L']->count() : 0) + (isset($village->treatment[1]['P']) ? $village->treatment[1]['P']->count() : 0) }}
                    </td>
                    <td>{{ isset($village->treatment[0]['L']) ? $village->treatment[0]['L']->count() : 0 }}
                    </td>
                    <td>{{ isset($village->treatment[0]['P']) ? $village->treatment[0]['P']->count() : 0 }}
                    </td>
                    <td>{{ (isset($village->treatment[0]['L']) ? $village->treatment[0]['L']->count() : 0) + (isset($village->treatment[0]['P']) ? $village->treatment[0]['P']->count() : 0) }}
                    </td>
                    <td>{{ isset($village->hypertension[0]['L']) ? $village->hypertension[0]['L']->count() : 0 }}
                    </td>
                    <td>{{ isset($village->hypertension[0]['P']) ? $village->hypertension[0]['P']->count() : 0 }}
                    </td>
                    <td>{{ (isset($village->hypertension[0]['L']) ? $village->hypertension[0]['L']->count() : 0) + (isset($village->hypertension[0]['P']) ? $village->hypertension[0]['P']->count() : 0) }}
                    </td>
                    <td>{{ isset($village->hypertension[1]['L']) ? $village->hypertension[1]['L']->count() : 0 }}
                    </td>
                    <td>{{ isset($village->hypertension[1]['P']) ? $village->hypertension[1]['P']->count() : 0 }}
                    </td>
                    <td>{{ (isset($village->hypertension[1]['L']) ? $village->hypertension[1]['L']->count() : 0) + (isset($village->hypertension[1]['P']) ? $village->hypertension[1]['P']->count() : 0) }}
                    </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td>Total</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
                <td>1000</td>
            </tr>
            <tr>
                <td>Persentase</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
                <td>10%</td>
            </tr>
        </tfoot>
    </table>
</div>

