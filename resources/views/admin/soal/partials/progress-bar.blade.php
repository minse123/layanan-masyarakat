@props([
    'persentase',
    'showValue' => false
])

@php
    $colorClass = match(true) {
        $persentase > 70 => 'bg-danger',
        $persentase > 40 => 'bg-warning',
        default => 'bg-success'
    };
@endphp

<div class="progress">
    <div class="progress-bar {{ $colorClass }}" 
         role="progressbar" 
         style="width: {{ $persentase }}%" 
         aria-valuenow="{{ $persentase }}" 
         aria-valuemin="0" 
         aria-valuemax="100">
        @if($showValue)
            {{ round($persentase, 1) }}%
        @endif
    </div>
</div>
