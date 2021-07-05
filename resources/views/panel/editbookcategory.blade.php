@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Edit Kategori Buku</h3>
        </div>
        <div class="module-body">
            <form class="form-horizontal row-fluid" action="{{route('category.update', $category)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="control-group">
                    <label class="control-label">Kategori</label>
                    <div class="controls">
                        <input type="text" id="category" data-form-field="category" value="{{$category['category']}}"
                            placeholder="Masukkan Kategori Buku Disini" class="span8" name="category">
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

<script type="text/javascript" src="{{ asset('static/custom/js/script.addbookcategory.js') }}"></script>

@stop