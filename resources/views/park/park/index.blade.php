@extends('admin.layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>用户管理</h5>
            </div>
            <div class="ibox-content">
                <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
{{--                            <a href="{{route('admins.create')}}" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 添加管理员</button></a>--}}
                <form method="post" action="{{route('lists.index')}}" name="form">
                    <table class="table table-striped table-bordered table-hover m-t-md">
                        <thead>
                        <tr>
                            <th class="text-center">编号</th>
                            <th class="text-center">车牌</th>
                            <th class="text-center">用户</th>
                            <th class="text-center">进库时间</th>
                            <th class="text-center" >停留时间</th>
                            <th class="text-center" >单价</th>
                            <th class="text-center" >此次收费</th>
                            <th class="text-center" >状态</th>
                            <th class="text-center" >地址</th>
                            {{--<th class="text-center" width="80">登录次数</th>--}}
                            {{--<th class="text-center" width="80">状态</th>--}}
                            <th class="text-center" >操作</th>
                        </tr>
                        </thead>
                        <tbody>
{{--                        {{dd($lists)}}--}}
                        @foreach($lists as $k => $item) {{--                        {{dd($item )}}--}}
                            <tr>
                                <td class="text-center">{{$item->id}}</td>
                                <td class="text-center">{{$item->license_plate}}</td>
                                <td class="text-center">
                                    @if($item->user)
                                        {{$item->user->truename}}
                                    @endif
                                </td>
                                <td class="text-center">{{date('Y-m-d H:i:s',$item->go_in)}}</td>
                                <td class="text-center">
                                    @if($item->go_out)
                                    {{App\Console\PublicFunction::Sec2Time($item->go_out-$item->go_in)}}
                                        @endif
                                </td>
                                <td class="text-center">{{$item->access->unit_price }}元</td>
                                <td class="text-center">@if($item->bill )￥ {{$item->bill->unit_price}} @else 暂无 @endif</td>
                                <td class="text-center">
                                    @switch ($item->state)
                                        @case(0)
                                    <p style='color: #ff0e0e'>账单已取消</p>
                                        @break
                                        @case(1)
                                    <p style='color: #13bf13'>待付款</p>
                                        @break
                                        @case(2)
                                    <p style='color: #ff0e0e'>账单超时已过期</p>
                                        @break
                                        @case(3)
                                    <p style='color: #13bf13'>账单已付款,<b style='color: red'>待出库</b></p>
                                        @break
                                        @case(4)
                                    <p style='color: #ff0e0e'>车辆出库超时,重新计费</p>
                                        @break
                                        @case(5)
                                    <p style='color: #0f189b'>车辆完成出库</p>
                                        @break
                                        @case(6)
                                    <p style='color: #13bf13'>待生成订单</p>
                                        @break
                                        @case(7)
                                    <p style='color: #e14517'>逃单</p>

                                    @endswitch
                                </td>
                                <td class="text-center">{{$item->access->ac_name}}</td>
                                {{--<td class="text-center">{{date('Y-m-d H:i:s',$item->add_time)}}</td>--}}
                                {{--<td class="text-center">{{$item->create_ip}}</td>--}}
                                {{--<td class="text-center">{{$item->login_count}}</td>--}}
                                {{--<td class="text-center">--}}
                                {{--@if($item->status == 1)--}}
                                {{--<span class="text-navy">正常</span>--}}
                                {{--@elseif($item->status == 2)--}}
                                {{--<span class="text-danger">锁定</span>--}}
                                {{--@endif--}}
                                {{--</td>--}}
                                {{--<td class="text-center">--}}
                                <div class="btn-group">
                                    <td class="text-center">
                                        <form class="form-common" action="{{route('park.update',$item->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden" name="type" value="0">
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-jpy"></i> 手动缴费</button>
                                        </form>
                                        <form class="form-common" action="{{route('park.update',$item->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden" name="type" value="1">
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-check-square-o"></i> 出库</button>
                                        </form>
                                        {{--<form class="form-common" action="{{route('park.destroy',$item->id)}}" method="post">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--{{ method_field('DELETE') }}--}}
                                            {{--<button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i> 删除</button>--}}
                                        {{--</form>--}}
                                    </td>
                                    {{--<a href="{{route('admins.edit',$item->id)}}">--}}
                                    {{--<button class="btn btn-primary btn-xs" type="button"><i class="fa fa-paste"></i> 修改</button>--}}
                                    {{--</a>--}}
                                    {{--@if($item->status == 2)--}}
                                    {{--<a href="{{route('admins.status',['status'=>1,'id'=>$item->id])}}"><button class="btn btn-info btn-xs" type="button"><i class="fa fa-warning"></i> 恢复</button></a>--}}
                                    {{--@else--}}
                                    {{--<a href="{{route('admins.status',['status'=>2,'id'=>$item->id])}}"><button class="btn btn-warning btn-xs" type="button"><i class="fa fa-warning"></i> 禁用</button></a>--}}
                                    {{--@endif--}}
                                    {{--<a href="{{route('user.destroy ',$item->id)}}"><button class="btn btn-danger btn-xs" type="button"><i class="fa fa-trash-o"></i> 删除</button></a>--}}

                                </div>

                                {{--</td>--}}
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    {{$lists->links()}}
                </form>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>
@endsection