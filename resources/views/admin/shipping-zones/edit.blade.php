@extends('layouts.admin')

@section('title', 'Edit Shipping Zone: ' . $shippingZone->name)

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Shipping Zone</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.shipping-zones.update', $shippingZone) }}" method="POST">
                        @csrf
                        @method('PUT')
                        @include('admin.shipping-zones._form')
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">Update Shipping Zone</button>
                            <a href="{{ route('admin.shipping-zones.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Shipping Rates</h3>
                    <a href="{{ route('admin.shipping-zones.rates.create', $shippingZone) }}" class="btn btn-primary btn-sm">Add Rate</a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-striped table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Rate</th>
                                <th>Free Threshold</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($shippingZone->rates as $rate)
                                <tr>
                                    <td>{{ $rate->name }}</td>
                                    <td>{{ number_format($rate->rate, 2) }}</td>
                                    <td>{{ $rate->free_shipping_threshold ? number_format($rate->free_shipping_threshold, 2) : '-' }}</td>
                                    <td>
                                        @include('admin.components.status-badge', ['status' => $rate->is_active ? 'active' : 'inactive'])
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.shipping-zones.rates.edit', [$shippingZone, $rate]) }}" class="btn btn-sm btn-primary">Edit</a>
                                        @include('admin.components.confirm-delete', ['action' => route('admin.shipping-zones.rates.destroy', [$shippingZone, $rate])])
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">No shipping rates found for this zone.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
