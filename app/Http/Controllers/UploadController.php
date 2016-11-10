<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Session;

class UploadController extends Controller
{
    public function __construct()
    {

        $this->middleware('auth');
    }


    public function index()
    {
        return view('upload/upload');
    }


    public function store(Request $request)
    {
        $files = $request->file('file');

        foreach($files as $file) {

            $imageName = 'woningen' . '.' . $file->getClientOriginalExtension();

            $file->move(
                base_path() . '/storage/app/public', $imageName
            );

            $uploadedfile = base_path() . '/storage/app/public/' . $imageName;

            $file = fopen($uploadedfile, "r");

            while (!feof($file)) {
                $value = (fgetcsv($file, 0, ';'));

                if ($value[0] != '') {
                    DB::table('adres')->insert([
                        ['straat' => $value["3"], 'huisnummer' => $value["4"], 'toevoeging' => $value["5"], 'postcode' => $value["6"], 'stad' => $value["7"], 'naam' => utf8_encode($value["9"])],
                    ]);
                }
            }
            fclose($file);
        }
        return view('upload/upload')->withError('Adressen toegevoegd');
    }

    public function clearDb(){

        DB::table('adres')->truncate();

        return view('upload/upload')->withError('Database leeggemaakt!');

    }
}

