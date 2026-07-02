@extends('layouts.admin')

@section('title', 'Add Shipping Zone')

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Shipping Zone</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipping-zones.store') }}" method="POST">
                @csrf
                @include('admin.shipping-zones._form')
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Shipping Zone</button>
                    <a href="{{ route('admin.shipping-zones.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
