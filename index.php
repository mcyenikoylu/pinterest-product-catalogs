<?php
declare(strict_types=1);

define('PINTEREST_PRODUCT_CATALOGS_VERSION', '1.0.6');
define('PINTEREST_PRODUCT_CATALOGS_PLUGIN_URL', plugin_dir_url( __FILE__ ));
define('PINTEREST_PRODUCT_CATALOGS_PLUGIN_ADMIN_FILE', plugin_dir_path(__FILE__)."index.php" );

function pinterest_product_catalogs_admin_menu(): void {
    add_options_page( 
        'Pinterest Product Catalogs Plugin Options', 
        'Product Feed for Pinterest Product Catalogs', 
        'manage_options', 
        'pinterest-product-catalogs-admin-options', 
        'pinterest_product_catalogs_options' 
    );
}
add_action( 'admin_menu', 'pinterest_product_catalogs_admin_menu' );