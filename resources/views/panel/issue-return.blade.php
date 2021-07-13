@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Pinjamkan Buku</h3>
        </div>
        <div class="module-body">
            <form class="form-horizontal row-fluid" method="POST" action="{{route('pinjam.buku')}}">
                @csrf
                <div class="control-group">
                    <label class="control-label">ID Murid</label>
                    <div class="controls">
                        <input type="number" name="student_id" data-form-field="student-issue-id" placeholder="Masukkan ID Murid Disini" class="span8">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">ID Buku</label>
                    <div class="controls">
                        <input type="number" name="book_id" data-form-field="book-issue-id" placeholder="Masukkan ID Buku Disini" class="span8">
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-inverse" id="issuebook">Pinjam Buku</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="module">
        <div class="module-head">
            <h3>Kembalikan Buku</h3>
        </div>
        <div class="module-body">
            <form class="form-horizontal row-fluid" method="POST" action="{{route('kembalikan.buku')}}">
                @csrf
                <div class="control-group">
                    <label class="control-label">ID Peminjaman</label>
                    <div class="controls">
                        <input type="number" name="return_book_id"  data-form-field="book-issue-id" placeholder="Masukkan ID Peminjaman Disini" class="span8">
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-inverse" id="returnbook">Kembalikan Buku</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <input type="hidden" id="_token" data-form-field="token" value="{{ csrf_token() }}">
</div>
@stop

@section('custom_bottom_script')
{{-- <script type="text/javascript" src="{{asset('static/custom/js/script.logs.js') }}"></script> --}}
{{-- <script type="text/template" id="all_logs_display">
    @include('underscore.all_logs_display')
</script> --}}
@stop