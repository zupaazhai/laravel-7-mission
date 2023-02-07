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
                <input type="hidden" name="topic_id" value="{{ $topic->id ?? '' }}">
                <div class="form-group">
                    <label for="comment">Comment</label>
                    <textarea name="comment" class="form-control" placeholder="Write your comment here..." id="" cols="4" rows="4" required></textarea>
                </div>
                <button class="btn btn-primary">Comment</button>
            </form>
        </div>
        <div class="col-12">
            @foreach ($comment as $item)
                <div class="alert alert-secondary" role="alert">
                    <h4 class="alert-heading">By {{ $item->user->name }} {{ $item->created_at }} 
                        @if($item->user_id == auth()->user()->id)
                            <form action="{{ route('comments.destroy',$item->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm"  onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        @endif
                    </h4>
                    <hr>
                    <p class="mb-0">{{ $item->comment }}</p>
                </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
