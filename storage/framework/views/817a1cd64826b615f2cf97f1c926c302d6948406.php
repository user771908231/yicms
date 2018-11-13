<?php $__env->startSection('title', '首页'); ?>

<?php $__env->startSection('css'); ?>
  <link href="<?php echo e(loadEdition('/admin/css/pxgridsicons.min.css')); ?>" rel="stylesheet" />
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
  <div class="row state-overview">
    <div class="col-lg-3 col-sm-6">
      <section class="panel">
        <div class="symbol userblue">
          <i class="icon-users"></i>
        </div>
        <div class="value">
          <a href="#"><h1 id="count1">
              <?php if($admin): ?>
                <?php if($admin->attribute): ?>
                <?php echo e(count($admin->attribute->user)); ?>

                <?php else: ?>
                  0
                <?php endif; ?>
              <?php else: ?>
                0
              <?php endif; ?>
            </h1></a>
          <p>用户总量</p>
        </div>
      </section>
    </div>
    <div class="col-lg-3 col-sm-6">
      <section class="panel">
        <div class="symbol commred">
          <i class="fa fa-automobile"></i>
        </div>
        <div class="value">
          <a href="#"><h1 id="count2">
              <?php if($admin): ?>
                <?php if($admin->attribute): ?>
                  <?php if($admin->attribute->accessControl): ?>
                    <?php echo e($admin->attribute->accessControl->garage_number); ?>

                  <?php else: ?>
                    <?php echo e($admin->attribute->accessControl->garage_number_all); ?>

                  <?php endif; ?>
                <?php else: ?>
                  0
                <?php endif; ?>
              <?php else: ?>
                0
              <?php endif; ?>

            </h1></a>
          <p>今日剩余车位</p>
        </div>
      </section>
    </div>
    <div class="col-lg-3 col-sm-6">
      <section class="panel">
        <div class="symbol articlegreen">
          <i class="icon-check-circle"></i>
        </div>
        <div class="value">
          <a href="#"><h1 id="count3">1876</h1></a>
          <p>笑话总数</p>
        </div>
      </section>
    </div>
    
      
        
          
        
        
          
          
        
      
    
  </div>
  
    
    
      
        
          
          
                                
                            

        
        
          
            

            
          
        
      
    
    
    
    
      
        
          
          
                                
                            
        
        
          
            
            
              
                
              
              
            
            
              
              
            
            
              
              
            
            
              
              
            
            
              
              
            
            
              
                
              
            
            
              
                
              
            
            
              
                
              
            
            
              
                
              
            
            
              
                
              
            
            
          
        
      
    
    
  
  
    
      
        
      
      

        
          
            
              
              
            
            
              
              
              
                
                
                
                
              
            
          
        

      
    
  
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.layout', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>