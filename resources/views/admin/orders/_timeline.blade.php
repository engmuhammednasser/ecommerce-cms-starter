<div class="timeline mb-0">
    <div>
        <i class="timeline-icon bi bi-circle-fill text-bg-primary"></i>
        <div class="timeline-item">
            <span class="time">{{ $order->created_at?->format('Y-m-d H:i') }}</span>
            <h3 class="timeline-header">Order created</h3>
            <div class="timeline-body">
                @include('admin.components.status-badge', ['status' => $order->status])
            </div>
        </div>
    </div>
    <div>
        <i class="timeline-icon bi bi-clock text-bg-secondary"></i>
        <div class="timeline-item">
            <h3 class="timeline-header">Status history</h3>
            <div class="timeline-body text-muted">
                Detailed order status history will be available when the activity/status history module is implemented.
            </div>
        </div>
    </div>
</div>
