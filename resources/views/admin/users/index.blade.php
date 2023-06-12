@extends('admin/layouts/masteradmin')
@section('content')
<!-- Table Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-md-12">
            <div class="bg-light rounded h-100 p-4">
                <h6 class="mb-4">Quản lý Users</h6>
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
