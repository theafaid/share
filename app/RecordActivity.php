<?php
namespace App;

trait RecordActivity{

    protected static function bootRecordActivity(){

        foreach(static::events() as $event){
            static::$event(function($model) use ($event){
                $model->recordActivity($event);
            });
        }
    }

    public function activities(){
        return $this->morphMany('App\Activity', 'subject');
    }

    protected function recordActivity($event){
        $this->activities()->create([
            'user_id' => auth()->id(),
            'type'     => $this->getActivityType($event)
        ]);
    }

    protected function getActivityType($event){
        $className = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$className}";
    }

    protected static function events(){
        return ['created'];
    }
}