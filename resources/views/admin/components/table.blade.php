@php
    $headers = $headers ?? [];
    $rows = $rows ?? [];
    $emptyMessage = $emptyMessage ?? 'No records found.';
    $class = $class ?? 'table table-hover mb-0';
@endphp

<div class="table-responsive">
    <table class="{{ $class }}">
        @if ($headers)
            <thead>
                <tr>
                    @foreach ($headers as $header)
                        <th>{{ $header }}</th>
                    @endforeach
                </tr>
            </thead>
        @endif
        <tbody>
            @forelse ($rows as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ max(count($headers), 1) }}" class="text-center text-muted py-4">
                        {{ $emptyMessage }}
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
