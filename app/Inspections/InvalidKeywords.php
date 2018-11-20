<?php
namespace App\Inspections;

class InvalidKeywords
{
    /**
     * Detect invalid keywords
     * @param $body
     * @throws \Exception
     */
    public function detect($body){
        $invalidKeywords = [
            'shit',
            'idiotic',
            'idiot'
        ];

        foreach($invalidKeywords as $keyword){
            if(stripos($body, $keyword) !== false){
                throw new \Exception("Your Reply Contains Spam !!");
            }
        }
    }
}