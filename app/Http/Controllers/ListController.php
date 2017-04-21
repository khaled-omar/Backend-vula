<?php

namespace App\Http\Controllers;
use App\Mylist;
use App\Card;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Illuminate\Http\Request;

class ListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($board_id)
    {
        //
        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg'=>'user not found'],404);
        }
       // $boards = Board::where('user_id',$user->id)->get();
        $lists = MyList::where('board_id',$board_id)->with('cards')->get();
        return response()->json(['Lists'=>$lists],200);
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
    public function store(Request $request,$board_id)
    {
        //
         $this->validate($request,[
            'name'=>'required|min:3',
            ]);

        if (!$user = JWTAuth::parseToken()->authenticate()) {
            return response()->json(['msg'=>'user not found'],404);
        }

        $list = new Mylist();
        $list->name = $request->name;
        $list->board_id = $board_id;
        $list->user_id = $user->id;

        if (!$list->save()) {
            return response()->json(['msg'=>'list creation failed'],500);
        }
        $list->cards = [];
        
        return response()->json([
            'msg'=>'list created successfuly',
            'list'=>$list
            ],200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($list_id)
    {
        //
        $cards = Card::where('mylist_id',$list_id)->delete();
        $list = Mylist::where('id',$list_id)->delete();
        
        if(!$list)
        {
            return response()->json(['msg'=>'list doesnot exist'],404);

        }
        return response()->json([
            'msg'=>'list deleted successfuly',
            ],200);        
    }
    
}
