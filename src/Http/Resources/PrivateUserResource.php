<?php

namespace OutamaOthmane\AuthApi\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PrivateUserResource extends JsonResource
{
	public function toArray($request)
    {
        return [
            'id'                => $this->id,
            'name'              => $this->name,
            'email'             => $this->email,
            'email_verified'    => (bool)$this->email_verified_at,
            'created_at'    	=> optional($this->created_at)->diffForHumans(),
        ];
    }
}