<?php

  /**
   * Facebookblog Controller
   *
   * @category Controller
   * @package  Croogo
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreekweb.com>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://www.firecreekweb.com
   */
  class FacebookblogController extends FacebookblogAppController {
    /**
     * Controller name
     *
     * @var string
     * @access public
     */
    public $name = 'Facebookblog';
      
    /**
     * Models used by the Controller
     *
     * @var array
     * @access public
     */
    public $uses = array('Node');
    
    
    /**
     * Component
     *
     * @access public
     * @var array
     */
    public $components = array('Facebookblog');


    /**
     * Admin index
     *
     * List existing redirect routes
     *
     * @access public
     * @return void
     */
    public function admin_index()
    {
      $this->set('title_for_layout', __('Discover', true));
      
      //Check valid data req.
      if(!Configure::read('Facebookblog.feed_url')) {
        $errors[] = __('Feed URL not set',true);
      }
      
      if(!Configure::read('Facebookblog.node_type_alias')) {
        $errors[] = __('Node type not set',true);
      }
      
      if(!Configure::read('Facebookblog.user_id')) {
        $errors[] = __('User id not set',true);
      }
      
      //
      if(isset($this->params['named']['run']) && empty($errors)) {
        $this->Facebookblog->discover();
        $logs = $this->Facebookblog->logs;
        $this->set(compact('logs'));
      }
      
      $this->set(compact('errors'));
    }



  }
?>
