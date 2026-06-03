<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h2 class="text-2xl font-bold mb-6 text-gray-800">Ma Galerie de Badges</h2>
            
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach($allBadges as $badge)
                    @php
                        $isUnlocked = in_array($badge->id, $userBadgesIds);
                    @endphp
                    
                    <div class="bg-white p-6 rounded-lg shadow-md text-center {{ $isUnlocked ? 'border-2 border-yellow-400' : 'opacity-50 grayscale' }}">
                        <img src="{{ asset($badge->image) }}" alt="{{ $badge->titre }}" class="w-24 h-24 mx-auto mb-4">
                        <h3 class="font-bold text-lg">{{ $isUnlocked ? $badge->titre : '???' }}</h3>
                        <p class="text-sm text-gray-600">{{ $badge->description }}</p>
                        
                        @if(!$isUnlocked)
                            <span class="inline-block mt-2 px-2 py-1 bg-gray-200 text-xs rounded">Verrouillé</span>
                        @else
                            <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-800 text-xs rounded font-bold">Obtenu !</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>