@extends('layouts.admin')

@section('title', 'Add Shipping Rate to ' . $shippingZone->name)

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Add Shipping Rate</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipping-zones.rates.store', $shippingZone) }}" method="POST">
                @csrf
                @include('admin.shipping-rates._form')
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Rate</button>
                    <a href="{{ route('admin.shipping-zones.edit', $shippingZone) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
