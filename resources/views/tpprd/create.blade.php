@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Input Kepesertaan Asuransi</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <form action="{{ route('tpprd.store') }}" method="POST">
        @csrf

        <div class="form-group mb-3">
            <label for="tpprd_nama">Nama Peserta:</label>
            <input type="text" name="tpprd_nama" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="tpprd_tanggal_lahir">Tanggal Lahir (dd/mm/yyyy):</label>
            <input type="text" name="tpprd_tanggal_lahir" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="tpprd_bank">Bank:</label>
            <input type="text" name="tpprd_bank" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="tpprd_masa_bulan">Masa (Bulan):</label>
            <input type="number" name="tpprd_masa_bulan" class="form-control" required>
        </div>

        <div class="form-group mb-3">
            <label for="tpprd_up">Nilai Pinjaman (UP):</label>
            <input type="number" name="tpprd_up" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
<hr>
<div class="container mt-5">
    <div style="justify-self: end;">
        <a class="btn btn-success mb-3" href="{{ route('tpprd.download-template') }}">Download Template Excel</a>
    </div>
    <h1>Upload</h1>
    <form action="{{ route('tpprd.upload-template') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="input-group mb-3">
            <input type="file" class="form-control" name="file" id="inputGroupFile02" accept=".xlsx" required>
            <label class="input-group-text" for="inputGroupFile02">Upload</label>
        </div> 
        <button class="btn btn-info text-white" type="submit">Upload Excel</button>
        <a class="btn btn-success" href="{{ route('home') }}">Kembali</a>
    </form>
</div>
@endsection