<div class="facebookblog index">
    <h2><?php echo $title_for_layout; ?></h2>

    <?php if(!empty($errors)): ?>
    
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
    
    <?php else: ?>
    
        <div class="actions">
            <ul>
                <li><?php echo $this->Html->link(__('Download and Sync Facebook RSS Feed', true), array('action'=>'index','run'=>true)); ?></li>
            </ul>
        </div>
        
        <?php if(isset($logs)): ?>
        
            <p><?php echo implode($logs,'<br>'); ?></p>
        
        <?php endif; ?>
        
    <?php endif; ?>

</div>
