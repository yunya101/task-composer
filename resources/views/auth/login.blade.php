@extends('layouts.base')

@section('name', 'Авторизация')

@section('main')

    <div class="row">
        <div class="col-6 offset-3 border border-secondary p-5 rounded">
            <h2 class="mb-3">Авторизация</h2>
            <form action="{{ route('authentication') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" name="email"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Пароль</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
                </div>
                <button type="submit" class="btn btn-outline-dark">Авторизация</button>
                <p class="mt-3">Нет аккаунта? - <a href="{{ route('register') }}">регистрация</a></p>
            </form>
        </div>
    </div>

@endsection