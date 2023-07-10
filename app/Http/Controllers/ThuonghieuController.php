<?php

namespace App\Http\Controllers;

use App\Models\Thuonghieu;
use Illuminate\Http\Request;
use Validator;

class ThuonghieuController extends Controller
{
    //
    public function index(Request $r)
    {
        $query = Thuonghieu::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tenthuonghieu', "\%" . $r->keyword . "\%")
                    ->orWhere('tenthuonghieu', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $thuonghieu = $query->orderBy('idthuonghieu','DESC')->paginate(5);

    
        return view('admin.thuonghieu.index', ['thuonghieu' => $thuonghieu]);
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenthuonghieu' => 'required|max:255|min:3',
                'slug_thuonghieu' => 'required|max:255',
                'motathuonghieu' => 'required|max:255',
            ],
            [

                'tenthuonghieu.required' => 'Vui lòng nhập tên',
                'tenthuonghieu.max' => 'Tên quá dài',
                'tenthuonghieu.min' => 'Tên tối thiểu 3 ký tự',
                'slug_thuonghieu.required' => 'Vui lòng nhập đường dẫn SEO',
                'slug_thuonghieu.max' => 'Đường dẫn SEO quá dài',
                'motathuonghieu.required' => 'Vui lòng nhập mô tả',
                'motathuonghieu.max' => 'Mô tả quá dài',
            ]
        );
        if ($validator->passes()) {
            $u = Thuonghieu::create([
                'tenthuonghieu' => $r->tenthuonghieu,
                'slug_thuonghieu' => $r->slug_thuonghieu,
                'motathuonghieu' => $r->motathuonghieu,
                'trangthai' => $r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
    }
    public function edit($id)
    {
        $data = Thuonghieu::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'tenthuonghieu' => 'required',
                'slug_thuonghieu' => 'required|max:255',
                'motathuonghieu' => 'required|max:255',

            ],
            [


                'tenthuonghieu.required' => 'Vui lòng nhập tên',
                'slug_thuonghieu.required' => 'Vui lòng nhập đường dẫn SEO',
                'slug_thuonghieu.max' => 'Đường dẫn SEO quá dài',
                'motathuonghieu.required' => 'Vui lòng nhập mô tả',
                'motathuonghieu.max' => 'Mô tả quá dài',

            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
            $c = Thuonghieu::findorfail($request->idthuonghieu);
            $c->tenthuonghieu = $request->tenthuonghieu;
            $c->slug_thuonghieu = $request->slug_thuonghieu;
            $c->motathuonghieu = $request->motathuonghieu;
            $c->trangthai = $request->trangthai;

            $c->save();
            //dd($c);
            return response()->json($c);
        }
        return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        if (count(Thuonghieu::find($id)->products) == 0) {
            Thuonghieu::destroy($id);
            session()->flash('mess', 'đã xóa');
        } else {
            session()->flash('error', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/brand');
    }
}
