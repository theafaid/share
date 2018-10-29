<?php
namespace App\Inspections;


class HeldKeyDOwn
{

    /**
     * Detect the body if any character has repeated (4) times or more
     * @param $body
     * @throws \Exception
     */
    public function detect($body){
        if(preg_match('/(.)\\1{4,}/', $body, $matches)){
            throw new \Exception("You Held a Key Down !!");
        }
    }
}