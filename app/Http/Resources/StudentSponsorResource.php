<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Sponsor;

class StudentSponsorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $sponsor = Sponsor::where('id', $this->sponsor_id)->get('name');
        return [
            'id'=>$this->id,
            'class_id'=>$this->class_id,
            'section_id'=>$this->section_id,
            'roll_no'=>$this->roll_no,
            'fname'=>$this->fname,
            'mname'=>$this->mname,
            'lname'=>$this->lname,
            'DOB'=>$this->DOB,
            'mobile_no'=>$this->mobile_no,
            'fathers_name'=>$this->fathers_name,
            'fathers_contact'=>$this->fathers_contact,
            'mothers_name'=>$this->mothers_name,
            'mothers_contact'=>$this->mothers_contact,
            'permanent_address'=>$this->permanent_address,
            'temporary_address'=>$this->temporary_address,
            'parent_name'=>$this->parent_name,
            'category_list'=>$this->category_id,
            'image_name'=>$this->image_name,
            'sponsor_name'=>$sponsor[0]->name,
            'sponsor_id'=>$this->sponsor_id
        ];
    }
}
