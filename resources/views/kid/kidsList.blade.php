@if($kids->count() > 0)
    <tbody id="list-kid" data-page="1">
        @foreach($kids as $kid)
            <tr>
                <th class="col-1">{{ $kid->name }}</th>
                <th class="col-2">{{ $kid->desc }}</th>
                <th class="col-3">
                    @foreach($kid->classrooms as $classroom)
                        {{ $classroom->classroom }}<br>
                    @endforeach
                </th>
                <th class="col-4">
                    <details>
                        <summary>Показать</summary>
                        <div>
                            @if($kid->payments()->count() > 0)
                                @foreach($kid->payments()->latest()->limit('3')->get() as $payment)
                                    <b>{{ $payment->created_at }}</b><br>
                                    <p><span>+{{ $payment->payment }} руб.</span> — {{ $payment->classroom->classroom }}</p>
                                @endforeach
                            @else
                                <div>Информация об оплате отсутствует</div>
                            @endif
                        </div>
                    </details>
                </th>
                <th class="col-5"><a onclick="changePopup(document.getElementById('editKid'), true);getKid({{ $kid->id }});return false;" >Изменить</a></th>
            </tr>
        @endforeach
        @if( $kids->count() % config('app.limit_on_longlist') == 0)
            <tr class="more-page">
                <th>
                    <a onclick="nextPage({'data-class':'kid','data-list':'list-kid'})" >Показать еще</a>
                </th>
            </tr>
        @endif
    </tbody>
@else
    <tbody id="list-kid" data-page="1">
        <tr>
            <th colspan="5">Записи отсутствуют</th>
        </tr>
    </tbody>
@endif
