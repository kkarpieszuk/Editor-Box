=== Editor Box ===

Contributors: Konrad Karpieszuk
Tags: editor, frontend, facebook, twitter, linkedin, pagelet
Requires at least: 4.9
Tested up to: 5.8.1
Requires PHP: 7.0
Stable tag: 1.1.1
License: GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

== Description ==

[Video demo at YouTube](https://www.youtube.com/watch?v=D0b0XepqxqE)

Editor Box allows you to post content on your blog with the same experience when you are posting on Facebook, Twitter or LinkedIn or any other social media site.

You don't need to go to your wp-admin, find list of posts, click "Add new" button... I found it often discouraging from posting. But have you realized how easy is to post to Facebook instead? Just visit Facebook and start writing!

With Editor Box it works the same: just visit your blog and start writing. Editor Box will add to the top of your home page small pagelet (box) with simple editor. Just start writing and click publish. That's it!

== Support ==

Editor Box is compatible with all WordPress standard themes. If you find it is not working with your theme, please create an issue report at [GitHub development page](https://github.com/kkarpieszuk/Editor-Box/issues).

== Screenshots ==

1. Editor Box displayed on Twenty Twenty-One theme

2. Editor Box displayed on Astra theme

== Frequently Asked Questions ==

= I've installed the plugin, but I don't see the editor anywhere =

Editor Box is displayed on the front end when two conditions are met:
- The visitor is logged in to the WordPress and has capability to edit posts.
- The theme used on your site has standard posts loop used on the front page.

= Is it possible to save draft instead of immediate publishing the post? =

Yes, you can switch saving mode from Publish to Save draft. To do this, mouse over the Publish button and and press Ctrl button. Now when you click the button, post will be saved as draft and you will be redirected to the editor in wp-admin area.
You can switch the mode back from Save draft to Publish by pressing Ctrl button again.

= What happens if I do not provide post title? =

Like on Facebook or Twitter, post title is not obligatory to provide. If you save the post without the title, the title will be constructed from first five words from post content with ellipsis at the end.

== Changelog ==

= 1.0 =
*Release Date - December 27th 2021*

* Feature - Editor allows creating post with title, text, tags, one category and one image

= 1.1 =
*Release Date - January 10th 2022*

* Feature     - Title, tags and category fields hidden by default for less distraction
* Feature     - Post content textarea automatically changes its height to prevent displaying scrollbar
* Feature     - Added visible notification about image being uploaded
* Feature     - Post can be saved as draft instead immediate publishing (press Ctrl button over Publish button to switch mode)
* Enhancement - Added assets versioning to help refreshing cached versions between plugin releases
* Enhancement - Use large image size in rendered html instead of full size
* Fix         - Fixed issue with not handled image uploads when image size bigger than PHP upload_max_filesize

= 1.1.1 =
*Release Date - January 11th 2022*

* Fix         - Fixed script relying on English version of the value when it could be translated.
* Enhancement - Updated Polish translation files
