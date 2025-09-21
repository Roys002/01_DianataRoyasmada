@extends('layouts.app')
@section('content')
  <h1>Buat Pengajuan</h1>
  <form method="POST" action="{{ route('submissions.store') }}" enctype="multipart/form-data">
    @csrf
    <div><input name="title" value="{{ old('title') }}" placeholder="Judul"></div>
    @error('title') <div>{{ $message }}</div> @enderror

    <div><textarea name="description" placeholder="Deskripsi">{{ old('description') }}</textarea></div>
    @error('description') <div>{{ $message }}</div> @enderror

    <div><input type="file" name="attachment"></div>
    @error('attachment') <div>{{ $message }}</div> @enderror

    <button type="submit">Kirim</button>
  </form>
@endsection
