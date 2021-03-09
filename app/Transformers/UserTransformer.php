<?php

namespace App\Transformers;

use App\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        //
    ];

    /**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'posts'
    ];

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'name' => $user->name,
            'email' => $user->email,
            'registered' => $user->created_at->diffForHumans(),
        ];
    }

    public function includePosts(User $user)
    {
        $posts = $user->posts()->lastestFirst()->get();

        return $this->collection($posts, new PostTransformer);
        # code...
    }
}
