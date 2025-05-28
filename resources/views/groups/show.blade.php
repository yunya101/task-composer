@extends('layouts.base')

@section('name', 'Задачи')

@section('main')

    <div class="row">
        <div class="col-6 mb-3">
            <form action="{{ route('groups.edit', ['group' => $group]) }}">
                <label for="title" class="form-label">Название: </label>
                <input type="text" value="{{ $group->title }}" class="form-control border-0">
                <label for="members" class="form-label">Добавить участников</label>
                <input type="text" class="form-control">
                <button type="submit" class="btn btn-outline-secondary btn-sm mt-3">Подтвердить</button>
            </form>
        </div>
    </div>

    @if ($tasks->isEmpty())
        <h2>В группе отсутствуют задачи</h2>
    @else
        <div class="row">
            @foreach ($tasks as $taks)
                <div class="col-2 ms-3 border border-secondary rounded p-3">
                    <a href="{{ route('tasks.show', ['group' => $group, 'task' => $task]) }}">{{ $task->title }}</a>
                    <p>Исполнитель: {{ $task->executor()->name }}</p>
                </div>
            @endforeach
        </div>
    @endif

@endsection