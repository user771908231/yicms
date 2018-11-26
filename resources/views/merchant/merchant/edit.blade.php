@extends('admin.layouts.layout')
@section('content')
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>编辑商户</h5>
        </div>
        <div class="ibox-content">
            <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>
            <a href="{{route('merchant.index')}}"><button class="btn btn-primary btn-sm" type="button"><i class="fa fa-plus-circle"></i> 商户管理</button></a>
            <div class="hr-line-dashed m-t-sm m-b-sm"></div>
            <form class="form-horizontal m-t-md" action=" {{ route('merchant.update',$admin->id) }}" method="post" accept-charset="UTF-8" enctype="multipart/form-data">
                {!! csrf_field() !!}
                {{method_field('PATCH')}}
                <div class="form-group">
                    <label class="col-sm-2 control-label">用户名：</label>
                    <div class="input-group col-sm-2">
                        <input type="text" class="form-control" name="name" value="{{$admin->name}}" required data-msg-required="请输入用户名">
                        @if ($errors->has('name'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('name')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">车位数：</label>
                    <div class="input-group col-sm-2">
                        <input type="number" class="form-control" name="park_number" value="{{$admin->attribute->park_number}}">
                        @if ($errors->has('park_number'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('park_number')}}</span>
                        @endif
                    </div>
                </div>
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">车位时间：</label>
                    <div class="input-group col-sm-2">
                        <input type="date" class="form-control" name="park_time" value="{{substr($admin->attribute->park_time,0,10)}}">
                        @if ($errors->has('park_time'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('park_time')}}</span>
                        @endif
                    </div>
                </div>
                {{--<div class="hr-line-dashed m-t-sm m-b-sm"></div>--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 control-label">头像：</label>--}}
                    {{--<div class="input-group col-sm-2">--}}
                        {{--<input type="file" class="form-control" name="avatr">--}}
                        {{--@if ($errors->has('avatr'))--}}
                            {{--<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('avatr')}}</span>--}}
                        {{--@endif--}}
                        {{--<span class="view picview ">--}}
                           {{--<img id="thumbnail-avatar" class="thumbnail img-responsive" src="{{$admin->avatr}}" width="100" height="100">--}}
                        {{--</span>--}}
                    {{--</div>--}}
                {{--</div>--}}
                {{--<div class="hr-line-dashed m-t-sm m-b-sm"></div>--}}
                {{--@if(!$admin->This)--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 control-label">所属角色：</label>--}}
                    {{--<div class="input-group col-sm-2">--}}
                        {{--@php--}}
                            {{--$ruleids = $admin->roles->pluck('id')->toArray();--}}
                        {{--@endphp--}}
                        {{--@foreach($roles as $k=>$item)--}}
                            {{--<label><input type="checkbox" name="role_id[]" value="{{$item->id}}" @if(in_array($item->id,$ruleids)) checked="checked" @endif> {{$item->name}}</label><br/>--}}
                        {{--@endforeach--}}
                        {{--@if ($errors->has('role_id'))--}}
                            {{--<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('role_id')}}</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <label class="col-sm-2 control-label">车位类型：</label>
                    <div class="input-group col-sm-1">
                        <select class="form-control" name="park_type">
                            <option value="0" @if($admin->attribute->park_type == 0) selected="selected" @endif>永久</option>
                            <option value="1" @if($admin->attribute->park_type == 1) selected="selected" @endif>定时</option>
                        </select>

                        @if ($errors->has('park_type'))
                            <span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('park_type')}}</span>
                        @endif
                    </div>
                    <label class="col-sm-2 control-label"></label>
                    <div class="input-group col-sm-2">
                        <p>永久 车位时间则不生效</p>
                    </div>
                </div>
                {{--<div class="hr-line-dashed m-t-sm m-b-sm"></div>--}}
                {{--<div class="form-group">--}}
                    {{--<label class="col-sm-2 control-label">是否可创建下级管理：</label>--}}
                    {{--<div class="input-group col-sm-1">--}}
                        {{--<select class="form-control" name="is_top">--}}
                            {{--<option value="0" @if(!$admin->is_top) selected="selected" @endif>否</option>--}}
                            {{--<option value="1" @if($admin->is_top) selected="selected" @endif>是</option>--}}
                        {{--</select>--}}
                        {{--@if ($errors->has('is_top'))--}}
                            {{--<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('is_top')}}</span>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                {{--</div>--}}
                    {{--<div class="hr-line-dashed m-t-sm m-b-sm"></div>--}}
                    {{--<div class="form-group">--}}
                        {{--<label class="col-sm-2 control-label">商户身份：</label>--}}
                        {{--<div class="input-group col-sm-1">--}}
                            {{--<select class="form-control" name="stop_up">--}}
                                {{--<option value="0" @if($admin->attribute->stop_up == 0) selected="selected" @endif>否</option>--}}
                                {{--<option value="1" @if($admin->attribute->stop_up == 1) selected="selected" @endif>是</option>--}}
                            {{--</select>--}}
                            {{--@if ($errors->has('stop_up'))--}}
                                {{--<span class="help-block m-b-none"><i class="fa fa-info-circle"></i>{{$errors->first('stop_up')}}</span>--}}
                            {{--@endif--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--@else--}}
                {{--<input type="hidden"  name="This" value="1">--}}
                {{--@endif--}}
                <div class="hr-line-dashed m-t-sm m-b-sm"></div>
                <div class="form-group">
                    <div class="col-sm-12 col-sm-offset-2">
                        <button class="btn btn-primary" type="submit"><i class="fa fa-check"></i>&nbsp;保 存</button>
                        <button class="btn btn-white" type="reset"><i class="fa fa-repeat"></i> 重 置</button>
                    </div>
                </div>
                <div class="clearfix"></div>
            </form>
        </div>
    </div>
</div>
@endsection