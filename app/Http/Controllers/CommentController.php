<?php

namespace App\Http\Controllers;

use App\Comment;
use App\User;
use App\Http\Requests\CommentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = request();
        $comment = new Comment();
        
        $request['user_id']= auth()->user()->id;
        $comment->create(['topic_id'=>$data['topic_id'], 'user_id' => $data['user_id'], 'description' =>  $data['comment']]);
        
        return back()->with('save_status', [
            'message' => 'Your comment saved',
            'status' => 'success'
        ]);
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
    public function destroy(Request $request, Comment $comment)
    {
        
        $this->authorize('delete',$comment);
        // if(Gate::allows('delete-comment', $comment)) {
		// 	$comment->delete();
		// } else {
		// 	abort(403);
		// }
        DB::table('comments')->where('id',$comment->id)->delete();
        // auth()->user()->comment()->where('id',$id)->delete();
        return back();
    }
}
