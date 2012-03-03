<?php

  /**
   * Facebook Blog Component
   *
   * An example hook component for demonstrating hook system.
   *
   * @category Component
   * @package  Croogo
   * @version  1.0
   * @author   Darren Moore <darren.m@firecreekweb.com>
   * @license  http://www.opensource.org/licenses/mit-license.php The MIT License
   * @link     http://www.firecreekweb.com
   */
  class FacebookblogComponent extends Object {
  
    /**
     * logs
     *
     * @access public
     * @var array
     */
    public $logs = array();
    
  
    /**
     * title work limit
     *
     * @access public
     * @var int
     */
    public $titleWordLimit = 10;
    
  
    /**
     * Startup
     *
     * @param object $controller instance of controller
     * @return void
     */
    public function startup(&$controller) {
      $this->controller =& $controller;
      $this->Node = ClassRegistry::init('Node');
    }
    
  
    /**
     * Text
     *
     * @param string $text
     * @return void
     */
    public function log($text) {
      $this->logs[] = $text;
    }
    

    /**
     * Discover
     *
     * @access public
     * @return boolean
     */
    public function discover() {
      App::import('Core', 'Xml');
      App::import('Core', 'HttpSocket');
      $socket = new HttpSocket();
      
      $result = $socket->get(Configure::read('Facebookblog.feed_url'));
  
      $this->log('Downloaded feed, '.Configure::read('Facebookblog.feed_url'));

      $xml =& new XML($result);
      $data = $xml->toArray();
      
      $items = Set::extract($data,'Rss.Channel.Item');
      
      if(!$items) {
        $this->log('No RSS items found');
        return false;
      }
    
      $this->_sync($items);      
      
      $this->log('Finished');
    }
    

    /**
     * Sync Facebook records with nodes
     *
     * @access public
     * @return boolean
     */
    private function _sync($items) {
      $this->log('Checking '.count($items).' RSS items');
    
      $existingGuids = $this->Node->Meta->find('list',array(
        'conditions' => array(
          'key' => 'facebook_guid'
        ),
        'contain' => false,
        'fields' => array('id','value')
      ));
      
      //
      $autoPublish    = Configure::read('Facebookblog.auto_publish');
      $nodeTypeAlias  = Configure::read('Facebookblog.node_type_alias');
      $userId         = Configure::read('Facebookblog.user_id');
      
      //Add nodes
      foreach($items as $item) {
        //Existing
        if(array_search($item['guid']['value'],$existingGuids)) {
          //continue;
        }
        
        //
        $title = $this->_title($item['description']);
        $slug = $this->_slug($title);
        
        //
        $status = $autoPublish;
        if(empty($title)) {
          $status = false;
        }
        
        //
        $data = array(
          'Node' => array(
            'title'   => $title,
            'body'    => $item['description'],
            'type'    => $nodeTypeAlias,
            'slug'    => $slug,
            'status'  => $status,
            'visibility_roles' => '',
            'user_id' => $userId,
            'created' => date('Y-m-d H:i:s',strtotime($item['pubDate'])),
          ),
          'Meta' => array(
            array(
              'key'   => 'facebook',
              'value' => 'true'
            ),
            array(
              'key'   => 'facebook_guid',
              'value' => $item['guid']['value']
            ),
            array(
              'key'   => 'facebook_link',
              'value' => $item['link']
            ),
            array(
              'key'   => 'facebook_author',
              'value' => $item['author']
            ),
            array(
              'key'   => 'facebook_creator',
              'value' => $item['creator']
            )
          )
        );
        
        $this->Node->create();
        $this->Node->saveWithMeta($data);
        
        $this->log('Added node, '.$this->Node->id.', "'.$title.'"');
      }
      
      return true;
    }
    

    /**
     * Title
     *
     * @param string $title
     * @access private
     * @return string
     */
    private function _title($text) {
      $output = preg_replace('/<br \/>/i',"\n",$text);
      $output = strip_tags($output);
      
      //First line
      if(strrpos($output, "\n")) {
        $output = substr($output, 0, strrpos($output, "\n"));
      }
      
      $words = substr_count($output," ");
      
      //Word limit
      if($words >= $this->titleWordLimit) {
        //Cut by endings
        $endings = array('.','!','?');
        $positions = array();
        foreach($endings as $ending) {
          if($pos = strpos($output,$ending)) {
            $positions[] = $pos;
          }
        }
        
        if(!empty($positions)) {
          sort($positions);
          $output = substr($output,0,$positions[0]+1);
        }
      }
      
      return $output;
    }
    

    /**
     * Slug
     *
     * @param string $title
     * @access private
     * @return string
     */
    private function _slug($title) {
      $slug = strtolower(trim($title));
      $slug = str_replace(' ','-',$slug);
      $slug = preg_replace('/[^A-Za-z0-9\-]+/','',$slug);
      
      $count = 0;
      $found = 1;
      
      while($found > 0) {
        $found = $this->Node->find('count',array(
          'conditions' => array('slug'=>$slug),
          'recurvise' => -1
        ));
        
        if($found) { $count++; $slug .= $count; }
      }
      
      return $slug;
    }
    
      
  }

?>
