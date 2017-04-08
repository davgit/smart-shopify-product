<?php
/**
 * Plugin Name: Smart Shopify Product
 * Plugin URI: http://www.com
 * Description: This plugin allows add some shortcodes on post to insert Shopify products. Also allow to retrieve automatically all products on the shopify store.
 * Version: 1.0.0
 * Author: Yulio Aleman Jimenez
 * Author URI: http://yulioaj290.com
 * License: GPL2
 */ 

	
function ssp_enqueued_assets() {
	// wp_enqueue_script( 'my-script', plugin_dir_url( __FILE__ ) . '/js/my-script.js', array( 'jquery' ), '1.0', true );
	// wp_enqueue_style( 'ssp-bootstrap-grid-system', plugin_dir_url( __FILE__ ) . 'public/css/bootstrap-grid-system.css', array(), '1.0', 'all' );
}
	
function ssp_admin_enqueued_assets() {
	wp_enqueue_style( 'ssp-css-tabed-admin-menu', plugin_dir_url( __FILE__ ) . 'public/css/tabed-admin-menu.css' );
	wp_enqueue_script( 'ssp-js-tabed-admin-menu', plugin_dir_url( __FILE__ ) . 'public/js/tabed-admin-menu.js', array( 'jquery' ), '1.0.0', true );
}

add_action( 'wp_enqueue_scripts', 'ssp_enqueued_assets' );
add_action( 'admin_enqueue_scripts', 'ssp_admin_enqueued_assets' );


function ssp_menu() {
	add_menu_page('Smart Shopify Product Settings', 'Smart Shopify Product', 'administrator', 'smart-shopify-product-settings', 'ssp_settings_page', 'dashicons-products');
}

add_action('admin_menu', 'ssp_menu');


function ssp_settings_page() {
   if ( !current_user_can( 'administrator' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
   
   ?>
	<div class="wrap">
		<h2>Smart Shopify Product Settings</h2>
		<hr>

		<h2 class="nav-tab-wrapper">
		      <a class="nav-tab nav-tab-active" href="#">Shopify API</a>
		      <a class="nav-tab" href="#">Post Type of Product</a>
		</h2>

		<form method="post" action="options.php">
			<?php settings_fields( 'smart-shopify-product-settings-group' ); ?>
			<?php do_settings_sections( 'smart-shopify-product-settings-group' ); ?>

	    	<div id='sections'>
		    	<section>

					<table class="form-table">

						<tr valign="top">
							<th scope="row">API url</th>
							<td>
								<input type="text" name="api_url" size="100" value="<?php echo esc_attr( get_option('api_url') ); ?>" />
								<br />
								<small><strong>Eg:</strong> https://apikey:password@my-shop.myshopify.com</small>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row">Shop url</th>
							<td>
								<input type="text" name="shop_url" size="100" value="<?php echo esc_attr( get_option('shop_url') ); ?>" />
								<br />
								<small><strong>Eg:</strong> my-shop.myshopify.com</small>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row">Access Token</th>
							<td>
								<input type="text" name="access_token" size="100" value="<?php echo esc_attr( get_option('access_token') ); ?>" />
								<br />
								<small>A long randomize string provided by Shopify.</small>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row">App ID Number</th>
							<td>
								<input type="text" name="app_id" size="100" value="<?php echo esc_attr( get_option('app_id') ); ?>" />
								<br />
								<small>For Buy Button, usually is 6.</small>
							</td>
						</tr>

					</table>

				</section>


			    <section>

					<table class="form-table">

						<tr valign="top">
							<th scope="row">Post Type Slug</th>
							<td>
								<input type="text" name="product_post_type_slug" size="100" value="<?php echo esc_attr( get_option('product_post_type_slug') ); ?>" />
								<br />
								<small>
									Slug of the Post Type for Products you have had created, using Toolset or another plugin for management of custom Post Type. 
									<br /> <strong>Eg:</strong> product, shopify-product, sh-product.
								</small>
							</td>
						</tr>

						<tr valign="top">
							<th scope="row">Product ID Meta Slug</th>
							<td>
								<input type="text" name="product_id_meta_slug" size="100" value="<?php echo esc_attr( get_option('product_id_meta_slug') ); ?>" />
								<br />
								<small>
									Slug of the custom field type (or meta) of Shopify Product ID, for the Product Post Type you have had created, using Toolset or another plugin for management of custom Post Type. 
									<br /> <strong>Eg:</strong> product-id, shopify-product-id, sh-product-id.
									<br /> <strong>Note:</strong> Custom field created with Toolset plugin have a "wpcf-" prefix. Eg: wpcf-product-id.
								</small>
							</td>
						</tr>
					</table>

				</section>

	    	</div>

			<?php submit_button(); ?>

		</form>

		<?php /* Only draw 'refresh' section if plugin is linked to Shopify store */ 
		if( !empty(get_option('api_url')) and !empty(get_option('shop_url')) and !empty(get_option('app_id')) ) : ?>

			<hr>
			<h3>Import all products</h3>

			<script type="text/javascript">
				function ajaxImportShopifyProduct() {
					jQuery(function ($) { 
						$.ajax({
							type: "POST",
							url: '<?php echo plugin_dir_url( __FILE__ ) . 'smart-shopify-product.php'; ?>',
							data: { action : 'auto-import-shopify-product' },
							success: function(html) {
								return true;
							}
						});
					});
				}
			</script>
			
			<a href="#" onclick="ajaxImportShopifyProduct()" class="button">Import All Shopify Products</a>

			<?php 

			if($_POST['action'] == 'auto-import-shopify-product') {
			  echo "imported";
			}


		endif;
		
		?>
	</div>
<?php

}
	

function ssp_settings() {
   register_setting( 'smart-shopify-product-settings-group', 'api_url' );
   register_setting( 'smart-shopify-product-settings-group', 'shop_url' );
   register_setting( 'smart-shopify-product-settings-group', 'access_token' );
   register_setting( 'smart-shopify-product-settings-group', 'app_id' );
   register_setting( 'smart-shopify-product-settings-group', 'product_post_type_slug' );
   register_setting( 'smart-shopify-product-settings-group', 'product_id_meta_slug' );
}

add_action( 'admin_init', 'ssp_settings' );



function auto_import_shopify_products($id, $title){

	// auto create product

	$args = array(
		'fields' => 'ids',
		'post_type'   => 'product',
		'meta_query'  => array(
			array(
				'key' => 'wpcf-product-id',
				'value' => $id
			)
		)
	);

	$my_query = new WP_Query( $args );

	if( empty($my_query->have_posts()) ) {

		$today = date("F j, Y, g:i a");
	    $post_ID = get_the_ID();            
	    $create_record_fields = array(
	        'post_title' => $title,
	        'post_type' => 'product',
	        'post_status' => 'publish'
	        );
	          
	    if ($_POST["log_time"] = "true") {  
	        $new_post_id = wp_insert_post($create_record_fields);
	        update_post_meta( $new_post_id,  'wpcf-post_title', $title );
	        update_post_meta( $new_post_id,  'wpcf-post_type', 'product' );
	        update_post_meta( $new_post_id,  'wpcf-post-status', 'publish' );
	        update_post_meta( $new_post_id,  'wpcf-product-id', $id );
	  
	    }

	}
}