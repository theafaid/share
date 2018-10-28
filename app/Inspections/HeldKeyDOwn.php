<?php
namespace App\Inspections;


class HeldKeyDOwn
{
    public function detect($body){
        if(preg_match('/(.)\\1{4,}/', $body, $matches)){
            throw new \Exception("You Held a Key Down !!");
        }
    }
}