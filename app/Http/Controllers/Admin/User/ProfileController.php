<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Context;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $contexts = Context::where('created_by', auth()->user()->id)->paginate(100);
        return view('admin.profile.index', compact('contexts'));
    }
}
