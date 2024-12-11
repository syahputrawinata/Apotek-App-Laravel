@extends('layouts.template')


@section('content')
    <div class="container mt-3">

        <br>

    <form action="{{ route('kasir.order.index') }}" method="GET" class="mb-3">
        <div class="d-flex">
            <input type="date" name="filter_date" class="justify-content-between me-2" placeholder="Pilih tanggal" value="{{ request('filter_date')}}">
            <button type="submit" class="btn btn-primary me-2">Filter</button>
            <a href="{{ route('kasir.order.index') }}" class="btn btn-secondary me-2">Clear</a>
            <div class="d-flex justify-content-end">
                <a href="{{ route('kasir.order.create') }}" class="btn btn-primary">+ Pembelian Baru</a>
            </div>
        </div>
    </form>

        <table class="table table-striped table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pembeli</th>
                <th>Obat</th>
                <th>Total Bayar</th>
                <th>Nama Kasir</th>
                <th>Tanggal Pembelian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @php $no = 1; @endphp
            @foreach ($orders as $item)
                <tr>
                    <td class="text-center">{{ $no++ }}</td>
                    <td>{{ $item['name_customer'] }}</td>
                    <td>
                        @foreach ($item['medicines'] as $medicine)
                        <ol>
                            <li>
                                {{ $medicine['name_medicine'] }} ( {{ number_format($medicine['price'], 0, ',', '.') }} ) : Rp. {{ number_format
                                ($medicine['sub_price'], 0, ',', '.') }} <small>qty {{ $medicine['qty'] }}</small>
                            </li>
                        </ol>
                        @endforeach
                    </td>
                    <td>Rp. {{ number_format($item['total_price'],0, ',', '.') }}</td>
                    <td>{{ $item['user']['name'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($item['created_at'])->translatedFormat('j F Y') }}</td>
                    <td>
                        <a href="{{ route('kasir.order.download', $medicine['id']) }}" class="btn btn-secondary">Download Setruk</a>
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