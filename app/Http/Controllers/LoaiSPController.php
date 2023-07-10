<?php

namespace App\Http\Controllers;

use App\Models\Loaisp;
use Illuminate\Http\Request;
use Validator;
class LoaiSPController extends Controller
{
    //
    public function index(Request $r){
        
        $query = Loaisp::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tenloai', "\%" . $r->keyword . "\%")
                    ->orWhere('tenloai', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $loaisp = $query->orderBy('idloaisanpham','DESC')->paginate(5);
        return view('admin.Loaisp.index',['loaisp'=>$loaisp]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenloai' => 'required|max:255|min:3',
                'slug_loai' => 'required|max:255',
                'motaloai' => 'required|max:255',
      


            ],
            [
                'tenloai.required' => 'Vui lòng nhập tên',
                'tenloai.max' => 'Tên quá dài',
                'tenthuonghieu.min' => 'Tên tối thiểu 3 ký tự',
                'slug_loai.required' => 'Vui lòng nhập đường dẫn SEO',
                'slug_loai.max' => 'Đường dẫn SEO quá dài',
                'motaloai.required' => 'Vui lòng nhập mô tả',
                'motaloai.max' => 'Mô tả quá dài',
            ]
        );
        if ($validator->passes()) {
            $u=Loaisp::create([
                'tenloai'=>$r->tenloai,
                'slug_loai'=>$r->slug_loai,
                'motaloai'=>$r->motaloai,
                'trangthai'=>$r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
    }
    public function edit($id)
    {
        $data = Loaisp::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tenloai' => 'required|max:255|min:3',
                'slug_loai' => 'required|max:255',
                'motaloai' => 'required|max:255',
                


            ],
            [
                
                
                'tenloai.required' => 'Vui lòng nhập tên',
                'tenloai.max' => 'Tên quá dài',
                'tenthuonghieu.min' => 'Tên tối thiểu 3 ký tự',
                'slug_loai.required' => 'Vui lòng nhập đường dẫn SEO',
                'slug_loai.max' => 'Đường dẫn SEO quá dài',
                'motaloai.required' => 'Vui lòng nhập mô tả',
                'motaloai.max' => 'Mô tả quá dài',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Loaisp::findorfail($request->idloaisanpham);
        $c->tenloai = $request->tenloai;
        $c->slug_loai = $request->slug_loai;
        $c->motaloai = $request->motaloai;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        if(count(Loaisp::find($id)->products)==0){
            Loaisp::destroy($id);
            session()->flash('mess', 'đã xóa');
        }else{
            session()->flash('error', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/category');
    }
}
