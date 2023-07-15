<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MarkRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**g
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
           'exam' => 'required|exists:exams,id',
           'section' => 'required|exists:sections,id',
           'exam_details' => 'array|min:1',
           'exam_details.*.marks' => 'array|min:1',
            // 'exam_details.*.student_name'=>'required|exists:students,name',
            // 'exam_details.*.student_role'=>'required',
            // "exam_details.*.student_gpa"=>'required',
            // "exam_details.*.student_remarks"=>'required',
            // "exam_details.*.gpa_grade"=>"required",
            // "exam_details.*.gpa_marks"=>"required",
            // "exam_details.*.marks"=>"array:min:1"
        ];

        foreach ($this->request->get('exam_details') as $key => $val) {
            $rules['exam_details.' . $key . '.student_id'] = 'required|exists:students,id';
            $rules['exam_details.' . $key . '.marks'] = 'array|min:1';
            // return $val;
            // dd($this->request->get('exam_details'));
            if (array_key_exists('marks', $val)) {
                foreach ($val['marks'] as $k => $v) {
//                    dd($val['marks']);
//                    $rules['exam_details.' . $key . '.marks.' . $k . '.subject'] = 'required';
//                    $rules['exam_details.' . $key . '.marks.' . $k . '.thfm'] = 'numeric';
//                    $rules['exam_details.' . $key . '.marks.' . $k . '.prfm'] = 'numeric';
                    $rules['exam_details.' . $key . '.marks.' . $k . '.theory'] = 'numeric|nullable';
                    $rules['exam_details.' . $key . '.marks.' . $k . '.practical'] = 'numeric|nullable';
//                    $rules['exam_details.' . $key . '.marks.' . $k . '.theory'] = 'numeric|nullable|lte:'.'exam_details.' . $key . '.marks.' . $k . '.thfm';
//                    $rules['exam_details.' . $key . '.marks.' . $k . '.practical'] = 'numeric|nullable|lte:'.'exam_details.' . $key . '.marks.' . $k . '.prfm';
//                    dd($rules);
                }
            }

        }
        return $rules;
    }
}
