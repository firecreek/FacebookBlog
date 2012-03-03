<?php

  /**
   * Facebookblog Activation
   *
   *
   * @package  Croogo
   * @author   Darren Moore <darren.m@firecreekweb.com>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://www.firecreekweb.com
   */
  class FacebookblogActivation {

    /**
     * onActivate will be called if this returns true
     *
     * @param  object $controller Controller
     * @return boolean
     */
    public function beforeActivation(&$controller) {
      return true;
    }
      
      
    /**
     * Called after activating the plugin in ExtensionsPluginsController::admin_toggle()
     *
     * @param object $controller Controller
     * @return void
     */
    public function onActivation(&$controller) {
      $controller->Croogo->addAco('Facebookblog');
      $controller->Croogo->addAco('Facebookblog/admin_index');
      
      $controller->Setting->write('Facebookblog.feed_url', '', array('editable' => 1, 'title' => 'Feed URL','description'=>'RSS2 Feed'));
      $controller->Setting->write('Facebookblog.node_type_alias', 'blog', array('editable' => 1, 'title' => 'Node type alias','description'=>''));
      $controller->Setting->write('Facebookblog.auto_publish', '1', array('editable' => 1, 'title' => 'Auto publish on discovery','description'=>''));
      $controller->Setting->write('Facebookblog.user_id', '1', array('editable' => 1, 'title' => 'User id','description'=>'User to publish nodes as'));
    }
    
    /**
     * onDeactivate will be called if this returns true
     *
     * @param  object $controller Controller
     * @return boolean
     */
    public function beforeDeactivation(&$controller) {
      return true;
    }
      
    /**
     * Called after deactivating the plugin in ExtensionsPluginsController::admin_toggle()
     *
     * @param object $controller Controller
     * @return void
     */
    public function onDeactivation(&$controller) {
      $controller->Croogo->removeAco('Facebookblog');
      
      $controller->Setting->deleteKey('Facebookblog.feed_url');
      $controller->Setting->deleteKey('Facebookblog.node_type_alias');
      $controller->Setting->deleteKey('Facebookblog.auto_publish');
      $controller->Setting->deleteKey('Facebookblog.user_id');
    }
      
  }
  
?>
