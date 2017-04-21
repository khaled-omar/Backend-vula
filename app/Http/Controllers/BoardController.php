<?php

namespace App\Http\Controllers;

use App\Board;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class BoardController extends Controller
{
    function __construct()
    {
        $this->middleware('jwt.auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg'=>'user not found'],404);
        }
       // $boards = Board::where('user_id',$user->id)->get();
        return response()->json(['Boards'=>$user->Boards],200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request,[
            'name'=>'required|min:3|regex:^[A-Z0-9 _]*$^',
            'description'=>'required|min:5'
            ]);
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg'=>'user not found'],404);
        }
        $board = new Board();
        $board->name = $request->name;
        $board->description = $request->description;
        $board->user_id = $user->id;
        if (!$board->save()) {
            return response()->json(['msg'=>'Board creation failed'],404);
        }
        return response()->json([
            'msg'=>'Board successfuly created',
            'board'=>$board
            ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function show(Board $board)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function edit(Board $board)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Board $board)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Board  $board
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        if(!Board::where('id',$id)->delete())
        {
            return response()->json(['msg'=>'Board doesnot exist'],404);

        }
        return response()->json([
            'msg'=>'Board deleted successfuly',
            ],200);  
    }
}
