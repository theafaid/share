<?php
namespace App\Inspections;

class Spam
{
    protected $inspections = [
        InvalidKeywords::class,
        HeldKeyDOwn::class
    ];

    /**
     * @param $body
     * @return bool
     */
    public function detect($body){
        foreach($this->inspections as $inspection){
            (new $inspection)->detect($body);
        }
        return false;
    }



}