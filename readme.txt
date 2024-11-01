=== Soronet Popup ===
Contributors: Dabuuker
Tags: popup, modal, lightbox
Requires at least: 4.0
Tested up to: 4.3.1
Stable tag: trunk
License: GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Show content in a modal after page load

== Description ==
Show content in a modal after page load.

Usage:

Select 'SN Popup' from the admin menu, then Add New. Type a name
for the popup and insert any content you like. If you're done, click Publish.

Now find a page or post you'd like to see the popup on and edit it. There should be a new metabox called 'SN Popup', choose the
settings you want and hit Update, then view your page.

Video: https://www.youtube.com/watch?v=t6lt6v3fuEQ

To change the styling of the modal, you can override its styles in your theme's css. Or for more advanced styling you can
dequeue the default css and replace it with your own.

For reference, the default unminified version of the css is located at /plugins/sn-popup/vendor/featherlight-1.3.4/src/featherlight.css

To dequeue the old css and enqueue your own, add something like this to your functions.php:

`
add_action('wp_enqueue_scripts','remove_featherlight_css');
function remove_featherlight_css(){
    wp_dequeue_style('sn-featherlight');
    wp_enqueue_style('featherlight-new-css','/path-to-new-css');
}
`


== Screenshots ==

== Installation ==
Go to your Wordpress Dashboard. From there select Plugins -> Add New. Search for Soronet Popup, make sure it found the
right plugin and click Install Now.
Or download the zip file and in the dashboard go to Plugins -> Add New. Click 'Upload Plugin' from the top and upload
the zip file.

Alternatively, extract the zip file and upload the contents to the wp-content/plugins/ directory of your WordPress
 installation and then activate the plugin from the plugins page.
== Changelog ==
= 1.1.0 =
* Optionally choose a popup to show on every page
= 1.0.0 =
* First release