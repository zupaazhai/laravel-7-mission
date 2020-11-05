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
            <form class="card" method="post" action="{{ $isCreate ? route('topics.store') : route('topics.update', $topic->id ?? 0) }}">
                @method($isCreate ? 'post' : 'put')
                @csrf
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
                <input type="hidden" name="topic_id" value="{{ $topic->id ?? '' }}">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" class="form-control" placeholder="Write your comment here..." id="" cols="4" rows="4"></textarea>
                </div>
                <button class="btn btn-primary">Comment</button>
            </form>
        </div>
        <div class="col-12">
            @foreach ($topic->comments->sortByDesc('created_at') as $comment)
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <b>{{$comment->user->name ?? ''}} ({{$comment->created_at}})</b>
                            @if(auth()->user()->id === $comment->user->id)
                                <small
                                    class="text-danger"
                                    style="cursor: pointer;"
                                    onclick="document.getElementById('delete-comment-form').submit();">
                                        Delete
                                </small>
                                <form id="delete-comment-form" action="{{route('comments.destroy', $comment)}}" method="post">
                                    @method('delete')
                                    @csrf
                                </form>
                            @endif
                        </h5>
                        <p class="card-text p-2">{{$comment->comment}}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
