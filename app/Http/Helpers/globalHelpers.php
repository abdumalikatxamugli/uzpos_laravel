<?php

use App\Models\Client;
use Illuminate\Support\Facades\Request;

if(!function_exists('isMenuOpen')){
    function isMenuOpen($menuName){
        $routeName = Request::route()->getName();
        if( is_array($menuName) ){
            foreach( $menuName as $name ){
                if( $name == $routeName ){
                    return true;
                }
            }
            return false;
        }
        if($menuName == $routeName ){
            return true;
        }
        return false;
    }
}
if(!function_exists('getRegion')){
    function getRegion($region_id){
        return Client::regionDict[$region_id];
    }
}

if(!function_exists('cleanPhoneNumber')){
    function cleanPhoneNumber($phone){
        return str_replace(['(',')','-',' '], '', $phone);
    }
}
if(!function_exists('route_with_query_params')){
    function route_with_query_params($routeName, $params=[]){
        return route($routeName, $params)."?".http_build_query(request()->query());
    }
}

if(!function_exists('get_filter_value')){
    function get_filter_value($filterName){
        if( request()->query('filters') ){
            return isset(request()->query('filters')[$filterName]) ? request()->query('filters')[$filterName]:'';
        }
        return '';
    }    
}
if(!function_exists('isActive')){
    function isActive($routeName, $params = []){
        $currentRouteName = Request::route()->getName();
        $currentRouteParams = Request::route()->parameters();
        return $routeName === $currentRouteName && $currentRouteParams === $params;
    }    
}
if(!function_exists('toYearMonth')){
    function toYearMonth($date):int{
        return intval(date('Y', strtotime($date))) * 100 + intval(date('m', strtotime($date))); 
    }
}


