<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        table,
        th,
        td {
            border: 1px solid;
        }

        td {
            text-align: center;
        }
    </style>
</head>

<body>
    <table>
        <thead>
            <tr>
                <th colspan=14>DATA REGISTER PASIEN - FOR TESTING PURPOSE </th>
            </tr>
            <tr>
                <th colspan=14>2022 </th>
            </tr>
            <tr>
                <th colspan=14>CAFE DITA </th>
            </tr>
            <tr>
                <th colspan=14>Jumlah Pasien {{ $patients->count() }}</th>
            </tr>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>1</th>
                <th>2</th>
                <th>3</th>
                <th>4</th>
                <th>5</th>
                <th>6</th>
                <th>7</th>
                <th>8</th>
                <th>9</th>
                <th>10</th>
                <th>11</th>
                <th>12</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($patients as $patient)
                <tr>
                    <td>{{ $loop->index + 1 }}</td>
                    <td style="text-align: left;">{{ $patient->name }}</td>
                    @php($counter = 0)
                    @foreach (range(1, 12) as $index)
                        @isset($patient->consultations[$counter])
                            @if (\Carbon\Carbon::parse($patient->consultations[$counter]->date)->month == $index)
                                <td>{{ $patient->consultations[$counter]->systole . '/' . $patient->consultations[$counter]->diastole }}
                                </td>
                                @php($counter++)
                            @else
                                <td>-</td>
                            @endif
                        @else
                            <td>-</td>
                        @endisset
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

