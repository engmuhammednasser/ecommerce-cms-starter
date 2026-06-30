<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <tbody>
            @foreach ($systemInfo as $label => $value)
                <tr>
                    <th class="w-50">{{ $label }}</th>
                    <td>{{ $value }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
