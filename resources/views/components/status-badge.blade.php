<span {{ $attributes->merge(['class' => 'status-badge inline-flex items-center gap-1 px-2 py-1 rounded-full text-xs font-medium ' . $result->color() . ' ' . $class]) }}>
    {!! $result->icon($set) !!}
    <span>{{ $result->label() }}</span>
</span>
