<?php
use Illuminate\Support\Facades\Http;

if (! function_exists('activePage')) {
    function activePage($route_name) {
        return request()->routeIs($route_name) ? 'active' : '';
    }
}
if (! function_exists('collapseMenu')) {
    function collapseMenu($route_name) {
        return request()->routeIs($route_name) ? 'active show' : '';
    }
}

if (! function_exists('storeFile')) {
    function storeFile($file,$title) {
        $fileName = time().'.'.$file->extension();
        $file->move(public_path("file/$title"), $fileName);
        return $fileName;
    }
}

if (! function_exists('dateFormat')) {
    function dateFormat($date) {
        return date('d-m-Y',strtotime($date));
    }
}

if (! function_exists('timeFormat')) {
    function timeFormat($time) {
        return date('H:i A',strtotime($time));
    }
}

