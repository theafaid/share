<?php
namespace App;


use App\Events\NewCommentAdded;

trait Commentable
{
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments(){
        return $this->hasMany(Comment::class);
    }

    /**
     * @param $body
     * @param null $userId
     * @return Model
     */
    public function addComment($body, $userId = null){

        $comment = $this->comments()->create([
            'body' => $body,
            'user_id' => $userId ?: auth()->id()
        ]);

        event(new NewCommentAdded($comment));

        return $comment;
    }
}