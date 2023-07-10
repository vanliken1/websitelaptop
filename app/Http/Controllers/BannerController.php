<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Support\Facades\Storage;
class BannerController extends Controller
{
    public function index(Request $r){
        $query = Banner::query();
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tenbanner', "\%" . $r->keyword . "\%")
                    ->orWhere('tenbanner', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $banner = $query->orderBy('idbanner','DESC')->paginate(5);
        return view('admin.banner.index',['banner'=>$banner]); 
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenbanner' => 'required|max:255|min:3',
                'img' => 'required|image',
                'motabanner' => 'required|max:255',
                
      
            ],
            [
                
                'tenbanner.required' => 'Vui lòng nhập tên',
                'tenbanner.max' => 'Tên quá dài',
                'tenbanner.min' => 'Tên tối thiểu 3 ký tự',
                'img.required' => 'Vui lòng nhập hình',
                'img.image' => 'Định dạng hình không hợp lệ',
                'motabanner.required' => 'Vui lòng nhập mô tả',
                'motabanner.max' => 'Mô tả quá dài',
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
                
               
                'tenbanner' => 'required|max:255|min:3',
                'img' => 'image',
                'motabanner' => 'required|max:255',
        
            ],
            [
                

                'tenbanner.required' => 'Vui lòng nhập tên',
                'tenbanner.max' => 'Tên quá dài',
                'tenbanner.min' => 'Tên tối thiểu 3 ký tự',
               
                'img.image' => 'Định dạng hình không hợp lệ',
             
                'motabanner.required' => 'Vui lòng nhập mô tả',
                'motabanner.max' => 'Mô tả quá dài',
                
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
