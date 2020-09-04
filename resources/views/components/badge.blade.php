@if (!isset($show) || $show )  
    <span class="badge badge-{{ $type ?? 'success'}}">
        {{-- {{ $message }} --}}
        {{ $slot }}
    </span>
@endif