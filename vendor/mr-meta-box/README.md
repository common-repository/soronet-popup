#mr meta box

**mr meta box** is a simple class for using powerful WordPress meta boxes as easily as possible.

Version: 0.3.2

##What are meta boxes?

With meta boxes you can make WordPress as versatile as any other CMS. Maybe you just want to add some **user friendly** custom fields to post or page or maybe you are dealing with **custom post types** and want to make them 1000 times more powerful - meta boxes are an **awesome way** to do that. The problem is that it's fairly complicated to make them and it requires a lot of code. Things get pretty messy even when you just want to add one simple text field as shown in this [Smashing Magazine Tutorial](http://wp.smashingmagazine.com/2011/10/04/create-custom-post-meta-boxes-wordpress/).

##Picture is worth a 1000 words

**mr meta box** helps you turn this:
![custom fields - before](https://raw.github.com/wiki/mrfoto/mr-meta-box/before.png)

---

into this:
![mr meta box - after](https://raw.github.com/wiki/mrfoto/mr-meta-box/after.png)

##Awesome, but surely someone already thought of that?

There are some plugins for making meta boxes but when you are developing a plugin or a theme you probably don't want it to rely on some other plugin. There are also a few libraries but most of them are overcomplicating this thing or are very poorly written.

##Well, why would you create your own then?

Because I think I **can** do better and I **want** to do better for my own WordPress plugins and themes. I think it should be even **easier**, require even **less code** and provide even **better results**. I want to use **HTML5** magic wherever possible and use **fallbacks** for browsers that just aren't that advanced. I want it to look **beautiful**; to be as similar to **default WordPress panels** as possible. **I want it to just work**.

##Great, how do I use it?

mr meta box is still in **development**, but you can already use it. There are more features coming, but it can already do most of what others do, but better and prettier. All suggestions, critics, problems,… you had with the other libraries/plugins,… are much appreciated so I can make mr meta box even better. If you have any problems with mr meta box please [open an issue](https://github.com/mrfoto/mr-meta-box/issues).

##Well, let's do this!

There are **only 3 steps** to get your shiny mr meta box working:

###1. Require mr meta box
Download mr meta box and place it in your plugin/theme/wherever than put this code in your `functions.php` or your main plugin file or wherever you want to use meta boxes.
```php
if(!class_exists('mrMetaBox')) {
	require_once('/path/to/mr-meta-box/mr-meta-box.php');
}
```

###2. Define mr meta box
Define what you need - the only required field is `'id'`. Down there are the default values, so if you want to use the same, you don't have to define it. Awesome, huh?
```php
$config = array(
	'id' => null, //string Meta box ID - required
	'title' => 'Title', //string Title of the meta box
	'prefix' => '', //string Prefix of the field ids
	'postType' => array('post'), //array Array of post types you want to add meta box to
	'context' => 'normal', //string The part of the page where the edit screen section should be shown ('normal', 'advanced', or 'side')
	'priority' => 'default', // string The priority within the context where the boxes should show ('high', 'core', 'default' or 'low')
	'usage' => 'theme', //string 'theme', 'plugin' or 'http://example.com/path/to/mr-meta-box/folder'
	'showInColumns' => false //boolean Whether to show the mr meta box fields in 3 columns - comes handy where there is many fields in one mr meta box
);
$metaBox = new mrMetaBox($config);
```

###3. Define fields
Now, that your mr meta box is ready, you just need to tell it what fields to show. Here is where it gets **really interesting**. If, for example, you just want to add some quick fields, and don't care about any default values, formats, limitation or any other options, I've provided a shortcut method `addFieldsSimple`:
```php
$metaBox->addFieldsSimple(array(
	'Name' => 'Text',
	'Description' => 'Textarea',
	'Agree to Terms of Service' => 'Checkbox'
));
```
This will auto generate those 3 fields. As you can see, you provide a simple array with field types as keys and labels as values. Couldn't be any simpler.

But, there are times when you will want to precisely tune your meta box - let's say for client. Here is where the `addField` method comes in. It is worth noting that those two methods are 100% compatible, so you can use the first one for some fields and the second one for others.

There are many different types of fields you can have in your mr meta box:

* [Text field](https://github.com/mrfoto/mr-meta-box/wiki/Text-field)
* [Textarea field](https://github.com/mrfoto/mr-meta-box/wiki/Textarea-field)
* [WYSIWYG field aka Rich Text Editor](https://github.com/mrfoto/mr-meta-box/wiki/WYSIWYG-field-aka-Rich-Text-Editor)
* [Checkbox field](https://github.com/mrfoto/mr-meta-box/wiki/Checkbox-field)
* [Select field](https://github.com/mrfoto/mr-meta-box/wiki/Select-field)
* [Radio group field](https://github.com/mrfoto/mr-meta-box/wiki/Radio-group-field)
* [Checkbox group field](https://github.com/mrfoto/mr-meta-box/wiki/Checkbox-group-field)
* [Color field](https://github.com/mrfoto/mr-meta-box/wiki/Color-field)
* [Date field](https://github.com/mrfoto/mr-meta-box/wiki/Date-field)
* [Time Field](https://github.com/mrfoto/mr-meta-box/wiki/Time-Field)
* [Range field aka Slider](https://github.com/mrfoto/mr-meta-box/wiki/Range-field-aka-Slider)
* [Image field](https://github.com/mrfoto/mr-meta-box/wiki/Image-field)
* [Gallery field](https://github.com/mrfoto/mr-meta-box/wiki/Gallery-field)
* [Location field](https://github.com/mrfoto/mr-meta-box/wiki/Location-field)

There is also a [Wiki](https://github.com/mrfoto/mr-meta-box/wiki) with everything you might want to know on how to use this.

##Is it all your work?

Mostly, but it relies on the works of many others:
* [WordPress](http://wordpress.org/) - no shit, Sherlock
* [jQuery](http://jquery.com/) - included with WordPress
* [jQuery UI](http://jqueryui.com/)  - included with WordPress
* [Farbtastic](http://acko.net/blog/farbtastic-jquery-color-picker-plug-in/) - included with WordPress
* [Modernizr](http://modernizr.com/)
* [jQuery Timepicker Addon](http://trentrichardson.com/examples/timepicker/)
* [Geocomplete](http://ubilabs.github.com/geocomplete/)

##Contributors:
* Miha Rekar - [mrfoto](https://github.com/mrfoto)
* Karim - [karimhossenbux](https://github.com/karimhossenbux)

##License

mr meta box is developed by [Miha Rekar](http://mr.si/) and licensed under the [MIT License](http://opensource.org/licenses/mit-license.php)
