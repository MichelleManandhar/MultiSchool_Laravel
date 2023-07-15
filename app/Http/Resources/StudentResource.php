<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'student_name' => $this->name,
            'student_roll' => $this->roll_no,
            'student_gpa' => $this->getTotalGpa,
            'student_remarks' =>
                "Very good boy, he will do very good in the future",
            'gpa_grade' => "A+",
            'gpa_marks' => 3.8,
            'marks' => MarkSheetResource::collection($this->marks()->where('exam'))
        ];
    }
}
