@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head" style="border:1px solid black">

            <h3 style="display: inline-block;">Riwayat Peminjaman</h3>
            <a href="{{route('cetak_pdf')}}" style="color: white; margin-left:600px "><i style="font-size: 20px"
                    class="fas fa-print"></i>
                Print</a>
        </div>
        <div class="module-body">
            <div class="row-fluid">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>ID Peminjaman</th>
                            <th>ID Peminjaman Buku</th>
                            <th>Judul Buku</th>
                            <th>Nama Murid</th>
                            <th class="align-self-center">Kelas</th>
                            <th class="align-self-center">Kategori</th>
                            <th>Dipinjam Pada Tanggal</th>
                            <th>Dikembalikan Pada Tanggal</th>
                        </tr>
                    </thead>
                    <tbody id="issue-logs-table">
                        @foreach ($riwayat as $item)
                        <tr class="text-center">
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
            </div>
        </div>
    </div>
</div>
@stop

@section('custom_bottom_script')

@stop