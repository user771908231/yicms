<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>用户管理</h5>
        </div>
        <div class="ibox-content">
            <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>

            <form method="post" action="<?php echo e(route('admins.index')); ?>" name="form">
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

                    <?php $__currentLoopData = $lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td class="text-center"><?php echo e($item->id); ?></td>
                            <td class="text-center"><?php echo e(App\Console\PublicFunction::building($item->build,0)); ?></td>
                            <td class="text-center"><?php echo e(App\Console\PublicFunction::building($item->unit,1)); ?></td>
                            <td class="text-center"><?php echo e(App\Console\PublicFunction::building($item->unit,2)); ?></td>
                            <td class="text-center"><?php echo e($item->name); ?></td>
                            <td class="text-center"><?php echo e($item->phone); ?></td>
                            <td class="text-center"><?php echo e(date('Y-m-d H:i:s',$item->created_at)); ?></td>
                            <td class="text-center">暂无</td>
                            <td class="text-center">
                            <?php switch( $item->state ):
                                case (0): ?>
                                    <p class="center" style="color: red">待审核</p>
                                <?php break; ?>
                                <?php case (1): ?>
                                <p class="center" style="color: #2ca02c">审核通过</p>
                                <?php break; ?>
                                    <?php default: ?>
                                    <p class="center" style="color: #404a58">已拒绝</p>
                                <?php endswitch; ?>
                            </td>
                            
                                
                                    
                                
                                    
                                
                            
                            
                                <div class="btn-group">
                                    <td class="text-center">
                                        <form class="form-common" action="<?php echo e(route('household.update',$item->id)); ?>" method="post">
                                            <input type="hidden" name="state" value="1">
                                            <?php echo e(csrf_field()); ?>

                                            <?php echo e(method_field('PATCH')); ?>

                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-trash-o"></i> 通过</button>
                                        </form>

                                        <form class="form-common" action="<?php echo e(route('household.update',$item->id)); ?>" method="post">
                                            <input type="hidden" name="state" value="2">
                                            <?php echo e(csrf_field()); ?>

                                            <?php echo e(method_field('PATCH')); ?>

                                            <button class="btn btn-default btn-xs" type="submit"><i class="fa fa-trash-o"></i> 拒绝</button>
                                        </form>

                                    </td>
                                    
                                        
                                    
                                    
                                            
                                    
                                            
                                    
                                    

                                </div>

                            
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
                <?php echo e($lists->links()); ?>

            </form>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>