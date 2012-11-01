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
 * `$this->set('markdown',true)` (from both controller and view)
 *
 * ### Helper utility
 * `$this->Markdown->auto()`
 *
 *
 */
 
App::import('Vendor', 'Markdown.markdown', array('file' => 'markdown.php'));

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
		// $this->set('markdown',true); 
		if ( isset($this->_View->viewVars['markdown']) && $this->_View->viewVars['markdown'] == true ) $doRender = true;
		if ( isset($this->_View->viewVars['Markdown']) && $this->_View->viewVars['Markdown'] == true ) $doRender = true;
		
		if ( $doRender ) {
			$this->_View->__set( 'output', $this->parse($this->_View->__get('output')) );
		}
		
	}
	
	public function auto( $auto = true ) {
		
		$this->auto = $auto;
		
	}
	
	
	/**
	 * Utility to parse a Markdown source string
	 */
	public function parse( $str ) {
		
		return Markdown($str);
		
	}
		
};

?>