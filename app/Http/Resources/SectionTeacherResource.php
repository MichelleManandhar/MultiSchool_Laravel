<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SectionTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->teacher->id,
            'name' => $this->teacher->name,
            'subject' => $this->section->id,
            'design' => $this->teacher_designation
        ];
    }
}
