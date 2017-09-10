=== BuddyForms Ultimate Member ===
Contributors: svenl77, konradS, buddyforms, themekraft
Tags: BuddyForms, Ultimate Member, forms, form, custom form, custom forms, form administration, form builder, form creation, form creator, form manager, forms, forms builder, forms creation, forms creator, forms manager
Requires at least: 3.9
Tested up to: 4.8.1
License: GPLv2 or later
Stable tag: 1.1
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Submit and Manage Posts from your Ultimate Member Profile. Create Forms with an easy to use Form Builder! Create Tabs - Group Forms. Works with any PostType Plugin and Theme.

== Description ==

BuddyForms Ultimate Member allows your users to write, edit and upload posts, images, video, & just about any other content to your site, right from their Ultimate Member Profile!

Once you download the plugin, it’s super simple to setup All you have to do is drag-and-drop to build the form your users will be submitting on the front-end.

<h4>Works with your existing Plugins</h4>
The easy way to bring your existing plugins into the Ultimate Member ecosystem and make it accessible for your users right from their profile.

<h4>For Any Post Type </h4>
Choose which post type should be created when users submit your form. Turn any custom-post-type based WordPress plugin into a collaborative publishing tool and let your users adding content!

<h4>Perfect for </h4>
Online Magazines, Blogs, Directories, Stores, Marketplaces, FAQ’s… you name it.

<h4>Easy Form Builder</h4>
Create and customize forms on the fly with easy drag and drop editing. No coding necessary.

<h4>Moderation</h4>
Moderate new Posts. Allow your users to create new versions of there posts and resent them to review without hiding the published post.

<h4>Form Elements</h4>
You get all the necessary elements like Text Fields, Email Input, Checkboxes, Dropdowns and more.

<h4>Permission</h4>
You can choose how your members create, manage and edit their posts. Adjust the permissions for every form to your needs.

<h4>Extendable</h4>

Works with:
<ul>
<li>WooCommerce</li>
<li>WooCommerce Simple Auctions</li>
<li>Advanced Custom Fields</li>
<li>Posts 2 Posts</li>
<li>And many more. See the <a href="https://themekraft.com/buddyforms/#extensions" target="_blank">Extensions</a> on the BuddyForms.com site for all available extensions</li>
</ul>


<h4>See this Video how to use the Plugin</h4>
[youtube https://www.youtube.com/watch?v=b7YNax-ORzQ]


== Documentation & Support ==

<h4>Extensive Documentation and Support</h4>

All code is neat, clean and well documented (inline as well as in the documentation).

The BuddyForms Documentation with many how-to’s is following now!

If you still get stuck somewhere, our support gets you back on the right track.
You can find all help buttons in your BuddyForms Settings Panel in your WP Dashboard!


<h4>Dependencies</h4>
<p>Please make sure you have the following plugins installed and activated:</p>
<ul>
  <li><a target="_blank" href="https://buddyforms.com/">BuddyForms</a></li>
  <li><a target="_blank" href="https://ultimatemember.com/">Ultimate Member</a></li>
</ul>
<br><br>

== Installation ==

You can download and install the plugin by using the built-in WordPress plugin installer. If you download the plugin manually,
make sure it is uploaded to "/wp-content/plugins/".

Activate the plugin in the "Plugins" admin panel by using the "Activate" link.

== Frequently Asked Questions ==

= Dependencies =

BuddyForms and Ultimate Member

== Screenshots ==

1. **Create and Edit Posts from the Ultimate Member Profile**

== Changelog ==


1.1
* Fixed an issue if multiple forms used in different tabs with the same post type the tab default got broken
* Changed the logic to add multi tab support
* If form slug is posts the form conflicts with the default tab "posts" and only can be use with the option "Use Attached Page as Parent Tab and make this form a sub tab of the parent"
* Fixed all issues reported by users
* Add an admin notice to the form builder in the metabox and above the update form
    --> This form slug is "posts". This slug is reserved for the Ultimate Member Posts Tab. You can only Use Attached Page as Parent Tab and make this form a sub tab of the parent. Please check both options
* Optimised and clean up the code

= 1.0.4 =
* Freemius Integration

= 1.0.3.1 =
* Fixed an issue with the dependencies management. If pro was activated it still ask for the free. Fixed now with a new default in the core to check if the pro is active.

= 1.0.3 =
* Add dependencies management with tgm

= 1.0.2 =
* fixed an issue with the user url structure rewrite. It only worked if the Profile Permalink Base was set to user. Should work now with all settings

= 1.0.1 =
* Hooks rename session
* Add the buddyforms_metabox_class class to the postmetabox to make sure it get displayed.
* Prevent Ultimate Member from flush rewrite roles with every page load.
* Add inline documentation
* Add a check if $buddyforms is an array to avoid undefined index issues
* There was an issue in the profile if the form slug has a "-" I have fixed this by add a global $bf_um_tabs to save the form slug without "-"
* Add new parameter to the list posts shortcode to display the correct posts. There was a issue displaying always the logged in user posts.
* code cleanup

= 1.0 =
* Final Version
