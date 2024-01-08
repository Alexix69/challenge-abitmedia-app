<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Software extends JsonResource implements ResourceInterface
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $portability = $this->operatingSystems->first();
        $details = $portability->details;
        return [
            'id' => $this->id,
            'sku' => $this->sku,
            'type' => $this->type,
            'serial' => $this->serial,
            'os_id' => $portability->id,
            'os_name' => $portability->name,
            'price' => $details->price,
            'stock' => $details->stock,
            'created_at' => $details->created_at,
            'updated_at' => $details->updated_at,
        ];
    }
}
