<?php

namespace App\Http\Controllers;

use simplehtmldom\HtmlWeb;
use App\Models\LatestResults;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class LottoResultsController extends Controller
{
    public function most_common()
    {
        //$now = array(time(),floor(time()/86400)*86400,date("n/j/Y H:i",floor(time()/86400)*86400));
        //return $now;
        $q_results = DB::table('lotto_6_42')->get();
        //$q_results = DB::connection('mysql2')->table('lotto_6_42')->pluck('combination');
        //return $q_results;
        $results = [];
        foreach($q_results as $q_result){
            $combination = explode('-',$q_result->combination);
            sort($combination);
            $draw_stamp = strtotime($q_result->date);
            $prize = str_replace(',','',$q_result->prize);
            //return $prize;
            $results[] = array(
                'combination' => json_encode($combination),
                'draw_stamp' => $draw_stamp,
                'draw_date' => $q_result->date,
                'prize' => $prize,
                'winners' => $q_result->winners
            );
        }
        
        return $results;
        
        DB::table('lotto_res_642')->insert($results);
        // $sort = call_user_func_array('array_merge',$results);
        // $sorts = array_count_values($sort);
        //natsort($sorts);
        //return $sorts;
    }


    public function stats()
    {
        $q_results = DB::table('lotto_res_649')->pluck('combination')->toArray();
        arsort($q_results);
        $r_results = [];
        foreach($q_results as $q_result){
            $r_results[] = json_decode($q_result);
        }
        $results = call_user_func_array('array_merge',$r_results);
        
        $stats = array_count_values($results);
        arsort($stats,SORT_NUMERIC);

        $data = [];
        $game = 'Superlotto 6/49';
        foreach($stats as $key => $value){
            $data[] = array(
                'game' => $game,
                'number' =>(int) $key,
                'num_str' =>$key,
                'count' => $value
            );
        }

        // DB::table('stat')->where('game',$game)->delete();
        // DB::table('stat')->insert($data);

        // echo '<pre>',print_r($stats,1);
        // exit();
        return $data;

    }

    public function orderStat($game,$orderBy,$order){
        $sorted = DB::table('stat')->where('game',$game)->orderBy($orderBy,$order)->get()->toArray();
        $counts = DB::table('stat')->where('game',$game)->orderBy('count','desc')->pluck('num_str')->toArray();

        switch($game){
            case 'Lotto 6/42':
                $table = 'lotto_res_642';
                break;
            case 'Megalotto 6/45':
                $table = 'lotto_res_645';
                break;
            case 'Superlotto 6/49':
                $table = 'lotto_res_649';
                break;
        }
        $res_count = DB::table($table)->pluck('combination')->toArray();
        $results_count = array_count_values($res_count);

        $len = count($counts);
        $common = array_slice($counts,0,6);
        $least = array_slice($counts,$len-6,6);

        return [$sorted,$common,$least,$results_count];
        
    }

    public function importData(){
        
        $url = 'https://www.pcso.gov.ph/SearchLottoResult.aspx';
        $doc = new HtmlWeb();
        $html =  $doc->load($url);
        $section = $html->find('#cphContainer_cpContent_GridView1',0);
        $data = [];
        $i = 1;
        foreach($section->find('tr') as $article) {
            //$column = $article->find('th',2)->plaintext;
            if($i > 1) {
                $combination = explode('-',$article->find('td',1)->plaintext);
                $jackpot = str_replace(',','',$article->find('td',3)->plaintext);
                $winners = str_replace(',','',$article->find('td',4)->plaintext);
                $time = strtotime($article->find('td',2)->plaintext);
                sort($combination);
                $data[] = array(
                    'game' => $article->find('td',0)->plaintext,
                    'combination' => json_encode($combination),
                    'draw_date' => $article->find('td',2)->plaintext,
                    'jackpot'=> (float)$jackpot,
                    'draw_time' => (int)$time,
                    'winners' => (int)$winners
                );
                // echo '<pre>', print_r($column,true);
                // exit();
            }
            $i++;
        }
        return $data;

        //LatestResults::truncate();
        //LatestResults::insert($data);
    }

    public function importCSV(){
        
        $results  = [];
        if (($handle = fopen("data/lotto_6_49.csv", "r")) !== FALSE) {
            $i = 1;
            while (($data = fgetcsv($handle, 100, ",")) !== FALSE) {
                if($i <> 1){
                    
                    $combination = explode('-',$data[1]);
                    sort($combination);
                    $draw_date = $data[2];
                    $prize = (float) str_replace(',','',$data[3]);
                    $winners = (int)$data[4];
                    $draw_time = strtotime($draw_date);

                    $results[] = array(
                        'combination' => json_encode($combination),
                        'draw_time' => $draw_time,
                        'draw_date' => $draw_date,
                        'prize' => $prize,
                        'winners' => $winners
                    );
                }
                $i++;
            }
            fclose($handle);
            //return $results;
            
           // DB::table('lotto_res_649')->insert($results);
        }
        return 'empty';
    }
    public function latestResult(Request $request){
        //return $request;
        switch($request->game){
            case '42':
                $game = 'Lotto 6/42';
                break;
            case '45':
                $game = 'Megalotto 6/45';
                break;
            case '49':
                $game = 'Superlotto 6/49';
                break;
        }

        return LatestResults::where('game',$game)->orderBy('draw_time','desc')->first();
        
    }
    
    public function latestResults(Request $request){

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
        return view('pages.'.$page)->with('result',$result)->with('results',$results)->with('stats',json_encode($this->orderStat($game,'number','asc')));
    }
    public function allLatestResults(){
        $results = LatestResults::all();
        return view('results')->with('results',$results)->with('stats',json_encode($this->orderStat('Lotto 6/42','number','asc')));
    }
    
    public function searchResults(Request $request){
        //return json_decode($request);
        $combination = json_encode($request->input('combination'));
        switch($request->game){
            case '42':
                $game = 'lotto_res_642';
                break;
            case '45':
                $game = 'lotto_res_645';
                break;
            case '49':
                $game = 'lotto_res_649';
                break;
        }

        return DB::table($game)->where('combination',$combination)->get();
        

    }
}
