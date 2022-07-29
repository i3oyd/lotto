<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Models\LatestResults;
use App\Http\Controllers\Controller;
use App\Http\Controllers\LottoResultsController as LottoResults;

class LottoResultsController extends Controller
{
    public function lottoResults(Request $request){
        $lottoResults = new LottoResults;
        switch($request->game){
            case 'six-forty-two':
                $page = 'regular';
                $game = 'Lotto 6/42';
                break;
            case 'six-forty-five':
                $page = 'mega';
                $game = 'Megalotto 6/45';
                break;
            case 'six-forty-nine':
                $page = 'super';
                $game = 'Superlotto 6/49';
                break;
        }
        $result = LatestResults::where('game',$game)->orderBy('draw_time','desc')->first();
        $results = LatestResults::all();
        return [
            'result' => $result,
            'results' => $results,
            'stats' => json_encode($lottoResults->orderStat($game,'number','asc'))
        ];
    }
}