@extends('layouts.main')

@section('content')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div id="success" style="display: none" class="col-md-8 text-center h3 p-4 bg-success text-light rounded">
                تمت عملية الشراء بنجاح
            </div>
            <div class="col-md-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">عربة التسوق</div>
                    <div class="card-body">
                        @if ($items->count())
                            <div class="table-responsive">
                                <table class="table table-bordered text-center">
                                    <thead class="thead-light">
                                        <tr>
                                            <th scope="col">العنوان</th>
                                            <th scope="col">السعر</th>
                                            <th scope="col">الكمية</th>
                                            <th scope="col">السعر الكلي</th>
                                            <th scope="col">خيارات</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $totalPrice = 0; @endphp

                                        @foreach ($items as $item)
                                            @php $totalPrice += $item->price * $item->pivot->number_of_copies; @endphp

                                            <tr>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->price }} $</td>
                                                <td>{{ $item->pivot->number_of_copies }}</td>
                                                <td>{{ $item->price * $item->pivot->number_of_copies }} $</td>
                                                <td>
                                                    <div class="d-flex flex-wrap justify-content-center gap-1">
                                                        <form action="{{ route('remove_all', $item->id) }}" method="POST" class="mx-1">
                                                            @csrf
                                                            <button type="submit" class="btn btn-danger btn-sm">ازل الكل</button>
                                                        </form>

                                                        <form action="{{ route('remove_one', $item->id) }}" method="POST" class="mx-1">
                                                            @csrf
                                                            <button type="submit" class="btn btn-warning btn-sm">ازل نسخة</button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="text-right mt-3">
                                <h4 class="mb-4">المجموع النهائي: <strong>{{ $totalPrice }} $</strong></h4>
                                <div class="d-inline-block" id="paypal-button-container"></div>
                            </div>
                        @else
                            <div class="alert alert-info text-center">
                                لا يوجد كتب بالعربة
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script')
    <script src="https://www.paypal.com/sdk/js?client-id=ARX7lzf7oH74rgnHEebaLpyIumto_L4OvDoknh68tZ0xB-N4AOygj5SUHvJfn47AFpYAf9ua-UraI6O4&currency=USD"></script>

    <script>
        paypal.Buttons({
            createOrder: (data, actions) => {
                return fetch('/api/paypal/create-payment', {
                    method: 'POST',
                    body: JSON.stringify({
                        'userId': {{ auth()->user()->id }}
                    })
                }).then(res => res.json()).then(orderData => orderData.id);
            },
            onApprove: (data, actions) => {
                return fetch('/api/paypal/execute-payment', {
                    method: 'POST',
                    body: JSON.stringify({
                        orderId: data.orderID,
                        userId: "{{ auth()->user()->id }}"
                    })
                }).then(res => res.json()).then(orderData => {
                    $('#success').slideDown(200);
                    $('.card-body').slideUp(0);
                });
            }
        }).render('#paypal-button-container');
    </script>
@endsection
