<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "path" => $this->path,
            "serial_id" => $this->serial_id,
            "meta" => $this->meta,
            "course_item_id" => $this->course_item_id,
            "created_at" => $this->created_at->format("Y-m-d H:i:s"),
            "updated_at" => $this->updated_at->format("Y-m-d H:i:s"),
        ];
    }
}
