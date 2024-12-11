<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Order::with('user')->orderBy('created_at', 'DESC')->get();
    }

    public function headings(): array
    {
        return [
            'ID Pembelian',
            'Nama Kasir',
            'Daftar Obat',
            'Nama Pembeli',
            'Total Harga',
            'Tanggal Pembelian',
        ];
    }

    public function map($order): array
    {
        $formatwadah = '';
        foreach ($order->medicines as $key => $value) {
            $format = $key+1 . ". " . $value['name_medicine'] . "(" . $value['qty'] . 
            "pcs : Rp. " . number_format($value['sub_price'], 0, ',', '.') . ")";

            $formatwadah .= $format;
        }

        return [
            $order->id,
            $order->user->name,
            $formatwadah,
            $order->name_customer,
            "Rp. " . number_format($order->total_price, 0, ',', '.'),
            \Carbon\Carbon::parse($order->created_at)->isoFormat('D MMMM YYYY'),
        ];
    }
}
