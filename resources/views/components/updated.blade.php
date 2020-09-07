<p class="text-muted"> 
    {{ empty(trim($slot)) ? 'Added' : $slot }} : {{ $date }} 
    {{-- {{ empty(trim($message)) ? 'Added' : $message}} : {{ $recentDate->diffForHumans() }}  --}}
    @if (isset($name))
        by: {{ $name }}
    @endif    
</p>
