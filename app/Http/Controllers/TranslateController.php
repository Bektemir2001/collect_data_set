<?php

namespace App\Http\Controllers;

use App\Services\TranslateService;
use Illuminate\Http\Request;

class TranslateController extends Controller
{
    private TranslateService $translateService;
    public function __construct(TranslateService $translateService)
    {
        $this->translateService = $translateService;
    }

    public function alpaca(Request $request)
    {
        $data = $request->validate([
            'from' => 'required',
            'value' => 'required'
        ]);

        $from = $this->translateService->translate($data['from'], 'EN', 'KG');
        $value = $this->translateService->translate($data['value'], 'EN', 'KG');

        return response(['from' => $from['result'], 'value' => $value['result']]);
    }
}
