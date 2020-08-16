# pinterest-product-catalogs

Automatically pin your products on your WooCommerce site to Pinterest.

## Getting Started

WooCommerce product RSS Feed for 'Pinterest Product Catalogs'. Automatically pin the products on your website by posting information such as photo, price, stock status, product description in your pinterest account.

*** Does not contain your blog posts! It feeds only your products. ***

It adds price information to the pin on your Pinterest account and when users click on your pin picture, they go to the sales page on your website.

Thus, you earn customer through pinterest and increase your potential sales channel.

The RSS feed has been developed with tags recommended by Pinterest.

### Prerequisites

It is mandatory to have WooCommerce in your Wordpress structure. You do not need to install an additional RSS plugin on your site.

### Installing

Login to the plugins section of your WordPress site. Click on the 'Add New' button. Then click the 'Upload Plugin' button. Upload the compressed file you downloaded from [this link pinterest-product-catalogs.zip](https://github.com/mcyenikoylu/pinterest-product-catalogs/files/5080160/pinterest-product-catalogs.zip) to your site.

> In the future, the plugin will be published on the WordPress Plugins website.

After the upload process is over. Go to the site's Plugins page. Activate the plugin and enjoy it.

** Step by step **
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
*id
*title 
*description (short description)
*link
*image_link (product first image)
*availability (in stock, out of stock, preorder)
*condition (default 'new')
*price

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
        <g:price>23.59</g:price>
    </item>
<channel>
```

### Frequently Asked Questions

No Questions

### Screenshots

Your website xml page
![screenshot-1](https://user-images.githubusercontent.com/12815851/90329234-75fae500-dfab-11ea-9db7-e29a45debfd6.png)

Pinterest product catalogs datasource web page
![screenshot-2](https://user-images.githubusercontent.com/12815851/90329237-78f5d580-dfab-11ea-84ec-0cf1a12ad877.png)

Pinterest mobile app screens
![screenshot-3](https://user-images.githubusercontent.com/12815851/90329238-7a270280-dfab-11ea-8248-c136747a9b5c.png)


### Changelog

** 1.0.1 **
2020-08-15 product type update.

** 1.0.0 **
2020-07-11 first launch.

## Deployment

*WordPress
*WooCommerce

## Built With

* [PHP](https://www.php.net/manual/en/migration70.new-features.php) - PHP v7.0.x
* [WordPress](https://wordpress.org) - WordPress v5.5
* [WooCommerce](https://woocommerce.com) - WooCommerce v4.3.1

## Versioning

v1.0.1

## Authors

* **Mehmet Cenk Yeniköylü** - 

## License

GPLv2 [License URI](http://www.gnu.org/licenses/gpl-2.0.html)