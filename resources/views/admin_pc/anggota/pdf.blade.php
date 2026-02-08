<!DOCTYPE html>
<html>

<head>
    <title>Laporan Data Anggota</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #1f2937;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #f3f4f6;
            font-weight: bold;
            text-transform: uppercase;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <h2>Laporan Data Anggota GP Ansor Tulungagung</h2>
    <p>Tanggal Cetak: {{ date('d-m-Y') }}</p>

    <table>
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="15%">NIK</th>
                <th width="20%">Nama Lengkap</th>
                <th width="15%">Jabatan</th>
                <th width="25%">Unit Organisasi</th>
                <th width="20%">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggotas as $index => $agt)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $agt->nik }}</td>
                <td>{{ $agt->nama }}</td>
                <td>{{ $agt->jabatan->nama ?? '-' }}</td>
                <td>
                    {{ $agt->organisasiUnit->nama }}
                    <br><small>({{ strtoupper($agt->organisasiUnit->level) }})</small>
                </td>
                <td>
                    {{ $agt->alamat ?? '-' }},
                    {{ $agt->desa->nama ?? '' }},
                    {{ $agt->kecamatan->nama ?? '' }}
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>