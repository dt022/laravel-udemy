@extends('layouts.app')

@section('title', isset($task) ? 'Edit Task' : 'Add Task')

@section('content')
    <form method="POST" action="{{ isset($task) ? route('tasks.update', ['task' => $task->id]) : route('tasks.store') }}">
        @csrf
        @isset($task)
            @method('PUT')
        @endisset
        <div class="mb-4">
            <label for="title">
                Title
            </label>

            <input type="text" name="title" id="title"
            @class(['border-red-500' => $errors->has('title')])
            value="{{ $task->title ?? old('title') }}">
            @error('title')
                <p class="error">{{ $message }}</p>               
            @enderror

            <div class="mb-4">
                <label for="">Description</label>
                <textarea name="description" id="description" rows="5"
                @class(['border-red-500' => $errors->has('title')])>{{ $task->description ?? old('description') }}</textarea>
                @error('description')
                    <p class="error">{{ $message }}</p>               
                @enderror
            </div>
            
            <div class="mb-4">
                <label for="">Long Description</label>
                <textarea name="long_description" id="long_description" rows="10"
                @class(['border-red-500' => $errors->has('title')])>{{ $task->long_description ?? old('long_description') }}</textarea>    
                @error('long_description')
                    <p class="error">{{ $message }}</p>               
                @enderror
            </div>

     
            <div class="mb-4 flex gap-2 items-center">
                <button class="btn" type="submit">
                    @isset($task)
                        Update Task
                    @else
                        Add Task
                    @endisset
                </button>
                <a href="{{ route('tasks.index') }}" class="link">Cancel</a>
            </div>

        </div>
    </form>
@endsection