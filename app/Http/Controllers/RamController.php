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
    public function index(Request $r)
    {
        
        $query = Ram::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tenram', "\%" . $r->keyword . "\%")
                    ->orWhere('tenram', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $ram = $query->orderBy('idram','DESC')->paginate(5);
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
                           
                'tenram' => 'required|max:255|min:3',
                'slug_ram' => 'required|max:255',
                'motaram' => 'required|max:255',
      
            ],
            [
                'tenram.required' => 'Vui lòng nhập tên',
                'tenram.max' => 'Tên quá dài',
                'tenram.min' => 'Tên tối thiểu 3 ký tự',
                'slug_ram.required' => 'Vui lòng nhập đường dẫn slug',
                'slug_ram.max' => 'Đường dẫn SEO quá dài',
                'motaram.required' => 'Vui lòng nhập mô tả',
                'motaram.max' => 'Mô tả quá dài',
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
                
                'tenram' => 'required|max:255|min:3',
                'slug_ram' => 'required|max:255',
                'motaram' => 'required|max:255',
        
            ],
            [
                

                'tenram.required' => 'Vui lòng nhập tên',
                'tenram.max' => 'Tên quá dài',
                'tenram.min' => 'Tên tối thiểu 3 ký tự',
                'slug_ram.required' => 'Vui lòng nhập đường dẫn slug',
                'slug_ram.max' => 'Đường dẫn SEO quá dài',
                'motaram.required' => 'Vui lòng nhập mô tả',
                'motaram.max' => 'Mô tả quá dài',
                
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
