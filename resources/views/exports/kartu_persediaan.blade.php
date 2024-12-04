<table>
    <thead>
        <tr>
            <th>Tanggal</th>
            <th>Jumlah Masuk</th>
            <th>Harga Satuan Masuk</th>
            <th>Total Masuk</th>
            <th>Jumlah Keluar</th>
            <th>Harga Satuan Keluar</th>
            <th>Total Keluar</th>
            <th>Sisa Jumlah</th>
            <th>Harga Satuan Sisa</th>
            <th>Sisa Total</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($pengajuan as $item)
            @php
                $totalPengeluaran = $item->jumlah_yg_diacc * $item->harga_satuan;
                $sisaJumlah = $item->banyak - $item->jumlah_yg_diacc;
                $sisaTotal = $sisaJumlah * $item->harga_satuan;
            @endphp
            <tr>
                <td>{{ $item->tanggal_realisasi }}</td>
                <td>{{ $item->banyak }}</td>
                <td>{{ $item->harga_satuan }}</td>
                <td>{{ $item->total_harga }}</td>
                <td>{{ $item->jumlah_yg_diacc }}</td>
                <td>{{ $item->harga_satuan }}</td>
                <td>{{ $totalPengeluaran }}</td>
                <td>{{ $sisaJumlah }}</td>
                <td>{{ $item->harga_satuan }}</td>
                <td>{{ $sisaTotal }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
