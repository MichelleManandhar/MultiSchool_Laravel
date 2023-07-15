<?php

namespace App\Http\Controllers;

use App\Sponsor;
use Illuminate\Http\Request;

class SponsorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $getAllSponsor = Sponsor::where('school_id' , $request->user()->school()->first()->id)->where('delete_flag',0)->get();;
            return response()->json([
                'status' => 1,
                'sponsors' => $getAllSponsor
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $this->validate($request,[
                'name'=>'required|string',
                'address'=>'required|string',
                'contact_no'=>'required|digits_between:9,10',
                'description'=>'string'
            ]);
            $sponsor = new Sponsor();
            $sponsor->name = $request->get('name');
            $sponsor->address = $request->get('address');
            $sponsor->contact_no= $request->get('contact_no');
            $sponsor->description= $request->get('description');
            $sponsor->school_id = $request->user()->school()->first()->id;
            $sponsor->save();
            return response()->json([
                'status' => 1,
                'sponsor' => $sponsor
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function show(Sponsor $sponsor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $sponsorId)
    {
        try{
            $this->validate($request,[
                'name'=>'required|string',
                'address'=>'required|string',
                'contact_no'=>'required|digits_between:9,10',
                'description'=>'string'
            ]);
            $sponsor=Sponsor::find($sponsorId);
            $sponsor->name = $request->get('name');
            $sponsor->address = $request->get('address');
            $sponsor->contact_no= $request->get('contact_no');
            $sponsor->description= $request->get('description');
            $sponsor->school_id = $request->user()->school()->first()->id;
            $sponsor->save();
            return response()->json([
                'status' => 1,
                'sponsor' => $sponsor
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sponsor $sponsor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request , $sponsorId)
    {
        try{
            $sponsor=Sponsor::find($sponsorId);
            $sponsor->delete_flag=1;
            $sponsor->save();
            return response()->json([
                'status' => 1,
                'message' => 'Successfully deleted'
            ]);
        } catch (Exception $e) {
            throw $e;
        }
    }
}
