<?php

namespace App\Http\Controllers;

use App\Card;
use Illuminate\Http\Request;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class CardController extends Controller
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
    public function index($board_id,$list_id)
    {
        //
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg'=>'user not found'],404);
        }
       // $boards = Board::where('user_id',$user->id)->get();
        $cards = Card::where([['board_id','=',$board_id],['mylist_id','=',$list_id]])->get();
        return response()->json(['Cards'=>$cards],200);
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
     * Store a newly created card in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$board_id,$list_id)
    {
        //
        $this->validate($request,[
            'name'=>'required|min:3',
            //'description'=>'required|min:3',
            ]);

        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg'=>'user not found'],404);
        }

        $card = new Card();
        $card->name = $request->name;
        $card->board_id = $board_id;
        $card->mylist_id = $list_id;
        $card->user_id = $user->id;

        if (!$card->save()) {
            return response()->json(['msg'=>'card creation failed'],500);
        }
        return response()->json([
            'msg'=>'card created successfuly',
            'card'=>$card
            ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function show(Card $card)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Card $card)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Card  $card
     * @return \Illuminate\Http\Response
     */
    public function destroy($card_id)
    {

        $card = Card::where('id',$card_id)->delete();
        
        if(!$card)
        {
            return response()->json(['msg'=>'card doesnot exist'],404);

        }
        return response()->json([
            'msg'=>'card deleted successfuly',
            ],200);        
    }
}
