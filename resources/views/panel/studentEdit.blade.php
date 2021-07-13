@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Edit Murid</h3>
        </div>
        <div class="module-body">
            <form class="form-horizontal row-fluid" action="{{route('murid.update', $student)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="control-group">
                    <label class="control-label">Nama Depan</label>
                    <div class="controls">
                        <input type="text" id="first_name" name="first_name" data-form-field="first_name"
                            value="{{$student['first_name']}}" placeholder="Masukkan Nama Depan" class="span8">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nama Belakang</label>
                    <div class="controls">
                        <input type="text" id="last_name" name="last_name" data-form-field="last_name"
                            value="{{$student['last_name']}}" placeholder="Masukkan Nama Belakang" class="span8">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Email</label>
                    <div class="controls">
                        <input type="text" id="branch" data-form-field="email_id" name="email_id"
                            placeholder="Masukkan Email Disini" class="span8" value="{{$student['email_id']}}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Tahun</label>
                    <div class="controls">
                        <input type="text" id="branch" data-form-field="year" name="year"
                            placeholder="Masukkan Tahun Angkatan Disini" class="span8" value="{{$student['year']}}">
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Nomor Absen</label>
                    <div class="controls">
                        <input type="text" id="branch" data-form-field="roll_num" name="roll_num"
                            placeholder="Masukkan Nomor Absen Disini" class="span8" value="{{$student['roll_num']}}">
                    </div>
                </div>
                <div class="control-group">
                    <div class="controls">
                        <button type="submit" class="btn btn-inverse">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('custom_bottom_script')


@stop