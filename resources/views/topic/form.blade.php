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

        @if (isset($comment))
            
            @foreach ($comment as $comments)
                <div class="card">
                    <form action="{{ route('comments.destroy',$comments->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        
                        <div class="card-body">
                            <p><span>By</span> {{ \App\User::findOrFail($comments->user_id)->name }}  ({{ $comments->created_at->format('Y-m-d H:i:s') }}) @if (auth()->user()->id == $comments->user_id)
                                <button type="submit" onclick="confirm('ต้อการลบใช่หรือไม่?!') || event.preventDefault();" style="color: red;border: none;outline:none;background-color:transparent;">Delete</button></p>
                            @endif
                            <div class="container">
                                {{ $comments->comment }}
                            </div>
                        </div>
                    </form>
                </div>
                <br>
            @endforeach
        @endif
    
    <br>    
        
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
        </div>
    </div>
    @endif
</div>
@endsection
