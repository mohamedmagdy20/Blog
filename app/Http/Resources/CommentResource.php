<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'comment_id'=>$this->id,
            'post_id'=>$this->post_id,
            'user_id'=>$this->user_id,
            'comment'=>$this->comment,
            'replies'=>ReplyResource::collection($this->replies),
        ];
    }
}
