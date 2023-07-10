<?php

namespace App\Http\Controllers;

use App\Models\CPU;
use Illuminate\Http\Request;
use Validator;

class CpuController extends Controller
{
    public function index(Request $r){
        $query = CPU::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tenCPU', "\%" . $r->keyword . "\%")
                    ->orWhere('tenCPU', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $cpu = $query->orderBy('idCPU','DESC')->paginate(5);
        return view('admin.cpu.index',['cpu'=>$cpu]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenCPU' => 'required|max:255|min:3',
                'slug_CPU' => 'required|max:255',
                'mota_CPU' => 'required|max:255',
      
            ],
            [
                
                              
                'tenCPU.required' => 'Vui lòng nhập tên',
                'tenCPU.max' => 'Tên quá dài',
                'tenCPU.min' => 'Tên tối thiểu 3 ký tự',
                'slug_CPU.required' => 'Vui lòng nhập đường dẫn SEO',
                'slug_CPU.max' => 'Đường dẫn SEO quá dài',
                'mota_CPU.required' => 'Vui lòng nhập mô tả',
                'mota_CPU.max' => 'Mô tả quá dài',
            ]
        );
        if ($validator->passes()) {
            $u=CPU::create([
                'tenCPU'=>$r->tenCPU,
                'slug_CPU'=>$r->slug_CPU,
                'mota_CPU'=>$r->mota_CPU,
                'trangthai'=>$r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
       

    }
    public function edit($id)
    {
        $data = CPU::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tenCPU' => 'required|max:255|min:3',
                'slug_CPU' => 'required|max:255',
                'mota_CPU' => 'required|max:255',
        
            ],
            [
                

                'tenCPU.required' => 'Vui lòng nhập tên',
                'tenCPU.max' => 'Tên quá dài',
                'tenCPU.min' => 'Tên tối thiểu 3 ký tự',
                'slug_CPU.required' => 'Vui lòng nhập đường dẫn SEO',
                'slug_CPU.max' => 'Đường dẫn SEO quá dài',
                'mota_CPU.required' => 'Vui lòng nhập mô tả',
                'mota_CPU.max' => 'Mô tả quá dài',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = CPU::findorfail($request->idCPU);
        $c->tenCPU = $request->tenCPU;
        $c->slug_CPU = $request->slug_CPU;
        $c->mota_CPU = $request->mota_CPU;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        if(count(CPU::find($id)->products)==0){
            CPU::destroy($id);
            session()->flash('mess', 'đã xóa');
        }else{
            session()->flash('error', 'không thể xóa vì có sản phẩm');
        }
        return redirect('/admin/cpu');
    }
}
