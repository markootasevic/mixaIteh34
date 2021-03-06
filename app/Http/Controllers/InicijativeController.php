<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\InicijativaJunk;
use App\Inicijativa;
use App\Http\Requests;
use Mail;
use View;
use App\User;
use Auth;
use Illuminate\Support\Facades\Storage;
use File;
class InicijativeController extends Controller
{

    public function __construct() {
      $this->middleware(['auth'], ['only' => ['getInicijative']]);
    }
    public function getPropisView() {
      return view('inicijative.inicijativePropisi');
    }

    public function getProceduraView() {
     return view('inicijative.inicijativeProcedure'); 
    }

	public function postInicijativa(Request $request) {
		  // $this->validate($request, [
    //     'imePrezime' => 'required|max:50|alpha',
    //     'adresa' => 'required',
    //     'email' => 'required',
    //     'adresa' => 'required',
    //     'adresa' => 'required',
    //     'adresa' => 'required',
    //     'adresa' => 'required',
    //     'adresa' => 'required',
    //     'adresa' => 'required',
    // ]);

		  // $inicijativaJunk = new InicijativaJunk;
		  // $inicijativaJunk->create($request-all());
      global $request;
		  $inicijativaJunk = InicijativaJunk::create($request->all());


      if ($request->hasFile('prilog')) {
        $file = $request->file('prilog');
        
        $extension = $file->getClientOriginalExtension();
        Storage::disk('local')->put($file->getClientOriginalName(),  File::get($file));
        $updateInicijativeJunk = InicijativaJunk::find($inicijativaJunk->id);

      $updateInicijativeJunk->prilog = $file->getClientOriginalName();
      //test faza
      $updateInicijativeJunk->mime = $file->getClientMimeType();

      $updateInicijativeJunk->save();
      }
     

// za slanje e-mail-a
       $data = array(
        'tip' => $request->input('tip'),
    );

    // Mail::send('mail', $data , function ($message) {
    //     global $request;
    //     $message->from('motasevic994@gmail.com');
    //       $subject='Unesena je nova inicijativa';
    //       if($request->input('tip') == 'propis')
    //         $subject = 'Unesena je nova inicijativa za propis';
    //       if ($request->input('tip') == 'procedura') {
    //         $subject = 'Unesena je nova inicijativa za proceduru';
    //       }

    //     $message->to('zeljkonikic1994@gmail.com')->subject($subject);

    // });
          // $inicijativaJunk->tip = $request->input('tip');

		  return redirect()->back()->with('info','Uspesno ste poslali inicativu');
	}
    // mora da se dorade uslovi ako se filtrira za jos nesto osim za tip inicijative
    public function getInicijative(Request $request) {
      global $request;
      if(Auth::user()->admin == 1) {
        if(empty($request->all())) {
            $inicijative =  InicijativaJunk::orderBy('created_at', 'desc')->get();
        }
        else {
          global $request;
            $array = $request->all();
            $a = $array['tip'];
            $inicijative= InicijativaJunk::where('tip','=', $a)->orderBy('created_at', 'desc')->get();
        }
      } else if(Auth::user()->admin == 2) {
        $inicijative = Auth::user()->inicijativeJunk()->get();
        
      }
      $users = User::where('admin','=', 2)->get();
      $inicijativePotvrdjene = Inicijativa::orderBy('created_at', 'desc')->get();
          
      return  view('adminPrikaz.administrativniPrikazInicijativa', compact('inicijative', 'users', 'inicijativePotvrdjene'));
      
    }

    public function dodeliInicijative(Request $request) {
      
      $zaposleniId = $request->input('zaposleni');
      $zaposleni = User::find($zaposleniId);
      $niz = $request->input('check_list');
      foreach ($niz as $inicijativaID) {
        $i = InicijativaJunk::find($inicijativaID);

        $i->user()->associate($zaposleni);
        $i->save();
      }
      return redirect()->back();
    }


    
    // mora da se dorade uslovi ako se filtrira za jos nesto osim za tip inicijative
    public function getPotvrdjeneInicijative(Request $request) {
      if(empty($request->all())) {
        $inicijative =  Inicijativa::all();
    }
    else {
        $array = $request->all();
        $a = $array['tip'];
        $inicijative= Inicijativa::where('tip','=', $a)->get();
    }
      
      return $inicijative;
    }

    public function transferInicijativaPrihvacena(InicijativaJunk $id) {
       
      $array = $id->toArray();
      $array = array_add($array, 'prihvacena', 'da');
      
      Inicijativa::create($array);

      $id->delete();
      
      return redirect()->back();
    }

    public function transferInicijativaOdbijena(InicijativaJunk $id) {
      $array = $id->toArray();
      $array = array_add($array, 'prihvacena', 'ne');
      Inicijativa::create($array);

      $id->delete();
      
      return redirect()->back();
    }


    public function deleteInicijativa(InicijativaJunk $id) {
      $id->delete();
      return redirect()->back();
    }

    public function getJednuInicijativu(InicijativaJunk $inicijativaId) {
      //return  view('adminPrikaz.administrativniPrikazInicijativa', compact('inicijativaId'));
      // dd('POTREBNO SREDITI METODU TAKO DA SALJE OBJEKAT INICIJATIVA U POP UP PROZOR', $inicijativaId);
      $inicijativa = $inicijativaId;
      return  view('adminPrikaz.jednaInicijativa', compact('inicijativa'));

    }

    public function getJavnoDostupne ($imeFajla) {

        $potvrdjeneInicijative = Inicijativa::all();
        return  view('javniPrikaz', compact('potvrdjeneInicijative'));
    }

    public function getFileInicijativaJunk (InicijativaJunk $id) {
      $imeFajla = $id->prilog;
      $ekstenzija = $id->mime;
      $file = storage_path() ."\\app\\". $imeFajla;

       $headers = array(
              'Content-Type: '.$ekstenzija,
            );
      return response()->download($file, $imeFajla, $headers);
    }

public function getFileInicijativa (Inicijativa $id) {
      $imeFajla = $id->prilog;
      $ekstenzija = $id->mime;
      $file = storage_path() ."\\app\\". $imeFajla;

       $headers = array(
              'Content-Type: '.$ekstenzija,
            );
      return response()->download($file, $imeFajla, $headers);
    }

    public function getCount(){
      $countJunk = InicijativaJunk::all()->count();
      $count = Inicijativa::all()->count();
      $array = array($countJunk, $count);
      return $array;

     }
    
    
}

