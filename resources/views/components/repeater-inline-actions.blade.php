<div class="flex items-center space-x-2">
    <button
        type="button"
        class="text-sm text-red-600 hover:text-red-800"
        x-on:click="$dispatch('repeater::remove-item', { statePath: '{{ $statePath }}' })"
    >
        Delete
    </button>

    <button
        type="button"
        class="text-sm text-blue-600 hover:text-blue-800"
        x-on:click="$dispatch('repeater::clone-item', { statePath: '{{ $statePath }}' })"
    >
        Clone
    </button>
</div>
