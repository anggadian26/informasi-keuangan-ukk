<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use App\Models\StokModel;
use App\Models\SubCtgrProductModel;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

date_default_timezone_set("Asia/Jakarta");
class ProdukController extends Controller
{
    public function showData(Request $request)
    {
        $queryCtgr = "
            SELECT *
            FROM ctgr_product
            WHERE status = 'Y'
        ";
        $ctgr_product = DB::select($queryCtgr);

        $querySubCtgr = "
            SELECT *
            FROM sub_ctgr_product
            WHERE status = 'Y'
        ";
        $sub_ctgr_product = DB::select($querySubCtgr);

        $product_code = $request->product_code;
        $product_name = $request->product_name;
        $ctgr_product_id = $request->ctgr_product_id;
        $sub_ctgr_product_id = $request->sub_ctgr_product_id;
        $status = $request->status;

        $query = ProductModel::query()
            ->select('A.*', 'B.ctgr_product_id', 'B.sub_ctgr_product_name', 'C.ctgr_product_name', 'D.name', 'E.total_stok')
            ->from('product AS A')
            ->join('sub_ctgr_product AS B', 'A.sub_ctgr_product_id', '=', 'B.sub_ctgr_product_id')
            ->join('ctgr_product AS C', 'B.ctgr_product_id', '=', 'C.ctgr_product_id')
            ->join('users AS D', 'A.record_id', '=', 'D.id')
            ->join('stok AS E', 'A.product_id', '=', 'E.product_id')
            ->when($product_code, function($query, $product_code) {
                return $query->where('A.product_code', 'like', '%' .$product_code. '%');
            })
            ->when($product_name, function($query, $product_name) {
                return $query->where('A.product_name', 'like', '%' .$product_name. '%');
            })
            ->when($sub_ctgr_product_id, function($query, $sub_ctgr_product_id) {
                return $query->where('A.sub_ctgr_product_id', '=', $sub_ctgr_product_id);
            })
            ->when($ctgr_product_id, function($query, $ctgr_product_id) {
                return $query->where('B.ctgr_product_id', '=', $ctgr_product_id);
            })
            ->when($status, function($query, $status) {
                return $query->where('A.status', '=', $status);
            })
            ->orderBy('A.product_code')
            ->orderBy('A.product_name')
            ->orderBy('B.sub_ctgr_product_name');

        $product = $query->paginate(50);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM product";

        $total = DB::select($queryCount);

        return view('produk.index', compact(['ctgr_product', 'sub_ctgr_product', 'product', 'total']));
    }

    public function addProductPage() 
    {
        $querySubCtgr = "
            SELECT *
            FROM sub_ctgr_product
            WHERE status = 'Y'
        ";

        $subCtgr = DB::select($querySubCtgr);
        return view('produk.addProduct', compact(['subCtgr']));
    }

    public function addProductAction(Request $request)
    {
        $val = $request->validate([
            'sub_ctgr_product_id'   => 'required',
            'product_code'          => 'required',
            'product_name'          => 'required',
            'merek'                 => 'required',
            'product_purcase'       => 'required',
            'product_price'         => 'required',
        ]);


        $product_code = strtoupper($val['product_code']);
        $product_name = $val['product_name'];
        $user_id = Auth::user()->id;

        $data = [
            'sub_ctgr_product_id'   => $val['sub_ctgr_product_id'],
            'product_code'          => $product_code,
            'product_name'          => $product_name,
            'merek'                 => $val['merek'],
            'product_purcase'       => $val['product_purcase'],
            'product_price'         => $val['product_price'],
            'status'                => 'Y',
            'record_id'             => $user_id
        ];

        $product = ProductModel::create($data);

        $stokData = [
            'product_id'        => $product->product_id,
            'total_stok'        => 0,
            'update_stok_date'  => Carbon::now()->toDateString()
        ];

        StokModel::create($stokData);

        return redirect()->route('index.produk')->with('toast_success', 'Data Produk berhasil ditambahkan!');
    }

    public function editProductPage($id)
    {
        $product = ProductModel::find($id);
        $subCtgr = SubCtgrProductModel::all();

        return view('produk.editProduct', compact(['product', 'subCtgr']));
    }

    public function editProductAction(Request $request, $id) 
    {
        $val = $request->validate([
            'sub_ctgr_product_id'   => 'required',
            'product_name'          => 'required',
            'merek'                 => 'required',
            'product_purcase'       => 'required',
            'product_price'         => 'required',
            'status'                => 'required'
        ]);

        $product = ProductModel::find($id);
        $user_id = Auth::user()->id;

        $product->update([
            'sub_ctgr_product_id'   => $request->sub_ctgr_product_id,
            'product_name'          => $request->product_name,
            'merek'                 => $val['merek'],
            'product_purcase'       => $val['product_purcase'],
            'product_price'         => $val['product_price'],
            'status'                => $request->status,
            'record_id'             => $user_id
        ]);

        return redirect()->route('index.produk')->with('toast_success', 'Data Produk berhasil diubah!');
    }

    public function deleteProductAction($id) 
    {
        $product = ProductModel::find($id);
        
        if($product){
            $stok = StokModel::where('product_id', $product->product_id)->first();

            if($stok) {
                $stok->delete();
            }

            $product->delete();
        }
        return redirect()->route('index.produk')->with('toast_success', 'Data Produk berhasil dihapus!');
    }
}
