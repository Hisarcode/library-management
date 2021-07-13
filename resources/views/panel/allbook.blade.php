@extends('layout.index')
@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Daftar Buku</h3>
        </div>
        <div class="module-body">
            <!--             <p>
                <strong>Combined</strong>
                -
                <small>table class="table table-striped table-bordered table-condensed"</small>
            </p> -->
            {{-- <div class="controls">
                <select class="" id="category_fill">
                    @foreach($categories_list as $category)
                    <option value="{{ $category->id }}">{{ $category->category }}</option>
            @endforeach
            </select>
        </div> --}}
        <table class="table table-striped table-bordered table-condensed">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Deskripsi</th>
                    <th>Kategori</th>
                    <th>Tersedia</th>
                    <th>Jumlah</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody id="all-books">
                @foreach ($books as $book)

                <tr class="text-center">
                    <td>{{$book['book_id']}}</td>
                    <td>{{$book['title']}}</td>
                    <td>{{$book['author']}}</td>
                    <td>{{$book['description']}}</td>
                    <td>{{$book['category']['category']}}</td>
                    <td>{{$book['qty'] - $book['issue']}}</td>
                    <td>{{$book['qty']}}</td>
                    {{-- <td>{{$book['dipinjam']}}</td> --}}

                    <td>
                        <a href="{{route('book.edit', $book['book_id'])}}" class="btn btn-primary">Edit</a>
                        <form action="{{route('book.delete', $book)}}" method="POST">
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
{{-- <input type="hidden" name="" id="categories_list" value="{{ json_encode($categories_list) }}"> --}}
</div>
@stop

@section('custom_bottom_script')
<script type="text/javascript">
    var categories_list = $('#categories_list').val();
</script>
{{-- <script type="text/javascript" src="{{asset('static/custom/js/script.addbook.js') }}"></script> --}}
<script type="text/template" id="allbooks_show">
    @include('underscore.allbooks_show')
</script>
@stop