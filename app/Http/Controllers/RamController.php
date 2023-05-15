<?php

namespace App\Http\Controllers;

use App\Models\Ram;
use Illuminate\Http\Request;
use Validator;


class RamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $ram=Ram::all();
        return view('admin.ram.index',['ram'=>$ram]); 
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $r)
    {
        $validator = Validator::make(
            $r->all(),
            [
                'tenram' => 'required',
      
            ],
            [
                'tenram.required' => 'Chưa nhập tên',
            ]
        );
        if ($validator->passes()) {
            $u = Ram::create([
                'tenram'=>$r->tenram,
                'slug_ram'=>$r->slug_ram,
                'motaram'=>$r->motaram,
                'trangthai'=>$r->trangthai,
            ]);
            return response()->json($u);
        }
        return response()->json(['error' => $validator->errors()]);
    }

    
    public function edit($id)
    {
        $data = Ram::findOrFail($id);
        return response()->json($data);
    }

    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tenram' => 'required',
        
            ],
            [
                

                'tenram.required' => 'Chưa nhập tên',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Ram::findorfail($request->idram);
        $c->tenram = $request->tenram;
        $c->slug_ram = $request->slug_ram;
        $c->motaram = $request->motaram;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }

    public function destroy($id)
    {
        if(count(Ram::find($id)->products)==0){
            Ram::destroy($id);
            session()->flash('mess', 'đã xóa');
        }else{
            session()->flash('mess', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/ram');
    }
}
