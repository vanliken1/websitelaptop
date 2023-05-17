<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
class BannerController extends Controller
{
    public function index(){
        $banner = Banner::all();
        return view('admin.banner.index',['banner'=>$banner]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenbanner' => 'required',
      
            ],
            [
                
                'tenbanner.required' => 'Chưa nhập tên',
            ]
        );
        if ($validator->passes()) {
            $data=$r->all();
            if($r->img != null){
            $img = $data['idbanner'] . '-' . $r->img->getClientOriginalName();
            $data['img'] = $img;
            $r->img->storeAs('public/img', $img);
            }
            
            $u= Banner::create($data);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
       

    }
    public function edit($id)
    {
        $data = Banner::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'tenbanner' => 'required',
        
            ],
            [
                

                'tenbanner.required' => 'Chưa nhập tên',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Banner::findorfail($request->idbanner);
        $temp=$c->img;
        if ($request->img != null) {
            Storage::disk('local')->delete("public/img/$temp");
            $img = $c['idbanner'] . '-' . $request->img->getClientOriginalName();
            $c['img'] = $img;
            $request->img->storeAs('public/img', $img);
        }
        $c->tenbanner = $request->tenbanner;
    
        $c->motabanner = $request->motabanner;
        $c->trangthai= $request->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        $data=Banner::find($id);
        //dd($data->img);
        
        Storage::disk('local')->delete("public/img/$data->img");
        Banner::destroy($id);
        session()->flash('mess', 'đã xóa');
        
        return redirect('/admin/banner');
    }
}
