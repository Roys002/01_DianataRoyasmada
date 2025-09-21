<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>@yield('title', 'Aplikasi')</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="antialiased">
  <nav class="p-4 bg-gray-100">
    <div class="container mx-auto flex justify-between">
      <div>
        <a href="{{ url('/') }}" class="font-bold">Portal</a>
      </div>
      <div>
        @auth
          <span>Hi, {{ auth()->user()->name }}</span>
          <form action="{{ route('logout') }}" method="POST" style="display:inline">
            @csrf
            <button type="submit">Logout</button>
          </form>
          @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.submissions.index') }}">Admin</a>
          @endif
        @else
          <a href="{{ route('login.form') }}">Login</a> | <a href="{{ route('register.form') }}">Register</a>
        @endauth
      </div>
    </div>
  </nav>

  <main class="container mx-auto p-6">
    @if(session('success'))
      <div class="bg-green-100 p-3 mb-4">{{ session('success') }}</div>
    @endif
    @if(session('error'))
      <div class="bg-red-100 p-3 mb-4">{{ session('error') }}</div>
    @endif

    @yield('content')
  </main>
</body>
</html>
