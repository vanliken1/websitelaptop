<?php

namespace App\Http\Controllers;

use App\Models\Donhang;
use App\Models\Sanpham;
use App\Models\Thongke;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    //
    public function index(){
        $sanpham_count=Sanpham::count();
        $users_count=User::where('level',0)->count();
        $order_count=Donhang::count();
        return view('admin.index',['sanpham_count'=>$sanpham_count,'user_count'=>$users_count,'order_count'=>$order_count]); 
    }
    public function filterdate(Request $r){
        $data=$r->all();
        // dd($data);
        $get=Thongke::whereBetween('ngaydat',[$data['tungay'],$data['denngay']])->orderBy('ngaydat','ASC')->get();
        $chart=[];
        foreach($get as $val){
            $chart[]=[
                'khoangngay'=>$val->ngaydat,
                'soluongdaban'=>$val->soluongdaban,
                'doanhthu'=>$val->doanhthu,
                'tongdonhang'=>$val->tongdonhang
            ];
        }
        //dd($chart);
        return response()->json($chart);
    }
    public function filterdate2(Request $r){
        $data=$r->all();
        // dd($data);
        //dd($chart);
        $today=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $dauthangnay=Carbon::now('Asia/Ho_Chi_Minh')->startOfMonth()->toDateString();
        $dauthangtruoc=Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->startOfMonth()->toDateString();
        $cuoithangtruoc=Carbon::now('Asia/Ho_Chi_Minh')->subMonth()->endOfMonth()->toDateString();
        $bayngayqua=Carbon::now('Asia/Ho_Chi_Minh')->subdays(7)->toDateString();
        $motnamqua=Carbon::now('Asia/Ho_Chi_Minh')->subdays(365)->toDateString();
        if($data['value_select']=='7ngay'){
            $get=Thongke::whereBetween('ngaydat',[$bayngayqua,$today])->orderBy('ngaydat','ASC')->get();

        }elseif($data['value_select']=='thangtruoc'){
            $get=Thongke::whereBetween('ngaydat',[$dauthangtruoc,$cuoithangtruoc])->orderBy('ngaydat','ASC')->get();

        }elseif($data['value_select']=='thangnay'){
            $get=Thongke::whereBetween('ngaydat',[$dauthangnay,$today])->orderBy('ngaydat','ASC')->get();

        }else{
            $get=Thongke::whereBetween('ngaydat',[$motnamqua,$today])->orderBy('ngaydat','ASC')->get();

        }
        $chart=[];
        foreach($get as $val){
            $chart[]=[
                'khoangngay'=>$val->ngaydat,
                'soluongdaban'=>$val->soluongdaban,
                'doanhthu'=>$val->doanhthu,
                'tongdonhang'=>$val->tongdonhang
            ];
        }
        return response()->json($chart);
    }
    public function rs30ngayqua(){
       
        // dd($data);
        //dd($chart);
        $bamuoingayqua=Carbon::now('Asia/Ho_Chi_Minh')->subdays(30)->toDateString();
        $today=Carbon::now('Asia/Ho_Chi_Minh')->toDateString();
        $get=Thongke::whereBetween('ngaydat',[$bamuoingayqua,$today])->orderBy('ngaydat','ASC')->get();
        $chart=[];
        foreach($get as $val){
            $chart[]=[
                'khoangngay'=>$val->ngaydat,
                'soluongdaban'=>$val->soluongdaban,
                'doanhthu'=>$val->doanhthu,
                'tongdonhang'=>$val->tongdonhang
            ];
        }
  
        return response()->json($chart);
    }
}
