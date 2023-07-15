<?php

namespace App\Http\Controllers;

use App\School_info;
use App\SchoolUser;
use Illuminate\Http\Request;

class SchoolInfoController extends Controller
{
    public function getSchoolDetails(Request $request ){
            try{
                $school_id = $request->user()->school()->first()->id;
                $details = School_info::where('id',$school_id)->get();
                return $details;
            } catch (Exception $e) {
                throw $e;
            }
        }

    public function store(Request $request){
        try {
            $this->validate($request,[
                'establishDateSchool'=>'integer',
                'nameSchool'=>'required|string',
                'acaedemicYearSchool'=>'integer',
                'contactSchool'=>'integer|digits_between:9,10',
                'addressSchool'=>'string',
                'sloganSchool'=>'string',
                'websiteSchool'=>'string',
                'emailSchool'=>'email'
            ]);
            $school = School_info::findOrFail( $request->user()->school()->first()->id);
            $school->establish_date = $request->get('establishDateSchool');
            $school->institute_name = $request->get('nameSchool');
            $school->acaedemic_year = $request->get('acaedemicYearSchool');
            $school->contact = $request->get('contactSchool');
            $school->address = $request->get('addressSchool');
            $school->slogan = $request->get('sloganSchool');
            $school->website_link = $request->get('websiteSchool');
            $school->email = $request->get('emailSchool');
            if($request->hasFile('logoSchool')){
                $school_logo = $request->file('logoSchool');
                $school->school_logo = $this->imageStore($request,'logoSchool','logo');

            }
            if($request->hasFile('signSchool')){
                $signature = $request->file('signSchool');
                $school->signature = $this->imageStore($request,'signSchool','sign');
            }
            $school->save();
            return response()->json([
                'status' => 1,
                'message' => "Successfully Updated"
            ]);
        }
        catch(\Exception $e){
            throw $e;
        }
    }
    public function imageStore($request,$image_name, $folder = null){
        try{
            $path =  storage_path() . DIRECTORY_SEPARATOR . 'app'.DIRECTORY_SEPARATOR.'public'.DIRECTORY_SEPARATOR.'upload'.DIRECTORY_SEPARATOR;
            $folder_path = $folder ? $path.$folder.DIRECTORY_SEPARATOR : $path;
            if( $request->file($image_name)){
                $file = $request->file($image_name);
                $original_file_name = $file->getClientOriginalName() ?: null;
                $original_file_name_extension = $file->getClientOriginalExtension() ?: null;
                $file_name = rand(1, 99999) . strtotime("now") . '_' . $original_file_name;
                $file->move($folder_path, $file_name);
                return $file_name;
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
