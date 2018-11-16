@extends('admin.layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>添加</h5>
            </div>
            <div class="ibox-content">
                <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
                <a href="{{route('parking-lot.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 车位列表</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('parking-lot.store') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}" title="用户姓名" placeholder="用户姓名" disabled="disabled">
                            @if ($errors->has('name'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">手机号：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="phone" id="phone" required data-msg-required="请输入密码">
                            @if ($errors->has('password'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('password')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">车辆：</label>
                        <div class="input-group col-sm-2">
                            <input type="password" class="form-control" name="car" placeholder="停放车辆" title="停放车辆" disabled="disabled">
                            @if ($errors->has('password'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('password')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">车位数：</label>
                        <div class="input-group col-sm-2">
                            <input type="number" class="form-control" name="number" placeholder="车位数" title="车位数" value="1">
                            @if ($errors->has('password'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('password')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <div class="col-sm-12 col-sm-offset-2">
                            <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;保 存</button>　<button class="btn btn-white" type="reset"><i class="fa fa-repeat"></i> 重 置</button>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
@section('js')
@parent
<script type="application/javascript">
    $('#phone').blur(function(){
            var phone = $('#phone').val();
            $.ajax({
                type: "post",
                data: {phone: phone,type:1,'_token':'{{csrf_token()}}',},
                url: "{{route('parking-lot.search')}}",
                dataType: "json",
                success: function (data) {
                    switch (data){
                        case 'NOT_FOUND':
                            alert('没有该用户');
                            break;
                        case 'NOT_FOUND_OWNER':
                            alert('该用户不是此小区业主');
                            break;
                        default:
                            $('#name').remove("disabled");
                            $('#name').val(data);
                            $('#name').attr("disabled","disabled");
                            break;
                    }
                }
            })
        });
</script>
@stop
@endsection