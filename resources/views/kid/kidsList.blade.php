@foreach($kids as $kid)
    <tr>
        <th class="col-1">{{ $kid->name }}</th>
        <th class="col-2">{{ $kid->desc }}</th>
        <th class="col-3">
            @foreach($kid->classrooms as $classroom)
                {{ $classroom->classroom }}<br>
            @endforeach
        </th>
        <th class="col-4"></th>
        <th class="col-5"><a onclick="changePopup(document.getElementById('editKid'), true);getKid({{ $kid->id }});return false;" >Изменить</a></th>
    </tr>
@endforeach
