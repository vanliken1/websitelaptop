@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Quản lý đơn hàng</h6>
                @if(session()->has('mess'))
                <p class="alert alert-primary sm-4">
                    {{session('mess')}}
                </p>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID đơn hàng</th>
                                <th>Ngày đặt</th>
                                
                                
                                <th>Trạng thái</th>
                                <th>📄</th>
                                <th>✏️</th>
                            </tr>
                        </thead>
                        @foreach($donhang as $item)
                        <tbody>
                            <tr>
                                <td>{{$item->iddonhang}}</td>
                                <td>{{$item->ngaydat}}</td>
                                <td>
                                    @if($item->trangthai==1)
                                    <span style="color: green;">Đơn hàng mới</span>
                                    @elseif($item->trangthai==2)
                                    <span style="color: blue;">Đã xử lý</span>
                                    @elseif($item->trangthai==3)
                                    <span style="color: red;">Hủy-sau xử lý</span>
                                    @elseif($item->trangthai==4)
                                    <span style="color: SkyBlue;">Đang giao</span>
                                    @elseif($item->trangthai==5)
                                    <span style="color: cyan;">Đã giao</span>
                                    @else
                                    <span style="color: red;">Hủy-trước xử lý</span>
                                    @endif

                                </td>
                                <td>
                                    <a href="/admin/donhang/chitiet/{{$item->iddonhang}}" class="btn btn-info"> Chi tiet</a>
                                </td>
                                <td>
                                    <form action="/admin/donhang/destroy/{{$item->iddonhang}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <input onclick="return confirm('Ban thuc su muon xoa ?')" type="submit" value="xóa" class="btn btn-danger">
                                    </form>
                                </td>
                               

                            </tr>
                            
                        </tbody>
                        @endforeach

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- Table End -->
@stop