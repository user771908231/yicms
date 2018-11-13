<?php $__env->startSection('content'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox-title">
            <h5>用户管理</h5>
        </div>
        <div class="ibox-content">
            <a class="menuid btn btn-primary btn-sm" href="javascript:history.go(-1)">返回</a>

            <form method="post" action="<?php echo e(route('lists.index')); ?>" name="form">
                <table class="table table-striped table-bordered table-hover m-t-md">
                    <thead>
                    <tr>
                        <th class="text-center" width="100">ID</th>
                        <th class="text-center">单号</th>
                        <th class="text-center">号牌</th>
                        <th class="text-center">用户</th>
                        <th class="text-center" >状态</th>
                        <th class="text-center" >支付价格</th>
                        <th class="text-center" >停放时间</th>
                        <th class="text-center" >开始时间</th>
                        <th class="text-center" >支付时间</th>
                        
                        
                        <th class="text-center" width="200">操作</th>
                    </tr>
                    </thead>
                    <tbody>

                    <?php $__currentLoopData = $lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                        <tr>
                            <td class="text-center"><?php echo e($item->id); ?></td>
                            <td class="text-center"><?php echo e($item->sn); ?></td>
                            <td class="text-center"><?php echo e($item->license); ?></td>
                            <td class="text-center">
                                <?php if(!empty($item->user)): ?>
                                    <?php echo e($item->user->truename); ?>

                                <?php endif; ?>
                            </td>
                            <td class="text-center">
                                <?php switch($item->order_state):
                                    case (0): ?>
                                    已取消
                                    <?php break; ?>

                                    <?php case (10): ?>
                                    未付款
                                    <?php break; ?>

                                    <?php case (20): ?>
                                    已付款
                                    <?php break; ?>

                                    <?php case (30): ?>
                                    已出库
                                    <?php break; ?>

                                    <?php case (40): ?>
                                    逃单
                                    <?php break; ?>
                                    <?php default: ?>
                                    未知
                                <?php endswitch; ?>
                            </td>
                            <td class="text-center"><?php echo e($item->pd_amount); ?></td>
                            <td class="text-center"><?php echo e(\App\Console\PublicFunction::Sec2Time($item->parking_time)); ?></td>
                            <td class="text-center"><?php echo e(date('Y-m-d H:i:s',$item->payment_time)); ?></td>
                            <td class="text-center"><?php echo e(date('Y-m-d H:i:s',$item->add_time)); ?></td>
                            
                            
                            
                                
                                    
                                
                                    
                                
                            
                            
                                <div class="btn-group">
                                    <td class="text-center">
                                        
                                            
                                            
                                            
                                            
                                        
                                        
                                            
                                            
                                            
                                            
                                        
                                        <form class="form-common" action="<?php echo e(route('lists.destroy',$item->id)); ?>" method="post">
                                            <?php echo e(csrf_field()); ?>

                                            <?php echo e(method_field('DELETE')); ?>

                                            <button class="btn btn-danger btn-xs" type="submit"><i class="fa fa-trash-o"></i> 删除</button>
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