@extends('layouts.base')

@section('name', 'Задача')

@section('main')

    <div class="col-6 ms-3 border border-secondary rounded p-3">
        <form action="{{ route('tasks.edit', ['group' => $group, 'task' => $task])  }}" method="post">
            @csrf
            @method('put')
            <div class="mb-3">
                <label class="form-label">Название задачи</label>
                <input type="text" class="form-control border-0" value="{{ $task->title }}" name="title">
            </div>
            <div class="mb-3">
                <label class="form-label">Дата выполнения</label>
                <input type="datetime-local" class="form-control" value="{{ $task->deadline }}" name="deadline">
            </div>
            <div class="mb-3">
                <label class="form-label">Описание задачи</label>
                <input type="text" class="form-control" name="description" value="{{ $task->description }}"
                    placeholder="необязательно">
            </div>
            <div class="mb-3">
                <label class="form-label">Исполнитель</label>
                <select name="executor">
                    <option value="{{ $task->executor }}">{{ $task->executor()->first()->name }}</option>
                    @foreach ($members as $member)
                    @if ($task->executor != $member->id)
                        <option value="{{ $member->id }}">{{ $member->name }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-outline-dark btn-sm">Обновить</button>
        </form>
    </div>

@endsection