<?php

namespace App\Http\Controllers\Admin\User;

use App\Http\Controllers\Controller;
use App\Models\Context;
use App\Models\QuestionAnswer;
use App\Services\ProfileService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class ProfileController extends Controller
{
    protected ProfileService $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function index()
    {
        $user = auth()->user()->id;
        $questions = QuestionAnswer::where('created_by', $user)->where('type', 'manual')->latest('created_at')->get();
        $contexts = Context::where('created_by', $user)->paginate(100);
        return view('admin.profile.index', compact('contexts', 'questions'));
    }

    public function getDiagram()
    {
        return response($this->profileService->getDiagram());
    }

    public function getGraphic(Request $request)
    {
        $current_date = Carbon::now();
        return response($this->profileService->getGraphic(auth()->user()->id, $request->day, $current_date));
    }
}
