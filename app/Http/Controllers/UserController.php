<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;
class UserController extends Controller
{
    //
    public function index(){
        $users=User::where('level',0)->get();
        $admin=User::where('level',1)->get();
        $adminql=User::where('level', '!=', 0)
                ->where('level', '!=', 1)
                ->get();
        return view('admin.users.index',['users'=>$users,'admin'=>$admin,'adminql'=>$adminql]); 
    }
    public function store(Request $r)
    {
        $validator = Validator::make(
            $r->all(),
            [
                'tennguoidung' => 'required',
                'level' => 'required'
            ],
            [
                'tennguoidung.required' => 'Chưa nhập tên',
                
            ]
        );
        if ($validator->passes()) {
            $u = User::create([
                'tennguoidung'=>$r->tennguoidung,
                'email'=>$r->email,
                'password'=>Hash::make($r->password),
                'sdt'=>$r->sdt,
                'diachi'=>$r->diachi,
                'level'=>$r->level,
                'trangthai'=>1,
            ]);
            return response()->json($u);
        }
        return response()->json(['error' => $validator->errors()]);
    }
    public function edit($id)
    {
        $data = User::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                
                'level' => 'required'
        
            ],
            [
                

                'level.required' => 'Chưa chọn cấp độ',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = User::findorfail($request->idnguoidung);
        $c->level= $request->level;
        $c->trangthai=$request->trangthai;
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    // public function destroy($id)
    // {
    //     if(count(User::find($id)->orders)==0&&count(User::find($id)->social)==0){
    //         User::destroy($id);
    //         session()->flash('thongbao', 'đã xóa');
    //     }else{
    //         session()->flash('thongbao', 'Admin này không thể xóa.Vui lòng xem xét lại');
    //     }
    //     return redirect('/admin/users');
    // }
    function infoadmin()
    {

        if(!auth()->check()){
            return redirect('/dangnhap');
        }else{
            $info=User::findOrFail(auth()->user()->idnguoidung);
            // dd($info->email);
            return view('admin.users.infoadmin',['nguoidung'=>$info]);

        }
        
       
    }
    function updateadmin(Request $request)
    {
        // dd($request->email);
        
        $c=User::findOrFail(auth()->user()->idnguoidung);
   
        $c->email=$request->email;
        $c->tennguoidung = $request->tennguoidung;
        $c->sdt= $request->sdt;
        $c->diachi = $request->diachi;
      
        $c->save();
        session()->flash("mess","Cập nhật thành công");
        return redirect("/admin/infoadmin");
    }
}
