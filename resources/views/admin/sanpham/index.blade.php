@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Quản lý Sản phẩm</h6>
                <!-- <p><button class='addSanpham btn btn-primary'>Thêm</button></p> -->
                <p><a href="/admin/product/create" class="btn btn-primary">Thêm</a></p>

                <div class="row">

                    <form class="col-sm-12 mb-4" action="/admin/product" method="GET">

                        <select multiple="" class="form-control-sm selectbrand" id="selectbrand" name="brand[]" style="margin-top: 10px;width: 180px;" data-allow-clear="false">

                            @foreach($thuonghieu as $item)
                            <option value="{{$item->idthuonghieu}}" {{ in_array($item->idthuonghieu, $selectedBrands) ? 'selected' : '' }}>{{$item->tenthuonghieu}}</option>

                            @endforeach

                        </select>

                        <select multiple="" class="form-control-sm selectcpu " name="cpu[]" style="margin-top: 10px;width: 180px;" data-allow-clear="false">
                            @foreach($cpu as $item)
                            <option value="{{$item->idCPU}}" {{ in_array($item->idCPU, $selectedCPUs) ? 'selected' : '' }}>{{$item->tenCPU}}</option>

                            @endforeach

                        </select>
                        <select multiple="" class="form-control-sm selectram " name="ram[]" style="margin-top: 10px;width: 180px;" data-allow-clear="false">

                            @foreach($ram as $item)
                            <option value="{{$item->idram}}" {{ in_array($item->idram, $selectedRAMs) ? 'selected' : '' }}>{{$item->tenram}}</option>

                            @endforeach

                        </select>
                        <select multiple="" class="form-control-sm selectluutru " name="luutru[]" style="margin-top: 10px;width: 180px;" data-allow-clear="false">

                            @foreach($luutru as $item)
                            <option value="{{$item->idluutru}}" {{ in_array($item->idluutru, $selectedLTs) ? 'selected' : '' }}>{{$item->tenluutru}}</option>

                            @endforeach

                        </select>
                        <select multiple="" class="form-control-sm selectdohoa " name="dohoa[]" style="margin-top: 10px;width: 180px;" data-allow-clear="false">
                            @foreach($dohoa as $item)
                            <option value="{{$item->iddohoa}}" {{ in_array($item->iddohoa, $selectedDHs) ? 'selected' : '' }}>{{$item->tendohoa}}</option>

                            @endforeach

                        </select>
                        <select multiple="" class="form-control-sm selectnhucau " name="nhucau[]" style="margin-top: 10px;width: 180px;" data-allow-clear="false">
                            @foreach($loaisp as $item)
                            <option value="{{$item->idloaisanpham}}" {{ in_array($item->idloaisanpham, $selectedNCs) ? 'selected' : '' }}>{{$item->tenloai}}</option>

                            @endforeach

                        </select>
                        <select multiple="" class="form-control-sm selectmanhinh " name="manhinh[]" style="margin-top: 10px;width: 180px;" data-allow-clear="false">
                            @foreach($manhinh as $item)
                            <option value="{{$item->idmanhinh}}" {{ in_array($item->idmanhinh, $selectedMHs) ? 'selected' : '' }}>{{$item->tenmanhinh}}</option>

                            @endforeach

                        </select>
                        <select multiple="" class="form-control-sm selectgia " name="gia[]" style="margin-top: 10px;width: 180px;" data-allow-clear="false">
                            <option value="under_10" {{ in_array('under_10', $selectedPrices) ? 'selected' : '' }}>Dưới 10 triệu</option>
                            <option value="10_to_15" {{ in_array('10_to_15', $selectedPrices) ? 'selected' : '' }}>Từ 10-15 triệu</option>
                            <option value="15_to_20" {{ in_array('15_to_20', $selectedPrices) ? 'selected' : '' }}>Từ 15-20 triệu</option>
                            <option value="20_to_25" {{ in_array('20_to_25', $selectedPrices) ? 'selected' : '' }}>Từ 20-25 triệu</option>
                            <option value="over_25" {{ in_array('over_25', $selectedPrices) ? 'selected' : '' }}>Trên 25 triệu</option>


                        </select>
                        <input class="form-control-sm" style="margin-top: 10px;width:180px;" type="search" name="keyword" placeholder="Search">





                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>


                    </form>

                </div>

                @if(session()->has('mess'))
                <!-- <p class="alert alert-primary sm-4">
                    {{session('mess')}}
                </p> -->
                <script>
                    // Lấy giá trị từ session message
                    var message = "{{ session('mess') }}";

                    // Hiển thị thông báo bằng SweetAlert
                    Swal.fire({
                        title: "Thông báo",
                        text: message,
                        icon: "success",
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        toast: true,
                        timerProgressBar: true
                    })
                </script>
                @endif
                @if(session()->has('error'))
                <!-- <div class="alert alert-primary sm-4">
                    {{session('mess')}}
                </div> -->
                <script>
                    // Lấy giá trị từ session message
                    var message = "{{ session('error') }}";

                    // Hiển thị thông báo bằng SweetAlert
                    Swal.fire({
                        title: "Thông báo",
                        text: message,
                        icon: "error",
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        toast: true,
                        timerProgressBar: true
                    })
                </script>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên Sản phẩm</th>
                                <th scope="col">Hình ảnh</th>
                                <th scope="col">Số lượng</th>
                                <th scope="col">Giá</th>
                                <th scope="col">Giá khuyến mãi</th>
                                <th scope="col">HOT</th>
                                <th scope="col">Ngày tạo</th>
                                <th>Trạng thái</th>
                                <th>🗑️</th>
                                <th>✏️</th>
                            </tr>
                        </thead>
                        @foreach($sanpham as $item)

                        <tbody>
                            <tr>
                                <td>{{$item->idsanpham}}</td>
                                <td>{{$item->tensanpham}} </td>
                                <td><img src="{{asset('storage/img/'.$item->img)}}" style="width:100px;height:100px" alt=""></td>
                                <td>{{$item->soluong}}</td>

                                <td>{{number_format($item->gia,0,',','.')}}</td>

                                <td>{{number_format($item->giakhuyenmai,0,',','.') }}</td>
                                <td>
                                    @if($item->hot==1)
                                    {{'HOT'}}
                                    @else
                                    {{'Không'}}
                                    @endif
                                </td>

                                <td>{{$item->ngaytao}}</td>
                                <td>
                                    @if($item->trangthai==0)
                                    <span style="color: red;">Đã khóa</span>
                                    @else
                                    <span style="color: green;">Đang hoạt động</span>
                                    @endif
                                </td>
                                <td>
                                    <form action="/admin/product/destroy/{{$item->idsanpham}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="submit" value="xóa" onclick="confirmXoa(event)" class="btn btn-danger">
                                    </form>
                                </td>
                                <td>
                                    <!-- <button class='editSanpham btn btn-success' data-id='{{$item->idsanpham}}'>Sửa</button> -->
                                    <a href="/admin/product/edit/{{$item->idsanpham}}" class="btn btn-success">Sửa</a>

                                </td>

                            </tr>
                        </tbody>
                        @endforeach

                    </table>
                    <div class="" style="float: right;"> {{$sanpham->appends(Request::all())->links()}}</div>
                </div>
            </div>
        </div>

    </div>
