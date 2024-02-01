<?php

namespace App\Http\Controllers;

use App\Models\SubCtgrProductModel;
use GuzzleHttp\Promise\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

date_default_timezone_set("Asia/Jakarta");
class SubCtgrProductController extends Controller
{
    public function showData(Request $request)
    {
        $queryCtgr = "
            SELECT *
            FROM ctgr_product
            WHERE status = 'Y'
            ORDER BY ctgr_product_code, ctgr_product_name
        ";
        $category = DB::select($queryCtgr);

        $sub_ctgr_product_code = $request->sub_ctgr_product_code;
        $sub_ctgr_product_name = $request->sub_ctgr_product_name;
        $ctgr_product_id = $request->ctgr_product_id;
        $status = $request = $request->status;

        $query = SubCtgrProductModel::query()
            ->select('A.*', 'B.ctgr_product_code', 'B.ctgr_product_name', 'C.name')
            ->from('sub_ctgr_product AS A')
            ->join('ctgr_product AS B', 'A.ctgr_product_id', '=', 'B.ctgr_product_id')
            ->join('users AS C', 'A.record_id', '=', 'C.id')
            ->when($sub_ctgr_product_code, function($query, $sub_ctgr_product_code) {
                return $query->where('A.sub_ctgr_product_code', 'like', '%' .$sub_ctgr_product_code. '%');
            })
            ->when($sub_ctgr_product_name, function($query, $sub_ctgr_product_name) {
                return $query->where('A.sub_ctgr_product_name', 'like', '%' .$sub_ctgr_product_name. '%');
            })
            ->when($ctgr_product_id, function($query, $ctgr_product_id) {
                return $query->where('A.ctgr_product_id', $ctgr_product_id);
            })
            ->when($status, function ($query, $status) {
                return $query->where('A.status', $status);
            })
            ->orderBy('A.sub_ctgr_product_code')
            ->orderBy('A.sub_ctgr_product_name');

        $subCtgr = $query->paginate(50);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM sub_ctgr_product    
            ";

        $total = DB::select($queryCount);

        return view('sub-ctgr-product.index', compact(['category', 'subCtgr', 'total']));
    }

    public function store(Request $request)
    {
        $validate = $this->validate($request, [
            'sub_ctgr_product_code'     => 'required',
            'sub_ctgr_product_name'     => 'required',
            'ctgr_product_id'           => 'required'
        ]);

        $subCtgrProductCode = strtoupper($validate['sub_ctgr_product_code']);
        $subCtgrProductName = strtoupper($validate['sub_ctgr_product_name']);
        $record_id = Auth::id();

        $data = [
            'sub_ctgr_product_code'     => $subCtgrProductCode,
            'sub_ctgr_product_name'     => $subCtgrProductName,
            'ctgr_product_id'           => $validate['ctgr_product_id'],
            'status'                    => 'Y',
            'record_id'                 => $record_id
        ];

        SubCtgrProductModel::create($data);

        return redirect()->route('index.subCtgrProduct')->with('toast_success', 'Data Sub Kategori Produk berhasil ditambahkan!');
    }

    public function editSubCtgr(Request $request, $id) 
    {
        $this->validate($request, [
            'sub_ctgr_product_name' => 'required',
            'ctgr_product_id'       => 'required',
            'status'                => 'required'
        ]);

        $subCtgrName = strtoupper($request->sub_ctgr_product_name);

        $subCtgr = SubCtgrProductModel::find($id);
        if($subCtgr == NULL) {
            return redirect()->route('index.subCtgrProduct')->with('toast_error', 'Data Sub Kategori gagal diubah!');
        } else {
            $subCtgr->update([
                'sub_ctgr_product_name' => $subCtgrName,
                'ctgr_product_id'       => $request->ctgr_product_id,
                'status'                => $request->status,
                'record_id'             => Auth::id()
            ]);

            return redirect()->route('index.subCtgrProduct')->with('toast_success', 'Data Sub Kategori Produk berhasil diubah!');
        }
    }

    public function deleteDataSubCtgr($id) 
    {
        SubCtgrProductModel::find($id)->delete();
        return redirect()->route('index.subCtgrProduct')->with('toast_success', 'Data Sub Kategori Produk berhasil dihapus!');
    }
}
