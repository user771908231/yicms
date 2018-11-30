@extends('admin.layouts.layout')
@section('content')
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox-title">
                <h5>添加管理员</h5>
            </div>
            <div class="ibox-content">
                <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
                <a href="{{route('user.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 管理员管理</button></a>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <form class="form-horizontal m-t-md" action="{{ route('user.store') }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <input type="hidden" name="type" value="{{\Illuminate\Support\Facades\Auth::user()->attribute->accessControl->ac_type}}">
                    <div class="form-group">
                        <label class="col-sm-2 control-label">用户名：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="name" id="name" value="{{old('name')}}"  placeholder="姓名" title="姓名" disabled="disabled" >
                            @if ($errors->has('name'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('name')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">电话：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" value="{{old('phone')}}"  name="phone" id="phone" placeholder="电话（纯数字）" title="请确保该手机号码已注册为物眼用户" >
                            @if ($errors->has('phone'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('phone')}}</span>
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
            data: {phone: phone,type:0,'_token':'{{csrf_token()}}'},
            url: "{{route('parking-lot.search')}}",
            dataType: "json",

            success: function (data) {
                console.log(data);
                if (data == 'NOT_FOUND'){
                    alert('没有该用户');
                }else{
                    $('#name').val(data);
                }
            }
        })
    });
</script>
@stop
@endsection