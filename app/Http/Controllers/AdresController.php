<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use \PDF;
use Session;
use Illuminate\Support\Facades\Mail;

class AdresController extends Controller
{

    public function __construct()
    {

        $this->middleware('auth');
    }

    public function index()
    {
        return view('adres/index');
    }

    public function search(Request $request)
    {
        $postcodeHuisnummer = $request->input('postcode_huisnummer');
        $pattern = '/([0-9]{4})([a-zA-Z]{2})([0-9]*)/';


        if (preg_match($pattern, $postcodeHuisnummer, $matches)) {
            $postcode1 = $matches[1];
            $postcode2 = $matches[2];
            $postcode = $postcode1 . " " . $postcode2;
            $huisnummer = $matches[3];

            if ($request->isMethod('post')) {
                $adresses = DB::table('adres')->where([
                    ['postcode', '=', $postcode],
                    ['huisnummer', '=', $huisnummer],
                ])->get();

                if ($adresses->isEmpty()) {
                    return view('adres/brief')->withError('Geen resultaten gevonden!');
                }
            }

            $adressen = $this->assignAdresses($adresses);

            return view('adres/index')->withAdressen($adressen);
        } else {
            return view('adres/index')->withError('Postcode en huisnummer zijn niet goed ingevuld!');
        }
    }

    public function brief(Request $request)
    {
        $datum = $request->input('datum');
        $afspraak = $request->input('afspraak');
        $tijd = $this->checkTijd($request->input('tijd'));
        $soort = $request->input('soort');




        setlocale(LC_ALL, array('Dutch_Netherlands', 'Dutch', 'nl_NL', 'nl', 'nl_NL.ISO8859-1', 'nld_NLD'));
        $huidigeDatum = strftime("%d %B %Y");

        if ($soort == 'createBrief') {
            $naam = $request->input('naam');
            $straat = $request->input('straat');
            $huisnummer = $request->input('huisnummer');
            $postcode = $request->input('postcode');
            $woonplaats = $request->input('woonplaats');
            $toevoeging = $request->input('toevoeging');

            $logo = url('images/logo.jpg');

            $aAdresData = array
            (
                'straat' => $straat,
                'huisnummer' => $huisnummer,
                'toevoeging' => $toevoeging,
                'postcode' => $postcode,
                'stad' =>  $woonplaats,
                'stad_datum'=> ucfirst($woonplaats),
                'naam' => $naam,
                'datum' => $datum,
                'tijd' => $tijd,
                'huidige_datum'=>$huidigeDatum,
                'logo' => $logo
            );

            $filename = str_replace(" ", "", $postcode) . $huisnummer . str_replace(" ", "", $toevoeging) . '.pdf';


            PDF::loadView('pdf.'. $afspraak , $aAdresData)->save('storage/' .$filename);


        } else {
            $id = $request->input('id');
            $adres = DB::table('adres')->where('id', $id)->first();
            $logo = asset('images/logo.jpg');
            $aAdresData = array
            (
                'straat' => $adres->straat,
                'huisnummer' => $adres->huisnummer,
                'toevoeging' => $adres->toevoeging,
                'postcode' => $adres->postcode,
                'stad' => $adres->stad,
                'stad_datum'=> ucfirst(strtolower($adres->stad)),
                'naam' => $adres->naam,
                'datum' => $datum,
                'tijd' => $tijd,
                'huidige_datum'=>$huidigeDatum,
                'logo' => $logo
            );

            $filename = str_replace(" ", "", $aAdresData['postcode']) . $adres->huisnummer . str_replace(" ", "", $adres->toevoeging) . '.pdf';

            $pdf = PDF::loadView('pdf.' . $afspraak, $aAdresData);
            $pdf->save('storage/' .$filename);

        }

        return $filename;
    }

    public function mail(Request $request)
    {
        $logo = asset('images/logo.jpg');
        $datum = $request->input('datum');
        $afspraak = $request->input('afspraak');
        $tijd = $request->input('tijd');
        $id = $request->input('id');
        $email = $request->input('email');
        $adres = DB::table('adres')->where('id', $id)->first();

        $tijd = $this->checkTijd($tijd);
        $brief = $this->checkAfspraak($afspraak);

        $data = [
            'naam' => $adres->naam,
            'datum' => $datum,
            'email' => $email,
            'tijd' => $tijd,
            'logo' => $logo
        ];


        Mail::send($brief, $data, function ($message) use ($data) {
            $message->to($data['email'], '')->subject('Afspraak');
            $message->from('maiko@dqservicegroep.nl', 'DQGlasservice');
        });
        return 'test';
    }

    public function maakBrief()
    {
        return view('adres/brief');
    }

    public function checkTijd($tijd)
    {
        if ($tijd == 'Ochtend') {
            $tijd = 'tussen 9.00 en 13.00 uur';
        } elseif ($tijd == 'Tussen') {
            $tijd = 'tussen 10.30 en 14.30 uur';
        } else {
            $tijd = 'tussen 12.00 en 16.30 uur';
        }
        return $tijd;
    }
    public function test()
    {
        return view('pdf/zetten');
    }

    public function checkAfspraak($afspraak)
    {
        if ($afspraak == 'meten') {
            $brief = 'emails.brief.meten';
        } elseif ($afspraak == 'zetten') {
            $brief = 'emails.brief.zetten';
        }
        return $brief;
    }

    public function assignAdresses($aAdresses)
    {
        $aAdressesData = array();

        if ($aAdresses) {
            foreach ($aAdresses as $oAddres) {
                $aAdressesData[] = array
                (
                    'id' => $oAddres->id,
                    'straat' => $oAddres->straat,
                    'huisnummer' => $oAddres->huisnummer,
                    'toevoeging' => $oAddres->toevoeging,
                    'postcode' => $oAddres->postcode,
                    'stad' => $oAddres->stad,
                    'naam' => $oAddres->naam
                );
            }
        }
        return $aAdressesData;
    }

}
