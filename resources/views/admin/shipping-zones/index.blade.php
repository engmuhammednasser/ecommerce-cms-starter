@extends('layouts.admin')

@section('title', 'Shipping Zones')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">Shipping Zones</h3>
            <a href="{{ route('admin.shipping-zones.create') }}" class="btn btn-primary btn-sm">Add Shipping Zone</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped table-hover mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px">#</th>
                        <th>Name</th>
                        <th>Status</th>
                        <th>Sort Order</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($zones as $zone)
                        <tr>
                            <td>{{ $zone->id }}</td>
                            <td>{{ $zone->name }}</td>
                            <td>
                                @include('admin.components.status-badge', ['status' => $zone->is_active ? 'active' : 'inactive'])
                            </td>
                            <td>{{ $zone->sort_order }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.shipping-zones.edit', $zone) }}" class="btn btn-sm btn-primary">Edit</a>
                                @include('admin.components.confirm-delete', ['action' => route('admin.shipping-zones.destroy', $zone)])
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No shipping zones found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
