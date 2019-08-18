<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

if(!function_exists('formatNum')){
    function formatNum($num) {
        if($num > 1000){
            $abbr = round($num/1000,2).'k';
        }
        return "<span data-toggle='tooltip' title='&#8358; ".number_format($num)."'>&#8358; ".(isset($abbr) ? $abbr : $num)."</span>";
    }
}

if(!function_exists('isNewUser')){
    function isNewUser() {
        return Session::has('new_user') ? true : false;
    }
}
if(!function_exists('primaryColor')){
    function primaryColor(){
        return config('custom.primary_color');
    }
}

if(!function_exists('secondaryColor')){
    function secondaryColor(){
        return config('custom.secondary_color');
    }
}