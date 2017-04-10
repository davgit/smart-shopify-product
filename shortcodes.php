<?php


// Alow to insert a Shopify product Buy Button using [shopify_basic_product product_id="ID"] shortcode
// =======================================================================================================

function sc_shopify_basic_product($atts) {
	return 
	'
	<script type="text/javascript">
		var product = shopify_basic_product('. $atts['product_id'] .');
	</script>

	<div class="shopify-basic-container row">
		<div id="sh-product-id" class="hidden">'. $atts['product_id'] .'</div>
		<div id="sh-product-'. $atts['product_id'] .'" class="shopify-product col-lg-12">
			<div class="sh-images center-text col-md-7">
				<div class="sh-images-main">
				</div>
				<div class="sh-images-gallery">
				</div>
			</div>
			<div class="sh-info center-text col-md-5">
				<h1 class="sh-title"></h1>
	    		<h2 class="variant-title"></h2>
				<h3 class="sh-price"></h3>
				<div class="sh-variant-types"></div>
				<div class="sh-add-cart">
					<button class="buy-button js-prevent-cart-listener">Add To Cart</button>
				</div>
				<div class="sh-content-body"></div>
			</div>
		</div>
	</div>
	';
}
add_shortcode( 'shopify_basic_product', 'sc_shopify_basic_product' );


// Alow to insert a Shopify product Buy Info using [shopify_info_product product_id="ID"] shortcode
// =======================================================================================================

function sc_shopify_info_product($atts) {
	return 
	'
	<div class="shopify-info-cell ' . ($atts['swipe'] == "true" ? '' : 'col-md-3 col-sm-6' ) .'">
		<script type="text/javascript">
			var product = shopify_info_product('. $atts['product_id'] .');
		</script>

		<div id="sh-i-product-'. $atts['product_id'] .'" data-product-id="'. $atts['product_id'] .'" >
			<div class="sh-i-product-image center-text"></div>
			<h3 class="sh-i-product-title center-text"></h3>
			<p class="sh-i-product-price center-text"></p>
		</div>
	</div>
	';
}
add_shortcode( 'shopify_info_product', 'sc_shopify_info_product' );

 