<?php

namespace App\Http\Controllers;

use App\Models\Giamgia;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Validator;

class GiamgiaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    //
    public function index(Request $r)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d H:i:s');
        $query = Giamgia::query();
        //Theo ten và code giam gia
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tengiamgia', "\%" . $r->keyword . "\%")
                    ->orWhere('tengiamgia', 'LIKE', "%" . $r->keyword . "%")
                    ->orWhere('codegiamgia', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        //Dieu kien
        if (isset($r->dieukiengiamgia) && $r->dieukiengiamgia == 'phantram') {
            $query->where('tinhnangma', 0);
        } elseif (isset($r->dieukiengiamgia) && $r->dieukiengiamgia == 'tien') {
            $query->where('tinhnangma', 1);
        }
        //Tinh trang
        if (isset($r->tinhtrang) && $r->tinhtrang == 'hethan') {
            $query->where('ngayketthuc', '<', $today);
        } elseif (isset($r->tinhtrang) && $r->tinhtrang == 'conhan') {
            $query->where('ngayketthuc', '>=', $today);
        }
        //Trang thai
        if (isset($r->trangthailoc) && $r->trangthailoc == 'kichhoat') {
            $query->where('trangthai', 1);
        } elseif (isset($r->trangthailoc) && $r->trangthailoc == 'khoa') {
            $query->where('trangthai', 0);
        }

        $coupon = $query->orderBy('idgiamgia', 'DESC')->paginate(5);
        foreach ($coupon as $item) {
            $dasudungArray = explode(',', $item->dasudung); // Chuyển chuỗi thành mảng dựa trên dấu phẩy
            $dasudungArray = array_filter($dasudungArray);  // Loại bỏ các giá trị rỗng

            $soluongDasudung = count($dasudungArray);

            $item->soluongDasudung = $soluongDasudung; // Thêm trường mới vào mục $coupon để lưu số lượng đã sử dụng
        }
        return view('admin.giamgia.index', ['coupon' => $coupon, 'today' => $today]);
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tengiamgia' => 'required|max:255|min:3',
                'codegiamgia' => 'required|max:255|min:3',
                'ngayketthuc' => 'required|after:today',
                'soluong'=>'numeric|min:1',
                'sotiengiam' => 'numeric|' . ($r->input('tinhnangma') == 0 ? 'max:90|min:1' : 'min:10000'),

            ],
            [

                'tengiamgia.required' => 'Vui lòng nhập tên',
                'tengiamgia.max' => 'Tên quá dài',
                'tengiamgia.min' => 'Tên tối thiểu 3 ký tự',
                'codegiamgia.required' => 'Vui lòng nhập tên code giảm giá',
                'codegiamgia.max' => 'Tên code quá dài',
                'codegiamgia.min' => 'Tên code giảm giá tối thiểu 3 ký tự',
                'ngayketthuc.required' => 'Vui lòng nhập hạn kết thúc',
                'ngayketthuc.after' => 'Hạn kết thúc không hợp lệ',
              
                'soluong.min' => 'Số lượng tối thiểu là 1',
                'sotiengiam.min' => 'Số tiền giảm tối thiểu là :min',
                'sotiengiam.max' => 'Số tiền giảm tối đa là :max',
            ]
        );
        if ($validator->passes()) {
            $u = Giamgia::create([
                'tengiamgia' => $r->tengiamgia,
                'ngayketthuc' => $r->ngayketthuc,
                'codegiamgia' => $r->codegiamgia,
                'soluong' => $r->soluong,
                'tinhnangma' => $r->tinhnangma,
                'sotiengiam' => $r->sotiengiam,
                'trangthai' => $r->trangthai,
            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
    }
    public function edit($id)
    {
        $data = Giamgia::findOrFail($id);
        return response()->json($data);
    }
    public function update(Request $r)
    {
        $validator = Validator::make(
            $r->all(),
            [
                'tengiamgia' => 'required|max:255|min:3',
                'codegiamgia' => 'required|max:255|min:3',
                'ngayketthuc' => 'required|after:today',
                'soluong'=>'numeric|min:1',
                'sotiengiam' => 'numeric|' . ($r->input('tinhnangma') == 0 ? 'max:90|min:1' : 'min:10000'),

            ],
            [


                
                'tengiamgia.required' => 'Vui lòng nhập tên',
                'tengiamgia.max' => 'Tên quá dài',
                'tengiamgia.min' => 'Tên tối thiểu 3 ký tự',
                'codegiamgia.required' => 'Vui lòng nhập tên code giảm giá',
                'codegiamgia.max' => 'Tên code quá dài',
                'codegiamgia.min' => 'Tên code giảm giá tối thiểu 3 ký tự',
                'ngayketthuc.required' => 'Vui lòng nhập hạn kết thúc',
                'ngayketthuc.after' => 'Hạn kết thúc không hợp lệ',
              
                'soluong.min' => 'Số lượng tối thiểu là 1',
                'sotiengiam.min' => 'Số tiền giảm tối thiểu là :min',
                'sotiengiam.max' => 'Số tiền giảm tối đa là :max',

            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
            $c = Giamgia::findorfail($r->idgiamgia);
            $c->tengiamgia = $r->tengiamgia;
            $c->ngayketthuc = $r->ngayketthuc;
            $c->codegiamgia = $r->codegiamgia;
            $c->soluong = $r->soluong;
            $c->tinhnangma = $r->tinhnangma;
            $c->sotiengiam = $r->sotiengiam;
            $c->trangthai = $r->trangthai;

            $c->save();
            //dd($c);
            return response()->json($c);
        }
        return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        $data = Giamgia::find($id);
        //dd($data->img);

        Giamgia::destroy($id);
        session()->flash('mess', 'đã xóa');

        return redirect('/admin/giamgia');
    }
}
