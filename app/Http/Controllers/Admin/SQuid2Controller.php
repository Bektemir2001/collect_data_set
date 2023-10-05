<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SQuid2Controller extends Controller
{
    public function index()
    {
        $jsonFilePath = public_path('train-v2.0.json');
        $jsonString = file_get_contents($jsonFilePath);
        $data = json_decode($jsonString, true);
        dd($data['data'][0]);
        return view('admin.squid2.index', compact('data'));
    }
}
