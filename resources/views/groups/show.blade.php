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
            <form action="{{ route('groups.delete', ['group' => $group]) }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger btn-sm mt-3">Удалить группу</button>
            </form>
        </div>
    </div>

    @if ($tasks->isEmpty())
        <h2>В группе отсутствуют задачи</h2>
    @else
        <div class="row">
            @foreach ($tasks as $task)
                <div class="col-2 ms-3 border border-secondary rounded p-3">
                    <a href="{{ route('tasks.show', ['group' => $group, 'task' => $task]) }}">{{ $task->title }}</a>
                    <p>Исполнитель: {{ $task->executor()->first()->name }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row text-center">
        <div class="col-2 offset-5 mt-3 border border-secondary rounded p-3">
            <h4>Создать задачу</h4>
            <form action="{{ route('tasks.store', ['group' => $group])  }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Название задачи</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="mb-3">
                    <label class="form-label">Дата выполнения</label>
                    <input type="datetime-local" class="form-control" name="deadline">
                </div>
                <div class="mb-3">
                    <label class="form-label">Описание задачи</label>
                    <input type="text" class="form-control" name="description" placeholder="необязательно">
                </div>
                <button type="submit" class="btn btn-outline-dark btn-sm">Создать</button>
            </form>
        </div>
    </div>

@endsection