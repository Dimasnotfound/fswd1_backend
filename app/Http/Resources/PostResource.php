<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    public $success;
    public $status;
    public $message;
    public $resource;

    public function __construct($success, $message, $resource, $status = null)
    {
        parent::__construct($resource);
        $this->success  = $success;
        $this->status  = $status;
        $this->message = $message;
    }


    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'code'    => $this->status,
            'success'   => $this->success,
            'message'   => $this->message,
            'data'      => $this->resource,
        ];

    }
}
