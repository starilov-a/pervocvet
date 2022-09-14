@if($payments->count() > 0)
    <tbody id="list-payment-classrooms" data-page="1">
    @foreach($payments as $payment)
        <tr>
            <td class="col-1"><b title="создано {{ $payment->created_at }}">{{ $payment->payment_date }}</b></th>
            <td class="col-2">{{ $payment->kid->name }}</th>
            <td class="col-4">{{ $payment->desc }}</th>
            <td class="col-5"><span class="green-price" >+{{ $payment->payment }} руб.</span></th>
        </tr>
    @endforeach
    <tr>
        <td colspan="5">Cумма по группе за указанный период: <span class="green-price" >+{{ $payments->sum('payment') }} руб. </span></th>
    </tr>
    @if( $payments->count() % config('app.limit_on_shortlist') == 0)
        <tr class="more-page">
            <td colspan="4">
                <a onclick="nextPage({'data-class':'payment','data-list':'list-payment-classrooms', 'count-on-page':{{config('app.limit_on_shortlist')}} })" >Показать еще</a>
            </td>
        </tr>
    @endif
    </tbody>
@else
    <tbody id="list-payment-classrooms" data-page="1">
        <tr>
            <td colspan="5" style="text-align: center">Записи отсутствуют</th>
        </tr>
    </tbody>
@endif
