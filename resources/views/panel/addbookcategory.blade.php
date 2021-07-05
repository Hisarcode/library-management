@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Tambah Kategori Buku</h3>
        </div>
        <div class="module-body">
            <form class="form-horizontal row-fluid">
                <div class="control-group">
                    <label class="control-label">Kategori</label>
                    <div class="controls">
                        <input type="text" id="category" data-form-field="category"
                            placeholder="Masukkan Kategori Buku Disini" class="span8">
                        <input type="hidden" data-form-field="token" value="{{ csrf_token() }}">
                    </div>
                </div>

                <div class="control-group">
                    <div class="controls">
                        <button type="button" class="btn btn-inverse" id="addbookcategory">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Daftar Kategori Buku</h3>
        </div>
        <div class="module-body">
            <table class="table table-striped table-bordered table-condensed">
                <thead>
                    <tr>
                        <th style="width: 5%">No.</th>
                        <th>Kategori</th>
                        <th>#</th>
                    </tr>
                </thead>
                <tbody id="all-books">
                    @foreach ($categories as $category)

                    <tr class="text-center">
                        <td style="width: 5%">{{$loop->iteration}}</td>
                        <td>{{$category['category']}}</td>

                        <td>
                            <a href="{{route('category.edit', $category)}}" class="btn btn-primary">Edit</a>
                            <form action="{{route('category.delete', $category)}}" method="POST">
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
</div>



@stop

@section('custom_bottom_script')

<script type="text/javascript" src="{{ asset('static/custom/js/script.addbookcategory.js') }}"></script>

@stop