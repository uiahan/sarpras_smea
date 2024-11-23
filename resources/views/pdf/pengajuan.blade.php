<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $judul }}</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        h1 {
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>{{ $judul }}</h1>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Barang</th>
                <th>Program Kegiatan</th>
                <th>Jurusan</th>
                <th>Tanggal Ajuan</th>
                <th>Tanggal Realisasi</th>
                <th>Harga Satuan</th>
                <th>Tahun</th>
                <th>Banyak</th>
                <th>Total Harga</th>
                <th>Harga Beli</th>
                <th>Sumber Dana</th>
                <th>Keterangan</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengajuan as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->barang }}</td>
                    <td>{{ $item->program_kegiatan }}</td>
                    <td>{{ $item->jurusan }}</td>
                    <td>{{ $item->tanggal_ajuan }}</td>
                    <td>{{ $item->tanggal_realisasi }}</td>
                    <td>{{ $item->harga_satuan }}</td>
                    <td>{{ $item->tahun }}</td>
                    <td>{{ $item->banyak }}</td>
                    <td>{{ $item->total_harga }}</td>
                    <td>{{ $item->harga_beli }}</td>
                    <td>{{ $item->sumber_dana }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>{{ $item->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
