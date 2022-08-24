@if($kids->count() > 0)
    <tbody id="list-kid" data-page="1">
        @foreach($kids as $kid)
            <tr>
                <td class="col-1">{{ $kid->name }}</th>
                <td class="col-2">{{ $kid->desc }}</th>
                <td class="col-3">
                    @foreach($kid->classrooms as $classroom)
                        - {{ $classroom->classroom }}<br>
                    @endforeach
                </th>
                <td class="col-4">
                    <details>
                        <summary>Показать</summary>
                        <div>
                            @if($kid->payments()->count() > 0)
                                @foreach($kid->payments()->latest()->limit('3')->get() as $payment)
                                    <b>{{ $payment->created_at }}</b><br>
                                    <p><span class="green-price" >+{{ $payment->payment }} руб.</span> — {{ $payment->classroom->classroom }}</p>
                                @endforeach
                            @else
                                <div>Информация об оплате отсутствует</div>
                            @endif
                        </div>
                    </details>
                </th>
                <td class="col-5"><a onclick="changePopup(document.getElementById('editKid'), true);getKid({{ $kid->id }});return false;" >Изменить</a></th>
            </tr>
        @endforeach
        @if( $kids->count() % config('app.limit_on_longlist') == 0)
            <tr class="more-page">
                <td>
                    <a onclick="nextPage({'data-class':'kid','data-list':'list-kid'})" >Показать еще</a>
                </td>
            </tr>
        @endif
    </tbody>
@else
    <tbody id="list-kid" data-page="1">
        <tr>
            <td colspan="5">Записи отсутствуют</th>
        </tr>
    </tbody>
@endif
