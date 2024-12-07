<?php
/*
 * Plugin Name:   Product Feed for Pinterest Product Catalogs
 * Plugin URI:    https://wordpress.org/plugins/wc-product-feed-for-pinterest
 * Description:   Product RSS Feed for 'Pinterest Product Catalogs'. Automatically pin the products on your website by posting information such as image, price, stock status, product description in your pinterest account.
 * Version:       1.0.6
 * Author:        Mehmet Cenk Yenikoylu
 * Author URI:    https://github.com/mcyenikoylu
 * License:       GPLv2 or later
 * License URI:   http://www.gnu.org/licenses/gpl-2.0.html
 */

 // Strict typing
declare(strict_types=1);

// Define constants
define('PINTEREST_PRODUCT_CATALOGS_PLUGIN_ALLOWED_TAGS', [
    'a' => [
        'href' => [],
        'title' => [],
        'class' => []
    ],
    'br' => [],
    'p' => ['class' => []],
    'div' => ['class' => []],
    'span' => ['class' => []]
]);

if ( is_admin() ){
    require_once dirname(__FILE__) . '/index.php';
    
    function pinterest_product_catalogs_plugin_action_links(array $links, string $file): array 
    {
        if ($file === plugin_basename(__FILE__)) {
            $settings_link = sprintf(
                '<a href="%s">%s</a>',
                admin_url('admin.php?page=pinterest-product-catalogs-admin-options'),
                __('Settings')
            );
            array_unshift($links, $settings_link);
        }
        return $links;
    }
    add_filter('plugin_action_links', 'pinterest_product_catalogs_plugin_action_links', 10, 2);
    
    // Admin panel fonksiyonunu buraya ekleyin
    function pinterest_product_catalogs_options() {
        if (!current_user_can('manage_options')) {
            return;
        }
        
        // Nonce field ekleyelim
        wp_nonce_field('pinterest_product_catalogs_options', 'pinterest_product_catalogs_nonce');    

        ?>
        <div>
            <h1>Product Feed for Pinterest Product Catalogs</h1>
            <p>Product RSS Feed for 'Pinterest Product Catalogs'. Automatically pin the products on your website by posting information such as photo, price, stock status, product description in your pinterest account.</p>
        </div>

        <div>
            <h3>Your Feed Links:</h3>
            
            <!-- All Products Feed -->
            <h4>All Products Feed:</h4>
            <a href="<?php echo site_url() ?>?call_pinterest_product_catalogs=1&ppcf_posts_per_page=100" target="_blank">
                <?php echo site_url() ?>?call_pinterest_product_catalogs=1&ppcf_posts_per_page=100
            </a>

            <!-- Category Specific Feeds -->
            <h4>Category Specific Feeds:</h4>
            <?php
            $product_categories = get_terms(array(
                'taxonomy' => 'product_cat',
                'hide_empty' => true
            ));

            if(!empty($product_categories) && !is_wp_error($product_categories)){
                echo '<ul>';
                foreach($product_categories as $category){
                    $feed_url = add_query_arg(array(
                        'call_pinterest_product_catalogs' => '1',
                        'ppcf_posts_per_page' => '100',
                        'ppcf_category' => $category->slug
                    ), site_url());
                    
                    echo '<li>';
                    echo '<strong>' . esc_html($category->name) . ':</strong><br>';
                    echo '<a href="' . esc_url($feed_url) . '" target="_blank">' . esc_url($feed_url) . '</a>';
                    echo '</li>';
                }
                echo '</ul>';
            }
            ?>

            <!-- Feed Example -->
            <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
            <div class="w3-panel w3-card w3-light-grey"> 
                <h4>Example Feed Format:</h4>
                <div class="w3-code htmlHigh notranslate">
                    &lt;channel&gt;<br>
                    &lt;item&gt;<br>
                    &lt;id&gt;1234&lt;/id&gt;<br>
                    &lt;title&gt;Grey Travel Bag&lt;/title&gt;<br>
                    &lt;description&gt;Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.&lt;/description&gt;<br>
                    &lt;link&gt;http://localhost/wordpress/product/grey-travel-bag/&lt;/link&gt;<br>
                    &lt;image_link&gt;http://localhost/wordpress/wp-content/uploads/2018/04/product-73.jpg&lt;/image_link&gt;<br>
                    &lt;g:availability&gt;in stock&lt;/g:availability&gt;<br>
                    &lt;g:condition&gt;New&lt;/g:condition&gt;<br>
                    &lt;sale_price&gt;19.59&lt;/sale_price&gt;<br>
                    &lt;g:price&gt;23.59&lt;/g:price&gt;<br>
                    &lt;/item&gt;<br>
                    &lt;channel&gt;
                </div>
            </div>
        </div>
        <?php
    }
}

