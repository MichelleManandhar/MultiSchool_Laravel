<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExamDetailResource extends JsonResource
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
            'id' => $this->id,
            'exam_id' => $this->exam->id,
            'fullmarks' => $this->fullmarks,
            'passmarks' => $this->passmarks,
            'practical' => $this->practical,
            'theoritical' => $this->theoritical
        ];
    }
}
