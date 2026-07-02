@extends('frontend.themes.default.layouts.app')

@section('title', $title ?? 'Register')

@section('content')
    <div class="mx-auto max-w-md px-6 py-20">
        <div class="rounded-3xl border border-slate-200 bg-white p-8 shadow-sm">
            <h1 class="mb-6 text-2xl font-bold text-slate-900">Create an account</h1>

            @if ($errors->any())
                <div class="mb-6 rounded-xl bg-red-50 p-4 text-sm text-red-600">
                    <ul class="list-inside list-disc">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('customer.register.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label for="name" class="mb-2 block text-sm font-medium text-slate-700">Full Name</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                </div>

                <div>
                    <label for="email" class="mb-2 block text-sm font-medium text-slate-700">Email Address</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                </div>

                <div>
                    <label for="password" class="mb-2 block text-sm font-medium text-slate-700">Password</label>
                    <input type="password" id="password" name="password" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                </div>

                <div>
                    <label for="password_confirmation" class="mb-2 block text-sm font-medium text-slate-700">Confirm Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-slate-500 focus:outline-none focus:ring-1 focus:ring-slate-500">
                </div>

                <button type="submit" class="w-full rounded-full bg-slate-900 px-6 py-3 text-center text-sm font-semibold text-white transition hover:bg-slate-800">
                    Create account
                </button>
            </form>

            <p class="mt-6 text-center text-sm text-slate-600">
                Already have an account?
                <a href="{{ route('customer.login') }}" class="font-semibold text-slate-900 hover:underline">Sign in</a>
            </p>
        </div>
    </div>
@endsection
