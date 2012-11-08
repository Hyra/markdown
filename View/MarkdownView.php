<?php
/**
 * MarkdownView
 * ============
 * 
 * Automagically renders view templates as Markdown sources.
 * 
 * I'm actually working on a simple placeholder mechanism to insert values
 * from viewVars without write PHP code... may be useful for long text sources!
 * 
 * ## How To Use
 * In a controller's class simply set:
 *     
 *     public $viewClass = 'Markdown.Markdown';
 * 
 * this way every view will be rendered as markdown source.
 * 
 * 
 * ## Prevent a view to be rendered as markdown
 * If you need an exception you can call preventMarkdown() utility from inside
 * a view source:
 * 
 *     // view.ctp
 *     $this->preventMarkdown()
 *     
 *     // TestController.php
 *     $this->set( 'markdown', false );
 * 
 *
 * @author		@MovableApp
 * @blogPost:	http://movableapp.com/2012/11/cakephp-markdown-plugin/
 */

App::import( 'Vendor', 'Markdown.markdown' );

class MarkdownView extends View {
	
	private $parseMarkdown = true;
	
	
	public function __construct(Controller $controller = null) {
		
		parent::__construct($controller);
		
		
		// Intercept afterRender event to inject Markdown parsing logic
		$this->getEventManager()->attach( array($this,'markdownParseViewSource'), 'View.afterRender' );
		
	}
	
	
	/**
	 * Evt Callback
	 * parses markdown source
	 */
	public function markdownParseViewSource() {
		
		// prevent to parse markdown
		if ( $this->parseMarkdown === false ) return;
		if ( isset($this->viewVars['markdown']) && $this->viewVars['markdown'] === false ) return;
		if ( isset($this->viewVars['Markdown']) && $this->viewVars['Markdown'] === false ) return;
		
		
		// render markdown
		
		$content = $this->Blocks->get('content');
		
		$content = $this->markdownParseViewVars( $content );
		
		$content =  Markdown( $content );
		
		$this->Blocks->set( 'content', $content );
		
	}
	
	
	/**
	 * markdownParseViewVars()
	 * parses placeholders from markdown source code.
	 * 
	 * a placeholder is a string like:
	 * {var.sub}
	 * 
	 * values are searched into viewVars
	 * 
	 * CakePHP events allow external components to extend parser capabilities!
	 * 
	 */
	protected function markdownParseViewVars( $string ) {
		
		// -- evt --
		$this->getEventManager()->dispatch($e = new CakeEvent('Markdown.beforeParseViewVars',$this,array(
			'string' => $string
		)));
		
		if ( !empty($e->result['string']) ) $string = $e->result['string'];
		// -- evt --
		
		
		
		
		// Apply a simple placeholder replacement from viewVars
		$string = String::insert( $string, Set::flatten($this->viewVars), array(
			'clear'		=> true,
			'clean'		=> false, 
			'before'	=> '{',
			'after'		=> '}'
		));
		
		
		
		
		// -- evt --
		$this->getEventManager()->dispatch($e = new CakeEvent('Markdown.afterParseViewVars',$this,array(
			'string' => $string
		)));
		
		if ( !empty($e->result['string']) ) $string = $e->result['string'];
		// -- evt --
		
		return $string;
		
	}
	
	
	/**
	 * preventMarkdown()
	 * view utility method to prevent a view to be rendered as markdown
	 *
	 */
	public function preventMarkdown() {
		
		$this->parseMarkdown = false;
		
	}
	
}
