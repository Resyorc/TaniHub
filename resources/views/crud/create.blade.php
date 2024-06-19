@extends('layout.sidebar')

@section('content')
<div class="container mt-5">
    <h1>Tambah Perangkat Baru</h1>
    <form action="{{ route('devices.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Nama Perangkat</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>
        <button type="submit" class="btn btn-primary mt-4">Tambah Perangkat</button>
    </form>
</div>
@endsection