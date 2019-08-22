{{--{{dd($a)}}--}}
<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <div class="card">
            <div class="card-header">
                <i class="zmdi zmdi-account-calendar"></i> User data
                <span style="float: right"> <button onclick="window.location='{{route('admin.create')}}'" type="button"
                                                    class="btn btn-primary">Thêm mới</button></span>
            </div>
            <form action="{{route('admin.search')}}" method="get" class="form-horizontal">
                <div class="card-body card-block">
                    <div class="row form-group">
                        <div class="col-6">
                            <div class="row form-group">
                                <div class="col-4"><label for="exampleInputName2">Tên người sử dụng</label></div>
                                <div class="col-8"><input type="text" id="name" name="name"
                                                          value="{{\Illuminate\Support\Facades\Session::get('name')}}"
                                                          placeholder="Nhập vào tên"
                                                          class="form-control"></div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row form-group">
                                <div class="col-4">
                                    <label for="exampleInputName2">Email</label>
                                </div>
                                <div class="col-8">
                                    <input type="text" id="email" name="email" placeholder="Nhập vào email"
                                           value="{{\Illuminate\Support\Facades\Session::get('email')}}"
                                           class="form-control">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row form-group">
                        <div class="col-6">
                            <div class="row form-group">
                                <div class="col-4">
                                    <label for="exampleInputName2">Quyền sử dụng</label>
                                </div>
                                <div class="col-8">
                                    <select class="browser-default custom-select" name="role" id="role">
                                        @foreach(config('rules.role') as $value=> $key)
                                            <option {{ \Illuminate\Support\Facades\Input::get('role') == $key ?"selected":'' }} value="{{$key}}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="row form-group">
                                <div class="col-4">
                                    <label for="exampleInputName2">Trạng thái</label>
                                </div>
                                <div class="col-8">
                                    <select class="browser-default custom-select" name="active" id="active">
                                        @foreach(config('rules.active') as $value=> $key)
                                            <option {{ \Illuminate\Support\Facades\Input::get('active') == $key ?"selected":'' }} value="{{$key}}">
                                                {{ $value }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fa fa-dot-circle-o"></i> Tìm kiếm
                    </button>

                </div>
            </form>
            <hr/>
            <table class="table table-data2">
                <thead>
                <tr>
                    <th>STT</th>
                    @if($request->sort=='')
                        <th><a href="{{route('admin.index',['sort'=>'asc','field'=>'name'])}}"> Tên đăng
                                nhập </a></th>
                    @else
                        <th><a href="{{route('admin.index',['sort'=>$request->sort,'field'=>'name'])}}"> Tên đăng
                                nhập </a></th>
                    @endif
                    @if($request->sort=='')
                        <th><a href="{{route('admin.index',['sort'=>'asc','field'=>'email'])}}"> Email </a></th>
                    @else
                        <th><a href="{{route('admin.index',['sort'=>$request->sort,'field'=>'email'])}}"> Email </a>
                        </th>
                    @endif

                    <th><a href="#"> Địa chỉ</a></th>
                    <th>Trạng thái</th>
                    <th>Quyền</th>
                    <th>Hình ảnh</th>
                    <th>Hành động</th>
                </tr>
                </thead>

                @foreach($user as $users)
                    <tbody>
                    <tr class="tr-shadow">
                        <td>{{($loop->index+1)+($user->currentPage()-1)*($user->perPage())}}</td>
                        <td>{{$users->name}}</td>
                        <td>{{$users->email}}</td>
                        <td class="desc">{{$users->address}}</td>
                        <td>{{$users->active_flg==1 ? "Hoạt động" :"Không hoạt động"}}</td>
                        <td>
                            {{$users->role_id==1 ? "Admin" : "Người dùng"}}
                        </td>
                        <td>
                            <img src="{{asset($users->profile_image)}}"
                                 onerror="this.src='{{asset('default-image.jpg')}}'"
                                 style="width: 100px">
                        </td>
                        <td>
                            <form method="get" action="{{route('admin.delete',['id'=>$users->id])}}">
                            <a href="{{route('admin.edit',['id'=>$users->id])}}"><i class="far fa-edit"></i></a>

                            @if($users->id!=Auth::user()->id && $users->active_flg == 1)
                                {{--                                <a href="javascript:;" data-toggle="modal" onclick="deleteData({{$users->id}})"--}}
                                {{--                                   data-target="#DeleteModal" ><i class="fa fa-trash"></i> </a>--}}

                                <button type="submit" onclick="return confirm('Bạn có muốn xoá không?')" href="{{route('admin.delete',['id'=>$users->id])}}" >

                                    <i class="fa fa-trash"
                                            style="font-size:18px;color:red "
                                            title="Delete"></i></button>
                            @else <i class="fa fa-trash"
                                     style="color: red; opacity: 0.2"
                                     aria-hidden="true"></i>
                            @endif
                            </form>

                        </td>
                    </tr>
                    </tbody>
                @endforeach
            </table>
            {{ $user->links() }}
        </div>
        <?php
        \Illuminate\Support\Facades\Session::forget('name');
        \Illuminate\Support\Facades\Session::forget('email');
        ?>

    </div>

</div>

