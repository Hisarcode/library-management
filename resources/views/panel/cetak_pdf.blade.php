<!DOCTYPE html>
<html>

<head>
    <title>Aplikasi Inventaris Buku Untuk Perpustakaan SMPN 13 Pontianak</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>

<body>
    <style type="text/css">
        table tr td,
        table tr th {
            font-size: 9pt;
        }
    </style>
    <center>
        <h5>Laporan Peminjaman Buku</h4>
    </center>

    <table class='table table-bordered'>
        <thead>
            <tr>
                <th>ID Peminjaman</th>
                <th>ID Buku</th>
                <th>Judul Buku</th>
                <th>Nama Murid</th>
                <th class="align-self-center">Kelas</th>
                {{-- <th class="align-self-center">Kategori</th> --}}
                <th>Dipinjam Pada Tanggal</th>
                <th>Dikembalikan Pada Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($reports as $report)
            <tr class="text-center">
                <td>{{$report['id']}}</td>
                <td>{{$report['book_id']}}</td>
                <td>{{$report['book']['title']}}</td>
                <td>{{$report['student']['first_name'] . ' ' . $report['student']['last_name']}}</td>
                <td>{{$report['student']['branch']}}</td>
                {{-- <td>{{$report->kategori}}</td> --}}
                <td>{{date("d-m-Y", strtotime($report['issue_at']))  }}</td>
                <td><?php if($report['return_at'] == null) {echo 'Belum Dikembalikan';} else {
                    echo date("d-m-Y", strtotime($report['return_at']));
                } ?></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>