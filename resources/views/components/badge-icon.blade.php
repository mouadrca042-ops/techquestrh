@props(['type' => '', 'unlocked' => true, 'size' => 'md'])

@php
    // Médaille (médaillon + rubans), déclinée par couleur selon le type de badge.
    // Style sobre et professionnel, une seule forme cohérente pour tous.
    $map = [
        'premier_defi' => ['ring' => 'bg-blue-50',    'color' => 'text-blue-600'],
        'assidu'       => ['ring' => 'bg-orange-50',  'color' => 'text-orange-500'],
        'maitrise'     => ['ring' => 'bg-amber-50',   'color' => 'text-amber-500'],
        'explorateur'  => ['ring' => 'bg-emerald-50', 'color' => 'text-emerald-600'],
        'secret'       => ['ring' => 'bg-purple-50',  'color' => 'text-purple-600'],
    ];
    $conf = $map[$type] ?? ['ring' => 'bg-gray-50', 'color' => 'text-gray-500'];

    $box = ['sm' => 'w-12 h-12', 'md' => 'w-16 h-16', 'lg' => 'w-24 h-24'][$size] ?? 'w-16 h-16';
    $ic  = ['sm' => 'w-7 h-7',  'md' => 'w-9 h-9',  'lg' => 'w-14 h-14'][$size] ?? 'w-9 h-9';

    $fond    = $unlocked ? $conf['ring'] : 'bg-gray-100';
    $couleur = $unlocked ? $conf['color'] : 'text-gray-300';
@endphp

<div {{ $attributes->merge(['class' => "$box rounded-full flex items-center justify-center mx-auto $fond"]) }}>
    {{-- Médaille : médaillon + étoile + rubans --}}
    <svg class="{{ $ic }} {{ $couleur }}" viewBox="0 0 24 24" fill="none"
         stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
        <circle cx="12" cy="8.5" r="5.5" />
        <path d="M12 5.6l1.05 2.13 2.35.34-1.7 1.66.4 2.34L12 11.3l-2.1 1.1.4-2.34-1.7-1.66 2.35-.34L12 5.6z" />
        <path d="M8.7 13.4l-2.2 6.1 3-.9 1.5 2.4" />
        <path d="M15.3 13.4l2.2 6.1-3-.9-1.5 2.4" />
    </svg>
</div>
