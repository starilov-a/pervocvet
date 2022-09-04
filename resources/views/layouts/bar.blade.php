<div class="bar">
    <h1>{{ config('app.name') }}</h1>
    <div class="nav-bar">
        <ul>
            <li @if(url()->current() == config('app.url').'/kids') class="active-nav-item" @endif><a href="/kids">Дети</a></li>
            <li @if(url()->current() == config('app.url').'/classrooms') class="active-nav-item" @endif><a href="/classrooms">Группы</a></li>
            <li @if(url()->current() == config('app.url').'/payments') class="active-nav-item" @endif><a href="/payments">Статистика приходов</a></li>
        </ul>
    </div>
    <div class="login-block">
        <div class="button-exit">
            <a href="/logout"><button>Выход</button></a>
        </div>
        <div class="login">
            <p> {{ auth()->user()->name }} </p>
        </div>
    </div>
</div>
