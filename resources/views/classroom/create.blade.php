<div class="popup-back" id="addClassroom" onclick="if(event.target.classList[0] == 'popup-back') changePopup(this, false);">
    <div class="popup-container">
        <div class="popap-header">
            <div class="title"><h3>Добавить группу</h3></div>
            <div class="close"><i class="fa fa-times" aria-hidden="true" onclick="changePopup(this.closest('.popup-back'), false)"></i></div>
        </div>
        <div class="popap-main">
            @include('layouts.errors')
            <form id="form-classroom-create" data-class='classroom' data-list='list-classroom'>
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
                <button onclick="addPopupAjax(document.getElementById('form-classroom-create'))">Добавить</button>
            </div>
            <div style="clear:both"></div>
        </div>
    </div>
</div>
