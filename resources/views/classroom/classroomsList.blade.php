@if($kids->count() > 0)
    <tbody id="list-classroom" data-page="1">
        @foreach($kids as $kid)
            <tr>
                <td class="col-1">{{ $kid->classroom }}</th>
                <td class="col-2">{{ $kid->desc }}</th>
                <td class="col-5"><a onclick="changePopup(document.getElementById('editClassroom'), true);getClassroom({{ $classroom->id }});return false;" >Изменить</a></th>
            </tr>
        @endforeach
        @if( $kids->count() % config('app.limit_on_longlist') == 0)
            <tr class="more-page">
                <td>
                    <a onclick="nextPage({'data-class':'classroom','data-list':'list-classroom'})" >Показать еще</a>
                </td>
            </tr>
        @endif
    </tbody>
@else
    <tbody id="list-classroom" data-page="1">
        <tr>
            <td colspan="5">Записи отсутствуют</th>
        </tr>
    </tbody>
@endif
