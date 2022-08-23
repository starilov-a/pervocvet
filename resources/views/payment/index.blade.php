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

        <div class="container-mini-main mini-main-1">
            <h3>По группе</h3>
            <hr>
            <table class="table-payments">
                <thead>
                <tr>
                    <th class="col-1">Дата</th>
                    <th class="col-2">Имя ребенка</th>
                    <th class="col-4">Примечание</th>
                    <th class="col-5">Приход</th>
                </tr>
                </thead>
                @include('payment.byClassroomsList', ['classrooms' => $classrooms])
            </table>
        </div>
        <div class="container-mini-main mini-main-2">
            <h3>По ребёнку</h3>
            <hr>
            <table class="table-payments">
                <thead>
                <tr>
                    <th class="col-1">Дата</th>
                    <th class="col-3">Услуга</th>
                    <th class="col-4">Примечание</th>
                    <th class="col-5">Приход</th>
                </tr>
                </thead>
                @include('payment.byKidsList', ['kids' => $kids])
            </table>
        </div>
        <div class="container-main">
            <h3>Все платежи</h3>
            <hr>
            <table class="table-payments">
                <thead>
                <tr>
                    <th class="col-1">Дата</th>
                    <th class="col-2">Имя ребенка</th>
                    <th class="col-3">Услуга</th>
                    <th class="col-4">Примечание</th>
                    <th class="col-5">Приход</th>
                    <th class="col-6"></th>
                </tr>
                </thead>
                @include('payment.paymentsList', ['payments' => $payments])
            </table>
        </div>
    </div>
    @include('payment.create')
    @include('payment.edit')
@endsection
