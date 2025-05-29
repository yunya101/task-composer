@extends('layouts.base')

@section('name', 'Главная')

@section('main')

<div class="row text-center">
    <h2>Добро пожаловать в Task Composer!</h2>
    <a href="{{ route('login') }}" class="btn btn-outline-dark mt-3">Войти в аккаунт</a>
    <a href="{{ route('register') }}" class="btn btn-outline-dark mt-3">Регистрация</a>
</div>

@endsection