function call_pinterest_product_catalogs(): void {  
    
    $ppcf_show_content = false; // Değişken tanımlanmamış
    $ppcf_show_thumbnail = false;
    $ppcf_show_post_terms = false;
    $ppcf_allowed_tags = PINTEREST_PRODUCT_CATALOGS_PLUGIN_ALLOWED_TAGS;
    $ppcf_pubdate_date_format = 'rfc';

    // Önceki tüm çıktıları temizle
    if (ob_get_level()) {
        ob_end_clean();
    }
    
    // Buffer'ı başlat
    ob_start();
    
    // XML header'ı gönder
    header('Content-Type: text/xml; charset=utf-8');

    $pinterest_product_catalogs_options = get_option('pinterest_product_catalogs_options');

    if(is_array($pinterest_product_catalogs_options)===false){
        $pinterest_product_catalogs_options = pinterest_product_catalogs_set_defults();
    }
    
    $options = array(
        'ppcf_show_content' => $ppcf_show_content,
        'ppcf_show_thumbnail' => $ppcf_show_thumbnail,
        'ppcf_show_post_terms' => $ppcf_show_post_terms,
        'ppcf_allowed_tags' => $ppcf_allowed_tags,
        'ppcf_pubdate_date_format' => $ppcf_pubdate_date_format
    );
    
    $args = array(
        'post_type' => isset($_GET["ppcf_post_type"]) ? sanitize_text_field($_GET["ppcf_post_type"]) : 'product',
        'posts_per_page' => isset($_GET["ppcf_posts_per_page"]) ? intval($_GET["ppcf_posts_per_page"]) : 100,
        'post_status' => isset($_GET["ppcf_post_status"]) ? sanitize_text_field($_GET["ppcf_post_status"]) : 'publish',
        'ignore_sticky_posts' => true
    );

    $xml_output = ppcf_build_xml_string($args, $options);
    
    // Buffer'ı temizle ve XML'i gönder
    ob_clean();
    echo trim($xml_output);
    exit();
}

