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
                <th>ID Peminjaman Buku</th>
                <th>Judul Buku</th>
                <th>Nama Murid</th>
                <th>Kelas</th>
                <th>Kategori</th>
                <th>Dipinjam Pada Tanggal</th>
                <th>Dikembalikan Pada Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($riwayat as $item)
            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$item->book_issue_id}}</td>
                <td>{{$item->book_name}}</td>
                <td>{{$item->student_name}}</td>
                <td>{{$item->kelas}}</td>
                <td>{{$item->kategori}}</td>
                <td>{{$item->issued_at}}</td>
                <td><?= $item->return_time ?></td>
            </tr>
            @endforeach
        </tbody>
    </table>

</body>

</html>