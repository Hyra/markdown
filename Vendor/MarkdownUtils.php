<?php
/**
 * MarkdownUtils
 * =============
 * 
 * Utilities to the Markdown Plugin parsing process
 *
 * @author peg
 */

class MarkdownUtils {
	
	/**
	 * parseViewVars()
	 * interpret placeholders from markdown source.
	 * 
	 * by default knows {var.var1.var2} to access viewVars
	 * 
	 * it can be extended by events!
	 * 
	 */
	public static function parseViewVars( $_View, $string ) {
		
		// -- evt --
		$_View->getEventManager()->dispatch($e = new CakeEvent('Markdown.beforeParseViewVars',$_View,array(
			'string' => $string
		)));
		
		if ( !empty($e->result['string']) ) $string = $e->result['string'];
		// -- evt --
		
		
		
		
		// Apply a simple placeholder replacement from viewVars
		$string = String::insert( $string, Set::flatten( Set::reverse($_View->viewVars) ), array(
			'clear'		=> true,
			'clean'		=> false, 
			'before'	=> '{',
			'after'		=> '}'
		));
		
		
		
		
		// -- evt --
		$_View->getEventManager()->dispatch($e = new CakeEvent('Markdown.afterParseViewVars',$_View,array(
			'string' => $string
		)));
		
		if ( !empty($e->result['string']) ) $string = $e->result['string'];
		// -- evt --
		
		
		
		return $string;
		
	}
	
}
