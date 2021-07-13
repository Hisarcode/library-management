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
                            <th>ID Buku</th>
                            <th>Judul Buku</th>
                            <th>Nama Murid</th>
                            <th class="align-self-center">Kelas</th>
                            {{-- <th class="align-self-center">Kategori</th> --}}
                            <th>Dipinjam Pada Tanggal</th>
                            <th>Dikembalikan Pada Tanggal</th>
                        </tr>
                    </thead>
                    <tbody id="issue-logs-table">
                        @foreach ($reports as $report)
                        <tr class="text-center">
                            <td>{{$report['id']}}</td>
                            <td>{{$report['book_id']}}</td>
                            <td>{{$report['book']['title']}}</td>
                            <td>{{$report['student']['first_name']}}</td>
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
            </div>
        </div>
    </div>
</div>
@stop

@section('custom_bottom_script')

@stop