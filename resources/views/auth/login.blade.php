@extends('layouts.master')
@section('content')
    <div class="auth-container">
        <div class="auth-container-header">
            <h1>Вход</h1>
        </div>
        <div class="auth-container-content">
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group row">
                    <label for="name" class="col-md-4 col-form-label text-md-right">Логин</label>
                    @error('name')
                        <span class=" error-message-input" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="col-md-6">
                        <input id="name" type="name" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-right">Пароль</label>
                    @error('password')
                        <span class=" error-message-input" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                    <div class="col-md-6">
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                    </div>
                    @error('noMatches')
                    <span class=" error-message-input" role="alert">
                            {{ $message }}
                        </span>
                    @enderror
                </div>

            </form>
        </div>
        <div class="auth-container-footer">
            <div class="header-button">
                <button onclick="document.getElementsByTagName('form')[0].submit()">Вход</button>
            </div>
        </div>
    </div>


@endsection


