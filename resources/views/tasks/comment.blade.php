@extends('layouts.app')

@section('content')
<h3>Comments for Task: {{ $task->title }}</h3>

<ul class="list-group">
    @foreach($task->comments as $comment)
        <li class="list-group-item">
            <strong>{{ $comment->user ? $comment->user->name : 'Unknown User' }}</strong>:
            {{ $comment->comment }}
        </li>
    @endforeach
</ul>

<form method="POST" action="{{ route('tasks.comment.store', $task->id) }}" class="mt-3">
    @csrf
    <div class="mb-3">
        <textarea name="comment" class="form-control" placeholder="Write a comment..." required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Add Comment</button>
</form>
@endsection
