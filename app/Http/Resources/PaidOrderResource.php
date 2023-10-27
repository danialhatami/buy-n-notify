<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Database\Seeders\ProductSeeder;
use Illuminate\Http\Resources\Json\JsonResource;

class PaidOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status->value,
            'user' => BasicUserResource::make($this->user),
            'product' => ProductResource::make($this->product)
        ];
    }
}
