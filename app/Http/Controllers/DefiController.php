<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DefiController extends Controller
{
     public function show($id)
    {
      $defi = \App\Models\Defi::findOrFail($id);
      return view('defis.show', compact('defi'));
    }
}
