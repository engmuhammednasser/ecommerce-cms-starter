@extends('layouts.admin')

@section('title', 'Edit Shipping Rate: ' . $shippingRate->name)

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Edit Shipping Rate</h3>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.shipping-zones.rates.update', [$shippingZone, $shippingRate]) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.shipping-rates._form')
                
                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Update Rate</button>
                    <a href="{{ route('admin.shipping-zones.edit', $shippingZone) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection
