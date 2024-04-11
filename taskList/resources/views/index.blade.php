@extends('layouts.app')

@section('title','The list of tasks:')

@section('content')
<div>
    @forelse ($tasks as $task)
        <a href="{{route('task.show',['id'=> $task->id])}}">{{$task->title}}</a></br>
    @empty
        <div>There are no tasks!</div>
    @endforelse
   
</div>
@endsection