function ppcf_build_xml_string(array $args, array $options): string {
    

    try {
        // Mevcut kod...
        $xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
    $xml .= '<rss version="2.0" xmlns:g="http://base.google.com/ns/1.0">' . "\n";
    $xml .= '<channel>' . "\n";

    $query = new WP_Query($args);
    
    if($query->have_posts()) {
        while($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $product = wc_get_product($post_id);
            
            // Temiz açıklama oluştur
            $description = wp_strip_all_tags($product->get_description());
            if(empty($description)) {
                $description = wp_strip_all_tags($product->get_short_description());
            }
            $description = html_entity_decode($description, ENT_QUOTES | ENT_HTML5, 'UTF-8');
$description = wp_strip_all_tags($description);
$description = trim(preg_replace('/\s+/', ' ', $description));
$description = preg_replace('/\<\!\[CDATA\[(.*?)\]\]\>/', '$1', $description);
            
            $xml .= "\t<item>\n";
            $xml .= sprintf("\t\t<g:id>%s</g:id>\n", esc_html($post_id));
            $xml .= sprintf("\t\t<title><![CDATA[%s]]></title>\n", get_the_title($post_id));
            $xml .= sprintf("\t\t<description><![CDATA[%s]]></description>\n", $description);
            $xml .= sprintf("\t\t<link>%s</link>\n", get_permalink($post_id));
            
            // Ürün görseli
            $image_url = wp_get_attachment_image_url(get_post_thumbnail_id($post_id), 'full');
            if($image_url) {
                $xml .= sprintf("\t\t<g:image_link>%s</g:image_link>\n", esc_url($image_url));
            }
            
            // Stok durumu
            $availability = $product->is_in_stock() ? 'in stock' : 'out of stock';
            $xml .= sprintf("\t\t<g:availability>%s</g:availability>\n", $availability);
            
            // Fiyat bilgisi
            $regular_price = $product->get_regular_price();
            $sale_price = $product->get_sale_price();
            
            if($regular_price) {
                $xml .= sprintf("\t\t<g:price>%s %s</g:price>\n", $regular_price, get_woocommerce_currency());
                if($sale_price) {
                    $xml .= sprintf("\t\t<sale_price>%s %s</sale_price>\n", $sale_price, get_woocommerce_currency());
                }
            }
            
            $xml .= "\t</item>\n";
        }
    }
    
    wp_reset_postdata();
    
    $xml .= '</channel></rss>';
    
    return $xml;
    } catch (Exception $e) {
        error_log('Pinterest Product Catalogs XML Build Error: ' . $e->getMessage());
        return '<?xml version="1.0" encoding="UTF-8"?><rss version="2.0"><channel><error>Feed generation failed</error></channel></rss>';
    }
}

 add_filter( 'query_vars', 'pinterest_product_catalogs_query_vars' );
function pinterest_product_catalogs_query_vars( $query_vars ){
    $query_vars[] = 'call_pinterest_product_catalogs';
    return $query_vars;
}

 add_action( 'parse_request', 'pinterest_product_catalogs_parse_request' );
function pinterest_product_catalogs_parse_request( $wp )
{
    if (array_key_exists('call_pinterest_product_catalogs', $wp->query_vars ) ) {
		$call_pinterest_product_catalogs = $wp->query_vars['call_pinterest_product_catalogs'];
		if($call_pinterest_product_catalogs=='1') call_pinterest_product_catalogs();
		die();
    }
}

register_activation_hook(__FILE__, 'pinterest_product_catalogs_activation');
// Activation function
function pinterest_product_catalogs_activation(bool $network_wide = false): void 
{
    // Default options
    $defaults = [
        'option1' => 'default_value1',
        'option2' => 'default_value2'
    ];
    
    if (!get_option('pinterest_product_catalogs_options')) {
        add_option('pinterest_product_catalogs_options', $defaults);
    }
}

register_deactivation_hook(__FILE__, 'pinterest_product_catalogs_deactivation');
function pinterest_product_catalogs_deactivation() {
	delete_option( 'pinterest_product_catalogs_options' );
}

 function pinterest_product_catalogs_set_defults(){
    $pinterest_product_catalogs_options	= array(
            'ppcf_post_type'=> 'product',
            'ppcf_post_status'=> 'publish',
            'ppcf_posts_per_page'=> 1000,
            'ppcf_show_meta'=> 0,
            'ppcf_show_thumbnail'=> 0,	
            'ppcf_show_content'=> 0,
            'ppcf_allowed_tags' => PINTEREST_PRODUCT_CATALOGS_PLUGIN_ALLOWED_TAGS,
            'ppcf_secret_key'=> '',
            'ppcf_xml_type'=> 0, 
            'ppcf_pubdate_date_format'=> 'rfc',
    );
    update_option('pinterest_product_catalogs_options',$pinterest_product_catalogs_options);
    return $pinterest_product_catalogs_options;
}