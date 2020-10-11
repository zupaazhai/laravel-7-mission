<?php

namespace App\Http\Controllers;

use App\Http\Requests\TopicRequest;
use App\Topic;
use App\Comment;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
                ->select("topics.*",
                          DB::raw("(SELECT count(comments.id) FROM comments
                                      WHERE comments.topic_id = topics.id
                                      GROUP BY comments.topic_id) as count_comment")
                       )->orderBy('topics.id', 'desc')
                       ->paginate(2);
        //dd($topics);
        // $topics = Topic::with('user')
        //     ->orderBy('id', 'desc')
        //     ->paginate();

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
          
        // $comment = Comment::where('comments.topic_id' , $id)
        // ->leftJoin('users','users.id','=','comments.user_id')
        // ->get();
        $comment = DB::select('select comments.*, users.name as name  from comments 
        join users on users.id = comments.user_id where topic_id='.$id.' order by comments.created_at Desc');
        //dd($comment);
        //$user = User::where('id' ,  $comment['user_id'])->get();
        $data['topic'] = $topic;
        $data['comments'] = $comment;
        
       // return view('topic.form', compact('topic'));
       return view('topic.form', ['data'=>$data]);
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
