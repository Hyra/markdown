<?php
/**
 * Markdown Helper
 *
 * Loads Markdown parser object and view's callback to auto
 * parse a rendered view.
 *
 * ## AUTO PARSING VIEWS
 * You can configure Markdown plugin to automagically parse a rendered view
 * as markdown source file in various ways.
 *
 * ### Helper Configuration
 * `public $helpers = array( 'Markdown.Markdown'=>true )`
 *
 * ### View Vars
 * `$this->set('_markdown',true)` (from both controller and view)
 *
 * ### Helper utility
 * `$this->Markdown->auto()`
 *
 *
 */
 
App::import( 'Vendor', 'Markdown.markdown' );
App::import( 'Vendor', 'Markdown.MarkdownUtils' );

class MarkdownHelper extends AppHelper {
	
	/**
	 * Set it to true to activate auto parsing, false to prevent it!
	 */
	protected $auto = false;
	
	
	public function __construct(View $view, $settings = array()) {
		
		// Understand a first boolean param from:
		// $helpers = array( 'Markdown.Markdown'=>true )
		if ( count($settings) === 1 && isset($settings[0]) && is_bool($settings[0]) ) $settings = array( 'auto'=>$settings[0] );
		
		parent::__construct($view, $settings);
		
		// Setup internal auto rendering option.
		if ( isset($settings['auto']) ) $this->auto = $settings['auto'];
		
	}
	
	
	/**
	 * Logic for view rendering as Markdown source
	 */
	public function beforeLayout( $file ) {
		
		$doRender = false;
		
		// set render from helper's property and configuration
		if ( $this->auto === true ) $doRender = true;
		
		// set render from controller or view:
		// $this->set('_markdown',true); 
		if ( isset($this->_View->viewVars['_markdown']) && $this->_View->viewVars['_markdown'] == true ) $doRender = true;
		
		if ( $doRender ) {
			$this->_View->__set( 'output', $this->render($this->_View->__get('output')) );
		}
		
	}
	
	
	/**
	 * Accessor method to activate or deactivate auto render utility
	 */
	public function auto( $auto = true ) {
		
		$this->auto = $auto;
		
	}
	
	/**
	 * Render element and parse it as Markdown source
	 */
	public function element($name, $data = array(), $options = array()) {
		
		return $this->render( $this->_View->element($name,$data,$options) );
		
	}
	
	/**
	 * Fetch a view block and parse it as Markdown source
	 */
	public function fetch( $name ) {
		
		return $this->render( $this->_View->fetch($name) );
		
	}
	
	/**
	 * Utility to parse a Markdown source string
	 * $data array is for the future.
	 *
	 * I plan to implement some utility syntax to access variables from view's scope
	 * or $data scope but I still tinking about it.
	 */
	public function render( $str, $data = array() ) {
		
		$str = MarkdownUtils::parseViewVars($this->_View, $str);
		
		$output = Markdown($str);
		
		return $output;
		
	}
	
	
	public function __($key, $data=array()) {
		$locale = APP . 'Locale' . DS . Configure::read('Config.language') . DS . 'LC_MARKDOWN' . DS . $key . '.md';
		if (!file_exists($locale)) {
			return $key;
		} else {
			return $this->render(file_get_contents($locale),$data);
		}
	}
	
	
	
		
};

?>