@extends('frontend.themes.default.layouts.app')

@section('title', $title ?? 'Login')

@section('content')
    <div class="mx-auto max-w-md px-6 py-20">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="mb-6 text-2xl font-bold text-slate-900">Sign in to your account</h1>

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 p-4 text-sm text-red-600">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customer.login.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                </div>

                <div class="flex items-center justify-between">
                    <label class="flex items-center gap-2 text-sm text-slate-600">
                        <input type="checkbox" name="remember" class="rounded border-slate-300 text-slate-900 focus:ring-slate-900">
                        Remember me
                    </label>
                </div>

                <button type="submit" class="w-full rounded-full bg-slate-900 px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-800">
                    Sign in
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Don't have an account?
                <a href="{{ route('customer.register') }}" class="font-semibold text-slate-900 hover:underline">Create one</a>
            </p>
        </div>
    </div>
@endsection
