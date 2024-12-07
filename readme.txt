=== Product Feed for Pinterest Product Catalogs ===
Contributors: mcyenikoylu
Author: Mehmet Cenk Yenikoylu
Author URI: https://github.com/mcyenikoylu
Donate link: https://www.patreon.com/mcy
Tags: pinterest, pinterest feed, pinterest rss, woocommerce product rss
Requires at least: 6.6
Stable tag: 1.0.6
Tested up to: 6.6.2
Requires PHP: 7.2.14
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Automatically pin your products on your WooCommerce site to Pinterest.

== Description ==

Automatically pin your products on your WooCommerce site to Pinterest.

WooCommerce product RSS Feed for 'Pinterest Product Catalogs'. Automatically pin the products on your website by posting information such as photo, price, stock status, product description in your pinterest account.

***Does not contain your blog posts! It feeds only your products.***

**for example:**

All products:
http://www.yourdomain.com/?call_pinterest_product_catalogs=1&ppcf_posts_per_page=100

Category specific feeds:
http://www.yourdomain.com/?call_pinterest_product_catalogs=1&ppcf_posts_per_page=100&ppcf_category=your-category-slug

**Product Items by:**

* id
* title 
* description (short description)
* link
* image_link (product first image)
* availability (in stock, out of stock, preorder)
* condition (default 'new')
* sale price
* price
* product_type (category hierarchy)

Thus, you earn customer through pinterest and increase your potential sales channel.

The RSS feed has been developed with tags recommended by Pinterest.

It is mandatory to have WooCommerce in your Wordpress structure.
You do not need to install an additional RSS plugin on your site.

== Installation ==

1. Upload the "Product Feed for Pinterest Product Catalogs" plugin to your website 
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go To "settings" and there you will find all you need under "Product Feed for Pinterest Product Catalogs" plugin options.
4. Good Luck

== Frequently Asked Questions ==

= How do I fix the "Error 107" error? =

You will get this error if the short description field is blank.

= Can I use the product long description? =

Yes you can use. It is necessary to update line 158. Please check the link: https://gist.github.com/mcyenikoylu/1a82962b41446b795007dff4ccc86889.

== Screenshots ==

1. Pinterest mobile pin screen
2. Pinterest RSS screen
3. RSS Feed XML print screen

== Changelog ==

= 1.0.6 =
2024-12-7
* Updated: PHP 7.2.14+ compatibility
* Updated: WordPress 6.6+ compatibility 
* Updated: Code optimization and strict type declarations
* Updated: Better error handling and XML output buffering
* Fixed: Security improvements for XML generation

= 1.0.5 =
2024-11-5
* Added: Category specific feed URLs
* Added: Custom post limit per page parameter (ppcf_posts_per_page)
* Fixed: HTML tags in product descriptions
* Fixed: XML output buffering issues

= 1.0.4 =
2021-01-16 errors have been fixed.

**1.0.3**
2020-09-10 
* errors have been fixed.
* 'sale price' field has been added.

**1.0.2**
2020-08-20 errors have been fixed.

**1.0.1**
2020-08-15 product type update.

**1.0.0**
2020-07-11 first launch.