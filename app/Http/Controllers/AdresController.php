<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Validator;
use Redirect;
use Illuminate\Support\Facades\Input;
use Session;

class adresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        return view('adres/index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    $imageName =  'woningen'.'.'.$request->file('file')->getClientOriginalExtension();

    $request->file('file')->move(
        base_path() . '/storage/app/public', $imageName
    );

    $uploadedfile = base_path() . '/storage/app/public/' . $imageName;



    $file = fopen($uploadedfile, "r");


        while (!feof($file))
            {
            $value = (fgetcsv($file, 0, ';'));

                if ($value[0] != '')
                {

                    DB::table('adres')->insert([
                        ['straat' => $value["2"], 'huisnummer' => $value["3"],'toevoeging' => $value["4"],'postcode' => $value["5"],'stad' => $value["6"],'naam' => utf8_encode($value["8"])],
                        
]);
                    // print_r($value["2"] . $value["3"]. $value["4"]. $value["5"]. $value["6"]. $value["8"]);
                    // print_r("</br>");
                }

            }

       
        fclose($file);


    return view('adres/upload');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function upload()
    {
        return view('adres/upload');
    }
}
