<?php



namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class DashboardRHController extends Controller
{
    public function index()
    {
        // On récupère tous les utilisateurs avec le compte de leurs badges
        $users = User::withCount('badges')->get();
        
        return view('dashboard-rh', compact('users'));
    }
}