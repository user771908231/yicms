@extends('admin.layouts.layout')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>用户管理</h5>
        </div>
        <div class="ibox-content">
            <form></form>
            <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
            {{--<a href="{{route('parking-lot.create')}}" link-url="javascript:void(0)"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 添加</button></a>--}}
            <form method="get" action="{{route('parking-application.index')}}" class="form-horizontal m-t-md" >
                <div class="form-group">
                    <label class="col-sm-3 control-label">关键词：</label>
                    <div class="input-group col-sm-3">
                     <input type="text" class="form-control" name="keywords" placeholder="车牌/姓名/电话"  value=" @isset($_GET['keywords']){{$_GET['keywords']}}@endisset">
                    </div>

                    <div class="input-group col-sm-3 ">
                        <button type="submit" class="btn btn-primary"> 查询</button>
                    </div>
                </div>

                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
            </form>
            <form method="post" action="{{route('parking-application.index')}}" name="form">
                <table class="table table-striped table-bordered table-hover m-t-md">

                    <thead>
                    <tr>
                        <th class="text-center" >ID</th>
                        <th class="text-center">姓名</th>
                        <th class="text-center">电话</th>
                        <th class="text-center" >车位号</th>
                        <th class="text-center" >状态</th>
                        <th class="text-center" >时间</th>
                        <th class="text-center" >备注</th>
                        <th class="text-center" >操作</th>
                    </tr>
                    </thead>
                    <tbody>
{{--                    {{dd($lists)}}--}}
                    @foreach($lists as $k => $item)
                        <tr>

                            <td class="text-center">{{$item->id}}</td>
                            <td class="text-center">
                                @if($item->user)
                                    {{$item->user->truename}}
                                @endif

                            </td>
                            <td class="text-center">
                                @if($item->user)
                                    {{$item->user->phone}}
                                @endif
                            </td>
                            <td class="text-center">{{$item->name}}</td>
                            <td class="text-center">
                                @switch($item->state)
                                    @case(1)
                                        <b style="color:green">同意</b>
                                    @break
                                    @case(2)
                                        <b style="color: red">拒绝</b>
                                    @break
                                    @default
                                        未审核
                                    @break
                                @endswitch
                            </td>
                            <td class="text-center"> {{ date('Y-m-d H:i:s',$item->add_time) }} </td>
                            <td class="text-center">@if($item->remark){{$item->remark}} @else 暂无 @endif</td>
                                <div class="btn-group">
                                    <td class="text-center">
                                        {{--<form class="form-common" action="{{route('parking.destroy',$item->user_id)}}" method="post">--}}
                                            {{--{{ csrf_field() }}--}}
                                            {{--{{ method_field('DELETE') }}--}}
                                            {{--<button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i> 删除</button>--}}
                                        {{--</form>--}}
                                        <a href="{{route('parking-application.edit',[$item->id,'type'=>true])}}" title="通过">
                                            <button class="btn btn-primary btn-xs" type="button"><i class="fa fa-minus-square-o"></i> 通过</button>
                                        </a>
                                        <a href="{{route('parking-application.edit',[$item->id,'type'=>false])}}" title="拒绝">
                                            <button class="btn btn-danger btn-xs" type="button"><i class="fa fa-plus-square-o"></i> 拒绝</button>
                                        </a>
                                    </td>

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