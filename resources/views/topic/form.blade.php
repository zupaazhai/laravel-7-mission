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
                        <label for="title">Title</label>
                        <input value="{{ $topic->title ?? '' }}" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title">
                        <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" cols="30" rows="10">{{ $topic->content ?? '' }}</textarea>
                        <span class="invalid-feedback">{{ $errors->first('content') }}</span>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-success">{{ $isCreate ? 'New' : 'Update' }} topic</button>
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
                <button type="submit" class="btn btn-primary">Comment</button>
            </form>
        </div>

        @forelse ($comment as $comment_data)
            <div class="col-12 mb-2">
                <div class="card">
                    <div class="card-body">
                        <span>
                            <b>
                                By {{$comment_data->get_user->name}} ( {{$comment_data->created_at}} ) 
                                @if($comment_data->user_id == auth()->user()->id)
                                    <a href="{{ route('comments.destroytest', $comment_data->id) }}"><span class="text-danger">Delete</span></a>
                                @endif
                                <br> 
                                {{$comment_data->comment}}
                            </b>
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
            </div>
        @endforelse

    </div>
    @endif
</div>
@endsection
