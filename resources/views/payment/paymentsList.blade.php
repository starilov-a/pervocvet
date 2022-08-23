@if($payments->count() > 0)
    <tbody id="list-payment" data-page="1">
        @foreach($payments as $payment)
            <tr>
                <th class="col-1">{{ $payment->created_at }}</th>
                <th class="col-2">{{ $payment->kid->name }}</th>
                <th class="col-3">{{ $payment->classroom->classroom }}</th>
                <th class="col-4">{{ $payment->desc }}</th>
                <th class="col-5">+{{ $payment->payment }}</th>
                <th class="col-6"><a onclick="changePopup(document.getElementById('editPayment'), true);getPayment({{ $payment->id }});return false;" >Изменить</a></th>
            </tr>
        @endforeach
        @if( $payment->count() % config('app.limit_on_longlist') == 0)
            <tr class="more-page">
                <th>
                    <a onclick="nextPage({'data-class':'payment','data-list':'list-payment'})" >Показать еще</a>
                </th>
            </tr>
        @endif
    </tbody>
@else
    <tbody id="list-payment" data-page="1">
        <tr>
            <th colspan="5">Записи отсутствуют</th>
        </tr>
    </tbody>
@endif
