<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Topic;
use App\Comment;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class TopicController extends Controller
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
        $user = auth()->user();
        // dd($users);
        $comments = Comment::with('user')
            ->orderBy('id', 'desc')
            ->paginate(5);
        $topics = Topic::with('user')
            ->orderBy('id', 'desc')
            ->paginate();
        return view('home', compact('topics','comments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('topic.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TopicRequest $request)
    {
        $topic = new Topic();
        $request->request->add(['user_id' => auth()->user()->id]);
        $topic->create($request->only(['title', 'content', 'user_id']));
        //$topic->create($request->all());
        return redirect()->route('topics.index');
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
        $topic = Topic::where('id' , $id)
            ->firstOrFail();
        // $comments = DB::table('comments')
        // ->where('topic_id', '>=', $id)
        // ->orderBy('created_at', 'DESC')
        // ->get();
        $comments = Comment::with('user')
        ->where('topic_id', '=', $id)
        ->orderBy('id', 'desc')
        ->paginate(5);
        return view('topic.form', ['comments'=>$comments],compact('topic', 'comments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TopicRequest $request, $id)
    {
        $topic = Topic::where('id' , $id)
            ->firstOrFail();

        $topic->title = $request->title;
        $topic->content = $request->content;
        $topic->save();

        return back()->with('save_status', [
            'message' => 'Update success',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
