<?php

namespace App\Http\Requests;

use App\Comment;
use App\Exceptions\ThrottleException;
use App\Rules\FreeSpam;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Gate;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class CreateCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Gate::allows('create', new Comment())){
            return true;
        }

        return false;
    }


    /**
     * @throws ThrottleException
     */
    protected function failedAuthorization()
    {
        throw new ThrottleException("You are commenting too fast. Wait a minute !");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'body' => ['required', 'string', 'max:1000', new FreeSpam()]
        ];
    }

    public function persist($thread){
        return $thread->locked ? response([], 422) :  $thread->addComment(request('body'))->load('user');
    }
}
