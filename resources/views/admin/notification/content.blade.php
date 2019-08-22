{{--{{dd($a)}}--}}
<div class="row">
    <div class="col-md-12">
        <!-- DATA TABLE -->
        <div class="card">
            <div class="card-header">
                <i class="zmdi zmdi-account-calendar"></i> User data
            </div>
            <table class="table table-data2">
                <thead>
                <tr>
                    <th>Mã tin nhắn</th>
                    <th>Người gửi-Người nhận</th>
                    <th>Nội dung</th>
                </tr>
                </thead>

{{--                @foreach($members as $member)--}}
{{--                    <tr>--}}
{{--                        <td><a href="#">{{$member['id']}}</a> </td>--}}
{{--                        <td><a href="#">{{$member['name']}} <img src="{{$member['avatar']}}" style="width: 30px;"> </a> =>@foreach($member['avt'] as $avt)--}}
{{--                                <span class="d-inline-block" tabindex="0" data-toggle="tooltip" title="{{$avt['name']}}">--}}
{{--                                <img src="{{$avt['avatar_image_url']}}" style="width: 30px;">--}}
{{--                                </span>--}}
{{--                            @endforeach</td>--}}
{{--                        <td>{{$member['message']}} </td>--}}

{{--                    </tr>--}}

{{--                @endforeach--}}
            </table>
{{--            {{$items->links()}}--}}
        </div>
    </div>

</div>

