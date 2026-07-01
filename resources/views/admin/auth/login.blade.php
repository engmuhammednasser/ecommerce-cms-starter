<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @if (setting('general.favicon'))
        <link rel="icon" href="{{ asset('storage/' . setting('general.favicon')) }}">
    @endif

    <title>{{ setting('admin.login_title', 'Admin Login') }} - {{ setting('general.site_name', config('app.name', 'Laravel')) }}</title>

    @vite(['resources/css/admin.css', 'resources/js/admin.js'])
</head>
<body class="bg-body-tertiary">
    @php
        $storeName = setting('general.site_name', config('app.name', 'Laravel'));
        $logo = setting('general.logo');
        $loginImage = setting('admin.login_image', setting('seo.default_image', 'demo/hero.svg'));
    @endphp

    <main class="min-vh-100 d-flex align-items-center justify-content-center p-3 p-lg-4">
        <div class="card overflow-hidden border-0 shadow-sm w-100" style="max-width: 1120px; border-radius: 1rem;">
            <div class="row g-0">
                <div class="col-lg-6">
                    <div class="d-flex min-vh-75 flex-column justify-content-center px-4 py-5 px-sm-5">
                        <div class="mb-5">
                            @if ($logo)
                                <img src="{{ asset('storage/' . $logo) }}" alt="{{ $storeName }}" class="mb-4" style="max-height: 56px; max-width: 180px;">
                            @else
                                <div class="mb-4 h4 fw-semibold">{{ $storeName }}</div>
                            @endif

                            <h1 class="display-6 fw-semibold mb-2">{{ setting('admin.login_title', 'Welcome back') }}</h1>
                            <p class="text-muted mb-0">{{ setting('admin.login_subtitle', 'Sign in to manage your store.') }}</p>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger" role="alert">
                                {{ $errors->first() }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('admin.login.store') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label fw-medium">Email address</label>
                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control form-control-lg rounded-3 @error('email') is-invalid @enderror"
                                    placeholder="admin@example.com"
                                    autocomplete="email"
                                    required
                                    autofocus
                                >
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label fw-medium">Password</label>
                                <div class="input-group input-group-lg">
                                    <input
                                        id="password"
                                        type="password"
                                        name="password"
                                        class="form-control rounded-start-3 @error('password') is-invalid @enderror"
                                        placeholder="Enter your password"
                                        autocomplete="current-password"
                                        required
                                    >
                                    <button
                                        type="button"
                                        class="btn btn-outline-secondary rounded-end-3"
                                        data-password-toggle
                                        data-password-target="password"
                                        aria-label="Show password"
                                    >
                                        <span data-password-toggle-label>Show</span>
                                    </button>
                                </div>
                            </div>

                            <div class="form-check mb-4">
                                <input id="remember" type="checkbox" name="remember" value="1" class="form-check-input">
                                <label for="remember" class="form-check-label">Remember me</label>
                            </div>

                            <button type="submit" class="btn btn-success btn-lg w-100 rounded-3">
                                {{ setting('admin.login_button_label', 'Sign in') }}
                            </button>
                        </form>
                    </div>
                </div>

                <div class="col-lg-6 d-none d-lg-block">
                    <div class="h-100 bg-success-subtle">
                        @if ($loginImage)
                            <img src="{{ asset('storage/' . $loginImage) }}" alt="{{ $storeName }}" class="h-100 w-100 object-fit-cover">
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </main>
</body>
</html>
