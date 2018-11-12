@extends('admin.layouts.layout')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>用户管理</h5>
        </div>
        <div class="ibox-content">
            <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
{{--            <a href="{{route('admins.create')}}" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 添加管理员</button></a>--}}
            <form method="post" action="{{route('lists.index')}}" name="form">
                <table class="table table-striped table-bordered table-hover m-t-md">
                    <thead>
                    <tr>
                        <th class="text-center" width="100">ID</th>
                        <th class="text-center">单号</th>
                        <th class="text-center">号牌</th>
                        <th class="text-center">用户</th>
                        <th class="text-center" >状态</th>
                        <th class="text-center" >支付价格</th>
                        <th class="text-center" >停放时间</th>
                        <th class="text-center" >开始时间</th>
                        <th class="text-center" >支付时间</th>
                        {{--<th class="text-center" width="80">登录次数</th>--}}
                        {{--<th class="text-center" width="80">状态</th>--}}
                        <th class="text-center" width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($lists as $k => $item)
{{--                        {{dd($item )}}--}}
                        <tr>
                            <td class="text-center">{{$item->id}}</td>
                            <td class="text-center">{{$item->sn}}</td>
                            <td class="text-center">{{$item->license}}</td>
                            <td class="text-center">
                                @if (!empty($item->user))
                                    {{$item->user->truename}}
                                @endif
                            </td>
                            <td class="text-center">
                                @switch($item->order_state)
                                    @case(0)
                                    已取消
                                    @break

                                    @case(10)
                                    未付款
                                    @break

                                    @case(20)
                                    已付款
                                    @break

                                    @case(30)
                                    已出库
                                    @break

                                    @case(40)
                                    逃单
                                    @break
                                    @default
                                    未知
                                @endswitch
                            </td>
                            <td class="text-center">{{$item->pd_amount}}</td>
                            <td class="text-center">{{\App\Console\PublicFunction::Sec2Time($item->parking_time)}}</td>
                            <td class="text-center">{{date('Y-m-d H:i:s',$item->payment_time)}}</td>
                            <td class="text-center">{{date('Y-m-d H:i:s',$item->add_time)}}</td>
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
                                        <form class="form-common" action="{{route('lists.update',$item->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden" name="type" value="0">
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-jpy"></i> 手动缴费</button>
                                        </form>
                                        <form class="form-common" action="{{route('lists.update',$item->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('PATCH') }}
                                            <input type="hidden" name="type" value="1">
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-check-square-o"></i> 出库</button>
                                        </form>
                                        <form class="form-common" action="{{route('lists.destroy',$item->id)}}" method="post">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i> 删除</button>
                                        </form>
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