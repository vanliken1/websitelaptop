<?php

namespace App\Http\Controllers;

use App\Models\Luutru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Validator;

class LuutruController extends Controller
{
    public function index(Request $r){
        $query = Luutru::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tenluutru', "\%" . $r->keyword . "\%")
                    ->orWhere('tenluutru', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $luutru = $query->orderBy('idluutru','DESC')->paginate(5);
        return view('admin.luutru.index',['luutru'=>$luutru]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenluutru' => 'required|max:255|min:3',
                'slug_luutru' => 'required|max:255',
                'motaluutru' => 'required|max:255',
            ],
            [
                
                'tenluutru.required' => 'Vui lòng nhập tên',
                'tenluutru.max' => 'Tên quá dài',
                'tenluutru.min' => 'Tên tối thiểu 3 ký tự',
                'slug_luutru.required' => 'Vui lòng nhập đường dẫn SEO',
                'slug_luutru.max' => 'Đường dẫn SEO quá dài',
                'motaluutru.required' => 'Vui lòng nhập mô tả',
                'motaluutru.max' => 'Mô tả quá dài',
            ]
        );
        if ($validator->passes()) {
            $u=Luutru::create([
                'tenluutru'=>$r->tenluutru,
                'slug_luutru'=>$r->slug_luutru,
                'motaluutru'=>$r->motaluutru,
                'trangthai'=>$r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
       

    }
    public function edit($id)
    {
        $data = Luutru::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tenluutru' => 'required|max:255|min:3',
                'slug_luutru' => 'required|max:255',
                'motaluutru' => 'required|max:255',
        
            ],
            [
                
                'tenluutru.required' => 'Vui lòng nhập tên',
                'tenluutru.max' => 'Tên quá dài',
                'tenluutru.min' => 'Tên tối thiểu 3 ký tự',
                'slug_luutru.required' => 'Vui lòng nhập đường dẫn SEO',
                'slug_luutru.max' => 'Đường dẫn SEO quá dài',
                'motaluutru.required' => 'Vui lòng nhập mô tả',
                'motaluutru.max' => 'Mô tả quá dài',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Luutru::findorfail($request->idluutru);
        $c->tenluutru = $request->tenluutru;
        $c->slug_luutru = $request->slug_luutru;
        $c->motaluutru = $request->motaluutru;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        if(count(Luutru::find($id)->products)==0){
            Luutru::destroy($id);
            session()->flash('mess', 'đã xóa');
        }else{
            session()->flash('error', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/luutru');
    }
}
