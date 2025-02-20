@extends('layouts.template')


@section('content')
    <div class="container mt-3">
        <div class="my-5 d-flex justify-content-end">
                <a href="{{ route('order.export-excel')}}" class="btn btn-primary">Export Data (excel)</a>
        </div>

    <br>


        <table class="table table-striped table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Obat</th>
                <th>Nama Kasir</th>
                <th>Tanggal Pembelian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                <tr>
                    <td>{{ ($orders->currentpage()-1) * $orders->perpage() + $loop->index + 1 }}</td>
                    <td>{{ $order->name_customer }}</td>
                    <td>
                        <ol>
                            @foreach ($order['medicines'] as $medicine)
                            <li>
                                {{ $medicine['name_medicine'] }} ( {{ number_format($medicine['price'], 0, ',', '.') }} ) : Rp. {{ number_format
                                ($medicine['sub_price'], 0, ',', '.') }} <small>qty {{ $medicine['qty'] }}</small>
                            </li>
                            @endforeach
                        </ol>
                    </td>
                    <td>{{ $order['user']['name'] }}</td>

                    @php
                    setlocale(LC_ALL, 'IND');
                    @endphp
                    <td>{{ \Carbon\Carbon::parse($order['created_at'])->formatLocalized('%d %B %Y') }}</td>
                    <td>
                        <a href="{{ route('kasir.order.download', $order['id']) }}" class="btn btn-secondary">Unduh (.pdf)</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>


    <div class="d-flex justify-content-end">
        @if  ($orders->count())
            {{ $orders->links() }}
        @endif
    </div>
    </div>
@endsection