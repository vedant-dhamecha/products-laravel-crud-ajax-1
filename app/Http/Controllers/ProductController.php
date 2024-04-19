<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Datatables;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            //return datatables()->of(Product::select('*'))
            return datatables()->of(Product::select('id', 'employeeNumber', 'operatorName', 'quarPriv', 'taskPriv', 'pickOverridePriv', 'created_by', 'is_active', 'created_at'))
                ->editColumn('created_at', function ($request) {
                    return $request->created_at->format('d-m-Y H:i'); // format date time
                })
                ->addColumn('action', 'products.product-action')
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }
        return view('products.products');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $productId = $request->id;

        $request->validate([
            'operatorName' => 'required',
            'employeeNumber' => 'required',
            'quarPriv' => 'required',
            'taskPriv' => 'required',
            'pickOverridePriv' => 'required',
            'is_active' => 'required',
        ]);

        $product = Product::updateOrCreate(
            [
                'id' => $productId
            ],
            [
                'operatorName' => $request->operatorName,
                'employeeNumber' => $request->employeeNumber,
                'quarPriv' => $request->quarPriv,
                'taskPriv' => $request->taskPriv,
                'pickOverridePriv' => $request->pickOverridePriv,
                'is_active' => $request->is_active,

            ]
        );

        return Response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $product  = Product::where($where)->first();

        return Response()->json($product);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::where('id', $request->id)->delete();

        return Response()->json($product);
    }
}
