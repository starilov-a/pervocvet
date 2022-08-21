@foreach($payments as $payment)
    <tr>
        <th class="col-1">{{ $payment->created_at }}</th>
        <th class="col-2">{{ $payment->kid->name }}</th>
        <th class="col-3">{{ $payment->classroom->classroom }}</th>
        <th class="col-4">{{ $payment->desc }}</th>
        <th class="col-5">{{ $payment->payment }}</th>
    </tr>
@endforeach
