@extends('admin.layouts.layout')
@section('content')
{{--<div class="row">--}}
    {{--<div class="col-sm-12">--}}
        {{--<div class="alert alert-warning alert-dismissable">--}}
            {{--<button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>--}}
            {{--系统权限菜单，非专业技术人员请勿修改、增加、删除等操作。--}}
        {{--</div>--}}
    {{--</div>--}}
{{--</div>--}}
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>{{$lists->accessControl->ac_name}}</h5>
        </div>
        <div class="ibox-content">
{{--            {{dd($lists)}}--}}
            <style>
                .stopcarrule{width:50%;padding:0 0 0 20px;float:left; border-left:1px solid #eee;min-height:400px;font-size:14px;font-family:"微软雅黑";box-sizing:border-box;}
                .stopcarrule div{margin:4px 0px;}
                .stopcarrule  >input{padding:5px 2px;outline: none;border: 1px solid #5CCA4A;border-radius: 3px;margin: 0 5px;
                    font-size: 12px;color: #4d4d4d;font-family:"微软雅黑";
                }
                .stopcarrule_insert{color: #fff;
                    margin: 0 2px;
                    border: none;
                    background: #229ffd;
                    padding: 4px 18px;
                    border-radius: 5px;
                    outline: none;}
                .stopcarrule_insert:hover{background:#53b7fa;}


            </style>
            <form class="form-horizontal m-t-md" action="{{route('parksetup.update',$lists->ac_id)}}" method="post">
                {!! csrf_field() !!}
                {{method_field('PATCH')}}
            <div  class="stopcarrule">
{{--                {{dd($lists)}}--}}
                <h5 style="font-size:18px;color:#3598db;">停车场基础设置</h5>
                <hr>
                对外开放功能<select name="is_open" id="is_open">
                    <option value="1" @if($lists->accessControl->is_open == 1) selected @endif>开启</option>
                    <option value="0" @if($lists->accessControl->is_open == 0) selected @endif>关闭</option>
                </select>
                <div>超时时限：<input type='text' name="over_time" id='over_time' value='@if ($lists->accessControl->rules) {{$lists->accessControl->rules->overtime}}@endif' placeholder='建议输入15 必须为数字'>  分设置时间来规定缴费后挪车时间</div>
                <div>免费分钟数：<input type='text' name="free" id='free' value='@if ($lists->accessControl->rules){{$lists->accessControl->rules->free}}@endif' placeholder='超出（）分钟，免费停放'> 分设置时间来规定免费停放时间</div>
                <div>车位总数：<input id="allNumber" name='all_number' type='text' value='{{$lists->accessControl->garage_number_all}}' placeholder='请输入车位总数 长度限制6位'>位</div>
                <hr/>
                <div id="setInfo">
                    <h4 style="font-size:18px;color:#3598db;">计费方式（任选其一）</h4>
                    <b>方式一：（按天）</b>
                    <div>单价设置：<input id='unit_price_day' name="unit_price_day" type='text' value='@if ($lists->accessControl->rules)@if($lists->accessControl->rules->type == 1) {{$lists->accessControl->unit_price}}@endif @endif' placeholder='金额'>元/天</div>
                    <br>
                    <b>方式二：（按小时）</b>
                    <div>单价设置：<input id='unit_price_hour' name='unit_price_hour' type='text' value='@if ($lists->accessControl->rules)@if($lists->accessControl->rules->type == 2) {{  $lists->accessControl->unit_price}}@endif @endif' placeholder='金额'>元/小时</div>
                    <br>

                    {{--<b>方式三：（自定义）</b>--}}
                    {{--<div class="list-z">--}}
                        {{--<div class="three">第1小时：<input  type='text' value='' placeholder='金额'>元</div>--}}
                    {{--</div>--}}
                    {{--<input type="button" class="stopcarrule_insert" value="添加" onclick="addDiv('')"><input class="stopcarrule_insert" type="button" onclick="delDiv()" value="删除上一个">--}}
                    {{--<div>此后每小时收费：<input id="everyhour_pay" name='' type='text' value='' placeholder='金额'>元</div>--}}
                    {{--<div>单日收费上限：<input name='' id="maxTotal_three" type='text' value='' placeholder='金额'>元</div>--}}
                    {{--<div>24小时重置规则：--}}
                        {{--<select name="" id="reset_three">--}}
                            {{--<option value="1">是</option>--}}
                            {{--<option value="0">否</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<br>--}}
                    {{--<b>方式四：（区间收费）</b>--}}
                    {{--<div class="list-q">--}}
                        {{--<div>第<time id="time1">1</time>小时至第<input id='flow1'  class='add-div'  type='text' style='width: 30px' value='' placeholder=''>小时：<input type="text" style='width: 30px'>元/时</div>--}}
                    {{--</div>--}}
                    {{--<input type="button" class="stopcarrule_insert" value="添加" onclick="addDivQ('','','')"><input class="stopcarrule_insert" type="button" onclick="delDivQ()" value="删除上一个">--}}
                    {{--<div>此后每小时收费：<input id='everyhour_pay_four' type='text' value='@isset($ac_config) {{$ac_config['unit_price']}}@endisset' placeholder='金额'>元/元</div>--}}
                    {{--<div>单日收费上限：<input id="maxTotal_four" type='text' value='@isset($ac_config) {{$ac_config['unit_price']}}@endisset' placeholder='金额'>元/元</div>--}}
                    {{--<div>24小时重置规则：--}}
                        {{--<select name="" id="reset_four">--}}
                            {{--<option value="1">是</option>--}}
                            {{--<option value="0">否</option>--}}
                        {{--</select>--}}
                    {{--</div>--}}
                    {{--<hr>--}}
                    {{--<h4>夜间计费模式</h4>--}}
                    {{--注：夜间模式可与上面计费方式(方式一除外)叠加 且 夜间收费优先级最高--}}
                    {{--<br>--}}
                    {{--<div class="list-y">--}}
                        {{--<div ><input id="startTime" type="time">至<input id='endTime'  class='add-div'  type='time' value='' placeholder=''>：--}}
                            {{--<input type="text" id="nightPrice" style='width: 60px'>元/时</div>--}}
                    {{--</div>--}}
                    <br>
                    <div>请选择计费方式
                        <select name="type" id="payType">
                            <option value="1">方式一</option>
                            <option value="2">方式二</option>
                            {{--<option value="3">方式三</option>--}}
                            {{--<option value="4">方式四</option>--}}
                        </select>
                        {{--<select name="" id="nightPay">--}}
                            {{--<option value="0"> 不开启夜间收费</option>--}}
                            {{--<option value="1">夜间收费</option>--}}
                        {{--</select>--}}
                    </div>
                    {{--<input type="button" class="stopcarrule_insert" --}}{{--onclick="setPayType()"--}}{{-- value="提交计费规则">--}}
                    <button value="提交">提交</button>
                </div>
            </div>
            </form>
            <div id="msg">
            </div>
        </div>
    </div>
</div>
</div>
{{--@include('js')--}}
<script>
@verbatim
    // var is_open = $('#is_open').val();
    $("#is_open").change(function(){
        var opt=$("#is_open").val();
        console.log(opt);
        if(opt == 0){
            $('#setInfo').css('display','none');
        }else{
            $('#setInfo').css('display','block');
        }
    });


    function setParkingConfig() {
        $.ajax({
            //几个参数需要注意一下
            type: "POST",//方法类型
            dataType: "json",//预期服务器返回的数据类型
            url: "/parking/set" ,//url
            data: $('#form1').serialize(),
            success: function (result) {
                if (result == 'SUCCESS'){
                    var msg = '更新成功';
                    var className ='alert-success';
                }else{
                    var msg = '更新失败，部分数据错误，请核实';
                    var className ='alert-danger';
                }
                document.getElementById('msg').innerHTML = '<div class="alert '+className+' alert-block fade in">'
                    +msg
                    +'</div>'
            },
            error : function() {
                alert("异常！");
            }
        });
    }
    function addDiv(value) {
        var num = $('.list-z').children().length+1;
        $('.list-z').append("<div class='three' >第"+num+"小时：<input type='text' value='"+value+"' placeholder='金额'>元</div>");
    }
    function delDiv() {
        var num = $('.list-z').children().length;
        if(num>1){
            $('.list-z div:last-child').remove();
        }else{
            alert('至少有一个定价');
        }
    }
    function addDivQ(Stime,Etime,value) {
        var length = $('.list-q .add-div').length;
        var newVal = $('.list-q div').eq(length - 1).find('input').eq(0).val();
        if (!newVal){
            alert('填写信息有误');
            return;
        }
        if(Stime){
            newVal = Stime;
        }
        var changeValue = length+1;
        $('.list-q').append("<div>第<time id='time"+changeValue+"'>"+newVal+"</time>小时至第<input id='flow' class='add-div' type='text' style='width: 30px' value='"+Etime+"' placeholder=''>小时：<input type='text' value='"+value+"' style='width: 30px'>&#12288;元/时</div>");
    }
    function delDivQ() {
        var num = $('.list-q').children().length;
        if(num>1){
            $('.list-q div:last-child').remove();
        }else{
            alert('至少有一个定价');
        }
    }


    function setPayType() {
        var allNumber = $('#allNumber').val();  //总车位
        var free = $('#free').val();    //免费分钟数
        var overTime = $('#over_time').val();    //超时实现
        var is_open = $('#is_open').val();
        var typeValue = $('#payType').val();  //收费方式
        var night_charge =$('#nightPay').val();
        var free_minutes = parseInt(free);
        var time_limit = parseInt(overTime);
        if(free_minutes == "" || free_minutes == null) {
            //正常执行
        } else if(!isNum(free_minutes)) {
            alert("免费分钟数输入有误");
            return;
        } else {
            var free = free_minutes; //给免费分钟赋值
        }

        if(time_limit == "" || time_limit == null) {
            alert("超时时限不能为空");
            return;
        } else if(!isNum(time_limit)) {
            alert("超时时限输入有误");
            return;
        } else if(time_limit < 5) {
            alert("超时时限必须大于等于五分钟");
        } else {
            var overtime = time_limit;
        }


        var celling = null;

        if(typeValue == 1){
            var price_set =$('#unit_price_day').val();
            if(night_charge ==1){
                alert('按天收费不能与夜间收费同时使用');
                return;
            }
            if(price_set == "" || price_set == null) {
                alert("单价设置输入不能为空");
                return;
            } else if(!isPrice(price_set)) {
                alert("单价设置输入有误");
                return;
            } else {
                var rules = price_set; //给单价赋值
            }

        }else if(typeValue ==2){
            var price_set =$('#unit_price_hour').val();
            console.log(price_set);
            if(price_set == "" || price_set == null) {
                mui.toast("单价输入不能为空");
                return;
            } else if(!isPrice(price_set)) {
                alert("单价输入有误");
                return;
            } else {
                var rules = price_set; //给单价赋值
            }
        }else if(typeValue ==3){
            var length = jQuery(".three").length;
            var customArr =new Array();
            for(var i=0 ;i<length;i++){
                var price_hour = jQuery(".three").eq(i).find('input').val();
                if(price_hour == null || price_hour == "") {
                    alert("小时单价不能为空")
                    return;
                } else if(!isPrice(price_hour)) {
                    alert("小时单价输入有误")
                    return;
                } else {
                    customArr[i] = parseInt(+price_hour * 100).toString();
                }
            }
            var everyhour_pay = $('#everyhour_pay').val();
            if(everyhour_pay == "" || everyhour_pay == null) {
                alert("此后每小时不能为空");
                return;
            } else if(!isPrice(everyhour_pay)) {
                alert("此后每小时输入有误");
                return;
            } else {
                customArr.push(parseInt(+everyhour_pay * 100).toString());
            }
            var rules = JSON.stringify(customArr);
            var isreset = $('#reset_three').val();
            //判断单日收费上限
            var upper_limit = $('#maxTotal_three').val();
            alert(upper_limit);
            if(upper_limit == "" || upper_limit == null) {
                //正常执行
            } else if(!isNum(upper_limit)) {
                alert("单日收费上限输入有误");
                return;
            } else {
                var celling = upper_limit; //给单日收费上限赋值
            }
        }else if(typeValue ==4){
            var customArr = new Array();
            var length = jQuery(".list-q").find('input').length;

            //循环判断用户输入的值
            for(var i = 0; i < length; i++) {
                if(i % 2 == 0) {
                    var value = parseInt(i/2)+1;
                    var startTime = "time"+value;
                    var startTimeValue = $("#"+startTime+"").text();  //起始时间
                    console.log(i+'起始时间的id是'+startTime+'对应值是'+startTimeValue);
                    customArr.push(startTimeValue);
                    var startTime = jQuery(".list-q").find('input').eq(i).val();
                    console.log('startTime='+startTime);
                    if(startTime == null || startTime == "") {
                        console.log(startTime)
                        alert("至第几小时不能为空");
                        return;
                    } else if(!isNum(startTime)) {
                        alert("至第几小时输入有误");
                        return;
                    } else if(+startTime > 24 || +startTime <= 1) {
                        alert("至第几小时需输入2到24的值");
                        return;
                    } else {
                        customArr.push(startTime);
                    }
                } else {
                    var price = jQuery(".list-q").find('input').eq(i).val();
                    if(price == null || price == "") {
                        alert("收费输入不能为空")
                        return;
                    } else if(!isPrice(price)) {
                        alert("收费输入有误")
                        return;
                    } else {
                        customArr.push(parseInt(+price * 100))
                    }
                }
            }
            //数组分组
            var bArr = [];
            var cArr = [];
            var k = 0;
            for(var p = 0; p < customArr.length; p++) {
                if(p % 3 == 0) {
                    bArr = [];
                    for(var j = 0; j < 3; ++j) {
                        if(customArr[p + j] == undefined) {
                            continue;
                        } else {
                            bArr[j] = customArr[p + j];
                        }
                    }
                    cArr[k] = bArr.toString();
                    k++;
                }
            }
            //判断此后每小时收费
            var everyhour = $('#everyhour_pay_four').val();
            var everyhour_pay = parseInt(everyhour);
            console.log(everyhour_pay);
            if(everyhour_pay == "" || everyhour_pay == null) {
                alert("此后每小时不能为空");
                return;
            } else if(!isPrice(everyhour_pay)) {
                alert("此后每小时输入有误");
                return;
            } else {
                cArr.push(parseInt(+everyhour_pay * 100).toString())
                var rules = JSON.stringify(cArr);
            }

            //判断单日收费上限
            var upper_limit = $('#maxTotal_four').val();
            alert(upper_limit);
            if(upper_limit == "" || upper_limit == null) {
                //正常执行
            } else if(!isNum(upper_limit)) {
                alert("单日收费上限输入有误");
                return;
            } else {
                var celling = upper_limit; //给单日收费上限赋值
            }
            var isreset = $('#reset_four').val();
        }
        //判断夜间收费
        if(night_charge == 1&&typeValue != 1) {
            var nightArr = new Array();
            var night_time = $("#startTime").val();
            var night_time1 = $("#endTime").val();
            var night_val = $("#nightPrice").val();

            if(night_time == "" || night_time == null || night_time1 == "" || night_time1 == null) {
                alert("夜间时间段不能有空")
                return;
            } else if(night_time == night_time1) {
                alert("夜间时间段的值不能相同");
                return;
            } else if(night_val == null || night_val == "") {
                alert("夜间收费不能为空");
                return;
            } else if(!isPrice(night_val)) {
                alert("夜间收费输入有误");
                return;
            } else {
                nightArr[0] = night_time.replace(/\:/, '');
                nightArr[1] = night_time1.replace(/\:/, '');
                nightArr[2] = parseInt(+night_val * 100).toString();
                var specail=JSON.stringify(nightArr);
            }
        }else{
            var specail=null;
        }
        $.ajax({
            type: "post",
            data: {
                type: typeValue,
                rules: (rules),
                free: free,
                overtime: overTime,
                special: specail,
                celling: celling,
                is_reset: isreset,
                number: allNumber,
                is_open: is_open
            },
            url: "{!! route('parksetup.update') !!}",
            dataType: "json",
            success: function(data) {
                console.log(data);
                alert(data);
            },
            error: function(){
                alert('填写信息错误');
            }
        })
    }
    //价格正则表达式
    function isPrice(price) {
        var pricePattern = /^(0|[1-9][0-9]{0,9})(\.[0-9]{1,2})?$/;
        result = pricePattern.test(price);
        return result;
    }

    //数字正则表达式函数
    function isNum(numValue) {
        var numPattern = /^[1-9]{1}[0-9]{0,8}$/; //数字的正则表达式
        result = numPattern.test(numValue);
        return result;
    }
    var ac_id = <?php echo $lists->ac_id ?>;

    $.ajax({
        type: "post",
        data: {
            ac_id:ac_id
        },
        url: "../api/parkingSetInfo",
        dataType: "json",
        success: function(data) {
            var is_open = data.is_open;
            if(is_open != 1){
                $('#setInfo').css('display','none');
                $('#is_open').val(0);
            };
            $('#over_time').val(data.overtime);
            $('#free').val(data.free);
            $('#allNumber').val(data.number);
            $('#payType').val(data.type);


            if (data.type == 1){
                $('#unit_price_day').val(data.rules);
            }else if(data.type ==2){
                $('#unit_price_hour').val(data.rules);
            }else if(data.type ==3){
                var rules =JSON.parse(data.rules);
                $('#everyhour_pay').val(rules.pop()/100);
                $('.list-z').children().find('input').val(rules.shift()/100);
                var rules_length =rules.length;
                for(var i=0;i<rules_length;i++){
                    addDiv(rules[i]/100);
                }
                $('#maxTotal_three').val(data.celling);
                $('#reset_three').val(data.is_reset);
            }else if(data.type ==4){
                var rules =JSON.parse(data.rules);
                $('#everyhour_pay_four').val(rules.pop()/100);
                $('#maxTotal_four').val(data.celling);
                $('#reset_four').val(data.is_reset);
                //第一行
                var first_rules = rules.shift();
                var first_arr =first_rules.split(',');
                $('.list-q div').eq(length - 1).find('input').eq(0).val(first_arr[1]);
                $('.list-q div').eq(length - 1).find('input').eq(1).val(first_arr[2]/100);
                for(var i=0;i<rules.length;i++){
                    var rules_arr = rules[i].split(',');
                    addDivQ(rules_arr[0],rules_arr[1],rules_arr[2]/100)
                }
            }

            if (data.special){
                $('#nightPay').val(1);
                var special = JSON.parse(data.special);
                var price = special.pop()/100;
                var newstr = new Array();
                for (var i=0;i<special.length;i++){
                    newstr[i]=insert_flg(special[i]);
                }
                $('#startTime').val(newstr[0]);
                $('#endTime').val(newstr[1]);
                $('#nightPrice').val(price);
            }
        },
        error: function(){
            alert('填写信息错误');
        }
    })

    function insert_flg(time){
        var first_str = time.substr(0,2);
        var second_str = time.substr(2,2);
        return first_str+':'+second_str;
    }

var data = <?php echo $lists->accessControl->rules; ?>;
console.log(data);
var is_open = data.is_open;
if(is_open != 1){
    $('#setInfo').css('display','none');
    $('#is_open').val(0);
};
$('#over_time').val(data.overtime);
$('#free').val(data.free);
$('#allNumber').val(data.number);
$('#payType').val(data.type);


if (data.type == 1){
    $('#unit_price_day').val(data.rules);
}else if(data.type ==2){
    $('#unit_price_hour').val(data.rules);
}else if(data.type ==3){
    var rules =JSON.parse(data.rules);
    $('#everyhour_pay').val(rules.pop()/100);
    $('.list-z').children().find('input').val(rules.shift()/100);
    var rules_length =rules.length;
    for(var i=0;i<rules_length;i++){
        addDiv(rules[i]/100);
    }
    $('#maxTotal_three').val(data.celling);
    $('#reset_three').val(data.is_reset);
}else if(data.type ==4){
    var rules =JSON.parse(data.rules);
    $('#everyhour_pay_four').val(rules.pop()/100);
    $('#maxTotal_four').val(data.celling);
    $('#reset_four').val(data.is_reset);
    //第一行
    var first_rules = rules.shift();
    var first_arr =first_rules.split(',');
    $('.list-q div').eq(length - 1).find('input').eq(0).val(first_arr[1]);
    $('.list-q div').eq(length - 1).find('input').eq(1).val(first_arr[2]/100);
    for(var i=0;i<rules.length;i++){
        var rules_arr = rules[i].split(',');
        addDivQ(rules_arr[0],rules_arr[1],rules_arr[2]/100)
    }
}

if (data.special){
    $('#nightPay').val(1);
    var special = JSON.parse(data.special);
    var price = special.pop()/100;
    var newstr = new Array();
    for (var i=0;i<special.length;i++){
        newstr[i]=insert_flg(special[i]);
    }
    $('#startTime').val(newstr[0]);
    $('#endTime').val(newstr[1]);
    $('#nightPrice').val(price);
}
    @endverbatim
</script>
@endsection