@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mb-2 text-right">
                <a class="btn btn-success" href="topics/create">New Topic</a>
            </div>
            <table class="table table-bordered bg-white table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Topic</th>
                        <th>Created By</th>
                        <th>Created At</th>
                        <th>Comments</th>
                    </tr>
                </thead>
                <tbody>
                    
                    @forelse ($topics as $topic)
                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>
                            <a href="{{ route('topics.edit', $topic->id) }}">{{ $topic->title }}</a>
                        </td>
                        <td>{{ $topic->user->name }}</td>
                        <td>{{ $topic->created_at }}</td>
                        <td>{{ $topic->comment->count() }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No topic found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            {{-- <div class="mb-0 text-left border ">
                <table id="" class="table table-borderless bg-white table-hover col-12 mb-0"
                width="100%">
                <tbody>
                        @forelse($comments as $comment)
                        <tr>
                            <td width ="250px" value={{$comment->topic_id}}>
                                    <div >By {{$comment->user->name}} {{$comment->created_at}} $users->id</div>
                                    <div>{{$comment->description}}</div>
                            </td>
                            <td>
                                

                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST">
                                        @method('DELETE')
                                        @csrf
                                            @can('delete',$users);
                                                <button class="btn btn-link " style="color: red" type="submit">Delete</button>  
                                            @endcan            
                                       </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5">No topic found</td>
                        <tr>
                        @endforelse
                        </tbody>
                </table>
            </div> --}}
        </div>
    </div>
</div>
@endsection