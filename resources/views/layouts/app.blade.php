<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Taskflow' }} · Taskflow</title>
    @vite(['resources/css/app.css'])
</head>
<body>
    <div class="app-shell">
        <header class="topbar">
            <a class="brand" href="{{ route('tasks.index') }}" aria-label="Taskflow home"><span class="brand-mark">T</span><span>taskflow</span></a>
            <span class="topbar-note">Personal task manager</span>
        </header>
        <main class="page-content">
            @if (session('success'))<div class="flash" role="status">{{ session('success') }}<span aria-hidden="true">&#10003;</span></div>@endif
            @if ($errors->any())<div class="error-summary" role="alert"><strong>Please check the form.</strong><ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
            @yield('content')
        </main>
    </div>
</body>
</html>