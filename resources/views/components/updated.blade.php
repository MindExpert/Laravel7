<p class="text-muted"> 
    {{ empty(trim($slot)) ? 'Added' : $slot }} : {{ $date->diffForHumans() }} 
    {{-- {{ empty(trim($attributes)) ? 'Added' : $attributes}} : {{ $date }}  --}}
    @if (isset($name))
        by: {{ $name }}
    @endif    
</p>
