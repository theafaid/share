<?php
namespace App;

trait RecordActivity{

    protected static function bootRecordActivity(){

        if(auth()->guest()) return;

        foreach(static::events() as $event){
            static::$event(function($model) use ($event){
                $model->recordActivity($event);
            });
        }

        static::deleting(function($model){
            $model->activities()->delete();
        });
    }

    /**
     * @return mixed
     */
    public function activities(){
        return $this->morphMany('App\Activity', 'subject');
    }


    protected function recordActivity($event){
        $this->activities()->create([
            'user_id' => auth()->id(),
            'type'     => $this->getActivityType($event)
        ]);
    }

    /**
     * @param $event
     * @return string
     * @throws \ReflectionException
     */
    protected function getActivityType($event){
        $className = strtolower((new \ReflectionClass($this))->getShortName());
        return "{$event}_{$className}";
    }

    /**
     * @return array
     */
    protected static function events(){
        return ['created'];
    }
}