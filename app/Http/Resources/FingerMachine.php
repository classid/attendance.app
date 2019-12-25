<?php

namespace CID\Finger\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FingerMachine extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return parent::toArray($request);
    }
}
