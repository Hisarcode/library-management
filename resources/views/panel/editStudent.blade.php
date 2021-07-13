@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Edit Buku</h3>
        </div>
        <div class="module-body">
            <form class="form-horizontal row-fluid" action="{{route('book.update', $book)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="control-group">
                    <label class="control-label">Judul Buku</label>
                    <div class="controls">
                        <input type="text" id="title" name="title" data-form-field="title" value="{{$book['title']}}"
                            placeholder="Masukkan Judul Buku Disini" class="span8">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Nama Pengarang</label>
                    <div class="controls">
                        <input type="text" id="author" data-form-field="author" name="author"
                            placeholder="Masukkan Pengarang Buku Disini" class="span8" value="{{$book['author']}}">
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label" for="basicinput">Deskripsi Buku</label>
                    <div class="controls">
                        <textarea class="span8" id="description" data-form-field="description" name="description"
                            rows="5" placeholder="Deskripsikan Buku Disini">{{$book['description']}}</textarea>
                    </div>
                </div>



                <div class="control-group">
                    <label class="control-label" for="basicinput">Kategori</label>
                    <div class="controls">
                        <select tabindex="1" id="category" data-form-field="category" name="category"
                            data-placeholder="Pilih Kategori" class="span8">
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{($category->id == $book['category_id']) ? 'selected' : ''}}>{{ $category->category }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="control-group">
                    <label class="control-label">Jumlah Buku</label>
                    <div class="controls">
                        <input type="number" id="number" data-form-field="number" name="number"
                            placeholder="Masukkan Jumlah Buku Disini" class="span8" value="{{$book['total']}}">
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