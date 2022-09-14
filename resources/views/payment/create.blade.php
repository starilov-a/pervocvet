<div class="popup-back" id="addPayment" onclick="if(event.target.classList[0] == 'popup-back') changePopup(this, false);">
    <div class="popup-container">
        <div class="popap-header">
            <div class="title"><h3>Добавить приход</h3></div>
            <div class="close"><i class="fa fa-times" aria-hidden="true" onclick="changePopup(this.closest('.popup-back'), false)"></i></div>
        </div>
        <div class="popap-main">
            @include('layouts.errors')
            <form id="form-payment-create" data-class='payment' data-list='list-payment'>
                <div>
                    <label>Имя ребёнка</label>
                    <select name="kid_id">
                        <option value="">Не выбрано</option>
                        @foreach($kids as $kid)
                            <option value="{{$kid->id}}">{{$kid->name}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Выбор оплачиваемой услуги</label>
                    <select name="classroom_id">
                        <option value="">Не выбрано</option>
                        @foreach($classrooms as $classroom)
                            <option value="{{$classroom->id}}">{{$classroom->classroom}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Дата фактической оплаты</label>
                    <input type="date" name="payment_date">
                </div>
                <div>
                    <label>Способ оплаты</label>
                    <select name="payment_option_id">
                        <option value="">Не выбрано</option>
                        @foreach($paymentOptions as $option)
                            <option value="{{$option->id}}">{{$option->option}}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label>Сумма оплаты</label>
                    <input name="payment" type="number">
                </div>
                <div>
                    <label>
                        Примечание к оплате:
                        <span>Любая полезная информация</span>
                    </label>
                    <textarea name="desc"></textarea>
                </div>
            </form>
        </div>
        <div class="popup-footer">
            <div class="button-add">
                <button href="/payments" onclick="addPopupAjax(this, document.getElementById('form-payment-create'))">Добавить</button>
            </div>
            <div style="clear:both"></div>
        </div>
    </div>
</div>
