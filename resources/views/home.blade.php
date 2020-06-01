@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mb-2 text-right">
                <a class="btn btn-success" href="{{ route('topics.create') }}">New Topic</a>
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
                        <td>{{ $topic->total_comment }}</td>
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
</div>
@endsection
