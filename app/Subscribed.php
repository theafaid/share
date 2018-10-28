<?php

namespace App;


trait Subscribed
{
    /**
     * @return mixed
     */
    public function subscriptions(){
        return $this->morphMany('App\Subscription', 'subscribed');
    }

    /**
     * Check if user has subscribed this thread
     * @return mixed
     */
    public function getIsSubscribedAttribute(){
        return $this->subscriptions()->where('user_id', auth()->id())->exists();
    }

    /**
     * User must be unsubscribed before subscribe
     * We check that in SubscriptionsController
     * @param null $userId
     */
    public function subscribeToThread($userId = null){
        $userId = $userId ?: auth()->id();
        $this->subscriptions()->create([
            'user_id' => $userId,
        ]);
    }

    /**
     * User must be subscribed before unsubscribe
     * We check that in SubscriptionsController
     * @param null $userId
     */
    public function unsubscribeFromThread($userId = null){
        $userId = $userId ?: auth()->id();
        $this->subscriptions()->where('user_id', $userId)->get()->each->delete();
    }
}