@extends('layouts.base')

@section('name', 'Задача')

@section('main')

    <div class="row">
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
            <form action="{{ route('tasks.delete', ['group' => $group, 'task' => $task]) }}" method="post">
                @method('delete')
                @csrf
                <button type="submit" class="btn btn-danger btn-sm mt-3">Удалить задачу</button>
            </form>
        </div>
        <div class="col-3 border border-secondary rounded p-3 d-flex flex-column">
            <h4 class="border-bottom p-1">Комментарии</h4>
            <div class="comments">
                @foreach ($comments as $comment)
                    <div class="bg-primary p-3 rounded mt-3 mb-3">
                        <b>{{ $members[$comment->user_id]->name }}</b><br>
                        {{ $comment->text }}
                    </div>
                @endforeach
            </div>
            <form class="mt-auto" action="{{ route('comments.store', ['group' => $group, 'task' => $task]) }}" method="post">
                @csrf
                <textarea name="text" placeholder="Написать комментарий"></textarea>
                <button type="submit" class="btn btn-outline-success btn-sm">Отправить</button>
            </form>
        </div>
    </div>
@endsection