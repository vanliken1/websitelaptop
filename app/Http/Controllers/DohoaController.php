<?php

namespace App\Http\Controllers;

use App\Models\Dohoa;
use Illuminate\Http\Request;
use Validator;

class DohoaController extends Controller
{
    public function index(){
        $dohoa=Dohoa::all();
        return view('admin.dohoa.index',['dohoa'=>$dohoa]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tendohoa' => 'required',
      
            ],
            [
                
                'tendohoa.required' => 'Chưa nhập tên',
            ]
        );
        if ($validator->passes()) {
            $u=Dohoa::create([
                'tendohoa'=>$r->tendohoa,
                'slug_dohoa'=>$r->slug_dohoa,
                'motadohoa'=>$r->motadohoa,
                'trangthai'=>$r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
       

    }
    public function edit($id)
    {
        $data = Dohoa::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tendohoa' => 'required',
        
            ],
            [
                

                'tendohoa.required' => 'Chưa nhập tên',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Dohoa::findorfail($request->iddohoa);
        $c->tendohoa = $request->tendohoa;
        $c->slug_dohoa = $request->slug_dohoa;
        $c->motadohoa = $request->motadohoa;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        if(count(Dohoa::find($id)->products)==0){
            Dohoa::destroy($id);
            session()->flash('mess', 'đã xóa');
        }else{
            session()->flash('mess', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/dohoa');
    }
}
