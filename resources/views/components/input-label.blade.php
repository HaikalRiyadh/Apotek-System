@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-semibold text-sm text-slate-600']) }}>
    {{ $value ?? $slot }}
</label>
