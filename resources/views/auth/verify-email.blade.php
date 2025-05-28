@extends('layouts.base')

@section('name', 'Подтверждение почты')

@section('main')

    <div class="alert alert-info">
        <p>Пожалуйста, подтвердите создание аккаунта с помощью ссылки, отправленной на вашу почту</p>
    </div>

    <div>
        <form action="{{ route('verification.send') }}" method="post">
            @csrf
            <button type="submit" class="btn btn-outline-dark">Отправить ещё раз</button>
        </form>
    </div>

@endsection