<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th colspan=9>DATA REGISTER PASIEN - FOR TESTING PURPOSE </th>
            </tr>
            <tr>
                <th colspan=9>2022 </th>
            </tr>
            <tr>
                <th colspan=9>CAFE DITA </th>
            </tr>
            <tr>
                <th colspan=9>{{ $patients->count() }}</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Ruangan</th>
                <th>Tanggal</th>
                <th>Khusus</th>
                <th>Nama</th>
                <th>No. RM</th>
                <th>RM Lama</th>
                <th>No BPJS</th>
                <th>No KTP</th>
                <th>No KK</th>
                <th>Suami/ Istri/ Penanggungjawab </th>
                <th>No HP</th>
                <th>L/P</th>
                <th>Tanggal_Lahir</th>
                <th>Umur</th>
                <th>Alamat</th>
                <th>Desa</th>
                <th>Kecamatan</th>
                <th>Kabupaten</th>
                <th>Provinsi</th>
                <th>Pekerjaan</th>
                <th>Kunjungan</th>
                <th>Kode Kunjungan</th>
                <th>Keluhan</th>
                <th>Terapi</th>
                <th>Tensi</th>
                <th>Nadi</th>
                <th>Suhu</th>
                <th>Pernapasan</th>
                <th>Tinggi</th>
                <th>Berat</th>
                <th>Lingkat Perut</th>
                <th>Faskes</th>
                <th>Kasus</th>
                <th>Diagnosa</th>
                <th>Petugas</th>
                <th>Tindakan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                @foreach ($patient->consultations as $consultation)
                    <tr>
                        <td>{{ $loop->index + 1 }}</td>
                        <td>CAFE DITA</td>
                        <td>{{ $consultation->date }}</td>
                        <td></td>
                        <td>{{ $patient->name }}</td>
                        <td>{{ '`' . $patient->medical_record_number }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ '`' . $patient->nik }}</td>
                        <td></td>
                        <td></td>
                        <td>{{ $patient->phone_number }}</td>
                        <td>{{ $patient->sex }}</td>
                        <td>{{ $patient->birthday }}</td>
                        <td></td>
                        <td>{{ $patient->address }}</td>
                        <td>{{ $patient->village->name }}</td>
                        <td>KARANGAN</td>
                        <td>TRENGGALEK</td>
                        <td>JAWA TIMUR</td>
                        <td>{{ $patient->job }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $consultation->note }}</td>
                        <td>{{ $consultation->systole . '/' . $consultation->diastole }}</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td>{{ $consultation->medicine }}</td>

                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
</body>

</html>

