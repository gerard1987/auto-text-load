=== Auto text load ===
Contributors: Gerard
Tags: text, modular, automatic
Requires at least: 3.0.1
Tested up to: 5
Requires PHP: 5.2.4
Stable tag: 0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
 
A plugin to retrieve text from server side and return sections of text automatic.
 
== Description ==
 
Auto-text-load is made to make the placement of text sections across follow up pages of similar layout and content faster and more accurate. 
By uploading a .docx file in the appropiate map with the same name as the page you want to display the text. 
Auto-text-load splits up the text by a placeholder [auto_text_load] and returns these text sections to the shortcode used.
To display sections of text simply use the following shortcodes in the designated area, and add the syntax for which section u want to display.
example :  [textload type="text-one"] up to text-sixteen. For placement of text areas.

Auto-text-load also provides the ability to place dynamic placenames and dynamic location numbers.
example : [telnr] || [telnr type='link_tel_number'] || [pagename] [pagename type="location"]
 
== Installation ==
 
1. Upload `auto_text_load.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. In the current directory of the site you are working on, create a directory with the name teksten.
4. Inside this directory place the .docx file with the name of the page u want to use it on.
5. On the page place the shortcodes in designated area u want the tekst to display.