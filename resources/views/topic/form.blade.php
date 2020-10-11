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
            <form class="card" method="post" action="{{ $isCreate ? route('topics.store') : route('topics.update', $data['topic']->id ?? 0) }}">
                @method($isCreate ? 'post' : 'put')
                @csrf
                <div class="card-header">
                    <h3 class="card-title">{{ $isCreate ? 'Create' : 'Edit' }} topic</h3>
                </div>
                <div class="card-body">
                    <div class="form-group">
                        <label for="topic">Title</label>
                        <input value="{{ $data['topic']->title ?? '' }}" class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" name="title"></input>
                        <span class="invalid-feedback">{{ $errors->first('title') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="content">Content</label>
                        <textarea name="content" id="content" class="form-control {{ $errors->has('content') ? 'is-invalid' : '' }}" cols="30" rows="10">{{ $data['topic']->content ?? '' }}</textarea>
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
            @forelse ($data['comments'] as $comment)
            <div>
                <h2>BY {{ $comment->name }} ({{$comment->created_at}})
                    @if (auth()->user()->id==$comment->user_id)
                  
                        
                        <a href="javascript:checkDelete({{$comment->id}});"  style="color:#FF0000; font-size:14px">Delete</a></span>
                       
                    
                    @endif</h2>
                <p>{{ $comment->comment }}</p>
            </div>
            @empty
            <div>

            </div>
             @endforelse
            
            <form action="{{ route('comments.store') }}" method="post" class="mb-4">
                @csrf
                <input type="hidden" name="topic_id" value="{{ $data['topic']->id ?? '' }}">
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
<script>
    function checkDelete(id) {
if (confirm('delete?')) {
    $.ajax({
      type: "DELETE",
      data: {
        "_token": "{{ csrf_token() }}",
        },
      url: '/comments/' + id,
      success: function(result) {
        window.location.reload();
      }
    });
  }
}
</script>
@endsection
