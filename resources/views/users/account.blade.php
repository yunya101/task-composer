@extends('layouts.base')

@section('name', 'Аккаунт')

@section('main')

    <div class="row">
        <div class="col-6 offset-3 border border-secondary p-5 rounded">
            <h2 class="mb-3">Аккаунт</h2>
            <form action="{{ route('users.edit') }}" method="post">
                @csrf
                @method('put')
                <div class="mb-3">
                    <label for="name" class="form-label">Имя пользователя</label>
                    <input type="test" class="form-control" value="{{ $user->name}}" id="name" name="name"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputEmail1" class="form-label">Адрес электронной почты</label>
                    <input type="email" class="form-control" value="{{ $user->email }}" id="exampleInputEmail1" name="email"
                        aria-describedby="emailHelp">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Изменить пароль</label>
                    <input type="password" class="form-control" name="password" id="exampleInputPassword1">
                </div>
                <div class="mb-3">
                    <label for="exampleInputPassword1" class="form-label">Повторите пароль</label>
                    <input type="password" class="form-control" name="password_confirmation" id="exampleInputPassword1">
                </div>
                <button type="submit" class="btn btn-outline-success">Сохранить</button>
            </form>
            <form class="mt-3" action="{{ route('users.delete') }}" method="post">
                @csrf
                @method('delete')
                <button class="btn btn-danger" type="submit">Удалить аккаунт</button>
            </form>
        </div>
    </div>
@endsection