@extends('admin.layouts.layout')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>管理员消费记录</h5>
        </div>
        <div class="ibox-content">
                <table class="table table-striped table-bordered table-hover m-t-md">
                    <thead>
                    <tr>
                        <th class="text-center" >ID</th>
                        <th class="text-center" >用户名</th>
                        <th class="text-center" >消费金额</th>
                        <th class="text-center" >剩余金额</th>
                        <th class="text-center" >操作时间</th>
                        {{--<th class="text-center" width="150">登录时间</th>--}}
                        <th class="text-center" width="100">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($lists as $key => $item)

<tr>
{{--                            {{dd($item)}}--}}
                            <td class="text-center">{{$item->id}}</td>
                            <td class="text-center">@if($item->admin){{$item->admin->name}}@endif</td>
                            <td class="text-center">{{$item->amount_money}}￥</td>
                            <td class="text-center">{{$item->data['amount_money']}}</td>
                            <td class="text-center">{{$item->created_at->diffForHumans()}}</td>
                            <td class="text-center">
                                <form></form>
                                <form class="form-common" action="{{route('consumption.destroy',$item->id)}}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i> 删除</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            <div class="pull-right pagination m-t-no">
                <div class="text-center">
                    {{$lists->links()}}
                </div>
                <div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
@endsection