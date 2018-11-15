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
            <form method="post" action="{{route('admins.index')}}" name="form">
                <table class="table table-striped table-bordered table-hover m-t-md">
                    <thead>
                    <tr>
                        <th class="text-center">编号</th>
                        <th class="text-center">整栋</th>
                        <th class="text-center">单元</th>
                        <th class="text-center">门牌号</th>
                        <th class="text-center">姓名</th>
                        <th class="text-center" >电话</th>
                        <th class="text-center" >申请时间</th>
                        <th class="text-center" >车位(数量)</th>
                        <th class="text-center" >状态</th>
                        <th class="text-center" >操作</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    {{dd($lists)}}--}}
                    @foreach($lists as $k => $item)
                        <tr>
                            <td class="text-center">{{$item->id}}</td>
                            <td class="text-center">{{App\Console\PublicFunction::building($item->build,0)}}</td>
                            <td class="text-center">{{App\Console\PublicFunction::building($item->unit,1)}}</td>
                            <td class="text-center">{{App\Console\PublicFunction::building($item->unit,2)}}</td>
                            <td class="text-center">{{$item->name}}</td>
                            <td class="text-center">{{$item->phone}}</td>
                            <td class="text-center">{{date('Y-m-d H:i:s',$item->created_at)}}</td>
                            <td class="text-center">暂无</td>
                            <td class="text-center">
                            @switch( $item->state )
                                @case(0)
                                    <p class="center" style="color: red">待审核</p>
                                @break
                                @case(1)
                                <p class="center" style="color: #2ca02c">审核通过</p>
                                @break
                                    @default
                                    <p class="center" style="color: #404a58">已拒绝</p>
                                @endswitch
                            </td>
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
                                        <form></form>
                                        <form class="form-common" action="{{route('household.update',$item->id)}}" method="post">
                                            <input type="hidden" name="state" value="1">
                                            {{ csrf_field() }}
                                            {{method_field('PATCH')}}
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-trash-o"></i> 通过</button>
                                        </form>

                                        <form class="form-common" action="{{route('household.update',$item->id)}}" method="post">
                                            <input type="hidden" name="state" value="2">
                                            {{ csrf_field() }}
                                            {{method_field('PATCH')}}
                                            <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-trash-o"></i> 拒绝</button>
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