<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use DB;
use App\Topic;
use App\Comment;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $topics = Topic::with('user')
            ->leftjoin('comments', 'topics.id', 'comments.topic_id')
            ->groupBy('topics.id')
            ->orderBy('topics.id', 'desc')
            ->select(
                'topics.*',
                'comments.topic_id',
                DB::raw("count(comments.topic_id) as topic_count")
            )
            ->paginate(5);

        return view('home', compact('topics'));
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

        $comment = Comment::where('topic_id' , $id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('topic.form', compact('topic', 'comment'));
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
        dd('topic');
        //
    }
}
