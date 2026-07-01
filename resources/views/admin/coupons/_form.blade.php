<form method="POST" action="{{ $action }}">
    @csrf
    @if ($method !== 'POST')
        @method($method)
    @endif

    <div class="row">
        <div class="col-lg-8">
            @include('admin.components.form.input', [
                'name' => 'code',
                'label' => 'Coupon Code',
                'value' => $coupon->code,
                'required' => true,
            ])

            @include('admin.components.form.input', [
                'name' => 'name',
                'label' => 'Name',
                'value' => $coupon->name,
            ])

            <div class="row">
                <div class="col-md-6">
                    @include('admin.components.form.select', [
                        'name' => 'discount_type',
                        'label' => 'Discount Type',
                        'selected' => $coupon->discount_type ?: 'fixed',
                        'required' => true,
                        'options' => \App\Models\Coupon::DISCOUNT_TYPES,
                    ])
                </div>
                <div class="col-md-6">
                    @include('admin.components.form.input', [
                        'name' => 'discount_value',
                        'label' => 'Discount Value',
                        'value' => $coupon->discount_value ?? 0,
                        'type' => 'text',
                        'required' => true,
                    ])
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    @include('admin.components.form.input', [
                        'name' => 'minimum_order_amount',
                        'label' => 'Minimum Order Amount',
                        'value' => $coupon->minimum_order_amount ?? 0,
                        'type' => 'text',
                    ])
                </div>
                <div class="col-md-6">
                    @include('admin.components.form.input', [
                        'name' => 'usage_limit',
                        'label' => 'Usage Limit',
                        'value' => $coupon->usage_limit,
                        'type' => 'number',
                    ])
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            @include('admin.components.form.select', [
                'name' => 'status',
                'label' => 'Status',
                'selected' => $coupon->status ?: 'active',
                'required' => true,
                'options' => \App\Models\Coupon::STATUSES,
            ])

            @include('admin.components.form.input', [
                'name' => 'starts_at',
                'label' => 'Starts At',
                'value' => $coupon->starts_at?->format('Y-m-d\TH:i'),
                'type' => 'datetime-local',
            ])

            @include('admin.components.form.input', [
                'name' => 'ends_at',
                'label' => 'Ends At',
                'value' => $coupon->ends_at?->format('Y-m-d\TH:i'),
                'type' => 'datetime-local',
            ])
        </div>
    </div>

    <div class="d-flex justify-content-end gap-2">
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-outline-secondary">Cancel</a>
        <button type="submit" class="btn btn-primary">Save Coupon</button>
    </div>
</form>
