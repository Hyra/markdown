# CakePHP Markdown

The Markdown plugin provides your CakePHP views with the ability to use Markdown instead of HTML.

## Purpose

Why use Markdown instead of HTML you ask? There's a few useful applications. For instance, at [Mind the Code](http://www.mindthecode.com/ "Mindthecode") I always write my Blog posts in Markdown while in bed or on the road. WHen I'm happy with what I wrote I just create a new entry in my blog database with the markdown text, and the Markdown plugin and some CSS do the rest. No need to go through the whole post and add `<br />`'s and `<h1>`'s

Another useful option is using it within a CMS. Instead of having bloated HTML in your database through one of the thousand WYSIWYG editors you can have your content-editors just write Markdown, and have plain and not-so-bloated content in your DB.

## Installation

- Clone the files from the repos into `app/plugins/markdown`
- Include the Helper in the controllers you want to use it with, or in `app_controller.php`:
	- `var $components = array('Markdown.Markdown')`

## Using Markdown

The simplest way to test if everything is working is by passing some markdown to your view. You can use the following example:

In your controller, make a EOF variable containing something like:

	Markdown allows you to write text in a easy-to-read and easy-to-write plain text format,
	and Markdown will convert it to structurally valid XHTML (or HTML).

	You can easily make text **bold** or **italic**  
	Use [Some link](http://www.example.com/ "Example")  
	Use [Another link][] like so  

	And any other Markdown features, as shown on [Daring Fireball][]

	  [Another link]: http://www.mindthecode.com/
	  [Daring Fireball]: http://daringfireball.net/

And set this to a variable. For instance, `$plain` and assign it to the view:

	$this->set(compact('plain'));

Then in your view, all you have to do is:

	<?php echo Markdown($plain); ?>

And watch the magic :)

For a full list of Markdown, please visit [DaringFireball.net](http://daringfireball.net/projects/markdown/)