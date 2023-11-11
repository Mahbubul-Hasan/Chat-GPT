<?php

namespace App\Http\Resources\Chat;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatResource extends JsonResource {
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request) {
        return [
            'id'         => @$this->id,
            'chat'       => @$this->chat,
            'response'   => @$this->response,
            'createdAt'  => date('d M, Y', strtotime(@$this->created_at)),
            'createdAgo' => @$this->created_at->diffForHumans() ?? null,
        ];
    }
}
