@extends('layouts.app')

@section('content')

@php
    $isCreate = Request::route()->getName() == 'topics.create';
@endphp

<div class="container">
    <div class="row mb-4">
        <div class="col-12">
            @if (session()->has('save_status'))
            <div class="alert alert-{{ session()->get('save_status')['status'] }}">
                {{ session()->get('save_status')['message'] }}
            </div>
            @endif
            <form class="card" method="post" action="{{ $isCreate ? (route('topics.store')) : route('topics.update', $topic->id ?? 0) }}">
                @csrf
                @method($isCreate ? 'post' : 'put')
                
                <div class="card-header">
                    <h3 class="card-title">{{ $isCreate ? 'Create' : 'Edit' }} topic</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="topic">Title</label>
                        <input value="{{ $topic->title ?? '' }}" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title"></input>
                        <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" cols="30" rows="10">{{ $topic->content ?? '' }}</textarea>
                        <span class="invalid-feedback">{{ $errors->first('content') }}</span>
                    </div>
                </div>
                <div class="card-footer">
                    <button class="btn btn-success">{{ $isCreate ? 'New' : 'Update' }} topic</button>
                </div>
            </form>
        </div>
    </div>

    @if (!$isCreate)
    <div class="row">
        <div class="col-12">
            <form action="{{ route('comments.store') }}" method="post" class="mb-4">
                @csrf
                @method('post')
                <input type="hidden" name="topic_id" value="{{ $topic->id ?? '' }}">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" class="form-control" placeholder="Write your comment here..." id="description" cols="4" rows="4"></textarea>
                </div>
                <button class="btn btn-primary"่>Comment</button>
            </form>
        </div>
        <div class="col-12">
            <div class="mb-0 text-left border ">
                <table id="" class="table table-borderless bg-white table-hover col-12 mb-0"
                width="100%">
                <tbody>
                        @forelse($comments as $comment)
                        <tr>
                            <td width ="250px" value={{$comment->topic_id}}>
                                    <div >By {{$comment->user->name}} {{$comment->created_at}}</div>
                                    <div>{{$comment->description}}</div>
                            </td>
                            <td>
                                
                                    {{-- <a href="{{ route('comments.destroy', $comment->id) }}" class="text-danger">Delete</a> --}}
                                        <form action="/comments/{{$comment->id}}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        
                                            @can('delete',$comment)
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
            </div>
        </div>
        <div class="col-12">
            {{ $comments->links() }}
        </div>
    </div>
    @endif
</div>
@endsection
