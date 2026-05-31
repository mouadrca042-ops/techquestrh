<x-app-layout>
    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm sm:rounded-2xl p-8 border border-gray-100">
                <div class="mb-6">
                    <a href="{{ route('admin.dashboard') }}" class="text-sm text-gray-400 hover:text-gray-600">← Admin</a>
                    <h2 class="text-2xl font-black text-gray-900 mt-1">Gestion des utilisateurs</h2>
                </div>

                @if(session('success'))
                    <div class="bg-green-50 border border-green-200 text-green-700 rounded-xl px-4 py-3 mb-6 text-sm font-medium">{{ session('success') }}</div>
                @endif

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold">Nom</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold">Email</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold">Rôle actuel</th>
                            <th class="text-left py-3 px-4 text-gray-500 font-semibold">XP</th>
                            <th class="text-right py-3 px-4 text-gray-500 font-semibold">Changer rôle</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b border-gray-50 hover:bg-gray-50 transition-colors">
                                <td class="py-4 px-4 font-semibold text-gray-800">{{ $user->name }}</td>
                                <td class="py-4 px-4 text-gray-500">{{ $user->email }}</td>
                                <td class="py-4 px-4">
                                    @php $roleColor = $user->role == 'manager' ? 'bg-purple-100 text-purple-700' : 'bg-blue-100 text-blue-700'; @endphp
                                    <span class="{{ $roleColor }} px-3 py-1 rounded-full text-xs font-bold">{{ $user->role }}</span>
                                </td>
                                <td class="py-4 px-4 font-bold text-yellow-600">{{ $user->xp_total }} XP</td>
                                <td class="py-4 px-4 text-right">
                                    <form action="{{ route('admin.users.role', $user) }}" method="POST" class="flex justify-end gap-2 items-center">
                                        @csrf @method('PUT')
                                        <select name="role" class="border border-gray-200 rounded-lg px-3 py-1.5 text-xs focus:outline-none focus:ring-2 focus:ring-purple-400">
                                            <option value="employe" {{ $user->role == 'employe' ? 'selected' : '' }}>Employé</option>
                                            <option value="manager" {{ $user->role == 'manager' ? 'selected' : '' }}>Manager RH</option>
                                        </select>
                                        <button type="submit" class="bg-purple-100 hover:bg-purple-200 text-purple-700 px-3 py-1.5 rounded-lg text-xs font-semibold transition-all">OK</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>