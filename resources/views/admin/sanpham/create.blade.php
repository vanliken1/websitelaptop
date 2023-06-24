@extends('admin/layouts/masteradmin')
@section('content')
<div class="container-fluid pt-4 px-4 ">
    <div class="row g-4 d-flex justify-content-center">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Thêm sản phẩm</h6>
                <form action="/admin/product/store" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="idsanpham" name="idsanpham">
                        <label for="floatingInput">Mã</label>
                        <!-- <span class="text-danger error-text idsanpham_err"></span> -->

                    </div>
                    <div class="form-floating mb-3">

                        <input type="text" name='tensanpham' id="tensanpham" class='form-control mt-3'>
                        <label for="floatingInput">Tên Sản phẩm</label>
                        @error('idcat')
                        <p class="alert alert-danger">{{$message}}</p>
                        @enderror
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

                    <div class="mb-3">
                        <label class="form-label">Nội dung</label>
                        <textarea style="height: 150px;" name="noidung" id="noidung" class='form-control'></textarea>
                        <script>
                            CKEDITOR.replace('noidung', {
                                filebrowserBrowseUrl: '/asset/admin/ckfinder/ckfinder.html',
                                filebrowserUploadUrl: '/asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                                filebrowserImageBrowseUrl: '/asset/admin/ckfinder/ckfinder.html?type=Images',
                                filebrowserFlashBrowseUrl: '/asset/admin/ckfinder/ckfinder.html?type=Flash',
                                filebrowserImageUploadUrl: '/asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                                filebrowserFlashUploadUrl: '/asset/admin/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash',
                                filebrowserWindowWidth: '1000',
                                filebrowserWindowHeight: '700'
                            });
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




                    <p class="d-flex justify-content-end">
                        <input type="submit" class="btn btn-success me-2" value="Thêm">

                        <a href="/admin/product" class="btn btn-danger me-2">Trở về</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
</div>
@stop