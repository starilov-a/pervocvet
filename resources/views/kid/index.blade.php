@extends('layouts.master')
@section('content')
    <div class="right-container">
        <div class="container-header">
            <div class="header-title"><h2>Дети</h2></div>
            <div class="header-button">
                <button onclick="changePopup(document.getElementById('addKid'), true);return false;">Добавить</button>
            </div>
            <div class="header-select">
                <select onchange="let filter = {classroom: this.options[this.selectedIndex].value}; refreshKidsList(filter)">
                    <option value="-1">Все</option>
                    @foreach($classrooms as $classroom)
                        <option value="{{$classroom->id}}">{{$classroom->classroom}}</option>
                    @endforeach
                </select>
            </div>
        </div>

        @include('kid.notificate.add')
        @include('kid.notificate.edit')
        @include('kid.notificate.delete')

        <div class="container-main">
            <table class="table-kids">
                <thead>
                <tr>
                    <th class="col-1">Имя</th>
                    <th class="col-2">Информация</th>
                    <th class="col-3">Группы</th>
                    <th class="col-4">Истоия оплаты</th>
                    <th class="col-5"></th>
                </tr>
                </thead>
                <tbody>
                @include('kid.kidsList', ['kids' => $kids])
                </tbody>
            </table>
        </div>
    </div>
    @include('kid.create', ['classrooms' => $classrooms])
    @include('kid.edit', ['classrooms' => $classrooms])
@endsection
