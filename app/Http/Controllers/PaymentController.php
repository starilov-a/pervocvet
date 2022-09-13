<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request,
    App\Http\Controllers\AjaxController,
    App\Payment,
    App\Classroom,
    App\Kid,
    App\PaymentOption;

class PaymentController extends AjaxController
{
    protected static $viewLists = [
        'list-payment' => 'payment.paymentsList',
        'list-payment-classrooms' => 'payment.byClassroomsList',
        'list-payment-kids' => 'payment.byKidsList'
    ];

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('payment.index', [
            'classrooms' => Classroom::where('deleted', 0)->get(),
            'kids' => Kid::where('deleted', 0)->get(),
            'payments' => Payment::where('deleted', 0)->latest('created_at')->limit(config('app.limit_on_longlist'))->get(),
            'paymentOptions' => PaymentOption::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->isAjax($request)) {
            list($validate, $data) = $this->validateAjaxData(Payment::class, $request);
            if(!$validate)
                return $data;

            unset($data['metaData']);
            $data = array_diff($data, array(''));
            $payment = Payment::create($data);

            return ['status' => true, 'notificateMessage' => $payment::$notificateMessage['add']];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment, Request $request)
    {
        if($this->isAjax($request)) {
            $data['kid_id'] = $payment->kid->id;
            $data['classroom_id'] = $payment->classroom->id;
            $data['payment_option_id'] = $payment->paymentOption->id;
            $data['payment_date'] = $payment->payment_date;
            $data['payment'] = $payment->payment;
            $data['desc'] = $payment->desc;

            return $data;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        if($this->isAjax($request)) {
            list($validate, $data) = $this->validateAjaxData($payment, $request);
            if(!$validate)
                return $data;

            unset($data['metaData']);
            $data = array_diff($data, array(''));
            $payment->update($data);

            return ['status' => true, 'notificateMessage' => $payment::$notificateMessage['update']];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Payment $payment)
    {
        if(!auth()->user()->isAdmin());
            return redirect()->back()->withMessage('Доступ запрещен');
        if($this->isAjax($request)) {
            $payment->delete();

            return ['status' => true, 'notificateMessage' => $payment::$notificateMessage['delete']];
        }
    }

    public function list(Request $request) {
        if($this->isAjax($request))
            return $this->getList(new Payment, $request);
    }
}
