<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TransactionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'transaction_date'=>$this->transaction_date,
            'detail'=>$this->detail,
            'amount'=>$this->amount,
            'type'=>$this->type,
            'category_id'=>$this->category_id,
            'tags' => TagResource::collection($this->whenLoaded('tags')),
        ];
    }
}
