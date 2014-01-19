<?php

class YiiTwitter extends CApplicationComponent
{

	//The Twitter Apps key, set in config.
	public $consumerKey = '';

	//The Twitter Apps secret key, set in config.
	public $consumerSecret = '';

	//The call back url for twitter
	public $callback = '';

	//Can be set in config to not load OAuth.php
	public $loadOauth = true;

	//Have we loaded our dependencies
	private static $registeredScripts = false;

	private $_instance = null;

	public function init() {
		$this->registerScripts();
		parent::init();
	}

	/**
	* Returns the callback url set in config
	*/
	public function getCallback() {
		return $this->callback;
	}


	/**
	* Use this one for when we need to authicate oursevles with twitter
	*/
	public function getTwitter($token=null, $secret=null, $refresh=false) {
		if ($this->_instance === null || $refresh) {
			$this->_instance = new TwitterOAuth($this->consumerKey,$this->consumerSecret, $token, $secret);
		}
		return 	$this->_instance;
	}

	/**
	* Use this for after we have a token and a secret for the use.
	*	(you must save these in order for them to be usefull
	*/
	public function getTwitterTokened($token,$secret) {
		return $this->getTwitter($token, $secret, true);
	}

    /**
    * Registers twitteroauth.php & OAuth.php
    */
    public function registerScripts() {
    	if (self::$registeredScripts) return;
    	self::$registeredScripts = true;
		if($this->loadOauth)
			require dirname(__FILE__).'/OAuth.php';
		require dirname(__FILE__).'/twitteroauth.php';
	}

}




