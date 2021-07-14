@extends('layout.index')

@section('content')
<div class="content">
    <div class="btn-controls">
        <div class="btn-box-row row-fluid">
            <button class="btn-box span12" style="background: #9400D3; ">
                <b style="color:#fff">Data Perpustakaan</b>
            </button>
        </div>


        <div class="btn-box-row row-fluid">
            <button class="btn-box big span4 homepage-form-box" id="findbookbox">
                <h1>{{ $buku_tersedia }}</h1>
                <b>Buku Tersedia</b>
            </button>

            <button class="btn-box big span4 homepage-form-box" id="findissuebox">
                <h1>{{ $buku_dipinjam }}</h1>
                <b>Buku Dipinjam</b>
            </button>

            <button class="btn-box big span4 homepage-form-box" id="findstudentbox">
                <h1>{{ $total_murid }}</h1>
                <b>Total Murid</b>
            </button>
        </div>


        <script type="text/javascript" src="{{asset('static/custom/js/script.mainpage.js') }}"></script>


        <script type="text/template" id="search_book">
            @include('underscore.search_book')
</script>
        <script type="text/template" id="search_issue">
            @include('underscore.search_issue')
</script>
        <script type="text/template" id="search_student">
            @include('underscore.search_student')
</script>
        <script type="text/template" id="approvalstudents_show">
            @include('underscore.approvalstudents_show')
</script>
        @stop