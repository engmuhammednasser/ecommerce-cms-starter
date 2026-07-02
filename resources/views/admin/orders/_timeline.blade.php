<div class="timeline mb-0">
    @foreach ($order->histories as $history)
        <div>
            @if ($history->action === 'status_change')
                <i class="timeline-icon bi bi-arrow-left-right text-bg-primary"></i>
            @elseif ($history->action === 'payment_change')
                <i class="timeline-icon bi bi-cash text-bg-success"></i>
            @elseif ($history->action === 'fulfillment_change')
                <i class="timeline-icon bi bi-truck text-bg-warning"></i>
            @elseif ($history->action === 'manual_note')
                <i class="timeline-icon bi bi-chat-text text-bg-secondary"></i>
            @else
                <i class="timeline-icon bi bi-info-circle text-bg-secondary"></i>
            @endif

            <div class="timeline-item">
                <span class="time">{{ $history->created_at->format('Y-m-d H:i') }}</span>
                <h3 class="timeline-header">
                    {{ $history->user ? $history->user->name : 'System' }} 
                    @if ($history->action === 'manual_note')
                        added a note
                    @else
                        updated the order
                    @endif
                </h3>

                <div class="timeline-body">
                    {{ $history->comment }}
                </div>
            </div>
        </div>
    @endforeach

    <div>
        <i class="timeline-icon bi bi-cart-check text-bg-primary"></i>
        <div class="timeline-item">
            <span class="time">{{ $order->created_at?->format('Y-m-d H:i') }}</span>
            <h3 class="timeline-header">Order placed</h3>
            <div class="timeline-body">
                Order was created by {{ $order->customer_name }}.
            </div>
        </div>
    </div>
    
    <div>
        <i class="timeline-icon bi bi-clock text-bg-secondary"></i>
    </div>
</div>

<div class="mt-4 border-top pt-3">
    <form action="{{ route('admin.orders.notes.store', $order) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="timeline_note" class="form-label">Add Note to Timeline</label>
            <textarea name="comment" id="timeline_note" rows="2" class="form-control" placeholder="Enter a note about this order..." required></textarea>
        </div>
        <button type="submit" class="btn btn-secondary btn-sm">Add Note</button>
    </form>
</div>
