@props(['title'])

<div {{ $attributes->merge(['class' => 'space-y-3']) }}>
    <h4 class="font-semibold text-gray-700 border-b border-gray-200 pb-2">{{ $title }}</h4>
    {{ $slot }}
</div>
