@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Lihat Buku Yang Sedang Dipinjam</h3>
        </div>
        <div class="module-body">
            <div class="row-fluid">
                <table class="table table-striped table-bordered table-condensed">
                    <thead>
                        <tr>
                            {{-- <th>ID Peminjaman</th> --}}
                            <th>ID Peminjaman Buku</th>
                            <th>Judul Buku</th>
                            {{-- <th>ID Murid</th> --}}
                            <th>Nama Murid</th>
                            <th>Dipinjam Pada Tanggal</th>
                            <th>Dikembalikan Pada Tanggal</th>
                        </tr>
                    </thead>
                    <tbody id="issue-logs-table">
                        @foreach ($reports as $report)
                        <tr>
                            <td>{{$report['id']}}</td>
                            <td>{{$report['book']['title']}}</td>
                            <td>{{$report['student']['first_name'] . ' ' . $report['student']['last_name']}}</td>
                            <td>{{date("d-m-Y", strtotime($report['issue_at']))  }}</td>
                            <td><?php if($report['return_at'] == null) {echo 'Belum Dikembalikan';} else {
                                echo date("d-m-Y", strtotime($report['return_at']));
                            } ?></td>
                            </tr>
                        @endforeach
                        {{-- <tr class="text-center">
                            
                        </tr> --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@stop

@section('custom_bottom_script')
{{-- <script type="text/javascript" src="{{ asset('static/custom/js/script.logs.js') }}"></script>
<script type="text/template" id="all_logs_display">
    @include('underscore.all_logs_display')
</script> --}}
@stop