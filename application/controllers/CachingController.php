<?php
/**
 * Caching controller
 * @author root
 *
 */
class CachingController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        // action body
    }
	
    /**
     * Cache text action
     * 
     */
    public function cacheTextAction()
    {
    	//Frontend attributes of what we're caching
    	$frontendOption = array('cache_id_prefix' => 'loudbite_',
    					'lifetime' => 900);
    	
    	//Backend attributes
    	$backendOptions = array('cache_dir' => '../application/tmp');
    	
    	//Create zend_cache object
    	$cache = Zend_Cache::factory('Core', 'File',
    					$frontendOption, $backendOptions);
    	
    	//Suppress the view
    	$this->_helper->viewRenderer->setNoRender();
    }

}

