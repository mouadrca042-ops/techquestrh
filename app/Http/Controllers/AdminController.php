<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Parcours;
use App\Models\Defi;
use App\Models\Badge;
use App\Models\Progression;
use Illuminate\Http\Request;

class AdminController extends Controller
{
   

    // ─── Dashboard ───────────────────────────────────────────
    public function dashboard()
    {
        $stats = [
            'total_employes'  => User::where('role', 'employe')->count(),
            'total_managers'  => User::where('role', 'manager')->count(),
            'total_parcours'  => Parcours::count(),
            'total_defis'     => Defi::count(),
            'total_badges'    => Badge::count(),
            'defis_completes' => Progression::whereNotNull('completed_at')->count(),
        ];
        return view('admin.dashboard', compact('stats'));
    }

    // ─── Parcours ─────────────────────────────────────────────
    public function parcours()
    {
        $parcours = Parcours::withCount('defis')->get();
        return view('admin.parcours.index', compact('parcours'));
    }

    public function createParcours()
    {
        return view('admin.parcours.create');
    }

    public function storeParcours(Request $request)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'outil'       => 'required|in:Excel,Teams,ERP,Email',
        ]);
        Parcours::create($request->only('titre', 'description', 'outil'));
        return redirect()->route('admin.parcours')->with('success', 'Parcours créé avec succès !');
    }

    public function editParcours(Parcours $parcours)
    {
        return view('admin.parcours.edit', compact('parcours'));
    }

    public function updateParcours(Request $request, Parcours $parcours)
    {
        $request->validate([
            'titre'       => 'required|string|max:255',
            'description' => 'nullable|string',
            'outil'       => 'required|in:Excel,Teams,ERP,Email',
        ]);
        $parcours->update($request->only('titre', 'description', 'outil'));
        return redirect()->route('admin.parcours')->with('success', 'Parcours mis à jour !');
    }

    public function destroyParcours(Parcours $parcours)
    {
        $parcours->delete();
        return redirect()->route('admin.parcours')->with('success', 'Parcours supprimé !');
    }

    // ─── Défis ────────────────────────────────────────────────
    public function defis()
    {
        $defis = Defi::with('parcours')->get();
        return view('admin.defis.index', compact('defis'));
    }

    public function createDefi()
    {
        $parcours = Parcours::all();
        return view('admin.defis.create', compact('parcours'));
    }

    public function storeDefi(Request $request)
    {
        $request->validate([
            'parcours_id'    => 'required|exists:parcours,id',
            'titre'          => 'required|string|max:255',
            'type'           => 'required|in:qcm,vrai_faux',
            'niveau'         => 'required|in:debutant,intermediaire,expert',
            'xp_recompense'  => 'required|integer|min:1',
            'contenu_json'   => 'required|json',
        ]);

        Defi::create($request->only(
            'parcours_id', 'titre', 'type', 'niveau', 'xp_recompense', 'contenu_json'
        ));

        // Mettre à jour nb_defis_total du parcours
        $parcours = Parcours::find($request->parcours_id);
        $parcours->nb_defis_total = $parcours->defis()->count();
        $parcours->save();

        return redirect()->route('admin.defis')->with('success', 'Défi créé avec succès !');
    }

    public function editDefi(Defi $defi)
    {
        $parcours = Parcours::all();
        return view('admin.defis.edit', compact('defi', 'parcours'));
    }

    public function updateDefi(Request $request, Defi $defi)
    {
        $request->validate([
            'parcours_id'    => 'required|exists:parcours,id',
            'titre'          => 'required|string|max:255',
            'type'           => 'required|in:qcm,vrai_faux',
            'niveau'         => 'required|in:debutant,intermediaire,expert',
            'xp_recompense'  => 'required|integer|min:1',
            'contenu_json'   => 'required|json',
        ]);

        $defi->update($request->only(
            'parcours_id', 'titre', 'type', 'niveau', 'xp_recompense', 'contenu_json'
        ));

        return redirect()->route('admin.defis')->with('success', 'Défi mis à jour !');
    }

    public function destroyDefi(Defi $defi)
    {
        $defi->delete();
        return redirect()->route('admin.defis')->with('success', 'Défi supprimé !');
    }

    // ─── Badges ───────────────────────────────────────────────
    public function badges()
    {
        $badges = Badge::withCount('users')->get();
        return view('admin.badges.index', compact('badges'));
    }

    public function createBadge()
    {
        return view('admin.badges.create');
    }

    public function storeBadge(Request $request)
    {
        $request->validate([
            'titre'            => 'required|string|max:255',
            'description'      => 'required|string',
            'condition_type'   => 'required|in:premier_defi,assidu,maitrise,explorateur,secret',
            'condition_valeur' => 'required|integer|min:1',
            'image'            => 'nullable|string|max:255',
        ]);
        Badge::create($request->only('titre', 'description', 'condition_type', 'condition_valeur', 'image'));
        return redirect()->route('admin.badges')->with('success', 'Badge créé avec succès !');
    }

    public function editBadge(Badge $badge)
    {
        return view('admin.badges.edit', compact('badge'));
    }

    public function updateBadge(Request $request, Badge $badge)
    {
        $request->validate([
            'titre'            => 'required|string|max:255',
            'description'      => 'required|string',
            'condition_type'   => 'required|in:premier_defi,assidu,maitrise,explorateur,secret',
            'condition_valeur' => 'required|integer|min:1',
            'image'            => 'nullable|string|max:255',
        ]);
        $badge->update($request->only('titre', 'description', 'condition_type', 'condition_valeur', 'image'));
        return redirect()->route('admin.badges')->with('success', 'Badge mis à jour !');
    }

    public function destroyBadge(Badge $badge)
    {
        $badge->delete();
        return redirect()->route('admin.badges')->with('success', 'Badge supprimé !');
    }

    // ─── Utilisateurs ─────────────────────────────────────────
    public function users()
    {
        $users = User::where('role', '!=', 'admin')->orderBy('role')->get();
        return view('admin.users.index', compact('users'));
    }

    public function updateUserRole(Request $request, User $user)
    {
        $request->validate(['role' => 'required|in:employe,manager']);
        $user->update(['role' => $request->role]);
        return redirect()->route('admin.users')->with('success', 'Rôle mis à jour !');
    }
}