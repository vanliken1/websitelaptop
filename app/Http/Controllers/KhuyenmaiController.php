<?php

namespace App\Http\Controllers;

use App\Models\Chitietkhuyenmai;
use App\Models\Khuyenmai;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Validator;
use DB;
use Carbon\Carbon;

class KhuyenmaiController extends Controller
{
    public function index(Request $r)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d ');
        // $loc = Khuyenmai::join('chitietkhuyenmai', 'khuyenmai.idkhuyenmai', '=', 'chitietkhuyenmai.idkhuyenmai')
        //     ->select('khuyenmai.*','chitietkhuyenmai.*')
        //     ->get();
        // foreach($loc as $item){
        //     dd($item->trangthaictkm);
        // }
        //dd($loc);    
        $query = Khuyenmai::query();
        $selectedDays = null;
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('tenkhuyenmai', "\%" . $r->keyword . "\%")
                    ->orWhere('tenkhuyenmai', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        if (isset($r->tu_ngay)) {
            $selectedDays = $r->tu_ngay;
            $query->where(function ($query) use ($r) {
                $query->where('ngaybatdau', '<=', $r->tu_ngay)
                    ->where('ngayketthuc', '>=', $r->tu_ngay);
            });
        }
        $khuyenmai = $query->orderBy('idkhuyenmai', 'DESC')->paginate(5);




        return view('admin.khuyenmai.index', ['khuyenmai' => $khuyenmai, 'today' => $today, 'selectedDays' => $selectedDays]);
    }
    public function storekm(Request $r)
    {
        // $data = $r->all();
        //dd($data);
        $validator = Validator::make(
            $r->all(),
            [
                'phantramkhuyenmai' => 'required',
                'idsanpham' => 'required',

            ],
            [

                'phantramkhuyenmai.required' => 'Chưa nhập tên',
                'idsanpham.required' => 'Không tồn tại sản phẩm',
            ]
        );
        if ($validator->passes()) {
            // $u = Chitietkhuyenmai::create($data);
            // dd($u);


            $u = Chitietkhuyenmai::create([
                'idkhuyenmai' => $r->idkhuyenmai,
                'phantramkhuyenmai' => $r->phantramkhuyenmai,
                'idsanpham' => $r->idsanpham,
                'trangthaictkm' => $r->trangthai,
            ]);
            $sanpham = Sanpham::find($r->idsanpham);
            if ($sanpham && $u->trangthaictkm == 1) {
                // Cập nhật giá khuyến mãi của sản phẩm
                $sanpham->giakhuyenmai = $sanpham->gia - ($sanpham->gia * ($u->phantramkhuyenmai / 100));
                $sanpham->save();
            } else {
                $sanpham->giakhuyenmai = $sanpham->gia;
                $sanpham->save();
            }
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
    }
    public function update(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'tenkhuyenmai' => 'required',
                'ngaybatdau' => 'after_or_equal:today',
                'ngayketthuc' => 'after:ngaybatdau',

            ],
            [


                'tenkhuyenmai.required' => 'Chưa nhập tên',
                'ngaybatdau.after_or_equal' => 'Ngày bắt đầu phải là ngày hiện tại hoặc sau đó',
                'ngayketthuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu và ngày hôm nay'

            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
            $ct = Chitietkhuyenmai::where('idkhuyenmai', $request->idkhuyenmai)->get();
            //dd($ct);
            if ($ct->isEmpty()) {
                $c = Khuyenmai::findorfail($request->idkhuyenmai);
                $c->tenkhuyenmai = $request->tenkhuyenmai;
                $c->ngaybatdau = $request->ngaybatdau;
                $c->ngayketthuc = $request->ngayketthuc;
                $c->save();
                session()->flash("mess", "Sua thanh cong");
                //dd($c);
                return response()->json();
            } else {
                foreach ($ct as $item) {
                    $sp[] = $item->idsanpham;
                }
                //dd($sp);
                foreach ($sp as $i) {
                    $k1 = Chitietkhuyenmai::where('idsanpham', $i)->where('trangthaictkm', '!=', '0')->where('idkhuyenmai', '!=', $request->idkhuyenmai)->get();
                    //dd($k1);
                    // if ($k1->isEmpty()) {
                    //     $a[] = ['idkhuyenmai' => '', 'idsanpham' => $i];
                    // } else {
                    foreach ($k1 as $i) {
                        $a[] =  $i->idkhuyenmai;
                    }
                    // }

                }
                $a = array_unique($a);
                //dd($a);
                foreach ($a as $i) {
                    $km = Khuyenmai::where('idkhuyenmai', $i)->first();
                    //dd($km['idkhuyenmai']);
                    $b[] = [
                        'idkhuyenmai' => $km['idkhuyenmai'],
                        'ngaybatdau' => $km['ngaybatdau'],
                        'ngayketthuc' => $km['ngayketthuc'],
                    ];
                }
                //dd($b);
                $kiemtra = [];
                foreach ($b as $i) {
                    //dd($i['ngaybatdau']);
                    if ($i['ngaybatdau'] >= $request->ngaybatdau && $i['ngayketthuc'] <= $request->ngayketthuc) {
                        // if($i['trangthaictkm'] == 2){
                        $kiemtra[] = [
                            'idkhuyenmai' => $i['idkhuyenmai'],
                            'check' => 'datbiet'
                        ];
                    } elseif ($i['ngaybatdau'] <= $request->ngaybatdau && $i['ngayketthuc'] >= $request->ngayketthuc) { // 7 15 16 20 
                        // if ($i['trangthaictkm'] == 2) {
                        $kiemtra[] = [
                            'idkhuyenmai' => $i['idkhuyenmai'],
                            'check' => 'datbiet'
                        ];
                    } elseif ($i['ngaybatdau'] < $request->ngaybatdau && $i['ngayketthuc'] < $request->ngayketthuc) { ///($i['ngayketthuc'] < $km->ngaybatdau && $i['ngayketthuc'] < $km->ngayketthuc )
                        if ($i['ngaybatdau'] < $request->ngaybatdau && $i['ngayketthuc'] > $request->ngaybatdau) {
                            $kiemtra[] = [
                                'idkhuyenmai' => $i['idkhuyenmai'],
                                'check' => 'datbiet'
                            ];
                        } elseif ($i['ngaybatdau'] == $request->ngaybatdau || $i['ngaybatdau'] == $request->ngayketthuc || $i['ngayketthuc'] == $request->ngaybatdau || $i['ngayketthuc'] == $request->ngayketthuc) {
                            $kiemtra[] = [
                                'idkhuyenmai' => $i['idkhuyenmai'],
                                'check' => 'datbiet'
                            ];
                        }
                    } elseif (($i['ngaybatdau'] > $request->ngaybatdau && $i['ngayketthuc'] > $request->ngayketthuc)) {  /// 7 15 16 20 
                        if ($i['ngaybatdau'] > $request->ngaybatdau && $i['ngaybatdau'] < $request->ngayketthuc) {
                            $kiemtra[] = [
                                'idkhuyenmai' => $i['idkhuyenmai'],
                                'check' => 'datbiet'
                            ];
                        } elseif ($i['ngaybatdau'] == $request->ngaybatdau || $i['ngaybatdau'] == $request->ngayketthuc || $i['ngayketthuc'] == $request->ngaybatdau || $i['ngayketthuc'] == $request->ngayketthuc) {
                            $kiemtra[] = [
                                'idkhuyenmai' => $i['idkhuyenmai'],
                                'check' => 'datbiet'
                            ];
                        }
                    }
                }
                //dd($kiemtra);
                if (empty($kiemtra)) {
                    //dd('sua');
                    $c = Khuyenmai::findorfail($request->idkhuyenmai);
                    $c->tenkhuyenmai = $request->tenkhuyenmai;
                    $c->ngaybatdau = $request->ngaybatdau;
                    $c->ngayketthuc = $request->ngayketthuc;
                    $c->save();
                    session()->flash("mess", "Sua thanh cong");
                    //dd($c);
                    return response()->json();
                } else {
                    foreach ($kiemtra as $item) {
                        $bien[] = $item['idkhuyenmai'];
                    }
                    return response()->json(['loi' => $bien]);
                    //session()->flash("errors", $bien);

                }
            }
            //$ngayBatDauFormatted = date_format($ngayBatDauObj, "d/m/Y")
            // $c = Khuyenmai::findorfail($request->idkhuyenmai);
            // $c->tenkhuyenmai = $request->tenkhuyenmai;
            // $c->ngaybatdau = $request->ngaybatdau;
            // $c->ngayketthuc = $request->ngayketthuc;


            // $c->save();
            // //dd($c);
            // return response()->json();
        }
        return response()->json(['error' => $validator->errors()]);
    }
    public function updatekm(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [

                'phantramkhuyenmai' => 'required|numeric|min:5|max:100',
            ],
            [


                'phantramkhuyenmai.required' => 'Vui lòng nhập phần trăm khuyến mãi',
                'phantramkhuyenmai.min' => 'Phần trăm giảm tối thiểu là 5',
                'phantramkhuyenmai.max' => 'Phần trăm giảm tối đa là 100',

            ]
        );
        // return print_r($request->all() ); exit;
        // response()->json($request->all());
        if ($validator->passes()) {
            $c = Chitietkhuyenmai::where('idsanpham', $request->idsanpham)->where('idkhuyenmai', $request->idkhuyenmai)->update([
                'phantramkhuyenmai' => $request->phantramkhuyenmai,

            ]);
            // $c = Chitietkhuyenmai::findorfail($request->idkhuyenmai);
            // $c->phantramkhuyenmai = $request->phantramkhuyenmai;

            // $c->save();


            // // $c->phantramkhuyenmai = $request->phantramkhuyenmai;
            // // $c->trangthai = $request->trangthai;

            // // $c->save();
            //$c = Chitietkhuyenmai::where('idsanpham', $request->idsanpham)->get();
            // if ($c) {
            //     foreach ($c as $chitiet)
            //         $sanpham = Sanpham::find($request->idsanpham);
            //     if ($sanpham && $chitiet->trangthaictkm == 1) {
            //         $sanpham->giakhuyenmai = $sanpham->gia - ($sanpham->gia * ($chitiet->phantramkhuyenmai / 100));
            //         $sanpham->save();
            //     } else {
            //         $sanpham->giakhuyenmai = $sanpham->gia;
            //         $sanpham->save();
            //     }
            // }
            //dd($c);

            return response()->json($c);
        }
        return response()->json(['error' => $validator->errors()]);
    }

    public function store(Request $r)
    {

        $validator = Validator::make(
            $r->all(),
            [
                'tenkhuyenmai' => 'required|min:3|max:255',
                'ngaybatdau' => 'required|after_or_equal:today',
                'ngayketthuc' => 'required|after:ngaybatdau',
            ],
            [

                'tenkhuyenmai.required' => 'Vui lòng nhập tên khuyến mãi',
                'tenkhuyenmai.min' => 'Tên tối thiểu 3 ký tự',
                'tenkhuyenmai.max' => 'Tên quá dài',
                'ngaybatdau.required' => 'Vui lòng nhập ngày bắt đầu khuyến mãi',
                'ngayketthuc.required' => 'Vui lòng nhập ngày kết thúc khuyến mãi',
                'ngaybatdau.after_or_equal' => 'Ngày bắt đầu phải là ngày hiện tại hoặc sau đó',
                'ngayketthuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu'


            ]
        );
        if ($validator->passes()) {
            $u = Khuyenmai::create([
                'tenkhuyenmai' => $r->tenkhuyenmai,
                'ngaybatdau' => $r->ngaybatdau,
                'ngayketthuc' => $r->ngayketthuc,

            ]);
            return response()->json($u);
            //return response()->json($u,['success'=>'Added new records.']);

        }

        return response()->json(['error' => $validator->errors()]);
    }
    public function edit($id)
    {
        $data = Khuyenmai::findOrFail($id);
        return response()->json($data);
    }
    public function editkm($id, Request $r)
    {
        //dd($r->all());
        $data = Chitietkhuyenmai::where('idsanpham', $id)->where('idkhuyenmai', $r->idkhuyenmai)->get();
        // $data=[$id];

        return response()->json($data);
    }

    public function chitiet($id,Request $r)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d ');
        // dd($id);

        $km = Khuyenmai::find($id);
        $query=Chitietkhuyenmai::query()->join('sanpham', 'chitietkhuyenmai.idsanpham', '=', 'sanpham.idsanpham');
        if (isset($r->keyword)) {
            $query->where(function ($query) use ($r) {
                $query->whereFullText('sanpham.tensanpham', "\%" . $r->keyword . "\%")
                    ->orWhere('sanpham.tensanpham', 'LIKE', "%" . $r->keyword . "%");
            });
        }
        $data = $query->where('chitietkhuyenmai.idkhuyenmai', $id)->paginate(10);

        //dd($km->ngayketthuc);
        //lay danh sach gia tri cot idsanpham sau do chuyen thanh mang
        // $existingValues = Chitietkhuyenmai::pluck('idsanpham')->toArray();
        // $arrSP = Sanpham::all();
        // dd($data);
        return view('admin.khuyenmai.chitietkm', ['data' => $data, 'id' => $id, 'khuyenmai' => $km, 'today' => $today]);
    }
    public function destroykm($id, Request $r)
    {
        // //dd(typeOf($r->vanngu) );

        // //dd($cc);


        $sanpham = Sanpham::leftJoin('chitietkhuyenmai', 'sanpham.idsanpham', '=', 'chitietkhuyenmai.idsanpham')
            ->select('sanpham.*', 'chitietkhuyenmai.trangthaictkm')
            ->where('sanpham.idsanpham', $id)
            ->where('chitietkhuyenmai.idkhuyenmai', $r->vanngu)
            ->first();
        // $sanpham = Sanpham::find($id);
        //dd($sanpham->trangthaictkm);
        if ($sanpham->trangthaictkm != 0 || $sanpham->trangthaictkm != 2) {
            // Thực hiện cập nhật thông tin sản phẩm tại đây
            // Ví dụ: $sanpham->ten_thuoc_tinh = giá_trị_mới;
            // $sanpham->save();
            $sanpham->giakhuyenmai = $sanpham->gia;
            $sanpham->save();
        }
        Chitietkhuyenmai::where('idsanpham', $id)->where('idkhuyenmai', $r->vanngu)->delete();
        session()->flash('mess', 'đã xóa');
        return redirect("/admin/khuyenmai/chitiet/$r->vanngu");
    }
    public function destroy($id)
    {
        $data = Khuyenmai::find($id);
        //dd($data->img);
        if (Count(Khuyenmai::find($id)->chitietkm) == 0) {
            Khuyenmai::destroy($id);
            session()->flash('mess', 'đã xóa');
        } else {
            session()->flash('error', 'Vui lòng xóa khuyến mãi trên sản phẩm');
        }
        return redirect('/admin/khuyenmai');
    }
    public function them($id)
    {
        // $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d ');
        // $arrSP = Sanpham::all();
        // //$data = Chitietkhuyenmai::where('idkhuyenmai', $id)->get();
        // $km = Khuyenmai::where('idkhuyenmai', $id)->first();
        // //dd($km['ngayketthuc']);
        // $timkhuyenmai = Chitietkhuyenmai::where('idkhuyenmai', $id)->get();
        // //dd($timkhuyenmai);
        // //dd($existingValues);
        // if ($km['ngayketthuc'] > $today) {
        //     if ($timkhuyenmai->isEmpty()) {
        //         $array[] = '';
        //     } else {
        //         foreach ($timkhuyenmai as $item) {
        //             // dd($item->idsanpham);
        //             //dd($item);
        //             $array[] = $item->idsanpham;
        //         }
        //     }
        // } else {
        //     $array[] = 'hehe';
        //     dd($array);
        // }
        //dd($array);
        //dd($data);

        return view('admin.khuyenmai.themctkm', ['id' => $id]);
    }
    public function themstore(Request $r)
    {
        $r->validate(
            [
                'phantramkhuyenmai' => 'numeric|min:5|max:100',

            ],
            [
                'phantramkhuyenmai.min' => 'Phần trăm giảm tối thiểu là 5',
                'phantramkhuyenmai.max' => 'Phần trăm giảm tối đa là 100',



            ]
        );
        $d = $r->sanpham;
        //for($i=0;$i<count($d);$i++)
        //$f=Chitietkhuyenmai::find([$d]);
        //dd($d);
        $km = Khuyenmai::where('idkhuyenmai', $r->idkhuyenmai)->first();
        //dd($km);
        // cung dc

        foreach ($d as $k => $v) {
            //HP220400253
            //$a[]=$item;
            // $k1 = Chitietkhuyenmai::where('idsanpham','AC211006749')->get();
            $k1 = Chitietkhuyenmai::where('idsanpham', $v)->where('trangthaictkm', '!=', '0')->get();
            //dd($k1);

            if ($k1->isEmpty()) {
                $a[] = ['idkhuyenmai' => '', 'idsanpham' => $v];
            } else {
                foreach ($k1 as $i) {
                    $a[] = ['idkhuyenmai' => $i->idkhuyenmai, 'idsanpham' => $i->idsanpham, 'trangthaictkm' => $i->trangthaictkm];
                }
            }
            //$a= array_unique($a);
            //$km1=Chitietkhuyenmai::where('idsanpham', $d)->pluck('idkhuyenmai')->toArray();
        }
        //dd($a);
        foreach ($a as $i) {
            if ($i['idkhuyenmai'] == '') {
                $b[] = [
                    'idkhuyenmai' => $i['idkhuyenmai'],
                    'ngaybatdau' => '',
                    'ngayketthuc' => '',
                    'idsanpham' => $i['idsanpham']
                ];
            } elseif ($i['idkhuyenmai'] != $km->idkhuyenmai) {
                $s = Khuyenmai::where('idkhuyenmai', $i['idkhuyenmai'])->first();;
                $b[] = [
                    'idkhuyenmai' => $s->idkhuyenmai,
                    'ngaybatdau' => $s->ngaybatdau,
                    'ngayketthuc' => $s->ngayketthuc,
                    'idsanpham' => $i['idsanpham'],
                    'trangthaictkm' => $i['trangthaictkm']
                ];
            }
        }
        // $p =array_reverse($b,true);
        // dd($p);
        // foreach($p as $i){
        //     dd($i);
        // }
        // dd(array_reverse($b,true));
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d ');
        //dd($b);
        foreach ($b as $i) {
            //dd();
            //if($i['ngayketthuc'] < ngay thuc tai)
            if ($i['ngaybatdau'] == '' && $i['ngaybatdau'] == '' && $i['idkhuyenmai'] == '') {
                $kiemtra[] = [
                    'idkhuyenmai' => $i['idkhuyenmai'],
                    'idsanpham' => $i['idsanpham'],
                    'check' => 'addNew'
                ];
            } elseif ($i['ngaybatdau'] >= $km->ngaybatdau && $i['ngayketthuc'] <= $km->ngayketthuc) {
                // if($i['trangthaictkm'] == 2){
                $kiemtra[] = [
                    'idkhuyenmai' => $i['idkhuyenmai'],
                    'idsanpham' => $i['idsanpham'],
                    'trangthaictkm' => $i['trangthaictkm'],
                    'check' => 'datbiet'
                ];
                // } 
                // else {
                //     if ($i['trangthaictkm'] != 0) {
                //         $kiemtra[] = [
                //             'idkhuyenmai' => $i['idkhuyenmai'],
                //             'idsanpham' => $i['idsanpham'],
                //             'trangthaictkm' => $i['trangthaictkm'],
                //             'check' => 'truonghopmoi'
                //         ];
                //         break;
                //     } else {
                //         $kiemtra[] = [
                //             'idkhuyenmai' => $i['idkhuyenmai'],
                //             'idsanpham' => $i['idsanpham'],
                //             'trangthaictkm' => $i['trangthaictkm'],
                //             'check' => 'true'
                //         ];
                //     }
                // }
            }
            // elseif(){

            // }
            elseif ($i['ngaybatdau'] <= $km->ngaybatdau && $i['ngayketthuc'] >= $km->ngayketthuc) { // 7 15 16 20 
                // if ($i['trangthaictkm'] == 2) {
                $kiemtra[] = [
                    'idkhuyenmai' => $i['idkhuyenmai'],
                    'idsanpham' => $i['idsanpham'],
                    'trangthaictkm' => $i['trangthaictkm'],
                    'check' => 'datbiet'
                ];
                // } 
                // else {
                //     if ($i['trangthaictkm'] != 0) {
                //         $kiemtra[] = [
                //             'idkhuyenmai' => $i['idkhuyenmai'],
                //             'idsanpham' => $i['idsanpham'],
                //             'trangthaictkm' => $i['trangthaictkm'],
                //             'check' => 'truonghopmoi'
                //         ];
                //         break;
                //     } else {
                //         $kiemtra[] = [
                //             'idkhuyenmai' => $i['idkhuyenmai'],
                //             'idsanpham' => $i['idsanpham'],
                //             'trangthaictkm' => $i['trangthaictkm'],
                //             'check' => 'true'
                //         ];
                //     }
                // }
            } elseif ($i['ngaybatdau'] < $km->ngaybatdau && $i['ngayketthuc'] < $km->ngayketthuc) { ///($i['ngayketthuc'] < $km->ngaybatdau && $i['ngayketthuc'] < $km->ngayketthuc )
                if ($i['ngaybatdau'] < $km->ngaybatdau && $i['ngayketthuc'] > $km->ngaybatdau) {
                    $kiemtra[] = [
                        'idkhuyenmai' => $i['idkhuyenmai'],
                        'idsanpham' => $i['idsanpham'],
                        'trangthaictkm' => $i['trangthaictkm'],
                        'check' => 'datbiet'
                    ];
                } elseif ($i['ngaybatdau'] == $km->ngaybatdau || $i['ngaybatdau'] == $km->ngayketthuc || $i['ngayketthuc'] == $km->ngaybatdau || $i['ngayketthuc'] == $km->ngayketthuc) {
                    $kiemtra[] = [
                        'idkhuyenmai' => $i['idkhuyenmai'],
                        'idsanpham' => $i['idsanpham'],
                        'trangthaictkm' => $i['trangthaictkm'],
                        'check' => 'datbiet'
                    ];
                } else {
                    $kiemtra[] = [
                        'idkhuyenmai' => $i['idkhuyenmai'],
                        'idsanpham' => $i['idsanpham'],
                        'trangthaictkm' => $i['trangthaictkm'],
                        'check' => 'true'
                    ];
                }
            } elseif (($i['ngaybatdau'] > $km->ngaybatdau && $i['ngayketthuc'] > $km->ngayketthuc)) {  /// 7 15 16 20 
                if ($i['ngaybatdau'] > $km->ngaybatdau && $i['ngaybatdau'] < $km->ngayketthuc) {
                    $kiemtra[] = [
                        'idkhuyenmai' => $i['idkhuyenmai'],
                        'idsanpham' => $i['idsanpham'],
                        'trangthaictkm' => $i['trangthaictkm'],
                        'check' => 'datbiet'
                    ];
                } elseif ($i['ngaybatdau'] == $km->ngaybatdau || $i['ngaybatdau'] == $km->ngayketthuc || $i['ngayketthuc'] == $km->ngaybatdau || $i['ngayketthuc'] == $km->ngayketthuc) {
                    $kiemtra[] = [
                        'idkhuyenmai' => $i['idkhuyenmai'],
                        'idsanpham' => $i['idsanpham'],
                        'trangthaictkm' => $i['trangthaictkm'],
                        'check' => 'datbiet'
                    ];
                } else {
                    $kiemtra[] = [
                        'idkhuyenmai' => $i['idkhuyenmai'],
                        'idsanpham' => $i['idsanpham'],
                        'trangthaictkm' => $i['trangthaictkm'],
                        'check' => 'true'
                    ];
                }
            }
            // elseif ($i['ngaybatdau'] > $km->ngayketthuc && $i['ngaybatdau'] > $km->ngaybatdau ) { /// 3 8 10 20 
            //     if($i['trangthaictkm']==2){
            //         if ($i['ngaybatdau']  > $today) {
            //             $kiemtra[] = [
            //                 'idkhuyenmai' => $i['idkhuyenmai'],
            //                 'idsanpham' => $i['idsanpham'],
            //                 'trangthaictkm' => $i['trangthaictkm'],
            //                 'check' => 'true'
            //             ];
            //         } else {
            //             $kiemtra[] = [
            //                 'idkhuyenmai' => $i['idkhuyenmai'],
            //                 'idsanpham' => $i['idsanpham'],
            //                 'trangthaictkm' => $i['trangthaictkm'],
            //                 'check' => 'falseDayNow'
            //             ];
            //         }
            //     } 
            // } 
            // elseif ($i['ngayketthuc'] < $km->ngaybatdau && $i['ngayketthuc'] < $km->ngayketthuc ) { /// 3 8 10 20 
            //     if ( $i['trangthaictkm'] == 2) {
            //         if ($i['ngayketthuc'] > $today) {
            //             $kiemtra[] = [
            //                 'idkhuyenmai' => $i['idkhuyenmai'],
            //                 'idsanpham' => $i['idsanpham'],
            //                 'trangthaictkm' => $i['trangthaictkm'],
            //                 'check' => 'true'
            //             ];
            //         } else {
            //             $kiemtra[] = [
            //                 'idkhuyenmai' => $i['idkhuyenmai'],
            //                 'idsanpham' => $i['idsanpham'],
            //                 'trangthaictkm' => $i['trangthaictkm'],
            //                 'check' => 'falseDayNow'
            //             ];
            //         }

            //     } else {
            //         if ($i['ngayketthuc'] > $today) {
            //             $kiemtra[] = [
            //                 'idkhuyenmai' => $i['idkhuyenmai'],
            //                 'idsanpham' => $i['idsanpham'],
            //                 'trangthaictkm' => $i['trangthaictkm'],
            //                 'check' => 'true'
            //             ];
            //         } else {
            //             $kiemtra[] = [
            //                 'idkhuyenmai' => $i['idkhuyenmai'],
            //                 'idsanpham' => $i['idsanpham'],
            //                 'trangthaictkm' => $i['trangthaictkm'],
            //                 'check' => 'falseDayNow'
            //             ];
            //         }
            //     }
            // } 
            else {
                $kiemtra[] = [
                    'idkhuyenmai' => $i['idkhuyenmai'],
                    'idsanpham' => $i['idsanpham'],
                    'trangthaictkm' => $i['trangthaictkm'],
                    'check' => 'false'
                ];
            }
        }
        //dd($kiemtra);
        $tam = [];

        $idkm = [];
        $mang = [];
        foreach ($kiemtra as $item) {
            //dd($item['check']);
            if ($item['check'] == 'datbiet') {
                $tam[] = [
                    'idkhuyenmai' => $item['idkhuyenmai'],
                    'idsanpham' => $item['idsanpham'],
                    //$item['check'] == 'datbiet'
                ];

                $idkm[] = $item['idsanpham'];
            } elseif ($item['check'] == 'addNew') {
                Chitietkhuyenmai::create([
                    'idkhuyenmai' => $r->idkhuyenmai,
                    'phantramkhuyenmai' => $r->phantramkhuyenmai,
                    'idsanpham' => $item['idsanpham'],
                    'trangthaictkm' => 2
                ]);

                $them[] = $item['idsanpham'];
                session()->flash('them', $them);
            } elseif ($item['check'] == 'true') {
                $ktra = Chitietkhuyenmai::where('idkhuyenmai', $km->idkhuyenmai)->where('idsanpham', $item['idsanpham'])->first();
                if ($ktra == null) {
                    Chitietkhuyenmai::create([
                        'idkhuyenmai' => $km->idkhuyenmai,
                        'phantramkhuyenmai' => $r->phantramkhuyenmai,
                        'idsanpham' => $item['idsanpham'],
                        'trangthaictkm' => 2
                    ]);

                    $mang[] = [
                        'idkhuyenmai' => $item['idkhuyenmai'],
                        'idsanpham' => $item['idsanpham'],
                    ];
                }
            }
        }
        //dd($idkm);
        //dd($tam);
        // dd($mang);
        if (empty($idkm)) {
            if (!empty($mang)) {
                foreach ($mang as $i) {
                    // dd(!in_array($i['idsanpham'], $idkm));
                    if (!in_array($i['idsanpham'], $idkm)) {
                        $themthanhcong[] = $i['idsanpham'];
                    }
                }
                session()->flash('themthanhcong', $themthanhcong);
            } else {
                $tam[] = $idkm;
                if (!empty($tam[0])) {
                    session()->flash('loi', $tam);
                }
                //dd($tam);

            }
        } else {

            if (!empty($mang)) {
                foreach ($mang as $i) {
                    // dd(!in_array($i['idsanpham'], $idkm));
                    if (in_array($i['idsanpham'], $idkm)) {
                        $themthanhcong = [];
                    } else {
                        $themthanhcong[] = $i['idsanpham'];
                    }
                    // else
                    // {
                    //     $themthanhcong = [];
                    // }
                }
                session()->flash('themthanhcong', $themthanhcong);
                // dd($themthanhcong);
            }
        }


        // }else{

        // }

        if (!empty($tam)) {
            if (!empty($tam[0])) {
                foreach ($tam as $item) {
                    Chitietkhuyenmai::where('idsanpham', $item['idsanpham'])->where('idkhuyenmai', $km->idkhuyenmai)->delete();
                    $bien[] = $item['idkhuyenmai'] . '---' . $item['idsanpham'];
                    session()->flash('loi', $bien);
                }
            }
        } else {
        }

        $id = $r->idkhuyenmai;
        //session()->flash('kiemtra', $kiemtra);
        return redirect("/admin/khuyenmai/chitiet/$id");
    }
    public function editform($id)
    {
        $km = Khuyenmai::findOrFail($id);
        return View('admin.khuyenmai.edit', ['km' => $km]);
    }
    public function updateform(Request $request)
    {
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d ');
        //dd($request->all());
        $request->validate(
            [

                'tenkhuyenmai' => 'required|min:3|max:255',
                'ngaybatdau' => 'required|after_or_equal:today',
                'ngayketthuc' => 'required|after:ngaybatdau',

            ],
            [

                'tenkhuyenmai.required' => 'Vui lòng nhập tên khuyến mãi',
                'tenkhuyenmai.min' => 'Tên tối thiểu 3 ký tự',
                'tenkhuyenmai.max' => 'Tên quá dài',
                'tenkhuyenmai.required' => 'Vui lòng nhập tên',
                'ngaybatdau.required' => 'Vui lòng nhập ngày bắt đầu khuyến mãi',
                'ngayketthuc.required' => 'Vui lòng nhập ngày kết thúc khuyến mãi',
                'ngaybatdau.after_or_equal' => 'Ngày bắt đầu phải là ngày hiện tại hoặc sau đó',
                'ngayketthuc.after' => 'Ngày kết thúc phải sau ngày bắt đầu và ngày hôm nay'

            ]
        );
        $ct = Chitietkhuyenmai::where('idkhuyenmai', $request->idkhuyenmai)->get();
        // dd($ct);
        if ($ct->isEmpty()) {
            $c = Khuyenmai::findorfail($request->idkhuyenmai);
            $c->tenkhuyenmai = $request->tenkhuyenmai;
            $c->ngaybatdau = $request->ngaybatdau;
            $c->ngayketthuc = $request->ngayketthuc;
            $c->save();
            session()->flash("mess", "Sua thanh cong");
            //dd($c);
            return redirect('/admin/khuyenmai');
        } else {
            foreach ($ct as $item) {
                $sp[] = $item->idsanpham;
            }
            // dd($sp);
            $a = [];

            foreach ($sp as $i) {
                $k1 = Chitietkhuyenmai::where('idsanpham', $i)->where('trangthaictkm', '!=', '0')->where('idkhuyenmai', '!=', $request->idkhuyenmai)->get();
                //$c[]=$k1;
                // dd($i);

                foreach ($k1 as $i) {

                    $a[] =  $i->idkhuyenmai;
                }
            }
            //dd($c);
            // dd($a);
            $a = array_unique($a);
            if (empty($a)) {
                $c = Khuyenmai::findorfail($request->idkhuyenmai);
                if ($c['ngaybatdau'] <= $today && $c['ngayketthuc'] >= $today) {
                    if ($request->ngaybatdau > $today) {
                        foreach ($ct as $i) {
                            $ctkm = Chitietkhuyenmai::findorfail($i->idkhuyenmai);
                            //dd($c);
                            $ctkm->trangthaictkm = 2;
                            $ctkm->save();
                            //dd($ctkm);
                            $sanpham = Sanpham::find($i->idsanpham);
                            if ($sanpham && $ctkm->trangthaictkm == 2) {
                                $sanpham->giakhuyenmai = $sanpham->gia;
                                $sanpham->save();
                            }
                        }
                    }
                }
                $c->tenkhuyenmai = $request->tenkhuyenmai;
                $c->ngaybatdau = $request->ngaybatdau;
                $c->ngayketthuc = $request->ngayketthuc;
                $c->save();
                session()->flash("mess", "Sua thanh cong");
                //dd($c);
                return redirect('/admin/khuyenmai');
            } else {


                //dd($a);
                foreach ($a as $i) {
                    $km = Khuyenmai::where('idkhuyenmai', $i)->first();
                    //dd($km['idkhuyenmai']);
                    $b[] = [
                        'idkhuyenmai' => $km['idkhuyenmai'],
                        'ngaybatdau' => $km['ngaybatdau'],
                        'ngayketthuc' => $km['ngayketthuc'],
                    ];
                }
                //dd($b);
                $kiemtra = [];
                foreach ($b as $i) {
                    //dd($i['ngaybatdau']);
                    if ($i['ngaybatdau'] >= $request->ngaybatdau && $i['ngayketthuc'] <= $request->ngayketthuc) {
                        // if($i['trangthaictkm'] == 2){
                        $kiemtra[] = [
                            'idkhuyenmai' => $i['idkhuyenmai'],
                            'check' => 'datbiet'
                        ];
                    } elseif ($i['ngaybatdau'] <= $request->ngaybatdau && $i['ngayketthuc'] >= $request->ngayketthuc) { // 7 15 16 20 
                        // if ($i['trangthaictkm'] == 2) {
                        $kiemtra[] = [
                            'idkhuyenmai' => $i['idkhuyenmai'],
                            'check' => 'datbiet'
                        ];
                    } elseif ($i['ngaybatdau'] < $request->ngaybatdau && $i['ngayketthuc'] < $request->ngayketthuc) { ///($i['ngayketthuc'] < $km->ngaybatdau && $i['ngayketthuc'] < $km->ngayketthuc )
                        if ($i['ngaybatdau'] < $request->ngaybatdau && $i['ngayketthuc'] > $request->ngaybatdau) {
                            $kiemtra[] = [
                                'idkhuyenmai' => $i['idkhuyenmai'],
                                'check' => 'datbiet'
                            ];
                        } elseif ($i['ngaybatdau'] == $request->ngaybatdau || $i['ngaybatdau'] == $request->ngayketthuc || $i['ngayketthuc'] == $request->ngaybatdau || $i['ngayketthuc'] == $request->ngayketthuc) {
                            $kiemtra[] = [
                                'idkhuyenmai' => $i['idkhuyenmai'],
                                'check' => 'datbiet'
                            ];
                        }
                    } elseif (($i['ngaybatdau'] > $request->ngaybatdau && $i['ngayketthuc'] > $request->ngayketthuc)) {  /// 7 15 16 20 
                        if ($i['ngaybatdau'] > $request->ngaybatdau && $i['ngaybatdau'] < $request->ngayketthuc) {
                            $kiemtra[] = [
                                'idkhuyenmai' => $i['idkhuyenmai'],
                                'check' => 'datbiet'
                            ];
                        } elseif ($i['ngaybatdau'] == $request->ngaybatdau || $i['ngaybatdau'] == $request->ngayketthuc || $i['ngayketthuc'] == $request->ngaybatdau || $i['ngayketthuc'] == $request->ngayketthuc) {
                            $kiemtra[] = [
                                'idkhuyenmai' => $i['idkhuyenmai'],
                                'check' => 'datbiet'
                            ];
                        }
                    }
                }

                //dd($kiemtra);
                if (empty($kiemtra)) {
                    //dd('sua');
                    $c = Khuyenmai::findorfail($request->idkhuyenmai);
                    if ($c['ngaybatdau'] <= $today && $c['ngayketthuc'] >= $today) {
                        if ($request->ngaybatdau > $today) {
                            foreach ($ct as $i) {
                                $ctkm = Chitietkhuyenmai::findorfail($i->idkhuyenmai);
                                //dd($c);
                                $ctkm->trangthaictkm = 2;
                                $ctkm->save();
                                //dd($ctkm);
                                $sanpham = Sanpham::find($i->idsanpham);
                                if ($sanpham && $ctkm->trangthaictkm == 2) {
                                    $sanpham->giakhuyenmai = $sanpham->gia;
                                    $sanpham->save();
                                }
                            }
                        }
                    }
                    $c->tenkhuyenmai = $request->tenkhuyenmai;
                    $c->ngaybatdau = $request->ngaybatdau;
                    $c->ngayketthuc = $request->ngayketthuc;
                    $c->save();
                    session()->flash("mess", "Sua thanh cong");
                    //dd($c);
                    return redirect('/admin/khuyenmai');
                } else {
                    foreach ($kiemtra as $item) {
                        $bien[] = $item['idkhuyenmai'];
                    }
                    session()->flash("errors", $bien);
                    return redirect('/admin/khuyenmai');
                }
            }
        }
    }




    public function capnhat(Request $r)
    {
        //dd($r->all());

        $loc = Khuyenmai::join('chitietkhuyenmai', 'khuyenmai.idkhuyenmai', '=', 'chitietkhuyenmai.idkhuyenmai')
            ->select('khuyenmai.*', 'chitietkhuyenmai.trangthaictkm')
            ->where('chitietkhuyenmai.trangthaictkm', '1')
            ->get();
        //dd($loc);
        foreach ($loc as $i) {
            //dd($i->idkhuyenmai);
            $c = Chitietkhuyenmai::findorfail($i->idkhuyenmai);
            //dd($c);
            $c->trangthaictkm = 0;
            $c->save();
        }
        //dd($loc);

        foreach ($r->idkhuyenmai as $i) {
            //dd($i);
            //$ctkm = Chitietkhuyenmai::where('idkhuyenmai',$i)->get();
            $ctkm = Khuyenmai::join('chitietkhuyenmai', 'khuyenmai.idkhuyenmai', '=', 'chitietkhuyenmai.idkhuyenmai')
                ->select('khuyenmai.*', 'chitietkhuyenmai.*')
                ->where('chitietkhuyenmai.idkhuyenmai', $i)
                ->get();
            //dd($ctkm);

            //     "idkhuyenmai" => 4
            // "tenkhuyenmai" => "test"
            // "ngaybatdau" => "2023-06-04"
            // "ngayketthuc" => "2023-06-06"
            // "phantramkhuyenmai" => 30.0
            // "idsanpham" => "MSI230402250"
            // "trangthaictkm" => 0
            foreach ($ctkm as $i) {
                //dd($i);
                $c = Chitietkhuyenmai::where('idsanpham', $i->idsanpham)->where('idkhuyenmai', $i->idkhuyenmai)->first();
                //dd($c);
                $c->trangthaictkm = 1;
                $c->save();
                $sanpham = Sanpham::find($i->idsanpham);
                //$tam[] = $c;
                if ($sanpham && $c->trangthaictkm == 1) {
                    $sanpham->giakhuyenmai = $sanpham->gia - ($sanpham->gia * ($c->phantramkhuyenmai / 100));
                    $sanpham->save();
                } else {
                    $sanpham->giakhuyenmai = $sanpham->gia;
                    $sanpham->save();
                }
            }
        }
        //
    }
    public function capnhatajax()
    {
        // Khuyenmai->lay alll
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d');
        $kiemtraKM = Khuyenmai::all();
        foreach ($kiemtraKM as $i) {
            //dd($i->ngaybatdau);
            if ($i->ngaybatdau <= $today && $i->ngayketthuc >= $today) {
                $idkhuyenmai[] = $i->idkhuyenmai;
            } else {
                $idkhuyenmai[] = '';
            }
        }
        // dd($idkhuyenmai);
        // dd($homnaycankhuyenmai);

        $loc = Khuyenmai::join('chitietkhuyenmai', 'khuyenmai.idkhuyenmai', '=', 'chitietkhuyenmai.idkhuyenmai')
            ->select('khuyenmai.*', 'chitietkhuyenmai.trangthaictkm')
            ->where('chitietkhuyenmai.trangthaictkm', '1')
            ->get();
        //dd($loc);
        foreach ($loc as $i) {
            //dd($i->idkhuyenmai);
            $c = Chitietkhuyenmai::findorfail($i->idkhuyenmai);
            //dd($c);
            $c->trangthaictkm = 0;
            $c->save();
        }
        //dd($loc);


        foreach ($idkhuyenmai as $i) {
            //dd($i);
            //$ctkm = Chitietkhuyenmai::where('idkhuyenmai',$i)->get();
            $ctkm = Khuyenmai::join('chitietkhuyenmai', 'khuyenmai.idkhuyenmai', '=', 'chitietkhuyenmai.idkhuyenmai')
                ->select('khuyenmai.*', 'chitietkhuyenmai.*')
                ->where('chitietkhuyenmai.idkhuyenmai', $i)
                ->get();
            //dd($ctkm);

            //     "idkhuyenmai" => 4
            // "tenkhuyenmai" => "test"
            // "ngaybatdau" => "2023-06-04"
            // "ngayketthuc" => "2023-06-06"
            // "phantramkhuyenmai" => 30.0
            // "idsanpham" => "MSI230402250"
            // "trangthaictkm" => 0
            foreach ($ctkm as $i) {
                //dd($i);
                $c = Chitietkhuyenmai::where('idsanpham', $i->idsanpham)->where('idkhuyenmai', $i->idkhuyenmai)->first();
                //dd($c);
                $c->trangthaictkm = 1;
                $c->save();
                $sanpham = Sanpham::find($i->idsanpham);
                $tam[] = $c;
                if ($sanpham && $c->trangthaictkm == 1) {
                    $sanpham->giakhuyenmai = $sanpham->gia - ($sanpham->gia * ($c->phantramkhuyenmai / 100));
                    $sanpham->save();
                } else {
                    $sanpham->giakhuyenmai = $sanpham->gia;
                    $sanpham->save();
                }
            }
        }
    }
    public function lockm(Request $request)
    {
        $keyword = $request->input('keyword');
        $today = Carbon::now('Asia/Ho_Chi_Minh')->format('Y-m-d ');
        $arrSP = Sanpham::all();
        $km = Khuyenmai::where('idkhuyenmai', $request->id)->first();
        $timkhuyenmai = Chitietkhuyenmai::where('idkhuyenmai', $request->id)->get();


        if ($km['ngayketthuc'] >= $today) {
            if ($timkhuyenmai->isEmpty()) {
                $existingValues[] = '';
            } else {
                foreach ($timkhuyenmai as $item) {
                    $existingValues[] = $item->idsanpham;
                }
            }
        } else {
            $existingValues[] = 'het han';
        }


        // Thực hiện tìm kiếm dựa trên từ khóa và lấy danh sách mã ID phù hợp
        $foundItems = Sanpham::where('tensanpham', 'like', '%' . $keyword . '%')
            ->whereNotIn('idsanpham', $existingValues)
            ->get();

        // // Trả về kết quả dưới dạng JSON

        return response()->json($foundItems);
    }
}
