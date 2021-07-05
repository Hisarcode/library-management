@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Murid Yang Belum Disetujui</h3>
        </div>
        <div class="module-body">
            <div class="controls">
                <select class="span3" id="branch_select">
                    <option value="0">Semua Kelas</option>
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
                <select class="span2" id="year_select">
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
                <button style="margin-bottom:10px" id="refresh" class="btn btn-warning">Refresh</button>


            </div>
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Depan</th>
                        <th>Nama Belakang</th>
                        <th>Nomor Absen</th>
                        <th>Kelas</th>
                        <th>Kategori</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody id="approval-table">
                    <tr class="text-center">
                        <td colspan="99"><i class="icon-spinner icon-spin"></i></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <input type="hidden" name="" id="branches_list" value="{{ json_encode($branch_list) }}">
    <input type="hidden" name="" id="student_categories_list" value="{{ json_encode($student_categories_list) }}">
    <input type="hidden" id="_token" data-form-field="token" value="{{ csrf_token() }}">

</div>

@stop

@section('custom_bottom_script')
<script type="text/javascript">
    var branches_list = $('#branches_list').val(),
        categories_list = $('#student_categories_list').val(),
        _token = $('#_token').val();
</script>
<script type="text/javascript" src="{{asset('static/custom/js/script.student-approval.js') }}"></script>
<script type="text/template" id="approvalstudents_show">
    @include('underscore.approvalstudents_show')
</script>
@stop