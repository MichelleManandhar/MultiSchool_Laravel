<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
class UserController extends Controller
{
    public function index()
    {
        try{
            $users = User::all();
            return response()->json(
                [
                    'status' => 'success',
                    'users' => $users->toArray()
                ], 200);
        } catch (Exception $e) {
            throw $e;
        }
    }
    public function show(Request $request, $id)
    {
        try{
            $user = User::find($id);
            return response()->json(
                [
                    'status' => 'success',
                    'user' => $user->toArray()
                ], 200);
        } catch (Exception $e) {
            throw $e;
        }
    }
}