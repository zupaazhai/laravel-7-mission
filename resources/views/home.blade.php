@extends('layouts.app')


@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="mb-2 text-right">
                <a class="btn btn-success" href="{{route('topics.create')}}">New Topic</a>
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
                    <?php 
                        $idtopic = $topic->id; 
                        
                        $id = $idtopic - 1;
                    ?>
                    <tr>
                        <td>{{ $topic->id }}</td>
                        <td>
                            <a href="{{ route('topics.edit', $topic->id) }}">{{ $topic->title }}</a>
                        </td>
                        <td>{{ $topic->user->name }}</td>
                        <td>{{ $topic->created_at }}</td>
                        <td>{{ $datacount[$id] }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5">No topic found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $topics->links()}}
            <table class="table table-bordered bg-white table-hover">
                <thead>
                    <tr>
                        <th>Comment</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                        @if (session()->has('deleted_status'))
                        <div class="alert alert-{{ session()->get('deleted_status')['status'] }}">
                            {{ session()->get('deleted_status')['message'] }}
                        </div>
                        @endif
                       
                        @foreach($data as $row)
                        <form method="post" action="{{ route('comments.destroy',$row->id)}}">
                        @csrf
                        <div class="card mt-2" >
                            <div class="card-body">
                            By {{ $row->user->name}} {{ $row->created_at }}
                            
                            
                            @if($row->user_id==Auth::user()->id)
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">delete</button>
                            @endif
                            <hr>
                            {{ $row->comment }}

                            </div>
                            </div>
                        </div>
                        </form>
                        @endforeach
                        </td>
                    </tr>
                </tbody>
            </table>
            {{ $data->links()}}
    </div>
</div>
@endsection
