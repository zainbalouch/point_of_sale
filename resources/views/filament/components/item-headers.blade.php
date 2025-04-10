@props([
    'headers' => [],
])

<div class="flex w-full">
    @foreach ($headers as $header)
        <div class="font-medium text-sm fs-1" style="width: {{ ($header['span'] / 10) * 100 }}%; padding-left: {{ $header['padding'] }}px;">
            {{ $header['label'] }}
        </div>
    @endforeach
</div>
