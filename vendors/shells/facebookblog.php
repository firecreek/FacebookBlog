<?php

  /**
   * Facebookblog Vendor Shell
   *
   * @category Controller
   * @package  Croogo
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreekweb.com>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://www.firecreekweb.com
   */
    App::import('Core', 'Security');
    
    class FacebookblogShell extends Shell {

        public function discover() {
            App::import('Component', 'Facebookblog.Facebookblog');
            $FacebookBlog = new FacebookblogComponent;
            
            $FacebookBlog->startup($this);
            
            $this->out('Discovering RSS feeds');
            
            $FacebookBlog->discover();
            
            foreach($FacebookBlog->log as $log) {
                $this->out($log);
            }
            
            $this->out('End');
        }
    
        
    }
?>
