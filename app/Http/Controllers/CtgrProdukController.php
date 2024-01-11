<?php

namespace App\Http\Controllers;

use App\Models\CtgrProductModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

date_default_timezone_set("Asia/Jakarta");
class CtgrProdukController extends Controller
{
    public function showData(Request $request)
    {
        $ctgr_product_code = $request->ctgr_product_code;
        $ctgr_product_name = $request->ctgr_product_name;
        $status = $request->status;

        $query = CtgrProductModel::query()
            ->select('A.*', 'B.name')
            ->from('ctgr_product AS A')
            ->join('users AS B', 'A.record_id', '=', 'B.id')
            ->when($ctgr_product_code, function ($query, $ctgr_product_code) {
                return $query->where('A.ctgr_product_code', 'like', '%' . $ctgr_product_code . '%');
            })
            ->when($ctgr_product_name, function ($query, $ctgr_product_name) {
                return $query->where('A.ctgr_product_name', 'like', '%' . $ctgr_product_name . '%');
            })
            ->when($status, function ($query, $status) {
                return $query->where('A.status', $status);
            })
            ->orderBy('A.ctgr_product_code', 'ASC')
            ->orderBy('A.ctgr_product_name', 'ASC');

        $kategori = $query->paginate(50);

        $queryCount = "
            SELECT COUNT(1) AS totalData
            FROM ctgr_product    
            ";

        $total = DB::select($queryCount);

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('ctgr-produk.index', compact(['kategori', 'total']));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'ctgr_product_code' => ['required', Rule::unique('ctgr_product', 'ctgr_product_code')],
            'ctgr_product_name' => 'required'
        ]);

        $ctgr_product_code = strtoupper($validate['ctgr_product_code']);
        $ctgr_product_name = strtoupper($validate['ctgr_product_name']);
        $record_id = Auth::id();

        $data = [
            'ctgr_product_code'     => $ctgr_product_code,
            'ctgr_product_name'     => $ctgr_product_name,
            'status'                => 'Y',
            'record_id'             => $record_id
        ];

        $CtgrProduct = CtgrProductModel::create($data);

        return redirect()->route('index.ctgrProduct')->with('toast_success', 'Data Kategori Produk berhasil ditambahkan!');
    }

    public function updateDataCtgr(Request $request, $id)
    {
        $this->validate($request, [
            'ctgr_product_name' => 'required',
            'status'            => 'required'
        ]);

        $ctgr_product_name = strtoupper($request->ctgr_product_name);

        $ctgrProduct = CtgrProductModel::find($id);

        if ($ctgrProduct == null) {
            return redirect()->route('index.ctgrProduct')->with('toast_error', 'Data Kategori gagal diubah!');
        } else {
            $ctgrProduct->update([
                'ctgr_product_name' => $ctgr_product_name,
                'status'            => $request->status,
                'record_id'         => Auth::id()
            ]);
            return redirect()->route('index.ctgrProduct')->with('toast_success', 'Data Kategori Produk berhasil diubah!');
        }
    }

    public function deleteDataCtgr($id)
    {
        CtgrProductModel::find($id)->delete();
        return redirect()->route('index.ctgrProduct')->with('toast_success', 'Data Kategori Produk berhasil dihapus!');
    }
}
