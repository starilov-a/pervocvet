<div class="popup-back" id="editClassroom" onclick="if(event.target.classList[0] == 'popup-back') changePopup(this, false);">
    <div class="popup-container">
        <div class="popap-header">
            <div class="title"><h3>Редактировать информацию</h3></div>
            <div class="close"><i class="fa fa-times" aria-hidden="true" onclick="changePopup(this.closest('.popup-back'), false)"></i></div>
        </div>
        <div class="popap-main">
            @include('layouts.errors')
            <form id="form-classroom-edit" data-class='classroom' data-list='list-classroom'>
                <div>
                    <label>Название группы</label>
                    <input name="classroom">
                </div>
                <div>
                    <label>
                        Дополнительная информация:
                    </label>
                    <textarea name="desc"></textarea>
                </div>
            </form>
        </div>
        <div class="popup-footer">
            <div class="button-add">
                <button href='' onclick="editPopupAjax(this, document.getElementById('form-classroom-edit'))">Изменить</button>
            </div>
            <div class="button-del">
                <button href='' onclick="delPopupAjax(this, document.getElementById('form-classroom-edit'))">Удалить</button>
            </div>
        </div>
    </div>
</div>
