@props(['outil' => '', 'size' => 'md'])

@php
    // Logo (couleur de marque + icône) propre à chaque formation.
    $map = [
        'Excel' => [
            'bg'   => 'bg-emerald-600',
            'icon' => '<rect x="3" y="4" width="18" height="16" rx="2"></rect><path d="M3 9h18M3 14.5h18M9 4v16M15 4v16"></path>',
        ],
        'Teams' => [
            'bg'   => 'bg-indigo-600',
            'icon' => '<path d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z"></path>',
        ],
        'ERP' => [
            'bg'   => 'bg-sky-600',
            'icon' => '<path d="M20.25 6.375c0 2.278-3.694 4.125-8.25 4.125S3.75 8.653 3.75 6.375m16.5 0c0-2.278-3.694-4.125-8.25-4.125S3.75 4.097 3.75 6.375m16.5 0v11.25c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125V6.375m16.5 0v3.75m-16.5-3.75v3.75m16.5 0v3.75c0 2.278-3.694 4.125-8.25 4.125s-8.25-1.847-8.25-4.125v-3.75"></path>',
        ],
        'Email' => [
            'bg'   => 'bg-rose-500',
            'icon' => '<path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"></path>',
        ],
    ];

    $conf = $map[$outil] ?? ['bg' => 'bg-gray-500', 'icon' => '<path d="M12 6.75v10.5M6.75 12h10.5"></path>'];

    $box  = ['sm' => 'w-9 h-9', 'md' => 'w-12 h-12', 'lg' => 'w-16 h-16'][$size] ?? 'w-12 h-12';
    $ic   = ['sm' => 'w-5 h-5', 'md' => 'w-6 h-6', 'lg' => 'w-8 h-8'][$size] ?? 'w-6 h-6';
@endphp

<div {{ $attributes->merge(['class' => "$box $conf[bg] rounded-xl flex items-center justify-center text-white shrink-0 shadow-sm"]) }}>
    <svg class="{{ $ic }}" fill="none" viewBox="0 0 24 24" stroke-width="1.6" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
        {!! $conf['icon'] !!}
    </svg>
</div>
