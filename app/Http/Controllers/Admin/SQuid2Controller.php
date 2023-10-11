<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Data;
use Illuminate\Http\Request;
use Stichoza\GoogleTranslate\GoogleTranslate;

class SQuid2Controller extends Controller
{
    public function index()
    {

        return view('admin.squid2.index');
    }

    public function getData()
    {
        $csvFilePath = public_path('train_old.csv');
        $data_csv = [];
        if (($handle = fopen($csvFilePath, 'r')) !== false) {
            while (($data = fgetcsv($handle)) !== false) {
                if(!in_array($data[2], $data_csv))
                {
                    array_push($data_csv, $data[2]);
                }
            }
            fclose($handle);
        } else {
            echo "Не удалось открыть CSV-файл";
        }
        return response(['data' => $data_csv]);
    }

    public function translate(Request $request)
    {
        try{
            $translator = new GoogleTranslate();
            $translator->setSource('en'); // Исходный язык
            $translator->setTarget('ky'); // Целевой язык
            $translatedText = $translator->translate($request->text);
            Data::create(['original' => $request->text, 'ky' => $translatedText]);
            return response(['res' => $translatedText]);
        }
        catch (\Exception $e)
        {
            return response(['error' => $e->getMessage()]);
        }




    }

}
