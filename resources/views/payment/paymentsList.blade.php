@if($payments->count() > 0)
    <tbody id="list-payment" data-page="1">
        @foreach($payments as $payment)
            <tr>
                <td class="col-1"><b title="создано {{ $payment->created_at }}">{{ $payment->payment_date }}</b></th>
                <td class="col-2">{{ $payment->kid->name }}</th>
                <td class="col-3">{{ $payment->classroom->classroom }}</th>
                <td class="col-4">{{ $payment->desc }}</th>
                <td class="col-5">
                    <span class="green-price" title="{{ $payment->paymentOption->option }}" >+{{ number_format($payment->payment,2) }} руб.</span>
                </th>
                @can('update', $payment)
                    <td class="col-6"><a onclick="changePopup(document.getElementById('editPayment'), true);getPayment({{ $payment->id }});return false;" >Изменить</a></th>
                @endcan
            </tr>
        @endforeach
        @if( $payments->count() % config('app.limit_on_longlist') == 0)
            <tr class="more-page">
                <td>
                    <a onclick="nextPage({'data-class':'payment','data-list':'list-payment'})" >Показать еще</a>
                </td>
            </tr>
        @endif
    </tbody>
@else
    <tbody id="list-payment" data-page="1">
        <tr>
            <td colspan="5">Записи отсутствуют</th>
        </tr>
    </tbody>
@endif
