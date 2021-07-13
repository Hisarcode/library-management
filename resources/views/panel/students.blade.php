@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Murid Yang Sudah Disetujui</h3>
        </div>
        <div class="module-body">
            {{--     <div class="controls">
                <select class="span3" id="branch_select">
                    @foreach($branch_list as $branch)
                    <option value="{{ $branch->id }}">{{ $branch->branch }}</option>
            @endforeach
            </select>
            <select class="span3" id="category_select">
                <option value="0">Semua Kategori</option>
                @foreach($student_categories_list as $student_category)
                <option value="{{ $student_category->cat_id }}">{{ $student_category->category }}</option>
                @endforeach
            </select>
            <select class="span3" id="year_select">
                <option value="0">Semua Tahun</option>
                <option>2020</option>
                <option>2021</option>
                <option>2022</option>
                <option>2023</option>
                <option>2024</option>
                <option>2025</option>
                <option>2026</option>
                <option>2027</option>
                <option>2028</option>
                <option>2029</option>
                <option>2030</option>
            </select>
        </div> --}}
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama</th>
                    <th>Nomor Absen</th>
                    <th>Kelas</th>
                    <th>Kategori</th>
                    <th>Tahun</th>
                    <th>ID Email</th>
                    <th>Buku Yang Dipinjam</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($students as $student)
                <tr class="text-center">
                    <td>{{$student->student_id}}</td>
                    <td>{{$student->first_name . ' ' . $student->last_name}}</td>
                    <td>{{$student->roll_num}}</td>
                    <td>{{$student->branch}}</td>
                    <td>{{$student->category}}</td>
                    <td>{{$student->year}}</td>
                    <td>{{$student->email_id}}</td>
                    <td>{{$student->buku_dipinjam}}</td>
                    <td>
                        <a href="{{route('murid.edit', $student['student_id'])}}" class="btn btn-primary">Edit</a>
                        <form action="{{route('murid.delete', $student)}}" method="POST">
                            @csrf
                            @method('delete')
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Hapus Data Ini ?')">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
{{-- <input type="hidden" name="" id="branches_list" value="{{ json_encode($branch_list) }}"> --}}
{{-- <input type="hidden" name="" id="student_categories_list" value="{{ json_encode($student_categories_list) }}"> --}}
{{-- <input type="hidden" id="_token" data-form-field="token" value="{{ csrf_token() }}"> --}}

</div>
@stop

@section('custom_bottom_script')
<script type="text/javascript">
    var branches_list = $('#branches_list').val(),
        categories_list = $('#student_categories_list').val(),
        _token = $('#_token').val();
</script>
<script type="text/javascript" src="{{ asset('static/custom/js/script.students.js') }}"></script>
<script type="text/template" id="allstudents_show">
    @include('underscore.allstudents_show')
</script>
@stop