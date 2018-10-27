<?php
if(!function_exists("create")){
    function create($class, $attributes = [], $count = null){
        return factory($class, $count)->create($attributes);
    }
}

if(!function_exists('make')){
    function make($class, $attributes = [], $count = null){
        return factory($class, $count)->make($attributes);
    }
}