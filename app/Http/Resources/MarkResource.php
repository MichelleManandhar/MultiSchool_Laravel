<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return $this;
        return [
            strtolower($this->subject->name).'-theory' => is_null($this->theoritical)?'.':$this->theoritical,
            strtolower($this->subject->name).'-practical' => is_null($this->practical)?'.':$this->practical,
            strtolower($this->subject->name).'-full_grade' => is_null($this->full_grade)?'.':$this->full_grade,
        ];
    }
}
