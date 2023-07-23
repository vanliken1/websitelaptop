@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Quản lý đơn hàng</h6>
                <form class="col-sm-20 mb-4" action="/admin/donhang" method="GET">
                    <div class="form-group">
                        Từ ngày:<input class="form-control-sm" type="date" name="tungay">
                        Đến ngày:<input class="form-control-sm" type="date" name="denngay">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                    </div>

                </form>
                <form class="col-sm-20 mb-4" action="/admin/donhang" method="GET">
                    <div class="form-group">
                        Lọc theo:
                        <select class="form-control-sm " id="trangthailoc" name="trangthailoc" style="text-align: center;" onchange="this.form.submit()">
                            <option value="" selected disabled>--Chọn tình trạng--</option>
                            <option value="all">--Tất cả--</option>
                            <option value="chuaxuly" <?php if (isset($_GET['trangthailoc']) && $_GET['trangthailoc'] === 'chuaxuly') echo 'selected'; ?>>Chưa xử lý</option>
                            <option value="daxuly" <?php if (isset($_GET['trangthailoc']) && $_GET['trangthailoc'] === 'daxuly') echo 'selected'; ?>>Đã xác nhận</option>
                            <option value="huytruocxuly" <?php if (isset($_GET['trangthailoc']) && $_GET['trangthailoc'] === 'huytruocxuly') echo 'selected'; ?>>Hủy trước xác nhận</option>
                            <option value="huysauxuly" <?php if (isset($_GET['trangthailoc']) && $_GET['trangthailoc'] === 'huysauxuly') echo 'selected'; ?>>Hủy sau xác nhận</option>
                            <option value="danggiao" <?php if (isset($_GET['trangthailoc']) && $_GET['trangthailoc'] === 'danggiao') echo 'selected'; ?>>Đang giao</option>
                            <option value="dagiao" <?php if (isset($_GET['trangthailoc']) && $_GET['trangthailoc'] === 'dagiao') echo 'selected'; ?>>Đã giao</option>

                        </select>
                    </div>

                </form>

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
                                    <span style="color: blue;">Đã xác nhận</span>
                                    @elseif($item->trangthai==3)
                                    <span style="color: red;">Hủy-sau xác nhận</span>
                                    @elseif($item->trangthai==4)
                                    <span style="color: SkyBlue;">Đang giao</span>
                                    @elseif($item->trangthai==5)
                                    <span style="color: cyan;">Đã giao</span>
                                    @else
                                    <span style="color: red;">Hủy-trước xác nhận</span>
                                    @endif

                                </td>
                                <td>
                                    <a href="/admin/donhang/chitiet/{{$item->iddonhang}}" class="btn btn-info"> Chi tiet</a>
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