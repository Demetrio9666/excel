<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Hash;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ArchiviController extends Controller
{
    public function index(){
        return view('welcome');
    }

    public function import(Request $request){
       
       // Storage::disk('local')->put($nombre,  \File::get($file));

       //carga
        $respondents = Excel::load($request->file('file'), function ($reader) {
            
            $reader->toArray();
        });
        $respondents = $respondents->parsed;
        $count = null;

        //guardar la ruta
        $file = $request->file('file');
        $nombre= Str::random(5).$file->getClientOriginalName();
       //\public\storage

       $file->move(public_path().'/excel/'.$nombre);
       

      

       //\storage\app\public\Excel
        //$ruta = storage_path().'\app\public\Excel/'.$nombre;

        //$store=Storage::url('\app\public\Excel');
       
       

        //$request->file('file')->store('\app\public\Excel');


        

        return "archivo guardado";



        //return $ruta;


        //importas
        foreach ($respondents as $respondent) {
            $count++;
            $new = User::create([ 'name' => $respondent->name,
                                  'email' => $respondent->email,
                                  'password' => Hash::make($respondent->password),]);
                                        
        }    


       

        return "Usuarios registrados: ".$count;
       
    }
}
