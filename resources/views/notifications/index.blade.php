@extends('layouts.base')

@section('name', 'Уведомления')

@section('main')

    @if ($invitations->isEmpty())
        <h2>Уведомления отстутствуют</h2>
    @else

        @foreach ($invitations as $invite)
            <div class="col-2 ms-3 border border-secondary rounded p-3">
                <p>Группа: {{ $invite->title }}</p>
                <p>Кол-во участников: {{ $invite->count_members }}</p>
                <form action="{{ route('notifications.accept', ['group' => $invite]) }}" method="post">
                    @csrf
                    <button class="btn btn-success">Принять</button>
                </form>
                <form action="{{ route('notifications.reject', ['group' => $invite]) }}" method="post">
                    @csrf
                    <button class="btn btn-danger">Отклонить</button>
                </form>
            </div>
        @endforeach

    @endif

@endsection