</div>
<!-- <div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm Sản phẩm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="idsanpham" name="idsanpham">
                            <label for="floatingInput">Mã</label>
                            <span class="text-danger error-text idsanpham_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='tensanpham' id="tensanpham" class='form-control mt-3'>
                            <label for="floatingInput">Tên Sản phẩm</label>
                            <span class="text-danger error-text tensanpham_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='slug_sanpham' id="slug_sanpham" class='form-control mt-3'>
                            <label for="floatingInput">Slug</label>
                            <span class="text-danger error-text slug_sanpham_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idthuonghieu' id="idthuonghieu" class='form-select mb-3' required>
                                @foreach($thuonghieu as $item)
                                <option value="{{$item->idthuonghieu}}">{{$item->tenthuonghieu}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Thương hiệu(*)</label>
                            <span class="text-danger error-text trangthai_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idCPU' id="idCPU" class='form-select mb-3'>

                                @foreach($cpu as $item)
                                <option value="{{$item->idCPU}}">{{$item->tenCPU}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">CPU(*)</label>
                            <span class="text-danger error-text idCPU_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idram' id="idram" class='form-select mb-3'>


                                @foreach($ram as $item)
                                <option value="{{$item->idram}}">{{$item->tenram}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Ram(*)</label>
                            <span class="text-danger error-text idCPU_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='iddohoa' id="iddohoa" class='form-select mb-3'>


                                @foreach($dohoa as $item)
                                <option value="{{$item->iddohoa}}">{{$item->tendohoa}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Card đồ họa(*)</label>
                            <span class="text-danger error-text iddohoa_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idluutru' id="idluutru" class='form-select mb-3'>


                                @foreach($luutru as $item)
                                <option value="{{$item->idluutru}}">{{$item->tenluutru}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Ổ cứng(*)</label>
                            <span class="text-danger error-text idluutru_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idmanhinh' id="idmanhinh" class='form-select mb-3'>


                                @foreach($manhinh as $item)
                                <option value="{{$item->idmanhinh}}">{{$item->tenmanhinh}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Màn hình(*)</label>
                            <span class="text-danger error-text idmanhinh_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idloaisanpham' id="idloaisanpham" class='form-select mb-3'>


                                @foreach($loaisp as $item)
                                <option value="{{$item->idloaisanpham}}">{{$item->tenloai}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Nhu cầu(*)</label>
                            <span class="text-danger error-text idloaisanpham_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="file" name='img' class='form-control mt-3'>

                            <label for="floatingInput">Hình ảnh</label>
                            <span class="text-danger error-text img_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <textarea style="height: 150px;" name="motasanpham" id="motasanpham" class='form-control'></textarea>
                            <label for="floatingInput">Mô tả</label>
                            <span class="text-danger error-text motasanpham_err"></span>
                        </div>
                         <div class="form-floating mb-3">
                            <label>Nội dung</label>
                            <textarea style="height: 200px;" name="noidung" id="noidung" class='form-control'></textarea>



                            <script>
                                CKEDITOR.replace('noidung');
                            </script>
                            <span class="text-danger error-text noidung_err"></span>
                        </div> 
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea style="height: 150px;" name="noidung" id="noidung" class='form-control'></textarea>
                            <script>
                                CKEDITOR.replace('noidung');
                            </script>
                            <span class="text-danger error-text noidung_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='gia' id="gia" class='form-control mt-3'>
                            <label for="floatingInput">Giá</label>
                            <span class="text-danger error-text gia_err"></span>
                        </div>


                        <div class="form-floating mb-3">

                            <input type="number" min="1" value="1" name='soluong' id="soluong" class='form-control mt-3'>
                            <label for="floatingInput">Số lượng</label>
                            <span class="text-danger error-text soluong_err"></span>
                        </div>
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">HOT</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hot" id="gridRadios1" value="1">
                                    <label class="form-check-label" for="gridRadios1">
                                        Có
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hot" id="gridRadios2" value="0" checked>
                                    <label class="form-check-label" for="gridRadios2">
                                        Không
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-floating mb-3">

                            <select type="number" name='trangthai' class='form-select mt-3'>
                                <option value="0">Ẩn</option>
                                <option value="1">Hiện</option>
                            </select>
                            <label for="floatingInput">Trạng thái</label>
                            <span class="text-danger error-text trangthai_err"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/product" class="btn btn-secondary">Thoát</a>
                <button type="button" class="btn btn-primary storeSanpham">Save..</button>
            </div>


        </div>
    </div>
</div> -->
<!-- <div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa</h5>

            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <form method="post" enctype="multipart/form-data">
                        @csrf
                 
                        <div class="form-floating mb-3">

                            <input type="text" name='tensanpham' id="tensanpham" class='form-control mt-3'>
                            <label for="floatingInput">Tên Sản phẩm</label>
                            <span class="text-danger error-text tensanpham_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='slug_sanpham' id="slug_sanpham" class='form-control mt-3'>
                            <label for="floatingInput">Slug</label>
                            <span class="text-danger error-text slug_sanpham_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idthuonghieu' id="idthuonghieu" class='form-select mb-3' required>
                                @foreach($thuonghieu as $item)
                                <option value="{{$item->idthuonghieu}}">{{$item->tenthuonghieu}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Thương hiệu(*)</label>
                            <span class="text-danger error-text trangthai_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idCPU' id="idCPU" class='form-select mb-3'>

                                @foreach($cpu as $item)
                                <option value="{{$item->idCPU}}">{{$item->tenCPU}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">CPU(*)</label>
                            <span class="text-danger error-text idCPU_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idram' id="idram" class='form-select mb-3'>


                                @foreach($ram as $item)
                                <option value="{{$item->idram}}">{{$item->tenram}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Ram(*)</label>
                            <span class="text-danger error-text idCPU_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='iddohoa' id="iddohoa" class='form-select mb-3'>


                                @foreach($dohoa as $item)
                                <option value="{{$item->iddohoa}}">{{$item->tendohoa}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Card đồ họa(*)</label>
                            <span class="text-danger error-text iddohoa_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idluutru' id="idluutru" class='form-select mb-3'>


                                @foreach($luutru as $item)
                                <option value="{{$item->idluutru}}">{{$item->tenluutru}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Ổ cứng(*)</label>
                            <span class="text-danger error-text idluutru_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idmanhinh' id="idmanhinh" class='form-select mb-3'>


                                @foreach($manhinh as $item)
                                <option value="{{$item->idmanhinh}}">{{$item->tenmanhinh}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Màn hình(*)</label>
                            <span class="text-danger error-text idmanhinh_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select name='idloaisanpham' id="idloaisanpham" class='form-select mb-3'>


                                @foreach($loaisp as $item)
                                <option value="{{$item->idloaisanpham}}">{{$item->tenloai}}</option>
                                @endforeach
                            </select>
                            <label for="floatingInput">Nhu cầu(*)</label>
                            <span class="text-danger error-text idloaisanpham_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="file" name='img' class='form-control mt-3'>
                            <img id="img1" style="width:200px;margin:10px" alt="">
                            <label for="floatingInput">Hình ảnh</label>
                            <span class="text-danger error-text img_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <textarea style="height: 150px;" name="motasanpham" id="motasanpham" class='form-control'></textarea>
                            <label for="floatingInput">Mô tả</label>
                            <span class="text-danger error-text motasanpham_err"></span>
                        </div>
                         <div class="form-floating mb-3">

                            <textarea style="height: 150px;" name="noidung" id="noidung" class='form-control'></textarea>

                            <label for="floatingInput">Nội dung</label>
                            <span class="text-danger error-text noidung_err"></span>
                        </div> 
                        <div class="mb-3">
                            <label class="form-label">Nội dung</label>
                            <textarea style="height: 150px;" name="noidung" id="noidung1" class='form-control'></textarea>
                            <script>
                                CKEDITOR.replace('noidung1')
                            </script>
                            <span class="text-danger error-text noidung_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='gia' id="gia" class='form-control mt-3'>
                            <label for="floatingInput">Giá</label>
                            <span class="text-danger error-text gia_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="number" min="0" value="0" step="1" name='soluong' id="soluong" class='form-control mt-3'>
                            <label for="floatingInput">Số lượng</label>
                            <span class="text-danger error-text soluong_err"></span>
                        </div>
                        <fieldset class="row mb-3">
                            <legend class="col-form-label col-sm-2 pt-0">HOT</legend>
                            <div class="col-sm-10">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hot" id="hot" value="1">
                                    <label class="form-check-label" for="gridRadios1">
                                        Có
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="hot" id="hot" value="0">
                                    <label class="form-check-label" for="gridRadios2">
                                        Không
                                    </label>
                                </div>
                            </div>
                        </fieldset>
                        <div class="form-floating mb-3">

                            <select type="number" name='trangthai' id="trangthai" class='form-select mt-3'>
                                <option value="0">Ẩn</option>
                                <option value="1">Hiện</option>
                            </select>
                            <label for="floatingInput">Trạng thái</label>
                            <span class="text-danger error-text trangthai_err"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/product" class="btn btn-secondary">Thoat</a>

                <button type="button" class="btn btn-primary updateSanpham">Save..</button>
            </div>


        </div>
    </div>
</div> -->
<!-- Table End -->
@stop
@section('script')
<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    function confirmXoa(event) {
        event.preventDefault(); // Ngăn chặn hành động mặc định của sự kiện onchange

        Swal.fire({
            title: "Xác nhận xóa",
            text: "Bạn có chắc chắn muốn xóa?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Xóa",
            cancelButtonText: "Hủy"
        }).then((result) => {
            if (result.isConfirmed) {
                // Hành động xóa khi người dùng xác nhận
                event.target.form.submit();
            }
        });
    }
    $(document).ready(
        function() {
            $('.selectbrand').select2({
                closeOnSelect: false,
                allowClear: false,
                placeholder: "--Chọn thương hiệu--"
            });
            // new MultiSelectTag('selectbrand', {
            //     rounded: true, // default true
            //     shadow: true, // default false
            //     placeholder: 'Search', // default Search...
            //     onChange: function(values) {
            //         console.log(values)
            //     }
            // })
            $('.selectcpu').select2({
                closeOnSelect: false,
                allowClear: false,
                placeholder: "--Chọn CPU--"
            });
            $('.selectram').select2({
                closeOnSelect: false,
                allowClear: false,
                placeholder: "--Chọn RAM--"
            });
            $('.selectluutru').select2({
                closeOnSelect: false,
                allowClear: false,
                placeholder: "--Chọn Ổ cứng--"
            });
            $('.selectdohoa').select2({
                closeOnSelect: false,
                allowClear: false,
                placeholder: "--Chọn Card Đồ Họa--"
            });
            $('.selectnhucau').select2({
                closeOnSelect: false,
                allowClear: false,
                placeholder: "--Chọn Nhu Cầu--"
            });
            $('.selectmanhinh').select2({
                closeOnSelect: false,
                allowClear: false,
                placeholder: "--Chọn Kích thước--"
            });
            $('.selectgia').select2({
                closeOnSelect: false,
                allowClear: false,
                placeholder: "--Chọn mức giá--"
            });
            // $('.select2').on('select2:unselecting', function(e) {
            //     if (e.params.args.data.id === '') {
            //         e.preventDefault(); // Ngăn người dùng xóa tùy chọn "--Chọn thương hiệu--"
            //     }
            // });


            // $('button.addSanpham').click(
            //     function() {
            //         $('#modelId').modal('show');

            //     }
            // );

            // $('button.storeSanpham').click(function() {

            //     for (const instance in CKEDITOR.instances) {
            //         CKEDITOR.instances[instance].updateElement();
            //     }
            //     let data = new FormData($('#modelId form')[0]); // you can consider this as 'data bag'

            //     //  files.append('fileName', $('#img')[0].files[0]);
            //     // let formData = new FormData();
            //     // formData.append('img', $('#img')[0].files[0]);
            //     // alert('hello');
            //     // e.preventDefault();
            //     //var ten = $("#ten").val();
            //     $.ajax({
            //         url: '/admin/product/store',
            //         type: 'POST',
            //         //  data: $('#modelId form').serializeArray(),files,
            //         data: data,
            //         dataType: 'json',
            //         processData: false, // tell jQuery not to process the data
            //         contentType: false, // tell jQuery not to set contentType
            //         // async: false,
            //         // cache: false,
            //         // enctype: 'multipart/form-data',
            //         success: function(s) {
            //             console.log(s);
            //             if ($.isEmptyObject(s.error)) {
            //                 alert("Thêm thành công");
            //                 location.reload();
            //                 $('#modelId').modal('hide');
            //             } else {
            //                 printErrorMsg(s.error);
            //                 // $.each( s.error , function(k,v){
            //                 //     alert(k+'->'+v);
            //                 // })
            //             }
            //             //$('#modelId form #ten2').val(s.error);
            //             //location.reload();
            //             // location.reload();
            //             // $('#modelId').modal('hide');
            //         },

            //     });

            //     function printErrorMsg(msg) {
            //         $.each(msg, function(key, value) {
            //             console.log(key);
            //             $('.' + key + '_err').text(value);

            //         });
            //     }
            // });
            // $('button.editSanpham').click(
            //     function() {
            //         //let data = new FormData( $('#modelId form')[0] );

            //         $('#modelId1').modal('show');
            //         $.ajax({
            //             url: '/admin/product/edit/' + $(this).data('id'),
            //             type: 'get',
            //             data: {
            //                 id: 1
            //             },
            //             dataType: 'json',
            //             success: function(data2) {
            //                 console.log(data2);
            //                 $('#modelId1 form #tensanpham').val(data2.tensanpham);
            //                 $('#modelId1 form #idsanpham').val(data2.idsanpham);
            //                 $('#modelId1 form #gia').val(data2.gia);
            //                 $('#modelId1 form #soluong').val(data2.soluong);
            //                 // $('#modelId1 form #noidung1').val(data2.noidung);
            //                 CKEDITOR.instances['noidung1'].setData(data2.noidung);

            //                 $('#modelId1 form #slug_sanpham').val(data2.slug_sanpham);
            //                 $('#modelId1 form #idthuonghieu').val(data2.idthuonghieu);
            //                 $('#modelId1 form #idram').val(data2.idram);
            //                 $('#modelId1 form #iddohoa').val(data2.iddohoa);
            //                 $('#modelId1 form #idmanhinh').val(data2.idmanhinh);
            //                 $('#modelId1 form #idluutru').val(data2.idluutru);
            //                 $('#modelId1 form #idloaisanpham').val(data2.idloaisanpham);
            //                 $('#modelId1 form #idCPU').val(data2.idCPU);
            //                 $('#modelId1 form #motasanpham').val(data2.motasanpham);
            //                 $('#modelId1 form #img1').attr('src', '/storage/img/' + data2.img);
            //                 if (data2.hot == 1) {
            //                     $('#modelId1 form input[name="hot"][value="1"]').prop('checked', true);
            //                 } else if (data2.hot == 0) {
            //                     $('#modelId1 form input[name="hot"][value="0"]').prop('checked', true);
            //                 }

            //                 $('#modelId1 form #trangthai').val(data2.trangthai);

            //             }
            //         })

            //     }

            // );


            // $('button.updateSanpham').click(function() {
            //     // alert('update');
            //     //     let data = {_token: $('input[name="_token"]:eq(0)').val() };//new FormData( $('#modelId1 form')[0] );
            //     //  console.log(data);
            //     // return;
            //     for (const instance in CKEDITOR.instances) {
            //         CKEDITOR.instances[instance].updateElement();
            //     }
            //     let data = new FormData($('#modelId1 form')[0])
            //     $.ajax({
            //         url: '/admin/product/update',
            //         type: 'POST',
            //         data: data,
            //         dataType: 'json',
            //         processData: false, // tell jQuery not to process the data
            //         contentType: false,
            //         success: function(s) {
            //             console.log(s);
            //             if ($.isEmptyObject(s.error)) {
            //                 alert("Sua thanh cong");
            //                 location.reload();
            //                 $('#modelId1').modal('hide');
            //             } else {
            //                 printErrorMsg(s.error);
            //                 // $.each( s.error , function(k,v){
            //                 //     alert(k+'->'+v);
            //                 // })
            //             }
            //         },
            //         // error: function(mess) {
            //         //     console.log(mess);
            //         // }

            //     });

            //     function printErrorMsg(msg) {
            //         $.each(msg, function(key, value) {
            //             console.log(key);
            //             $('.' + key + '_err').text(value);
            //         });
            //     }
            // });

        }
    );
</script>
@stop