@extends('layout.index')

@section('custom_top_script')
@stop

@section('content')
<div class="content">
    <div class="module">
        <div class="module-head">
            <h3>Edit Kelas</h3>
        </div>
        <div class="module-body">
            <form class="form-horizontal row-fluid" action="{{route('class.update', $branch)}}" method="POST">
                @csrf
                @method('PUT')
                <div class="control-group">
                    <label class="control-label">Kelas</label>
                    <div class="controls">
                        <input type="text" id="category" value="{{$branch['branch']}}"
                            placeholder="Masukkan Kelas Disini" class="span8" name="branch">
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