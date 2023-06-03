@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Quản lý giảm giá</h6>
                <p><button class='addgiamgia btn btn-primary'>Thêm</button></p>
                @if(session()->has('mess'))
                <p class="alert alert-primary sm-4">
                    {{session('mess')}}
                </p>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên giảm giá</th>
                                <th>Mã code giảm giá</th>
                                <th>Ngày bắt đầu</th>
                                <th>Ngày kết thúc</th>
                                <th>Số lượng</th>
                                <th>Điều kiện giảm giá</th>
                                <th>Số giảm</th>
                                <th>Hết hạn</th>
                                <th>Trạng thái</th>
                                <th>🗑️</th>
                                <th>✏️</th>
                            </tr>
                        </thead>
                        @foreach($coupon as $item)
                        <tbody>
                            <tr>
                                <td>{{$item->idgiamgia}}</td>
                                <td>{{$item->tengiamgia}}</td>
                                <td>{{$item->codegiamgia}}</td>
                                <td>{{$item->ngaybatdau}}</td>
                                <td>{{$item->ngayketthuc}}</td>
                                <td>{{$item->soluong}}</td>
                                <td>@if($item->tinhnangma==0)
                                    {{'Giảm theo phần trăm'}}
                                    @else
                                    {{'Giảm theo tiền'}}
                                    @endif
                                </td>
                                <td>
                                    @if($item->tinhnangma==0)
                                    {{'Giảm' .$item->sotiengiam. '%'}}
                                    @else
                                    {{'Giảm' .$item->sotiengiam. 'đ'}}
                                    @endif
                                </td>

                                <td>
                                    @if($item->ngayketthuc>=$today)
                                    <span style="color: green;">Còn hạn</span>
                                    @else
                                    <span style="color: red;">Hết hạn</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->trangthai==1)
                                    <span style="color: green;">Đang kích hoạt</span>
                                    @else
                                    <span style="color: red;">Đã khóa</span>
                                    @endif
                                </td>

                                <td>
                                    <form action="/admin/giamgia/destroy/{{$item->idgiamgia}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <input onclick="return confirm('Ban thuc su muon xoa ?')" type="submit" value="xóa" class="btn btn-danger">
                                    </form>
                                </td>
                                <td>
                                    <button class='editgiamgia btn btn-success' data-id='{{$item->idgiamgia}}'>Sửa</button>
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
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Thêm </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="hidden" class="form-control" id="idgiamgia" name="idgiamgia">
                            <span class="text-danger error-text idgiamgia_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='tengiamgia' id="tengiamgia" class='form-control mt-3'>
                            <label for="floatingInput">Tên giảm giá</label>
                            <span class="text-danger error-text tengiamgia_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='codegiamgia' id="codegiamgia" class='form-control mt-3'>
                            <label for="floatingInput">Mã code giảm giá</label>
                            <span class="text-danger error-text codegiamgia_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="date" name='ngaybatdau' id="ngaybatdau" class='form-control mt-3'>
                            <label for="floatingInput">Ngày bắt đầu</label>
                            <span class="text-danger error-text ngaybatdau_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="date" name='ngayketthuc' id="ngayketthuc" class='form-control mt-3'>
                            <label for="floatingInput">Ngày kết thúc</label>
                            <span class="text-danger error-text ngayketthuc_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='soluong' id="soluong" class='form-control mt-3'>
                            <label for="floatingInput">Số lượng giảm giá</label>
                            <span class="text-danger error-text soluong_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select type="number" name='tinhnangma' class='form-select mt-3'>
                                <option value="0">Giảm giá theo phần trăm</option>
                                <option value="1">Giảm giá theo tiền</option>
                            </select>
                            <label for="floatingInput">Tính năng mã</label>
                            <span class="text-danger error-text tinhnangma_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='sotiengiam' id="sotiengiam" class='form-control mt-3'>
                            <label for="floatingInput">Nhập số hoặc phần trăm giảm giá</label>
                            <span class="text-danger error-text sotiengiam_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select type="number" name='trangthai' class='form-select mt-3'>
                                <option value="0">Đã khóa</option>
                                <option value="1">Kích hoạt</option>
                            </select>
                            <label for="floatingInput">Trạng thái</label>
                            <span class="text-danger error-text trangthai_err"></span>
                        </div>


                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/giamgia" class="btn btn-secondary">Thoát</a>
                <button type="button" class="btn btn-primary storegiamgia">Save..</button>
            </div>


        </div>
    </div>
