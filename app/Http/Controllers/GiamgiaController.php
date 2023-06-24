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
        if (isset($r->dieukiengiamgia)&&$r->dieukiengiamgia == 'phantram') {
            $query->where('tinhnangma', 0);
        } elseif (isset($r->dieukiengiamgia)&&$r->dieukiengiamgia == 'tien') {
            $query->where('tinhnangma', 1);
        } 
        //Tinh trang
        if (isset($r->tinhtrang)&&$r->tinhtrang == 'hethan') {
            $query->where('ngayketthuc','<', $today);
        } elseif (isset($r->tinhtrang)&&$r->tinhtrang == 'conhan') {
            $query->where('ngayketthuc','>=', $today);
        } 
        //Trang thai
        if (isset($r->trangthailoc)&&$r->trangthailoc == 'kichhoat') {
            $query->where('trangthai', 1);
        } elseif (isset($r->trangthailoc)&&$r->trangthailoc == 'khoa') {
            $query->where('trangthai', 0);
        } 
        $coupon = $query->orderBy('idgiamgia','DESC')->paginate(5);
        return view('admin.giamgia.index', ['coupon' => $coupon,'today'=>$today]);
    }
    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tengiamgia' => 'required',
      
            ],
            [
                
                'tengiamgia.required' => 'Chưa nhập tên',
            ]
        );
        if ($validator->passes()) {
            $u=Giamgia::create([
                'tengiamgia'=>$r->tengiamgia,
                'ngaybatdau'=>$r->ngaybatdau,
                'ngayketthuc'=>$r->ngayketthuc,
                'codegiamgia'=>$r->codegiamgia,
                'soluong'=>$r->soluong,
                'tinhnangma'=>$r->tinhnangma,
                'sotiengiam'=>$r->sotiengiam,
                'trangthai'=>$r->trangthai,
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
                
                'tengiamgia' => 'required',
        
            ],
            [
            

                'tengiamgia.required' => 'Chưa nhập tên',
                
            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
        $c = Giamgia::findorfail($r->idgiamgia);
        $c->tengiamgia=$r->tengiamgia;
        $c->ngaybatdau=$r->ngaybatdau;
        $c->ngayketthuc=$r->ngayketthuc;
        $c->codegiamgia=$r->codegiamgia;
        $c->soluong=$r->soluong;
        $c->tinhnangma=$r->tinhnangma;
        $c->sotiengiam=$r->sotiengiam;
        $c->trangthai=$r->trangthai;
      
        $c->save();
        //dd($c);
        return response()->json($c);
    }
    return response()->json(['error' => $validator->errors()]);
    }
    public function destroy($id)
    {
        $data=Giamgia::find($id);
        //dd($data->img);
        
        Giamgia::destroy($id);
        session()->flash('mess', 'đã xóa');
        
        return redirect('/admin/giamgia');
    }
}
