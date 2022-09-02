<div class="popup-back" id="editKid" onclick="if(event.target.classList[0] == 'popup-back') changePopup(this, false);">
    <div class="popup-container">
        <div class="popap-header">
            <div class="title"><h3>Редактировать информацию</h3></div>
            <div class="close"><i class="fa fa-times" aria-hidden="true" onclick="changePopup(this.closest('.popup-back'), false)"></i></div>
        </div>
        <div class="popap-main">
            @include('layouts.errors')
            <form id="form-kid-edit" data-class='kid' data-list='list-kid'>
                <div>
                    <label>Имя ребёнка</label>
                    <input name="name">
                </div>
                <div>
                    <label>
                        Дополнительная информация:
                        <span>Информация о родиятелях (имена, номера и тд.)</span>
                    </label>
                    <textarea name="desc"></textarea>
                </div>
                <div>
                    <label>Выбор группы:</label>
                    <select name="classrooms" onchange="addClassroom(this.value, this.closest('form'))">
                        <option value="">Отсутствует</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{$classroom->id}}">{{$classroom->classroom}}</option>
                        @endforeach
                    </select>
                </div>
            </form>
        </div>
        <div class="popup-footer">
            <div class="button-add">
                <button onclick="editPopupAjax(document.getElementById('form-kid-edit'))">Изменить</button>
            </div>
            <div class="button-del">
                <button onclick="delPopupAjax(document.getElementById('form-kid-edit'))">Удалить</button>
            </div>
        </div>
    </div>
</div>
