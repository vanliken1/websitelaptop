<?php

namespace App\Http\Controllers;

use App\Models\Dohoa;
use Illuminate\Http\Request;
use Validator;

class DohoaController extends Controller
{
    public function index(Request $r){
        $query = Dohoa::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tendohoa', "\%" . $r->keyword . "\%")
                    ->orWhere('tendohoa', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $dohoa = $query->orderBy('iddohoa','DESC')->paginate(5);
        return view('admin.dohoa.index',['dohoa'=>$dohoa]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tendohoa' => 'required|max:255|min:3',
                'slug_dohoa' => 'required|max:255',
                'motadohoa' => 'required|max:255',
      
            ],
            [
                
                'tendohoa.required' => 'Vui lòng nhập tên',
                'tendohoa.max' => 'Tên quá dài',
                'tendohoa.min' => 'Tên tối thiểu 3 ký tự',
                'slug_dohoa.required' => 'Vui lòng nhập đường dẫn slug',
                'slug_dohoa.max' => 'Đường dẫn SEO quá dài',
                'motadohoa.required' => 'Vui lòng nhập mô tả',
                'motadohoa.max' => 'Mô tả quá dài',
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
                
                'tendohoa' => 'required|max:255|min:3',
                'slug_dohoa' => 'required|max:255',
                'motadohoa' => 'required|max:255',
        
            ],
            [
                
                'tendohoa.required' => 'Vui lòng nhập tên',
                'tendohoa.max' => 'Tên quá dài',
                'tendohoa.min' => 'Tên tối thiểu 3 ký tự',
                'slug_dohoa.required' => 'Vui lòng nhập đường dẫn slug',
                'slug_dohoa.max' => 'Đường dẫn SEO quá dài',
                'motadohoa.required' => 'Vui lòng nhập mô tả',
                'motadohoa.max' => 'Mô tả quá dài',
                
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
