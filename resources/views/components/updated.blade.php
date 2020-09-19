<p class="text-muted"> 
    {{ empty(trim($slot)) ? __('Added') : $slot }} : {{ $date }} 
    {{-- {{ empty(trim($message)) ? 'Added' : $message}} : {{ $recentDate->diffForHumans() }}  --}}
    @if (isset($name))

        @if (isset($userId))
            by <a href="{{ route('users.show', ['user'=> $userId]) }}"> {{ $name }} </a>
        @else 
            by: {{ $name }}
        @endif

    @endif    
</p>
