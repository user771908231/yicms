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
            <form method="post" action="{{route('parking.index')}}" name="form">
                <table class="table table-striped table-bordered table-hover m-t-md">
                    <thead>
                    <tr>
                        <th class="text-center" width="100">ID</th>
                        <th class="text-center">区域</th>
                        <th class="text-center">用户</th>
                        <th class="text-center" >车牌</th>
                        <th class="text-center">进出</th>
                        <th class="text-center" >时间</th>
                        {{--<th class="text-center" width="150">注册IP</th>--}}
                        {{--<th class="text-center" width="80">登录次数</th>--}}
                        {{--<th class="text-center" width="80">状态</th>--}}
                        <th class="text-center" width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    {{dd($lists)}}--}}
                    @foreach($lists as $k => $item)
                        <tr>
                            <td class="text-center">{{$item->v_id}}</td>
                            <td class="text-center">{{$item->machine_name}}</td>
                            <td class="text-center">{{$item->user->truename}}</td>
                            <td class="text-center">{{$item->license_plate}}</td>
                            <td class="text-center">
                                @if($item->is_out == 1)
                                    出
                                @else
                                    进
                                @endif
                            </td>
                            <td class="text-center">
                                {{mb_substr($item->time,0,4).'-'.mb_substr($item->time,4,2).'-'.mb_substr($item->time,6,2)." ".mb_substr($item->time,8,2).':'.mb_substr($item->time,10,2).':'.mb_substr($item->time,12) }}
                            </td>

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
                                        <form class="form-common" action="{{route('parking.destroy',$item->v_id)}}" method="post">
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