</div>
<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Sửa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <form method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="idgiamgia" name="idgiamgia" readonly>
                            <label for="floatingInput">ID</label>
                            <span class="text-danger error-text idgiamgia_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='tengiamgia' id="tengiamgia" class='form-control mt-3'>
                            <label for="floatingInput">Tên giảm giá</label>
                            <span class="text-danger error-text tengiamgia_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='codegiamgia' id="codegiamgia" class='form-control mt-3'>
                            <label for="floatingInput">Mã code giảm giá</label>
                            <span class="text-danger error-text codegiamgia_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="date" name='ngaybatdau' id="ngaybatdau" class='form-control mt-3'>
                            <label for="floatingInput">Ngày bắt đầu</label>
                            <span class="text-danger error-text ngaybatdau_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="date" name='ngayketthuc' id="ngayketthuc" class='form-control mt-3'>
                            <label for="floatingInput">Ngày kết thúc</label>
                            <span class="text-danger error-text ngayketthuc_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='soluong' id="soluong" class='form-control mt-3'>
                            <label for="floatingInput">Số lượng giảm giá</label>
                            <span class="text-danger error-text soluong_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select type="number" name='tinhnangma' id="tinhnangma" class='form-select mt-3'>
                                <option value="0">Giảm giá theo phần trăm</option>
                                <option value="1">Giảm giá theo tiền</option>
                            </select>
                            <label for="floatingInput">Tính năng mã</label>
                            <span class="text-danger error-text tinhnangma_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='sotiengiam' id="sotiengiam" class='form-control mt-3'>
                            <label for="floatingInput">Nhập số hoặc phần trăm giảm giá</label>
                            <span class="text-danger error-text sotiengiam_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select type="number" name='trangthai' id="trangthai" class='form-select mt-3'>
                                <option value="0">Đã khóa</option>
                                <option value="1">Kích hoạt</option>
                            </select>
                            <label for="floatingInput">Trạng thái</label>
                            <span class="text-danger error-text trangthai_err"></span>
                        </div>

                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/giamgia" class="btn btn-secondary">Thoat</a>

                <button type="button" class="btn btn-primary updategiamgia">Save..</button>
            </div>


        </div>
    </div>
</div>
<!-- Table End -->
@stop
@section('script')
<script>
    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $(document).ready(
        function() {

            $('button.addgiamgia').click(
                function() {
                    $('#modelId').modal('show');
                }
            );

            $('button.storegiamgia').click(function() {

                let data = new FormData($('#modelId form')[0]); // you can consider this as 'data bag'
                //  files.append('fileName', $('#img')[0].files[0]);
                // let formData = new FormData();
                // formData.append('img', $('#img')[0].files[0]);
                // alert('hello');
                // e.preventDefault();
                //var ten = $("#ten").val();
                $.ajax({
                    url: '/admin/giamgia/store',
                    type: 'POST',
                    //  data: $('#modelId form').serializeArray(),files,
                    data: data,
                    dataType: 'json',
                    processData: false, // tell jQuery not to process the data
                    contentType: false, // tell jQuery not to set contentType
                    // async: false,
                    // cache: false,
                    // enctype: 'multipart/form-data',
                    success: function(s) {
                        console.log(s);
                        if ($.isEmptyObject(s.error)) {
                            alert("Thêm thành công");
                            location.reload();
                            $('#modelId').modal('hide');
                        } else {
                            printErrorMsg(s.error);
                            // $.each( s.error , function(k,v){
                            //     alert(k+'->'+v);
                            // })
                        }
                        //$('#modelId form #ten2').val(s.error);
                        //location.reload();
                        // location.reload();
                        // $('#modelId').modal('hide');
                    },

                });

                function printErrorMsg(msg) {
                    $.each(msg, function(key, value) {
                        console.log(key);
                        $('.' + key + '_err').text(value);
                    });
                }
            });

        }
    );
    $(document).ready(
        function() {
            $('button.editgiamgia').click(
                function() {
                    //let data = new FormData( $('#modelId form')[0] );

                    $('#modelId1').modal('show');
                    $.ajax({
                        url: '/admin/giamgia/edit/' + $(this).data('id'),
                        type: 'get',
                        data: {
                            id: 1
                        },
                        dataType: 'json',
                        success: function(data2) {
                            console.log(data2);
                            $('#modelId1 form #idgiamgia').val(data2.idgiamgia);
                            $('#modelId1 form #tengiamgia').val(data2.tengiamgia);
                            $('#modelId1 form #ngaybatdau').val(data2.ngaybatdau);
                            $('#modelId1 form #ngayketthuc').val(data2.ngayketthuc);
                            $('#modelId1 form #codegiamgia').val(data2.codegiamgia);
                            $('#modelId1 form #soluong').val(data2.soluong);
                            $('#modelId1 form #tinhnangma').val(data2.tinhnangma);
                            $('#modelId1 form #sotiengiam').val(data2.sotiengiam);
                            $('#modelId1 form #trangthai').val(data2.trangthai);

                        }
                    })
                }
            );
            $('button.updategiamgia').click(function() {
                // alert('update');
                //     let data = {_token: $('input[name="_token"]:eq(0)').val() };//new FormData( $('#modelId1 form')[0] );
                //  console.log(data);
                // return;
                let data = new FormData($('#modelId1 form')[0])
                $.ajax({
                    url: '/admin/giamgia/update',
                    type: 'POST',
                    data: data,
                    dataType: 'json',
                    processData: false, // tell jQuery not to process the data
                    contentType: false,
                    success: function(s) {
                        console.log(s);
                        if ($.isEmptyObject(s.error)) {
                            alert("Sua thanh cong");
                            location.reload();
                            $('#modelId1').modal('hide');
                        } else {
                            printErrorMsg(s.error);
                            // $.each( s.error , function(k,v){
                            //     alert(k+'->'+v);
                            // })
                        }
                    },
                    // error: function(mess) {
                    //     console.log(mess);
                    // }

                });

                function printErrorMsg(msg) {
                    $.each(msg, function(key, value) {
                        console.log(key);
                        $('.' + key + '_err').text(value);
                    });
                }
            });
        }
    );
</script>
@stop