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
 *     $this->set( '_markdown', false );
 * 
 *
 * @author		@MovableApp
 * @blogPost:	http://movableapp.com/2012/11/cakephp-markdown-plugin/
 */

App::import( 'Vendor', 'Markdown.markdown' );
App::import( 'Vendor', 'Markdown.MarkdownUtils' );

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
		if ( isset($this->viewVars['_markdown']) && $this->viewVars['_markdown'] === false ) return;
		
		
		// render markdown
		
		$content = $this->Blocks->get('content');
		
		$content = MarkdownUtils::parseViewVars( $this, $content );
		
		$content =  Markdown( $content );
		
		$this->Blocks->set( 'content', $content );
		
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
