<?php

namespace App\Http\Resources;

use App\Models\Receiver;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RaiseFundResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "title" => $this->title,
            "links" => $this->links,
            "pictures" => $this->pictures,
            "funds" => $this->funds,
            "closed_funds" => $this->closed_funds,
            "details_funds" => $this->details_funds,
            "user_id" => $this->user_id,
            "receiver" => new ReceiverResource(Receiver::where("id", $this->receiver_id)->get()),
            "created_at" => $this->created_at,
            "updated_at" => $this->updated_at
        ];
    }
}
