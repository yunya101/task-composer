@extends('layouts.base')

@section('name', 'Регистрация')

@section('main')

    <div class="row">
        <div class="col-6 offset-3 border border-secondary p-5 rounded">
            <h2 class="mb-3">Регистрация</h2>
            <form action="{{ route('users.store') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
                    <input type="email" class="form-control" id="exampleInputEmail1" value="{{ old('email') }}" name="email" aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputName" class="form-label">Имя пользователя</label>
                    <input type="text" class="form-control" id="exampleInputName" value="{{ old('name') }}" name="name">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Пароль</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword2" class="form-label">Повторите пароль</label>
                    <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword2">
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" name="remember" class="form-check-input" id="exampleCheck1">
                    <label class="form-check-label" for="exampleCheck1">Запомнить меня</label>
                </div>
                <button type="submit" value="{{ old('remember') }}" class="btn btn-outline-dark">Регистрация</button>
                <p class="mt-3">Есть аккаунт? - <a href="{{ route('login') }}">авторизация</a></p>
            </form>
        </div>
    </div>

@endsection