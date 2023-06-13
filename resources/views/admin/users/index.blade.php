@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Người dùng(Khách hàng)</h6>
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
                                <th scope="col">Tên người dùng</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</tH>
                                <th>Cấp độ</th>
                            </tr>
                        </thead>
                        @foreach($users as $item)
                        <tbody>
                            <tr>
                                <td>{{$item->idnguoidung}}</td>
                                <td>{{$item->tennguoidung}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->sdt}}</td>
                                <td>{{$item->diachi}}</td>
                                <td> @if($item->level==0)
                                    {{'Khách hàng'}}
                                    @else
                                    {{'Admin'}}
                                    @endif
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
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Admin</h6>
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
                                <th scope="col">Tên người dùng</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</tH>
                                <th>Cấp độ</th>
                            </tr>
                        </thead>
                        @foreach($admin as $item)
                        <tbody>
                            <tr>
                                <td>{{$item->idnguoidung}}</td>
                                <td>{{$item->tennguoidung}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->sdt}}</td>
                                <td>{{$item->diachi}}</td>
                                <td>
                                    @if($item->level==0)
                                    {{'Khách hàng'}}
                                    @else
                                    {{'Admin'}}
                                    @endif

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
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Admin quản lý</h6>
                <p><button class='addadmin btn btn-primary'>Thêm</button></p>
                @if(session()->has('mess'))
                <p class="alert alert-primary sm-4">
                    {{session('mess')}}
                </p>
                @endif
                @if(session()->has('thongbao'))
                <p class="alert alert-primary sm-4">
                    {{session('thongbao')}}
                </p>
                @endif
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Tên người dùng</th>
                                <th>Email</th>
                                <th>SĐT</th>
                                <th>Địa chỉ</tH>
                                <th>Cấp độ</th>
                                <th>🗑️</th>
                                <th>✏️</th>
                            </tr>
                        </thead>
                        @foreach($adminql as $item)
                        <tbody>
                            <tr>
                                <td>{{$item->idnguoidung}}</td>
                                <td>{{$item->tennguoidung}}</td>
                                <td>{{$item->email}}</td>
                                <td>{{$item->sdt}}</td>
                                <td>{{$item->diachi}}</td>
                                <td>
                                    @if($item->level==0)
                                    {{'Khách hàng'}}
                                    @elseif($item->level==1)
                                    {{'Admin'}}
                                    @elseif($item->level==2)
                                    {{'Admin quản lý danh mục'}}
                                    @elseif($item->level==3)
                                    {{'Admin quản lý sản phẩm'}}
                                    @elseif($item->level==4)
                                    {{'Admin quản lý Banner'}}
                                    @elseif($item->level==5)
                                    {{'Admin quản lý khuyến mãi'}}
                                    @elseif($item->level==6)
                                    {{'Admin quản lý giảm giá'}}
                                    @elseif($item->level==7)
                                    {{'Admin quản lý đơn hàng'}}
                                    @endif

                                </td>
                                
                                <td>
                                    <form action="/admin/users/destroy/{{$item->idnguoidung}}" method="POST">
                                        @csrf
                                        <input type="hidden" name="_method" value="delete">
                                        <input type="submit" value="xóa" class="btn btn-danger">
                                    </form>
                                </td>
                                <td>
                                    <button class='editadmin btn btn-success' data-id='{{$item->idnguoidung}}'>Cấp quyền</button>
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
                <h5 class="modal-title">Thêm</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <form method="POST">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="hidden" class="form-control"  name="idnguoidung">
                            <span class="text-danger error-text idram_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='tennguoidung' id="tennguoidung" class='form-control mt-3'>
                            <label for="floatingInput">Tên người dùng</label>
                            <span class="text-danger error-text tennguoidung_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='email' id="email" class='form-control mt-3'>
                            <label for="floatingInput">Email</label>
                            <span class="text-danger error-text email_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="password" name='password' id="password" class='form-control mt-3'>
                            <label for="floatingInput">Password</label>
                            <span class="text-danger error-text password_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <input type="text" name='sdt' id="sdt" class='form-control mt-3'>
                            <label for="floatingInput">SĐT</label>
                            <span class="text-danger error-text sdt_err"></span>
                        </div>

                        <div class="form-floating mb-3">

                            <textarea style="height: 150px;" name="diachi" id="diachi" class='form-control'></textarea>
                            <label for="floatingInput">Địa chỉ</label>
                            <span class="text-danger error-text diachi_err"></span>
                        </div>
                        <div class="form-floating mb-3">

                            <select type="number" name='level'  class='form-select mt-3'>
                                <option value="">--Chọn cấp độ--</option>
                                <option value="2">Quản lý danh mục</option>
                                <option value="3">Quản lý sản phẩm</option>
                                <option value="4">Quản lý Banner</option>
                                <option value="5">Quản lý khuyến mãi</option>
                                <option value="6">Quản lý giảm giá</option>
                                <option value="7">Quản lý đơn hàng</option>
                            </select>
                            <label for="floatingInput">Cấp độ</label>
                            <span class="text-danger error-text level_err"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/users" class="btn btn-secondary">Thoát</a>
                <button type="button" class="btn btn-primary storeadmin">Save..</button>
            </div>


        </div>
    </div>
