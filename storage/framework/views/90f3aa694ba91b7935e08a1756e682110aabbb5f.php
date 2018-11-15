<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
    <title>后台登录 - <?php echo e(config('app.name', 'Laravel')); ?></title>
    <meta name="keywords" content="后台登录">
    <meta name="description" content="后台登录">
    <link href="<?php echo e(loadEdition('/admin/css/bootstrap.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(loadEdition('/admin/css/font-awesome.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(loadEdition('/admin/css/animate.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(loadEdition('/admin/css/style.min.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(loadEdition('/admin/css/login.min.css')); ?>" rel="stylesheet">
    <script>
        if(window.top!==window.self){window.top.location=window.location};
    </script>

</head>

<body class="signin">
    <div class="signinpanel">
        <div class="row">
            <div class="col-sm-5 animated fadeInLeft">
                <div class="signin-info">
                    <div class="logopanel m-b">
                        <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <h1>[ <?php echo e(config('app.name', 'Laravel')); ?> V1.0 ]</h1>
                    </div>
                    <div class="m-b"></div>
                    <h4>欢迎使用 <span class="label label-info"><?php echo e(config('app.name', 'Laravel')); ?></span></h4>
                    <ul class="m-b">
                        
                        
                        
                        
                        
                        <li><i class="fa fa-circle text-navy"></i> 新增辅助管理用户</li>
                        <li><i class="fa fa-circle text-navy"></i> 设备管理</li>
                        <li><i class="fa fa-circle text-navy"></i> 网点管理</li>
                        
                        
                    </ul>
                </div>
            </div>
            <div class="col-sm-7 animated fadeInRight">
                <form method="post" action="<?php echo e(route('login-handle')); ?>">
                    <?php echo e(csrf_field()); ?>

                    <p class="login-title">登录</p>
                    <p class="m-t-md" style="color:#666">登录到<?php echo e(config('app.name', 'Laravel')); ?>系统后台管理</p>
                    <input type="text" class="form-control uname" name="name" value="<?php echo e(old('name')); ?>" required placeholder="用户名" />
                    <input type="password" class="form-control pword m-b" name="password" required placeholder="密码" />
                    <div style="width: 300px;">
                        <?php echo Geetest::render(); ?>

                    </div>
                    <p></p>
                    <button class="btn btn-success btn-block">登录</button>
                    <p></p>
                    <?php if(count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <h4>有错误发生：</h4>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li> <?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
        <div class="signup-footer animated fadeInUp">
            &copy; 2015 All Rights Reserved. <?php echo e(config('app.name', 'Laravel')); ?>

        </div>
    </div>
</body>
</html>
