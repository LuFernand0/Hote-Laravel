<?php

namespace App\Http\Controllers;

use App\Models\quarto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class QuartoController extends Controller
{

    public function showFormularioCadastroQuarto(Request $request){
        return view("formularioCadastroQuarto");
    }

    public function cadQuarto(Request $request){
        $dadosValidos = $request->validate([
            'numeroQuarto' => 'integer|required',
            'tipoQuarto' => 'string|required',
            'valorDiario' => 'numeric|required'
        ]);

        quarto::create($dadosValidos);
        return Redirect::to('/');
    }

    public function buscarQuarto(Request $request){
        $dadosQuarto = quarto::query();
        $dadosQuarto->when($request->numeroQuarto, function($query, $valor){
            $query->where('numeroQuarto','like','%'.$valor.'%');
        });
        $dadosQuarto = $dadosQuarto->get();

        return view('gerenciarQuarto', ['registrosQuarto' => $dadosQuarto]);
    }

    public function destroy(quarto $id){
        $id->delete();
        return Redirect::to('/');
    }
}
