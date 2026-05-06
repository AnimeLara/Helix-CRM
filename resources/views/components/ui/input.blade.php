@props(['label', 'name'])

<label class="block">
    <span class="mb-2 block text-sm font-medium text-slate-700 dark:text-slate-200">{{ $label }}</span>
    <input name="{{ $name }}" {{ $attributes->merge(['class' => 'crm-input']) }}>
    @error($name)
        <span class="mt-2 block text-sm text-rose-500">{{ $message }}</span>
    @enderror
</label>
