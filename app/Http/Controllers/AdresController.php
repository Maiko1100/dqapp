<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
use Redirect;
use Illuminate\Support\Facades\Storage;
use Session;
use FPDF;
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
        $tijd = $request->input('tijd');
        $soort = $request->input('soort');


        if ($tijd == 'Ochtend') {
            $tijd = 'tussen 9.00 en 13.00 uur';
        } elseif ($tijd == 'Tussen') {
            $tijd = 'tussen 10.30 en 14.30 uur';
        } else {
            $tijd = 'tussen 12.00 en 16.30 uur';
        }

        setlocale(LC_ALL, array('Dutch_Netherlands', 'Dutch', 'nl_NL', 'nl', 'nl_NL.ISO8859-1', 'nld_NLD'));
        $date = strftime("%d %B %Y");

        $pdf = new FPDF();

        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Times', '', 16);
        $this->Header($pdf);
        if ($soort == 'createBrief') {
            $naam = $request->input('naam');
            $straat = $request->input('straat');
            $huisnummer = $request->input('huisnummer');
            $postcode = $request->input('postcode');
            $woonplaats = $request->input('woonplaats');
            $toevoeging = $request->input('toevoeging');
            $filename = str_replace(" ", "", $postcode) . $huisnummer . str_replace(" ", "", $toevoeging) . '.pdf';

            $this->PrintNaw($pdf, $naam, $straat, $huisnummer, $postcode, $woonplaats, $toevoeging);

        } else {
            $id = $request->input('id');
            $adres = DB::table('adres')->where('id', $id)->first();
            $this->PrintNaw($pdf, $adres->naam, $adres->straat, $adres->huisnummer, $adres->postcode, $adres->stad, $adres->toevoeging);
            $filename = str_replace(" ", "", $adres->postcode) . $adres->huisnummer . str_replace(" ", "", $adres->toevoeging) . '.pdf';

        }
        $this->PrintDate($pdf, $date);

        if ($afspraak == 'Inmeten') {
            $this->PrintBriefMeten($pdf, $tijd, $datum);
        } elseif ($afspraak == 'Zetten') {
            $this->PrintBriefZetten($pdf, $tijd, $datum);
        }


        $pdf->Output('F', 'download/' . $filename);
        Storage::delete('download/' . $filename);

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

    public function upload()
    {
        return view('adres/upload');
    }

    public function checkTijd($tijd)
    {
        if ($tijd == 'Ochtend') {
            $tijd = 'tussen 9.00 en 13.00 uur';
        } else {
            $tijd = 'tussen 12.00 en 16.30 uur';
        }
        return $tijd;
    }

    public function checkAfspraak($afspraak)
    {
        if ($afspraak == 'Inmeten') {
            $brief = 'emails.brief.meten';
        } elseif ($afspraak == 'Zetten') {
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

    function Header($pdf)
    {
        $pdf->Image('images/logo.jpg', 10, 10, 80);
        $pdf->SetFont('Times', '', 14);
    }

    public function PrintNaw($pdf, $naam, $straat, $huisnummer, $postcode, $woonplaats, $toevoeging)
    {
        $pdf->SetFont('Times', '', 14);
        $pdf->SetXY(130, 48);
        $pdf->Cell(0, 0, $naam);
        $pdf->SetXY(130, 60);
        $pdf->Cell(0, 0, $straat . ' ' . $huisnummer . ' ' . $toevoeging);
        $pdf->SetXY(130, 72);
        $pdf->Cell(0, 0, $postcode . ' ' . $woonplaats);
    }

    function PrintDate($pdf, $date)
    {
        $pdf->SetFont('Times', '', 14);
        $pdf->SetXY(120, 120);
        $pdf->Cell(0, 0, "Amsterdam, " . ' ' . $date);
    }

    function PrintBriefZetten($pdf, $tijd, $datum)
    {

        $pdf->SetXY(20, 130);
        $pdf->Cell(0, 0, "Geachte bewoner(s),");
        $pdf->SetXY(20, 140);
        $pdf->Cell(0, 0, "Hierbij willen wij u op de hoogte brengen dat de ruit zal worden geplaatst op:");
        $pdf->SetXY(20, 150);
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 0, $datum . ' ' . $tijd);
        $pdf->SetFont('Times', '', 14);
        $pdf->SetXY(20, 160);
        $pdf->Cell(0, 0, "Wilt u zo vriendelijk zijn thuis te blijven en indien van toepassing de");
        $pdf->SetXY(20, 165);
        $pdf->Cell(0, 0, "vitrage, gordijnen, luxaflex, planten, tafels, banken e.d. te verwijderen rondom ");
        $pdf->SetXY(20, 170);
        $pdf->Cell(0, 0, "de ramen zodat de glaszetters de ruimte hebben om te kunnen draaien en lopen ");
        $pdf->SetXY(20, 175);
        $pdf->Cell(0, 0, "zonder dat zij iets beschadigen.");
        $pdf->SetXY(20, 185);
        $pdf->Cell(0, 0, "Indien de monteurs genoodzaakt zijn spullen te verzetten om zo hun werk te");
        $pdf->SetXY(20, 190);
        $pdf->Cell(0, 0, "kunnen uitvoeren, dan zijn wij niet aansprakelijk voor eventuele schade die");
        $pdf->SetXY(20, 195);
        $pdf->Cell(0, 0, "daarbij ontstaat.");
        $pdf->SetXY(20, 205);
        $pdf->Cell(0, 0, "Mocht u niet thuis zijn en/of blijven, dan vragen wij u vriendelijk ons daarvan");
        $pdf->SetXY(20, 210);
        $pdf->Cell(0, 0, "op de hoogte te brengen. ");
        $pdf->SetXY(20, 220);
        $pdf->Cell(0, 0, "Bij eventuele vragen kunt u tijdens kantooruren bellen met onze planning, ");
        $pdf->SetXY(20, 225);
        $pdf->Cell(0, 0, "telefoonnummer: 020-6681216");
        $pdf->SetXY(20, 235);
        $pdf->Cell(0, 0, "Bij voorbaat dank voor uw medewerking.");
        $pdf->SetXY(20, 245);
        $pdf->Cell(0, 0, "Met vriendelijke groet,");
        $pdf->SetXY(20, 255);
        $pdf->Cell(0, 0, "De planning");
    }

    function PrintBriefMeten($pdf, $tijd, $datum)
    {

        $pdf->SetXY(20, 130);
        $pdf->Cell(0, 0, "Geachte bewoner(s),");
        $pdf->SetXY(20, 140);
        $pdf->Cell(0, 0, "Via deze brief laten weten dat wij het glas en/of roosters komen opmeten op:");
        $pdf->SetXY(20, 150);
        $pdf->SetFont('Times', 'B', 14);
        $pdf->Cell(0, 0, $datum . ' ' . $tijd);
        $pdf->SetFont('Times', '', 14);
        $pdf->SetXY(20, 160);
        $pdf->Cell(0, 0, "Mocht het zo zijn dat u niet thuis kunt zijn en/of blijven, dan vragen wij u");
        $pdf->SetXY(20, 165);
        $pdf->Cell(0, 0, "vriendelijk ons daarvan op de hoogte te brengen.");
        $pdf->SetXY(20, 170);
        $pdf->Cell(0, 0, "Als blijkt dat er niemand aanwezig is op de bovengenoemde dag/datum/tijdstip,");
        $pdf->SetXY(20, 175);
        $pdf->Cell(0, 0, "kunnen wij kosten in rekening brengen.");
        $pdf->SetXY(20, 185);
        $pdf->Cell(0, 0, "Bij eventuele vragen kunt u tijdens kantooruren bellen met onze planning op het");
        $pdf->SetXY(20, 190);
        $pdf->Cell(0, 0, "telefoonnummer: 020-6681216");
        $pdf->SetXY(20, 200);
        $pdf->Cell(0, 0, "Bij voorbaat dank voor uw medewerking.");
        $pdf->SetXY(20, 215);
        $pdf->Cell(0, 0, "Met vriendelijke groet,");
        $pdf->SetXY(20, 230);
        $pdf->Cell(0, 0, "De planning");
    }

}
