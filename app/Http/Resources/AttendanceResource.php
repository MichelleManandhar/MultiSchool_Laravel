<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceResource extends JsonResource
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
            'roll_no' => $this->student->roll_no,
            'student_id' => $this->student->id,
            'name' => $this->student->fname.' '.$this->student->mname.' '.$this->student->lname,
            'school_days' => 180,
            'present_days' => $this->present_days
        ];
    }
}
