<?php

use Illuminate\Support\Facades\File;
if(! function_exists('siegy_path')) {
    /**
     * Retorna el path utilizado en co figuracion .htacces
     * @param  string  $path
     * @return string
     */
    function siegy_path($path = '') {
        $app    = app('path');
        $string = explode('/', $app, -2);
        $url    = implode("/", $string)."/public";
        $final  = $url.($path ? DIRECTORY_SEPARATOR.ltrim($path, DIRECTORY_SEPARATOR) : $path);

        try{
            if(!File::isDirectory($path)) {
                if(!File::makeDirectory($url, $mode = 0777, true, true))
                    $response = false;
            }
        }
        catch(Exception $ex){
            throw $ex;
        }

        return $final;
    }
}