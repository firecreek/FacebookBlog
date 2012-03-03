<div class="facebookblog index">
    <h2><?php echo $title_for_layout; ?></h2>

    <?php if(!empty($errors)): ?>
    
        <p>There were errors, make sure you edit the <?php echo $html->link(__('settings', true), array('plugin' => '', 'controller' => 'settings', 'action' => 'prefix', 'Facebookblog')); ?> before using discover.</p>
    
        <ul>
            <?php foreach($errors as $error): ?>
                <li><?php echo $error; ?></li>
            <?php endforeach; ?>
        </ul>
        
        <p></p>
    
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
