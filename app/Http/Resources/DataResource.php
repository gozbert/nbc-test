<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'api' => $this->api,
            'description' => $this->description,
            'auth' => $this->auth,
            'https' => $this->https,
            'cors' => $this->cors,
            'link' => $this->link,
            'category' => $this->category,
        ];
    }
}
