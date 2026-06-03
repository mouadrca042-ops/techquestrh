<x-app-layout>
    @php 
        $contenu = json_decode($defi->contenu_json); 
    @endphp

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Messages success / error / explication --}}
            @if(session('success'))
                <div class="bg-green-50 border-2 border-green-300 text-green-800 rounded-2xl px-6 py-5 mb-6 text-lg font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-orange-50 border-2 border-orange-300 text-orange-800 rounded-2xl px-6 py-5 mb-6 text-lg font-semibold">
                    {{ session('error') }}
                </div>
            @endif

            @if(session('explication'))
                <div class="bg-blue-50 border-2 border-blue-200 text-blue-800 rounded-2xl px-6 py-5 mb-6 text-base">
                    💡 <span class="font-bold">Explication :</span> {{ session('explication') }}
                </div>
            @endif

            {{-- Conteneur Blanc principal --}}
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100 mb-6">
                
                <h2 class="text-3xl font-black text-gray-900 mb-6">{{ $defi->titre }}</h2>

                {{-- La Question --}}
                <div class="bg-gray-50 rounded-2xl p-6 mb-8 border border-gray-200">
                    <p class="text-xl text-gray-800 font-medium">{{ $contenu->question }}</p>
                </div>

                {{-- Formulaire --}}
                <form action="{{ route('defis.check', $defi->id) }}" method="POST">
                    @csrf
                    
                    <div class="space-y-4 mb-10">
                        @if($defi->type == 'qcm')
                            @foreach($contenu->options as $option)
                                <label class="flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-blue-500 hover:bg-blue-50 transition-all">
                                    <input type="radio" name="reponse" value="{{ $option }}" class="w-5 h-5 text-blue-600" required>
                                    <span class="ml-4 text-lg font-semibold text-gray-700">{{ $option }}</span>
                                </label>
                            @endforeach
                        @else
                            {{-- Cas Vrai / Faux --}}
                            <div class="flex space-x-4">
                                <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-green-50">
                                    <input type="radio" name="reponse" value="Vrai" class="mr-2" required> Vrai
                                </label>
                                <label class="flex-1 text-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:bg-red-50">
                                    <input type="radio" name="reponse" value="Faux" class="mr-2" required> Faux
                                </label>
                            </div>
                        @endif
                    </div>

                    {{-- BOUTON DE VALIDATION --}}
                    <div class="border-t border-gray-100 pt-8 flex justify-center">
                        <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-12 py-4 rounded-2xl font-bold text-xl shadow-xl transition-all active:scale-95">
                            Valider ma réponse
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>