<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function make_parentheses()
    {
        
        $par = $this->make_first_set(4);
        $n = strlen($par)/2;
        
        $new_set = $par;
        $sets = [$par];
        for($k=1;$k<$n;$k+=1){
            $b = $new_set[$k];
            for($i = $n;$i < strlen($new_set)-1;$i++){ 
                $new_set[$k] = $new_set[$i];
                $new_set[$i] = $b;
                $sets[] = $new_set;
                $new_set = $par;//reset first set
            }
        }

        return $sets;
    }

    public function make_first_set($n){
        $pars = '';
            for($i=0;$i<$n;$i+=1){
                $pars.="(";
            }
            for($i=0;$i<$n;$i+=1){
                $pars.=")";
            }
            return $pars;
    }
}
