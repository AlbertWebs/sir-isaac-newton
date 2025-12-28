@props(['label', 'name', 'type' => 'text', 'required' => false, 'icon' => null, 'placeholder' => '', 'value' => '', 'help' => null])

<div class="group">
    <label for="{{ $name }}" class="block text-sm font-medium text-gray-700 mb-2 group-focus-within:text-blue-600 transition-colors">
        @if($icon)
        <span class="flex items-center">
            <svg class="w-4 h-4 mr-1 text-gray-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                {!! $icon !!}
            </svg>
            {{ $label }}@if($required) *@endif
        </span>
        @else
            {{ $label }}@if($required) *@endif
        @endif
    </label>
    <input 
        type="{{ $type }}" 
        id="{{ $name }}" 
        name="{{ $name }}" 
        value="{{ old($name, $value) }}" 
        @if($required) required @endif
        placeholder="{{ $placeholder }}"
        class="w-full px-4 py-2.5 border-2 border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 shadow-sm hover:shadow-md focus:shadow-lg bg-white"
        {{ $attributes }}
    >
    @if($help)
    <p class="text-xs text-gray-500 mt-1.5 flex items-center">
        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ $help }}
    </p>
    @endif
    @error($name)
        <p class="text-red-500 text-xs mt-1.5 flex items-center">
            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
            </svg>
            {{ $message }}
        </p>
    @enderror
</div>

