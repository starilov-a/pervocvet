@extends('layouts.master')
@section('content')
    <div class="right-container">
        <div class="container-header">
            <div class="header-title"><h2>Статистика приходов</h2></div>
            <div class="header-button add-payment-button">
                <button onclick="changePopup(document.getElementById('addPayment'), true);return false;">Добавить приход</button>
            </div>
        </div>

        @include('payment.notificate.add')
        @include('payment.notificate.edit')
        @include('payment.notificate.delete')
        <div>
            <div class="container-mini-main mini-main-1">
                <h3>По группе</h3>
                <div class="header-select">
                    <button name="datefilter" data-list="list-payment-classrooms"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                    <select onchange="refreshList({'data-class':'payment','data-list':'list-payment-classrooms', 'count-on-page':{{config('app.limit_on_shortlist')}} },{classroom: this.options[this.selectedIndex].value, page: 1})">
                        <option value="">Не выбрано</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{$classroom->id}}">{{$classroom->classroom}}</option>
                        @endforeach
                    </select>
                </div>

                <hr>
                <table class="table-payments">
                    <thead>
                    <tr>
                        <td class="col-1">Дата</th>
                        <td class="col-2">Имя</th>
                        <td class="col-4">Примечание</th>
                        <td class="col-5">Приход</th>
                    </tr>
                    </thead>
                    <tbody id="list-payment-classrooms" data-page="1">
                    <tr>
                        <td colspan="4" style="text-align: center;">Группа не выбрана</th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div class="container-mini-main mini-main-2">
                <h3>По ребёнку</h3>
                <div class="header-select">
                    <button name="datefilter" data-list="list-payment-kids"><i class="fa fa-calendar" aria-hidden="true"></i></button>
                    <select onchange="refreshList({'data-class':'payment','data-list':'list-payment-kids', 'count-on-page':{{config('app.limit_on_shortlist')}} },{kid: this.options[this.selectedIndex].value, page: 1})">
                        <option value="">Не выбрано</option>
                        @foreach($kids as $kid)
                            <option value="{{$kid->id}}">{{$kid->name}}</option>
                        @endforeach
                    </select>
                </div>
                <hr>
                <table class="table-payments">
                    <thead>
                    <tr>
                        <td class="col-1">Дата</th>
                        <td class="col-3">Услуга</th>
                        <td class="col-4">Примечание</th>
                        <td class="col-5">Приход</th>
                    </tr>
                    </thead>
                    <tbody id="list-payment-kids" data-page="1">
                    <tr>
                        <td colspan="4" style="text-align: center;">Ребёнок не выбран</th>
                    </tr>
                    </tbody>
                </table>
            </div>
            <div style="clear:both"></div>
        </div>

        <div class="container-main">
            <h3>Все платежи</h3>
            <hr>
            <table class="table-payments">
                <thead>
                <tr>
                    <td class="col-1">Дата</th>
                    <td class="col-2">Имя ребенка</th>
                    <td class="col-3">Услуга</th>
                    <td class="col-4">Примечание</th>
                    <td class="col-5">Приход</th>
                    <td class="col-6"></th>
                </tr>
                </thead>
                @include('payment.paymentsList', ['payments' => $payments])
            </table>
        </div>
    </div>
    @include('payment.create')
    @can('update', $payments)
        @include('payment.edit')
    @endcan
@endsection
