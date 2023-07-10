<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Validator;

class UserController extends Controller
{
    //
    public function index(Request $r)
    {

        // $users = User::where('level', 0)->get();
        $admin = User::where('level', 1)->get();

        $query = User::query();
        $query2 = User::query();

        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tennguoidung', "\%" . $r->keyword . "\%")
                    ->orWhere('tennguoidung', 'LIKE', "%" . $r->keyword . "%")
                    ->orWhere('email', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        // if (isset($r->keyword2)) {
        //     // dd($r->keyword);
        //     $query2->where('tennguoidung', 'LIKE', "%" . $r->keyword2 . "%")->orWhere('email', 'LIKE', "%" . $r->keyword2 . "%");
        // }
        if (isset($r->keyword2)) {
            $query2->where(function ($query2) use ($r) {
                $query2->whereFullText('tennguoidung', "\%" . $r->keyword2 . "\%")
                    ->orWhere('tennguoidung', 'LIKE', "%" . $r->keyword2 . "%")
                    ->orWhere('email', 'LIKE', "%" . $r->keyword2 . "%");
            });
        }

        $adminql = $query->where('level', '!=', 0)
            ->where('level', '!=', 1)->paginate(5, ['*'], 'adminql_page');
        $users = $query2->where('level', 0)->paginate(5, ['*'], 'user_page');



        return view('admin.users.index', ['users' => $users, 'admin' => $admin, 'adminql' => $adminql]);
    }
    public function store(Request $r)
    {
        $validator = Validator::make(
            $r->all(),
            [
                'tennguoidung' => 'required|min:3|max:255',
                'email' => 'required|unique:nguoidung|max:255|email',
                'password' => 'required|max:50|min:2',
                'sdt' => 'required|digits:10',
                'diachi' => 'required|max:255',
                'level' => 'required'
            ],
            [
                'tennguoidung.required' => 'Vui lòng nhập tên',
                'tennguoidung.min' => 'Tên tối thiểu 3 ký tự',
                'tennguoidung.max' => 'Tên quá dài',
                'email.required' => 'Vui lòng nhập email',
                'email.unique' => 'Email đã tồn tại',
                'email.max' => 'Email quá dài',
                'email.email' => 'Trường này phải là email',
                'password.required' => 'Vui lòng nhập mật khẩu',
                'password.max' => 'Mật khẩu quá dài',
                'password.min' => 'Mật khẩu quá ngắn',
                'sdt.required' => 'Vui lòng nhập sđt',
                'sdt.digits' => 'SĐT không hợp lệ',
                'diachi.required' => 'Vui lòng nhập địa chỉ',
                'diachi.max' => 'Địa chỉ quá dài',
                'level.required' => 'Vui lòng chọn cấp độ',



            ]
        );
        if ($validator->passes()) {
            $u = User::create([
                'tennguoidung' => $r->tennguoidung,
                'email' => $r->email,
                'password' => Hash::make($r->password),
                'sdt' => $r->sdt,
                'diachi' => $r->diachi,
                'level' => $r->level,
                'trangthai' => 1,
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
            $c->level = $request->level;
            $c->trangthai = $request->trangthai;
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

        if (!auth()->check()) {
            return redirect('/dangnhap');
        } else {
            $info = User::findOrFail(auth()->user()->idnguoidung);
            // dd($info->email);
            return view('admin.users.infoadmin', ['nguoidung' => $info]);
        }
    }
    function updateadmin(Request $request)
    {
        // dd($request->email);
        $request->validate(
            [
                'tennguoidung' => 'required|min:3|max:255',
                'sdt' => 'required|digits:10',
                'diachi' => 'required|max:255',
            ],
            [
                'tennguoidung.required' => 'Vui lòng nhập tên',
                'tennguoidung.min' => 'Tên tối thiểu 3 ký tự',
                'tennguoidung.max' => 'Tên quá dài',
                'sdt.required' => 'Vui lòng nhập sđt',
                'sdt.digits' => 'SĐT không hợp lệ',
                'diachi.required' => 'Vui lòng nhập địa chỉ',
                'diachi.max' => 'Địa chỉ quá dài',



            ]
        );
        $c = User::findOrFail(auth()->user()->idnguoidung);

        $c->email = $request->email;
        $c->tennguoidung = $request->tennguoidung;
        $c->sdt = $request->sdt;
        $c->diachi = $request->diachi;
        if ($request->changePassword == "on") {
            $request->validate(
                [


                    'password2' => 'same:password',


                ],
                [


                    'password2.same' => 'Không trùng khớp',

                ]
            );
            $c->password = Hash::make($request->password);
        }

        $c->save();
        session()->flash("mess", "Cập nhật thành công");
        return redirect("/admin/infoadmin");
    }
}
