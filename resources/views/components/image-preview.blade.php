@props(['url'])

<img src="{{ Storage::url($url) }}" alt="Preview" class="w-16 h-16 object-cover rounded">
