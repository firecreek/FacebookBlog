<a href="#"><?php __('Facebook Blog'); ?></a>
<ul>
   <li><?php echo $html->link(__('Discover', true), array('plugin' => 'facebookblog', 'controller' => 'facebookblog', 'action' => 'index')); ?></li>
   <li><?php echo $html->link(__('Settings', true), array('plugin' => '', 'controller' => 'settings', 'action' => 'prefix', 'Facebookblog')); ?></li>
</ul>

