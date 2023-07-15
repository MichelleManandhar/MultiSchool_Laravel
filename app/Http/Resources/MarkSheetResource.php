<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MarkSheetResource extends JsonResource
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
            'subject' => $this->subject->name,
            'gpa_th' => $this->theory_grade,
            'gpa_pr' => $this->practical_grade,
            'gpa_total' => $this->full_grade
        ];
    }
}
