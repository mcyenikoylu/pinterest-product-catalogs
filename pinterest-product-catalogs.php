<?php
/*
 * Plugin Name:   WC Product Feed for Pinterest
 * Plugin URI:    
 * Description:   WooCommerce product RSS Feed for 'Pinterest Product Catalogs'. Automatically pin the products on your website by posting information such as photo, price, stock status, product description in your pinterest account.
 * Version:       1.0.0
 * Author:        Mehmet Cenk Yenikoylu
 * Author URI:    https://github.com/mcyenikoylu
 * License: GPLv2 or later
 */

if ( is_admin() ){
    require_once dirname( __FILE__ ) . '/index.php';

    function pinterest_product_catalogs_plugin_action_links( $links, $file ) {
        if ( $file == plugin_basename( dirname(__FILE__).'/pinterest-product-catalogs.php' ) ) {
            $links[] = '<a href="' . admin_url( 'admin.php?page=pinterest-product-catalogs-admin-options' ) . '">'.__( 'Settings' ).'</a>';
            }
            return $links;
        }
        add_filter('plugin_action_links', 'pinterest_product_catalogs_plugin_action_links', 10, 2);
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

add_filter( 'query_vars', 'pinterest_product_catalogs_query_vars' );
function pinterest_product_catalogs_query_vars( $query_vars ){
    $query_vars[] = 'call_pinterest_product_catalogs';
    return $query_vars;
}

register_activation_hook(__FILE__, 'pinterest_product_catalogs_activation');
function pinterest_product_catalogs_activation() {
	pinterest_product_catalogs_set_defults();
}

register_deactivation_hook(__FILE__, 'pinterest_product_catalogs_deactivation');
function pinterest_product_catalogs_deactivation() {
	delete_option( 'pinterest_product_catalogs_options' );
}

function mcy_build_xml_string($args,$options){
	    
    extract($options);
   
    $the_query = new WP_Query( $args );
    
    $namespaces_str = '';
    foreach($namespaces as $name => $value){
        $namespaces_str .=  'xmlns:'.$name.'="'.$value.'" ';
    }    
    $csrp_feed_current = '<?xml version="1.0" encoding="UTF-8"?>
    <rss version="2.0" '.$namespaces_str.' >';

    $csrp_feed_current .= '
        <channel>
        <title>'.get_bloginfo("name").'</title>
        <description>'.get_bloginfo("description").'</description>
        <link>'.get_home_url().'</link>
        <lastBuildDate>'.  mysql2date('D, d M Y H:i:s +0000', get_lastpostmodified('GMT'), false) .'</lastBuildDate>';
        $debug_data = array(
            'args' => $args,
            'options' => $options,
        );

        if(isset($csrp_debug)&& $csrp_debug=='1') $csrp_feed_current .=	'<debug>'.json_encode($debug_data, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_UNESCAPED_UNICODE).'</debug>';

        if ( $the_query->have_posts() ) {
            while ( $the_query->have_posts() ) {
                $the_query->the_post();		
                $post_id = get_the_ID();
                $the_post = get_post($post_id);
                $excerpt = $the_post->post_excerpt;
                $modified = $the_post->post_modified;
                $created = $the_post->post_date;
                $author_id = $the_post->post_author;
                $menu_order  = $the_post->menu_order;
                $post_parent  = $the_post->post_parent;
                $post_status = $the_post->post_status;
                $author = get_the_author_meta('display_name', $author_id );				
                $categories = get_the_category();
                switch ($csrp_pubdate_date_format) {
                    case "rfc":
                        $date_format =  'D, d M Y H:i:s O';
                        $pub_date = get_the_date( $date_format, $post_id );
                        break;
                    case "blog_date":
                        $date_format =  get_option( 'date_format' );
                        $pub_date = get_the_date( $date_format, $post_id );
                        break;
                    case "blog_date_time":
                        $date_format =  get_option( 'date_format' ).' '.get_option('time_format');
                        $pub_date = get_the_date( $date_format, $post_id );
                        break;
                    default:
                        $date_format =  'D, d M Y H:i:s O';
                        $pub_date = get_the_date( $date_format, $post_id );
                }
                $collection = null;
                $taxonomies = null;
             
                $taxonomy_objects = null;
                
                $custom_fields = get_post_custom($post_id);
               
                $thumb = wp_get_attachment_image_src( get_post_thumbnail_id($post_id), $options['csrp_thumbnail_size=full'],true);
             
                $thumb_url = $thumb['0'];
               
                    $csrp_feed_current .='
                    <item>
                   
                            <id><![CDATA['. $post_id .']]></id>
                            <title><![CDATA['. get_the_title($post_id) .']]></title>
                            <description><![CDATA['. $excerpt .']]></description>
                            <link><![CDATA['. get_permalink($post_id) .']]></link>
                            <image_link><![CDATA[ '. esc_url($thumb_url) .']]></image_link>
                            
                            ';

                          
                             foreach ( $custom_fields as $key => $value ) {
                                if ($key=='_stock_status'){
                                    if ($value[0] == 'instock')
                                        $csrp_feed_current .= "<g:availability><![CDATA[ in stock ]]></g:availability>";//$value[0] = str_replace("instock","in stock",$value[0]);
                                    else if ($value[0] == 'outofstock')
                                        $csrp_feed_current .= "<g:availability><![CDATA[ out of stock ]]></g:availability>";//$value[0] = str_replace("instock","in stock",$value[0]);
                                    else if ($value[0] == 'preorder')
                                        $csrp_feed_current .= "<g:availability><![CDATA[ preorder ]]></g:availability>";//$value[0] = str_replace("instock","in stock",$value[0]);
                                }
                            }

                            $csrp_feed_current .= "<g:condition><![CDATA[ New ]]></g:condition>";

                            $price = get_post_meta(get_the_ID(), '_price', true);
                            $csrp_feed_current .= "<g:price><![CDATA[".$price."]]></g:price>";
                               
                    $csrp_feed_current .='		
                    </item>';

            }
        } else {
            // no posts 
        }			
      
        wp_reset_postdata();
        
    $csrp_feed_current .='</channel></rss><!-- end of xml string -->';
    return $csrp_feed_current;
    
}

function pinterest_product_catalogs_set_defults(){
    $pinterest_product_catalogs_options	= array(
            'csrp_post_type'=> 'product',
            'csrp_post_status'=> 'publish',
            'csrp_posts_per_page'=> 1000,
            'csrp_show_meta'=> 0,
            'csrp_show_thumbnail'=> 0,	
            'csrp_show_content'=> 0,
            'csrp_allowed_tags' => PINTEREST_PRODUCT_CATALOGS_PLUGIN_ALLOWED_TAGS,
            'csrp_secret_key'=> '',
            'csrp_xml_type'=> 0, 
            'csrp_pubdate_date_format'=> 'rfc',
    );
    update_option('pinterest_product_catalogs_options',$pinterest_product_catalogs_options);
    return $pinterest_product_catalogs_options;
}

function call_pinterest_product_catalogs(){    

    $pinterest_product_catalogs_options = get_option('pinterest_product_catalogs_options');

	if(is_array($pinterest_product_catalogs_options)===false){
		$pinterest_product_catalogs_options = pinterest_product_catalogs_set_defults();
	}
	
    $csrp_show_post_terms = $csrp_debug = $csrp_show_all_post_terms = null;
     
    extract($pinterest_product_catalogs_options);
    
	$args = array(
		'post_type' => $csrp_post_type,
		'showposts' => $csrp_posts_per_page, 
		'post_status'=>$csrp_post_status,
		'ignore_sticky_posts' => true,
	);
	
    $namespaces = array(
        "content" => "http://purl.org/rss/1.0/modules/content/",
		"wfw" => "http://wellformedweb.org/CommentAPI/",
		"dc" => "http://purl.org/dc/elements/1.1/",
		"atom" => "http://www.w3.org/2005/Atom",
		"sy" => "http://purl.org/rss/1.0/modules/syndication/",
		"slash" => "http://purl.org/rss/1.0/modules/slash/",
        "media" => "http://search.yahoo.com/mrss/",
        "wp" => "http://wordpress.org/export/1.2/",
        "excerpt" => "http://wordpress.org/export/1.2/excerpt/",
        "g" => "http://base.google.com/ns/1.0",
    );
    $options['namespaces'] = $namespaces;
    
    $csrp_feed_output = null;
    $csrp_feed_output = mcy_build_xml_string($args,$options);

    if($csrp_feed_output){
        header('Content-Type: text/xml; charset=utf-8');
        print($csrp_feed_output);         
    }else{
        header('Content-Type: text/xml; charset=utf-8');
        print('<?xml version="1.0" encoding="UTF-8"?><rss/>'); 
    }
 }