</div>
<div class="modal fade" id="modelId1" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cấp quyền</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container-fluid">
                    <form method="post">
                        @csrf
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="idnguoidung" name="idnguoidung" readonly>
                            <label for="floatingInput">ID</label>
                            <span class="text-danger error-text idnguoidung_err"></span>

                        </div>
                        <div class="form-floating mb-3">

                            <select type="number" name='level' id="level" class='form-select mt-3' required>
                                <option value="">--Chọn cấp độ--</option>
                                <option value="2">Quản lý danh mục</option>
                                <option value="3">Quản lý sản phẩm</option>
                                <option value="4">Quản lý Banner</option>
                                <option value="5">Quản lý khuyến mãi</option>
                                <option value="6">Quản lý giảm giá</option>
                                <option value="7">Quản lý đơn hàng</option>
                            </select>
                            <label for="floatingInput">Cấp độ</label>
                            <span class="text-danger error-text level_err"></span>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer">
                <a href="/admin/users" class="btn btn-secondary">Thoat</a>

                <button type="button" class="btn btn-primary updateadmin">Save..</button>
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

            $('button.addadmin').click(
                function() {
                    $('#modelId').modal('show');
                }
            );

            $('button.storeadmin').click(function() {

                let data = new FormData($('#modelId form')[0]); // you can consider this as 'data bag'
                //  files.append('fileName', $('#img')[0].files[0]);
                // let formData = new FormData();
                // formData.append('img', $('#img')[0].files[0]);
                // alert('hello');
                // e.preventDefault();
                //var ten = $("#ten").val();
                $.ajax({
                    url: '/admin/users/store',
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
            $('button.editadmin').click(
                function() {
                    //let data = new FormData( $('#modelId form')[0] );

                    $('#modelId1').modal('show');
                    $.ajax({
                        url: '/admin/users/edit/' + $(this).data('id'),
                        type: 'get',
                        data: {
                            id: 1
                        },
                        dataType: 'json',
                        success: function(data2) {
                            console.log(data2);
                           
                            $('#modelId1 form #idnguoidung').val(data2.idnguoidung);
                            $('#modelId1 form #level').val(data2.level);

                        }
                    })
                }
            );
            $('button.updateadmin').click(function() {
                // alert('update');
                //     let data = {_token: $('input[name="_token"]:eq(0)').val() };//new FormData( $('#modelId1 form')[0] );
                //  console.log(data);
                // return;
                let data = new FormData($('#modelId1 form')[0])
                $.ajax({
                    url: '/admin/users/update',
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