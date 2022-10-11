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
                <form class="card" method="post"
                    action="{{ $isCreate ? route('topics.store') : route('topics.update', $topic->id ?? 0) }}">
                    @csrf
                    @method($isCreate ? 'post' : 'put')
                    <div class="card-header">
                        <h3 class="card-title">{{ $isCreate ? 'Create' : 'Edit' }} topic</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="topic">Title</label>
                            <input value="{{ $topic->title ?? '' }}"
                                class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title"></input>
                            <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" id="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}"
                                cols="30" rows="10">{{ $topic->content ?? '' }}</textarea>
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
                            <textarea name="comment" class="form-control" placeholder="Write your comment here..." id="" cols="4"
                                rows="4"></textarea>
                        </div>
                        <button class="btn btn-primary">Comment</button>
                    </form>
                </div>

                <div class="col-12">
                    @forelse ($topic->comments as $comment)
                        <div class="card mb-2">
                            <div class="card-body">
                                <h5>
                                    By {{ $comment->user->name }} ({{ $comment->created_at }}) 
                                    @if ($comment->user_id == auth()->user()->id)
                                        <a href="{{ route('comments.delete', $comment->id) }}" style="color:red">DELETE</a>
                                    @endif
                                </h5>
                                <div class="p-2">{{ $comment->comment }}</div>
                            </div>
                        </div>
                    @empty
                        <h5 class="text-center">No comment yet</h5>
                    @endforelse


                </div>
        @endif
    </div>
@endsection
