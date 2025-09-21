@extends('layouts.app')
@section('content')
  <h1>Semua Pengajuan</h1>
  <table>
    <thead><tr><th>ID</th><th>Judul</th><th>Pemohon</th><th>Status</th><th>Aksi</th></tr></thead>
    <tbody>
    @foreach($submissions as $s)
      <tr>
        <td>{{ $s->id }}</td>
        <td>{{ $s->title }}</td>
        <td>{{ $s->user->name }}</td>
        <td>{{ $s->status }}</td>
        <td><a href="{{ route('admin.submissions.show',$s->id) }}">Detail</a></td>
      </tr>
    @endforeach
    </tbody>
  </table>

  {{ $submissions->links() }}
@endsection
