# pinterest-product-catalogs

WordPress Plugin that automatically catalogs your products on your WooCommerce site to Pinterest.

## Getting Started

WooCommerce product RSS Feed for 'Pinterest Product Catalogs'. Automatically pin the products on your website by posting information such as photo, price, stock status, product description in your pinterest account.

***Does not contain your blog posts! It feeds only your products.***

It adds price information to the pin on your Pinterest account and when users click on your pin picture, they go to the sales page on your website.

Thus, you earn customer through pinterest and increase your potential sales channel.

The RSS feed has been developed with tags recommended by Pinterest.

### Prerequisites

It is mandatory to have WooCommerce in your Wordpress structure. You do not need to install an additional RSS plugin on your site.

### Installing

Login to the plugins section of your WordPress site. Click on the 'Add New' button. Then click the 'Upload Plugin' button. Upload the compressed file you downloaded from [this link pinterest-product-catalogs.zip](https://github.com/mcyenikoylu/pinterest-product-catalogs/files/5080160/pinterest-product-catalogs.zip) to your site.

> [Install from WordPress plugin site to website!](https://wordpress.org/plugins/wc-product-feed-for-pinterest/)

After the upload process is over. Go to the site's Plugins page. Activate the plugin and enjoy it.

**Step by step**
1. Upload the "Product Feed for Pinterest Product Catalogs" plugin to your website 
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go To "settings" and there you will find all you need under "Product Feed for Pinterest Product Catalogs" plugin options.
4. Good Luck.

### Use of

You just need to login this link for use
```
http://www.yourdomain.com/?call_pinterest_product_catalogs=1
```

### Screen Print

Product Items by
* id
* title 
* description (short description)
* link
* image_link (product first image)
* availability (in stock, out of stock, preorder)
* condition (default 'new')
* sale price
* price

```xml
<channel>
    <item>
        <id>1234</id>
        <title>Grey Travel Bag</title>
        <description>Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</description>
        <link>http://localhost/wordpress/product/grey-travel-bag/</link>
        <image_link>http://localhost/wordpress/wp-content/uploads/2018/04/product-73.jpg</image_link>
        <g:availability>in stock</g:availability>
        <g:condition>New</g:condition>
        <saleprice>19.59</saleprice>
        <g:price>23.59</g:price>
    </item>
<channel>
```

### Frequently Asked Questions

No Questions

### Screenshots

Pinterest mobile app screens
![screenshot-3](https://user-images.githubusercontent.com/12815851/90329238-7a270280-dfab-11ea-8248-c136747a9b5c.png)

### Changelog

**1.0.6**
2024-12-7
* Updated: PHP 7.2.14+ compatibility
* Updated: WordPress 6.6+ compatibility 
* Updated: Code optimization and strict type declarations
* Updated: Better error handling and XML output buffering
* Fixed: Security improvements for XML generation

**1.0.5**
2024-11-5
* Added: Category specific feed URLs
* Added: Custom post limit per page parameter (ppcf_posts_per_page)
* Fixed: HTML tags in product descriptions
* Fixed: XML output buffering issues

**1.0.4**
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

## Deployment

* WordPress
* WooCommerce

## Built With

* [PHP](https://www.php.net/) - PHP v7.2.14+
* [WordPress](https://wordpress.org) - WordPress v6.6+
* [WooCommerce](https://woocommerce.com) - Latest version

## Versioning

v1.0.6

## Authors

* **Mehmet Cenk Yeniköylü** - [WordPress Profile](https://profiles.wordpress.org/mcyenikoylu/)

## License

GPLv2 [License URI](http://www.gnu.org/licenses/gpl-2.0.html)
