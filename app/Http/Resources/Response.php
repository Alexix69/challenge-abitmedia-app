<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Response extends JsonResource implements ResourceInterface
{
    protected $data;
    protected $message;

    public function __construct(ResourceInterface $data = null, $message = "")
    {
        $this->data = $data;
        $this->message = $message;
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'message' => $this->message,
            'data' => $this->data
        ];
    }
}
