@extends('layouts.master')
@section('content')
    <div class="right-container">
        <div class="container-header">
            <div class="header-title"><h2>Детские группы</h2></div>
            <div class="header-button">
                <button onclick="changePopup(document.getElementById('addClassroom'), true);return false;">Добавить</button>
            </div>
        </div>
        @include('layouts.notificates.successMessage')
        <div class="container-main">
            <table class="table-classrooms">
                <thead>
                <tr>
                    <td class="col-1">Название</th>
                    <td class="col-2">Информация</th>
                    <td class="col-5"></th>
                </tr>
                </thead>
                @include('classroom.classroomsList', ['classrooms' => $classrooms])
            </table>

        </div>
    </div>
    @include('classroom.create', ['classrooms' => $classrooms])
    @include('classroom.edit', ['classrooms' => $classrooms])
@endsection
