@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Data Kepesertaan Asuransi</h2>

    <!-- Form Pencarian -->
    <form id="search-form" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="nama" id="nama" class="form-control" placeholder="Nama Peserta">
            </div>
            <div class="col-md-3">
                <input type="text" name="bank" id="bank" class="form-control" placeholder="Nama Bank">
            </div>
            <div class="col-md-3">
                <input type="text" name="nomor_peserta" id="nomor_peserta" class="form-control" placeholder="Nomor Peserta">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <input type="date" name="start_date" id="start_date" class="form-control" placeholder="Tanggal Awal">
            </div>
            <div class="col-md-3">
                <input type="date" name="end_date" id="end_date" class="form-control" placeholder="Tanggal Akhir">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>

    <!-- Tabel Data Kepesertaan -->
    <table id="kepesertaan-table" class="table table-bordered">
        <thead>
            <tr>
                <!-- <th>Nomor Peserta</th> -->
                <th>Nama Peserta</th>
                <!-- <th>Tanggal Lahir</th>
                <th>Umur</th>
                <th>Nama Bank</th>
                <th>Tanggal Awal</th>
                <th>Tanggal Akhir</th>
                <th>UP</th>
                <th>Premi</th> -->
            </tr>
        </thead>
        <tbody></tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
    var table = $('#kepesertaan-table').DataTable({
        processing: true,
        // serverSide: true,
        ajax: {
            url: `{{ route('kepesertaan.data') }}`, // Ganti dengan rute Anda
            type: 'GET',
            dataSrc: 'data', // Pastikan ini menunjuk pada key 'data' dari JSON
            data: function (d) {
                d.nama = $('#nama').val();
                // d.bank = $('#bank').val();
                // d.nomor_peserta = $('#nomor_peserta').val();
                // d.start_date = $('#start_date').val();
                // d.end_date = $('#end_date').val();
            }
        },
        columns: [
            // { data: 'tpprd_nomor_peserta', name: 'tpprd_nomor_peserta' },
            { data: 'tpprd_nama', name: 'tpprd_nama' },
            // { data: 'tpprd_tanggal_lahir', name: 'tpprd_tanggal_lahir' },
            // { data: 'tpprd_umur', name: 'tpprd_umur' },
            // { data: 'tpprd_bank', name: 'tpprd_bank' },
            // { data: 'tpprd_tanggal_awal', name: 'tpprd_tanggal_awal' },
            // { data: 'tpprd_tanggal_akhir', name: 'tpprd_tanggal_akhir' },
            // { data: 'tpprd_up', name: 'tpprd_up' },
            // { data: 'tpprd_premi', name: 'tpprd_premi' }
        ],
        order: [[0, 'asc']] // Urutkan berdasarkan nama
    });

    // Event listener for search button
    $('#search-button').on('click', function() {
        // console.log('aaaaa');
        // table.draw(); // Refresh the table with new search criteria
    });
});
</script>
@endpush
