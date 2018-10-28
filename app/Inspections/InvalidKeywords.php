<?php
namespace App\Inspections;

class InvalidKeywords
{
    public function detect($body){
        $invalidKeywords = [
            'dog',
            'donkey',
            'stupid',
            'asshole'
        ];

        foreach($invalidKeywords as $keyword){
            if(stripos($body, $keyword) !== false){
                throw new \Exception("Your Reply Contains Spam !!");
            }
        }
    }
}