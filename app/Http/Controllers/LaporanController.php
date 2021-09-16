<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function index(){

        //Perguruan Tinggi
        $univ = \App\ymgRegistration::where('id_competition',\App\ymgCompetition::where('isOpen',1)->pluck('id')->first())->orderBy('pt')->groupBy(['pt'])->get(['pt']);
        $pt = [];
        $datas1 = [];
        $datas2 = [];
        $datas3 = [];

        foreach($univ as $u){
            $pt[] = $u->pt;

            //Belum Verifikasi
            if(\App\ymgRegistration::where('id_competition',\App\ymgCompetition::where('isOpen',1)->pluck('id')->first())->where('status',1)->where('pt',$u->pt)->first()){
                $datas1[] = \App\ymgRegistration::where('id_competition',\App\ymgCompetition::where('isOpen',1)->pluck('id')->first())->where('status',1)->where('pt',$u->pt)->count();
            }
            else{
                $datas1[] = 0;
            }

             //Sudah Verifikasi
             if(\App\ymgRegistration::where('id_competition',\App\ymgCompetition::where('isOpen',1)->pluck('id')->first())->where('status',2)->where('pt',$u->pt)->first()){
                $datas2[] = \App\ymgRegistration::where('id_competition',\App\ymgCompetition::where('isOpen',1)->pluck('id')->first())->where('status',2)->where('pt',$u->pt)->count();
            }
            else{
                $datas2[] = 0;
            }

             //Ditolak
             if(\App\ymgRegistration::where('id_competition',\App\ymgCompetition::where('isOpen',1)->pluck('id')->first())->where('status',0)->where('pt',$u->pt)->first()){
                $datas3[] = \App\ymgRegistration::where('id_competition',\App\ymgCompetition::where('isOpen',1)->pluck('id')->first())->where('status',0)->where('pt',$u->pt)->count();
            }
            else{
                $datas3[] = 0;
            }
     
        }

        

        //dd(json_encode($datas3));
        return view('admin.dashboard.dashboard',['pt' => $pt,'datas1' => $datas1, 'datas2' => $datas2, 'datas3' => $datas3]);
    }
}
