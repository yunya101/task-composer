@extends('layouts.base')

@section('name', 'Dashboard')

@section('main')

    @if ($groups->isEmpty())
        <h2 class="text-center">У вас нет ни одной группы</h2>

    @else
        <div class="row">
            @foreach ($groups as $group)
                <div class="col-2 ms-3 border border-secondary rounded p-3">
                    <b><a href="{{ route('groups.show', ['group' => $group]) }}">{{ $group->title }}</a></b>
                    <p>Кол-во участников: {{ $group->count_members }}</p>
                </div>
            @endforeach
        </div>
    @endif

    <div class="row mt-3 text-center">
        <div class="col-2 offset-5 mt-3 border border-secondary rounded p-3">
            <h4>Создать группу</h4>
            <form action="{{ route('groups.store')  }}" method="post">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Название группы</label>
                    <input type="text" class="form-control" name="title">
                </div>
                <div class="mb-3">
                    <label class="form-label">Участники</label>
                    <input type="members" class="form-control" name="members">
                </div>
                <button type="submit" class="btn btn-outline-dark btn-sm">Создать</button>
            </form>
        </div>
    </div>

@endsection