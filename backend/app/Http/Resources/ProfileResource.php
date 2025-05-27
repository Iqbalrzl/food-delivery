<?php

// app/Http/Resources/ProfileResource.php
namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'location' => $this->location,
            'profile_image_url' => $this->profile_image_url,
        ];
    }
}
