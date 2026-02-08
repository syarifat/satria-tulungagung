<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Anggota PAC</title>
    <style>
        @page {
            margin: 20mm 15mm;
        }

        body {
            font-family: 'Arial', sans-serif;
            font-size: 10pt;
            line-height: 1.4;
            color: #333;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 18pt;
            color: #1e293b;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header h2 {
            margin: 5px 0 0 0;
            font-size: 14pt;
            color: #4F46E5;
            font-weight: bold;
        }

        .header p {
            margin: 3px 0;
            font-size: 9pt;
            color: #64748b;
        }

        .info-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 10px;
            margin-bottom: 15px;
        }

        .info-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-box td {
            padding: 4px 8px;
            font-size: 9pt;
        }

        .info-box td:first-child {
            font-weight: bold;
            width: 120px;
            color: #475569;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data thead {
            background: #4F46E5;
            color: white;
        }

        table.data th {
            padding: 10px 8px;
            text-align: left;
            font-size: 9pt;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        table.data tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }

        table.data tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        table.data td {
            padding: 8px;
            font-size: 9pt;
            vertical-align: top;
        }

        .no {
            text-align: center;
            font-weight: bold;
            color: #64748b;
        }

        .nama {
            font-weight: bold;
            color: #1e293b;
        }

        .nik {
            font-size: 8pt;
            color: #64748b;
        }

        .unit {
            font-size: 8pt;
            color: #4F46E5;
            font-weight: bold;
        }

        .jabatan {
            background: #EEF2FF;
            color: #4F46E5;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 8pt;
            font-weight: bold;
            display: inline-block;
        }

        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 9pt;
        }

        .footer .signature {
            margin-top: 60px;
            font-weight: bold;
        }

        .total-box {
            background: #EEF2FF;
            border: 2px solid #4F46E5;
            border-radius: 8px;
            padding: 10px;
            text-align: center;
            margin-top: 15px;
        }

        .total-box h3 {
            margin: 0;
            font-size: 12pt;
            color: #4F46E5;
        }
    </style>
</head>

<body>
    {{-- HEADER --}}
    <div class="header">
        <h1>GP Ansor Tulungagung</h1>
        <h2>{{ $pacUnit->nama }}</h2>
        <p>Data Anggota Pimpinan Anak Cabang</p>
    </div>

    {{-- INFO BOX --}}
    <div class="info-box">
        <table>
            <tr>
                <td>Tanggal Cetak</td>
                <td>: {{ $tanggal }}</td>
            </tr>
            <tr>
                <td>Filter Unit</td>
                <td>: {{ $filterInfo }}</td>
            </tr>
            <tr>
                <td>Total Data</td>
                <td>: {{ $anggotas->count() }} Anggota</td>
            </tr>
        </table>
    </div>

    {{-- DATA TABLE --}}
    <table class="data">
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 35%;">Nama & NIK</th>
                <th style="width: 25%;">Unit Organisasi</th>
                <th style="width: 20%;">Jabatan</th>
                <th style="width: 20%;">Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($anggotas as $index => $agt)
            <tr>
                <td class="no">{{ $index + 1 }}</td>
                <td>
                    <div class="nama">{{ $agt->nama }}</div>
                    <div class="nik">NIK: {{ $agt->nik }}</div>
                </td>
                <td>
                    <div class="unit">{{ $agt->organisasiUnit->nama }}</div>
                </td>
                <td>
                    <span class="jabatan">{{ $agt->jabatan->nama }}</span>
                </td>
                <td style="font-size: 8pt;">
                    {{ $agt->alamat ?? '-' }}<br>
                    @if($agt->desa)
                    {{ $agt->desa->nama }}, {{ $agt->kecamatan->nama ?? '' }}
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{-- TOTAL BOX --}}
    <div class="total-box">
        <h3>Total: {{ $anggotas->count() }} Anggota</h3>
    </div>

    {{-- FOOTER --}}
    <div class="footer">
        <p>Tulungagung, {{ $tanggal }}</p>
        <p>Pimpinan {{ $pacUnit->nama }}</p>
        <div class="signature">
            <p>_______________________</p>
            <p>Ketua PAC</p>
        </div>
    </div>
</body>

</html>