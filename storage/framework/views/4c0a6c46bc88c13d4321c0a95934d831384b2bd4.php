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
                            <th class="text-center">编号</th>
                            <th class="text-center">车牌</th>
                            <th class="text-center">用户</th>
                            <th class="text-center">进库时间</th>
                            <th class="text-center" >停留时间</th>
                            <th class="text-center" >单价</th>
                            <th class="text-center" >此次收费</th>
                            <th class="text-center" >状态</th>
                            <th class="text-center" >地址</th>
                            
                            
                            <th class="text-center" >操作</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php $__currentLoopData = $lists; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $k => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                            <tr>
                                <td class="text-center"><?php echo e($item->id); ?></td>
                                <td class="text-center"><?php echo e($item->license_plate); ?></td>
                                <td class="text-center">
                                    <?php if($item->user): ?>
                                        <?php echo e($item->user->truename); ?>

                                    <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo e(date('Y-m-d H:i:s',$item->go_in)); ?></td>
                                <td class="text-center">
                                    <?php if($item->go_out): ?>
                                    <?php echo e(App\Console\PublicFunction::Sec2Time($item->go_out - $item->go_in)); ?>

                                        <?php endif; ?>
                                </td>
                                <td class="text-center"><?php echo e($item->access->unit_price); ?>元</td>
                                <td class="text-center"><?php if($item->bill ): ?>￥ <?php echo e($item->bill->unit_price); ?> <?php else: ?> 暂无 <?php endif; ?></td>
                                <td class="text-center">
                                    <?php switch($item->state):
                                        case (0): ?>
                                    <p style='color: #ff0e0e'>账单已取消</p>
                                        <?php break; ?>
                                        <?php case (1): ?>
                                    <p style='color: #13bf13'>待付款</p>
                                        <?php break; ?>
                                        <?php case (2): ?>
                                    <p style='color: #ff0e0e'>账单超时已过期</p>
                                        <?php break; ?>
                                        <?php case (3): ?>
                                    <p style='color: #13bf13'>账单已付款,<b style='color: red'>待出库</b></p>
                                        <?php break; ?>
                                        <?php case (4): ?>
                                    <p style='color: #ff0e0e'>车辆出库超时,重新计费</p>
                                        <?php break; ?>
                                        <?php case (5): ?>
                                    <p style='color: #0f189b'>车辆完成出库</p>
                                        <?php break; ?>
                                        <?php case (6): ?>
                                    <p style='color: #13bf13'>待生成订单</p>
                                        <?php break; ?>
                                        <?php case (7): ?>
                                    <p style='color: #e14517'>逃单</p>

                                    <?php endswitch; ?>
                                </td>
                                <td class="text-center"><?php echo e($item->access->ac_name); ?></td>
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                
                                <div class="btn-group">
                                    <td class="text-center">
                                        <form class="form-common" action="<?php echo e(route('park.update',$item->id)); ?>" method="post">
                                            <?php echo e(csrf_field()); ?>

                                            <?php echo e(method_field('PATCH')); ?>

                                            <input type="hidden" name="type" value="1">
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-jpy"></i> 手动缴费</button>
                                        </form>
                                        <form class="form-common" action="<?php echo e(route('park.update',$item->id)); ?>" method="post">
                                            <?php echo e(csrf_field()); ?>

                                            <?php echo e(method_field('PATCH')); ?>

                                            <input type="hidden" name="type" value="0">
                                            <button class="btn btn-primary btn-xs" type="submit"><i class="fa fa-check-square-o"></i> 出库</button>
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