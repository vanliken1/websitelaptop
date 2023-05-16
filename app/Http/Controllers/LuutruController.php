<?php

namespace App\Http\Controllers;

use App\Models\Luutru;
use Illuminate\Http\Request;
use Validator;

class LuutruController extends Controller
{
    public function index(){
        $luutru=Luutru::all();
        return view('admin.luutru.index',['luutru'=>$luutru]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenluutru' => 'required',
      
            ],
            [
                
                'tenluutru.required' => 'Chưa nhập tên',
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
                
                'tenluutru' => 'required',
        
            ],
            [
                

                'tenluutru.required' => 'Chưa nhập tên',
                
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
            session()->flash('mess', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/luutru');
    }
}
