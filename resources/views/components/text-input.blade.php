@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'bg-slate-50 border-slate-200 focus:border-emerald-500 focus:ring-emerald-500/20 rounded-xl shadow-sm']) }}>
