<?php

namespace App\Http\Controllers;

use App\Models\Sanpham;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    //
    public function trangchu(){
        
        return view('clients.index'); 
    }
    public function trangsanpham(){
        $sanpham=Sanpham::leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
                        ->select('sanpham.*', 'chitietkhuyenmai.phantramkhuyenmai','chitietkhuyenmai.trangthaictkm')
                        ->whereNotNull('chitietkhuyenmai.idsanpham')
                        ->orWhereNull('chitietkhuyenmai.idsanpham')
                        ->paginate(12);
        
        // $sanpham=Sanpham::with('chitietkm')->paginate(12);
        return view('clients.home.sanpham',['sanpham'=>$sanpham]); 
    }
   
}
