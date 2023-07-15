<?php

namespace App\Http\Controllers;

use App\IdTemplate;
use App\SchoolUser;
use Illuminate\Http\Request;

class IdTemplateController extends Controller
{
    public function index( Request $request){
        try{
            $IdTemplate = IdTemplate::where('school_id' ,$request->user()->school()->first()->id)->get();
            return response()->json([
                $IdTemplate
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    public function store(Request $request){
        try{
            $this->validate($request,[
                'templateName'=>'required',
                'text_color'=>'string',
                'bgcolor'=>'string',
                'pcbrdrcolor'=>'string',
                'brdrcolor'=>'string',
                'sizeQR'=>'integer',
                'imgradius'=>'integer',
                'sizeSchoollogo'=>'integer'
            ]);          
            $IdTemplate = new IdTemplate();
            $IdTemplate->template_name = $request->get('templateName');
            $IdTemplate->text_color = $request->get('text_color');
            $IdTemplate->background_color = $request->get('bgcolor');
            $IdTemplate->picture_border_color = $request->get('pcbrdrcolor');
            $IdTemplate->border_color = $request->get('brdrcolor');
            $IdTemplate->qr_code_size = $request->get('sizeQR');
            $IdTemplate->image_radius = $request->get('imgradius');
            $IdTemplate->logo_size = $request->get('sizeSchoollogo');
            $IdTemplate->template_selected = $request->get('selected_template');
            $IdTemplate->school_id = $request->user()->school()->first()->id;
            $res = $IdTemplate->save();
            if($res){
                return response()->json([
                    'message'=>"Template Successfully Saved "
                ]);
            }
        } catch (Exception $e) {
            throw $e;
        }
    }
}
