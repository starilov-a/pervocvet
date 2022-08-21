<div class="bar">
    <h1>{{ config('app.name') }}</h1>
    <div class="nav-bar">
        <ul>
            <li @if(url()->current() == config('app.url').'/kids') class="active-nav-item" @endif><a href="/kids">Дети</a></li>
            <li @if(url()->current() == config('app.url').'/payments') class="active-nav-item" @endif><a href="/payments">Статистика приходов</a></li>
        </ul>
    </div>
    <div class="login-block">
        <div class="button-exit">
            <button>Выход</button>
        </div>
        <div class="login">
            <p>Иванова Анастасия</p>
        </div>
    </div>
</div>
