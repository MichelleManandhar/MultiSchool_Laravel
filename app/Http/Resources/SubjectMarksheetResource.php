<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectMarksheetResource extends JsonResource
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
            'headerName'=> $this->name,
                    'field'=> "english",
                    'sortable'=> true,
                    'filter'=> true,
                    'editable'=>true,
//                    'children' => [
//                        {
//                            'headerName' => "th",
//                            'field'=> "englishth",
//                            'width'=> 50,
//                            'editable'=>true,
//                        },
//                        {
//                            'headerName'=> "pr",
//                            'field'=> "englishpr",
//                            'width'=> 50,
//                            'editable'=>true,
//                        },
//                        {
//                            'headerName'=> "total",
//                            'field'=> "englishtotal",
//                            'width'=> 80,
//                            'editable'=>true,
//                        }
//                    ]
        ];
    }
}
