<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserTransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => 1,
            'user' => BasicUserResource::make($this->user),
            'amount' => $this->amount,
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
