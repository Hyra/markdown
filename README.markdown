# CakePHP Markdown

CakePHP Markdown is a lightweight plugin that lets you render Markdown content directly in your CakePHP views.

## Why use this plugin?

Using Markdown instead of raw HTML makes content easier to write, read, and maintain.

Typical use cases:

- **Blog posts:** write posts in plain text, store Markdown in your database, and render HTML on output.
- **CMS content:** let editors work with clean, readable text instead of heavy WYSIWYG-generated HTML.
- **Reusable content blocks:** keep content portable and version-friendly.

## Installation

1. Clone this repository into:
   `app/Plugin/Markdown`
2. Load the plugin in `app/Config/bootstrap.php`:

   ```php
   CakePlugin::load('Markdown');
   ```

3. Add the helper in the controllers where you need it (or globally in `AppController.php`):

   ```php
   public $helpers = array('Markdown.Markdown');
   ```

## Basic usage

A quick way to verify everything works is to pass Markdown text from your controller to a view.

### Controller

```php
$plain = <<<EOF
Markdown allows you to write text in an easy-to-read and easy-to-write plain text format,
and Markdown will convert it to structurally valid XHTML (or HTML).

You can easily make text **bold** or *italic*  
Use [Some link](http://www.example.com/ "Example")  
Use [Another link][] like so  

And any other Markdown features, as shown on [Daring Fireball][]

  [Another link]: http://www.mindthecode.com/
  [Daring Fireball]: http://daringfireball.net/
EOF;

$this->set(compact('plain'));
```

### View

```php
<?php echo Markdown($plain); ?>
```

## Notes

- The plugin renders Markdown to HTML in your views.
- You can style rendered output with your own CSS.

## Markdown reference

For the complete Markdown syntax, see:

- <http://daringfireball.net/projects/markdown/>
