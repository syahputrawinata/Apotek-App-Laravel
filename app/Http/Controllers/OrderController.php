<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\pdf as PDF;
// use  Maatwebsite\Excel\Facades\Excel as Excel;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrdersExport;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $orders = Order::WHERE('created_at', 'LIKE', '%'. $request->filter_date . '%')->orderBY('created_at', 'ASC')->simplePaginate(5);
        // $orders = Order::with('user')->simplePaginate(5);
        return view('order.kasir.index', compact('orders'));
        // return view('order.kasir.index');
    }

    // public function index(Request $request)
    // {

    // $query = Order::with('user', 'medicine');


    // if ($request->has('filter_date') && !empty($request->input('filter_date'))) {
    //     $filterDate = $request->input('filter_date');

    //     $query->whereDate('created_at', $filterDate);
    // }

    // $orders = $query->simplePaginate(5);


    // return view('order.kasir.index', compact('orders'));
    // }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $medicines = Medicine::all();
        return view("order.kasir.create", compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name_customer' => 'required|max:50',
            'medicines' => 'required',
        ]);

        // mencaari jumlah item yang sama pada array
        $arrayDistinct = array_count_values($request->medicines);
        // menyiapkan array kosong untuk menampung format array barunya
        $arrayMedicines = [];

        foreach($arrayDistinct as $id => $count) {
            //mencari data obat berdasarkan id(obat yang dipilih)
            $medicines = Medicine::where('id', $id)->first();

            if ($medicines['stock'] < $count) {
                $valueBefore = [
                    "name_customer" => $request->name_customer,
                    "medicines" => $request->medicines
                ];
                $msg = "Obat " . $medicines['name'] . " Sisa Stok : " . $medicines['stock'] . ". Tidak dapat melakukan proses pembelian!";
                return redirect()->back()->withInput()->with('failed', $msg);
            }else {
                $medicines['stock']-= $count;
                $medicines->save();
            }

            $subPrice = $medicines['price'] * $count;

            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicines['name'],
                "qty" => $count,
                "price" => $medicines['price'],
                "sub_price" => $subPrice,
            ];

            array_push($arrayMedicines, $arrayItem);
        }


        $totalPrice = 0;

        foreach($arrayMedicines as $item) {
            $totalPrice += (int)$item['sub_price'];
        }


        //harga total price ditambah 10%
        $pricePpn = $totalPrice + ($totalPrice * 0.01);

        $proses = Order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $pricePpn,
        ]);

        if($proses) {
            $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();

            return redirect()->route('kasir.order.print', $order['id']);
        }else {
            return redirect()->back()->with('failed', 'Gagal membuat data pembelian. Silahkan coba kembali dengan data yang benar');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        //
        $order = Order::where('id', $id)->first();
        // dd($order);
        return view('order.kasir.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }


    public function downloadPdf($id) 
    {
        //Ambil data berdasarkan id yang ada di struk dan dipartikan terformat array
        $order = Order::find( $id)->toArray();
        //kita akan share data dengan inisial awal agar bisa digunakan ke blade manapun
        view()->share('order', $order);
        //ini akan meload view halaman downlaodnya
        $pdf = PDF::loadView('order.kasir.Download-pdf', $order);
        //kita tinggal download
        return $pdf->download('Invoice.pdf');
    }


    public function data(){

        $orders = Order::with('user')->simplePaginate(5);
        return view('order.admin.index', compact('orders'));
    }

    public function exportExcel()
    {
        return Excel::download(new OrdersExport, 'rekap-pembelian.xlsx');
    }
}
