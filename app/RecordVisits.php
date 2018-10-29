<?php
namespace App;


trait RecordVisits
{
    /**
     * Record a visit if user visit a thread
     */
    public function recordVisit(){
        (new Visits($this))->record($this);
    }

    /**
     * Get the thread visits count
     */
    public function visits(){
        return (new Visits($this))->count($this);
    }
}