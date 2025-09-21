@extends('layouts.app')
@section('title','Register')
@section('content')
  <h1>Register</h1>
  <form method="POST" action="{{ route('register.submit') }}">
    @csrf
    <div><input type="text" name="name" value="{{ old('name') }}" placeholder="Nama"></div>
    @error('name') <div class="text-red-600">{{ $message }}</div> @enderror

    <div><input type="email" name="email" value="{{ old('email') }}" placeholder="Email"></div>
    @error('email') <div class="text-red-600">{{ $message }}</div> @enderror

    <div><input type="password" name="password" placeholder="Password"></div>
    @error('password') <div class="text-red-600">{{ $message }}</div> @enderror

    <div><input type="password" name="password_confirmation" placeholder="Confirm Password"></div>

    <button type="submit">Register</button>
  </form>
@endsection
