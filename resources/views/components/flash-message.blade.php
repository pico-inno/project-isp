@if (session()->has('message'))
    @php
        $type = session('message_type', 'success');
        $color = match ($type) {
            'success' => 'green',
            'error' => 'red',
            'info' => 'blue',
            'warning' => 'yellow',
            default => 'gray',
        };
    @endphp

    <mijnui:alert variant="default" color="{{ $type }}" class="flex items-center gap-3 p-4 rounded-lg shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-{{ $color }}-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            @if ($type === 'success')
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M9 12.75 11.25 15 15 9.75M21 12c0 1.268-.63 2.39-1.593 3.068a3.745 3.745 0 0 1-1.043 3.296
                         3.745 3.745 0 0 1-3.296 1.043A3.745 3.745 0 0 1 12 21c-1.268 0-2.39-.63-3.068-1.593a3.746
                         3.746 0 0 1-3.296-1.043 3.745 3.745 0 0 1-1.043-3.296A3.745 3.745 0 0 1 3 12c0-1.268.63-2.39
                         1.593-3.068a3.745 3.745 0 0 1 1.043-3.296 3.746 3.746 0 0 1 3.296-1.043A3.746 3.746 0 0 1 12
                         3c1.268 0 2.39.63 3.068 1.593a3.746 3.746 0 0 1 3.296 1.043 3.746 3.746 0 0 1 1.043
                         3.296A3.745 3.745 0 0 1 21 12Z" />
            @else
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
            @endif
        </svg>
        <span class="text-sm text-{{ $color }}-700 font-medium">
            {{ session('message') }}
        </span>
    </mijnui:alert>
@endif
