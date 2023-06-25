<?php

namespace App\Http\Controllers;

use App\Models\Manhinh;
use Illuminate\Http\Request;
use Validator;

class ManhinhController extends Controller
{
    public function index(Request $r){
        $query = Manhinh::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tenmanhinh', "\%" . $r->keyword . "\%")
                    ->orWhere('tenmanhinh', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $manhinh = $query->orderBy('idmanhinh','DESC')->paginate(5);
        return view('admin.manhinh.index',['manhinh'=>$manhinh]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenmanhinh' => 'required|max:255|min:3',
                'slug_manhinh' => 'required|max:255',
                'motamanhinh' => 'required|max:255',
      
            ],
            [
                
                'tenmanhinh.required' => 'Vui lòng nhập tên',
                'tenmanhinh.max' => 'Tên quá dài',
                'tenmanhinh.min' => 'Tên tối thiểu 3 ký tự',
                'slug_manhinh.required' => 'Vui lòng nhập đường dẫn slug',
                'slug_manhinh.max' => 'Đường dẫn SEO quá dài',
                'motamanhinh.required' => 'Vui lòng nhập mô tả',
                'motamanhinh.max' => 'Mô tả quá dài',
            ]
        );
        if ($validator->passes()) {
            $u=Manhinh::create([
                'tenmanhinh'=>$r->tenmanhinh,
                'slug_manhinh'=>$r->slug_manhinh,
                'motamanhinh'=>$r->motamanhinh,
                'trangthai'=>$r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
       

    }
    public function edit($id)
    {
        $data = Manhinh::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tenmanhinh' => 'required|max:255|min:3',
                'slug_manhinh' => 'required|max:255',
                'motamanhinh' => 'required|max:255',
        
            ],
            [
                
                'tenmanhinh.required' => 'Vui lòng nhập tên',
                'tenmanhinh.max' => 'Tên quá dài',
                'tenmanhinh.min' => 'Tên tối thiểu 3 ký tự',
                'slug_manhinh.required' => 'Vui lòng nhập đường dẫn slug',
                'slug_manhinh.max' => 'Đường dẫn SEO quá dài',
                'motamanhinh.required' => 'Vui lòng nhập mô tả',
                'motamanhinh.max' => 'Mô tả quá dài',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Manhinh::findorfail($request->idmanhinh);
        $c->tenmanhinh = $request->tenmanhinh;
        $c->slug_manhinh = $request->slug_manhinh;
        $c->motamanhinh = $request->motamanhinh;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        if(count(Manhinh::find($id)->products)==0){
            Manhinh::destroy($id);
            session()->flash('mess', 'đã xóa');
        }else{
            session()->flash('mess', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/manhinh');
    }
}
