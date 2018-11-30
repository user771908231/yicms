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
                        <label class="col-sm-2 control-label">栋数：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" value="{{old('building')}}" name="building" id="building" placeholder="栋数（纯数字）" title="栋数（纯数字）">
                            @if ($errors->has('building'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('building')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">单元：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control"  value="{{old('unit')}}" name="unit" id="unit" placeholder="单元（纯数字）" title="单元（纯数字）">
                            @if ($errors->has('unit'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('unit')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">号数：</label>
                        <div class="input-group col-sm-2">
                            <input type="text" class="form-control" name="home" value="{{old('home')}}" id="home" placeholder="号数（如 1楼1号为 0101 ）" title="号数（如 1楼1号为 0101 ）">
                            @if ($errors->has('home'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('home')}}</span>
                            @endif
                        </div>
                    </div>
                    <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">状态：</label>
                        <div class="input-group col-sm-1">
                            <select class="form-control" name="state">
                                <option value="1" @if(old('state') == 1) selected="selected" @endif>未缴费</option>
                                <option value="0" @if(old('state') == 0) selected="selected" @endif>正常</option>
                            </select>
                            @if ($errors->has('state'))
                                <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('state')}}</span>
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