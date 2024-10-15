/**/
/* on load event */
/**/
"use strict";
jQuery(document).ready( function (){
	if ( !is_mobile_device () ) {
		$('body').append('<div id="tuner" class="tuner"> <div class="colors"> <p>Color Skin</p> <div id="color-1" class="color-picker" data-color="#ffc107" style="background-color:#ffc107;"></div> </div><div class="layout-style"><p>Layout Style</p><div class="page-style wide active">Wide</div><div class="page-style boxed">Boxed</div></div><i id="tuner-switcher" class="fa fa-cog"></i> </div> <div id="tuner-style-1" class="tuner-style" style="display: none;"> /* Colors for: main color */    p a, ins, ins.alt-3, ul.style-2 li:before, ul.icon li i, ul.icon-style li .list-icon, .title-section-top, .title-section.alt span, .title-section.gray span, .inner-nav > ul > li.slash, .menu-contacts .menu-contacts-item .cws-icon, .main-nav li.search .search-icon, .main-nav li.search .close-button span, .main-nav.transparent .search li .close-button:hover, .mn-sub li:hover > .button_open, .mn-sub li.active > .button_open, .inner-nav.desktop-nav ul li .mn-sub li > a:not(.mn-group-title):before, .mobile_nav ul li a:not(.cws-button):hover, .mobile_nav ul.mn-sub li a:not(.cws-button):hover, .site-top-panel .top-left-wrap a:hover, .site-top-panel .top-left-wrap span, .site-top-panel .top-right-wrap .top-login a:hover, .site-top-panel .top-right-wrap .dropdown ul li a:hover, .search-tours-wrap .search-tours-tabs .search-tabs-wrap .tours-tab-btn .tours-tab-icon, .search-tours-wrap .search-tours-content .tours-container .cars-advance span, .search-tours-wrap .search-tours-content .tours-container .flights-advance span, .search-tours-wrap .search-tours-content .tours-container .tours-calendar .calendar-icon, .search-tours-wrap .search-tours-content .tours-container .selection-box .box-icon, .search-tours-wrap .search-tours-content .tours-container form.form.search .search-wrap .search-icon, .search-hotels .tours-container .cars-advance span, .search-hotels .tours-container .flights-advance span, .search-hotels .tours-container .tours-calendar .calendar-icon, .search-hotels .tours-container .selection-box .box-icon, .search-hotels .tours-container form.form.search .search-wrap .search-icon, .slider-info-wrap .slider-info-content .slider-info-item .info-item-media .info-item-text .info-price span, .slider-info-wrap .slider-info-content .slider-info-item .info-item-media .info-item-text .info-temp span, .slider-info-wrap .slider-info-content .slider-info-item .info-item-content .main-title .price span, .slider-info-wrap .slider-info-content .slider-info-item .info-item-content .main-title .button, .features-tours-full-width .features-tours-wrap .features-tours-item .features-media .features-info-top .info-price span, .features-tours-full-width .features-tours-wrap .features-tours-item .features-media .features-info-top .info-temp span,.features-tours-full-width .features-tours-wrap .features-tours-item .features-media .features-info-bot .title span, .features-tours-full-width .features-tours-wrap .features-tours-item .features-media .features-info-bot .button, .recom-item .recom-item-body .blog-title:hover, .breadcrumbs h2 > span, .breadcrumbs .breadcrumbs-item > a:hover, .breadcrumbs .breadcrumbs-item .location a, .cws-button.alt:hover, .cws-button.gray-dark.alt, .cws-button.gray-dark:hover, .cws-button.white:hover, .cws-button.with-icon, .cws-button.with-icon.alt:hover, .cws-icon.main-color, .cws-icon.border-icon.alt:hover, .service-item:hover .cws-icon.border-icon.alt, .service-item:hover .cws-icon, .service-item:hover h3, .service-item a:hover, .cws-icon.type-3:hover:before, .hover-effect-2:hover .opacity:hover h3, .cws-social:hover, .dark > .cws-social:hover, .service-item.color-icon .cws-icon, .service-item.on-dark:hover .cws-icon, .service-item.on-dark:hover h3, .service-center-icon .cws-icon, .pricing-tables .pricing-list li .list-icon.flaticon-mark, .pricing-tables.active .header-pt h3, .pricing-tables:hover .header-pt h3, .tabs .block-tabs-btn .tabs-btn.active, .profile-item .soc-links .cws-social:hover, .profile-item:hover .title, nav .showing span, .carousel-container .carousel-nav .prev:hover, .carousel-container .carousel-nav .next:hover, .comments .comment-body .comment-info .comment-content > a:hover, .reviews-total h5, .contact-item .contact-cws-social a:hover, footer.footer .widget-tags-wrap .tag:hover, footer.footer .twitter-footer li a, footer.footer .twitter-footer .twitt, footer.footer .copyright p span, footer.footer .copyright a:hover, .blog-item .blog-item-body .blog-title:hover, .blog-item .blog-item-body .blog-button:hover, .blog-item .post-info .post-category:hover, .nav-blog .prev:hover, .nav-blog .next:hover, .blog-nav-tags a:hover, .blog-nav-share .cws-social:hover, .quote.alt-3 h4 span, .widget-search form .search-submit, .widget-subscribe form .submit, .widget-categories ul li:hover a, .widget-archive ul li:hover a, .widget-items ul li:hover a, .widget-custom-filter ul li:hover a, .widget-items ul li:hover a span, .widget-categories.alt .accordion.style-2 .content-title.active, .widget-categories.alt .accordion.style-2 .content ul li:hover a, .widget-categories.alt .accordion.style-2 .content ul li.active a, .widget-post .item-recent .title a:hover, .widget-post .item-top-sellers .title a:hover, .widget-top-sellers .item-recent .title a:hover, .widget-top-sellers .item-top-sellers .title a:hover, .widget-post .item-recent .price, .widget-post .item-top-sellers .price, .widget-top-sellers .item-recent .price, .widget-top-sellers .item-top-sellers .price, .top-shop .widget-top-sellers p span, .top-shop .widget-top-sellers .item-top-sellers .title .shop-close i:hover, .top-shop .widget-top-sellers .item-top-sellers .price > span:first-child, .top-shop .widget-top-sellers .total .sub-total span, .widget-comments ul li .widget-comments-title a:hover, .widget-tags .tag:hover, .ui-datepicker-title span:last-child, .admin-about .admin-name a, .project-details .description .tag:hover, .project-details .description .link, .project-details .description .social:hover, .star-rating:before, .stars:before, #list-or-grid .switch-button.active, .shop-data .result-count span, .shop-item .shop-item-body .shop-title:hover, .color-filter ul .cat-item.main-color.active, .color-filter ul .cat-item.main-color:hover, .color-filter ul .cat-item.main-color.active a, .color-filter ul .cat-item.main-color:hover a, .brand-filter ul .cat-item.main-color.active, .brand-filter ul .cat-item.main-color:hover, .brand-filter ul .cat-item.main-color.active a, .brand-filter ul .cat-item.main-color:hover a, .size-filter .size:hover, .size-filter .size.active, .single-product .summary .shop-price span, .single-product .price , .single-product .post-number a:hover, .single-product .category-line a:hover, .single-product .tags-line a:hover, .review-status .status-product span, input[type="checkbox"]:before, .shipping .amount, .inner-nav li.menu-shop-card .mn-sub li .shop-cart-menu a.cws-button, .inner-nav.mobile_nav .shop-cart-menu a.cws-button, table.table .table-icon, .woocommerce-shipping-fields #ship-to-different-address label, abbr, .woocommerce table tbody .cart_item:hover .product-name, .contact-address p span, .twitter-1 .twitt-icon, #scroll-top:hover i, .login-popup .login-popup-wrap .login-content .remember a, .dropcap, .back-home, .tuner .page-style.active, .tuner .page-style.active.boxed:before, .stars-perc > span:before     { color: #<span>cws_theme_main#</span>; }    header .transparent .inner-nav > ul > li > a.active, header .transparent .inner-nav > ul > li > a:hover, .mn-sub li:hover > a, .mn-sub li.active > a, .mobile_nav li:hover a:not(.cws-button), .mobile_nav li.active > a     { color: #<span>cws_theme_main#</span> !important; }    hr ,input[type="number"]:focus, .radio label:hover, .radio.radio1 label, .radio input[type=radio]:checked + label, .search-tours-wrap .search-tours-content .tours-container .buttons-wrap .tour-button:hover, .search-hotels .tours-container .buttons-wrap .tour-button:hover, .cws-button, .cws-button.border-left:before, .cws-button.gray-dark.alt:hover, .cws-button.gray-dark.border-left:hover:before, .cws-button.with-icon, .cws-button.with-icon:hover, .cws-button.with-icon.alt, .cws-button.with-icon.alt:hover, .cws-icon.border-icon:hover, .cws-icon.border-icon.alt, .service-item:hover .cws-icon.border-icon, .service-item.border:hover, .service-item.icon-right.alt:hover .cws-icon, .service-item.icon-left.alt:hover .cws-icon, .service-item.icon-right.alt:hover .cws-icon:after, .service-item.icon-left.alt:hover .cws-icon:after, .pricing-tables.active, .pricing-tables:hover, .pricing-tables.active a.cws-button, .profile-item:hover, .carousel-container .carousel-nav .prev:hover, .carousel-container .carousel-nav .next:hover, .carousel-pag .owl-pagination .owl-page.active, .pagiation-carousel .owl-pagination .owl-page.active, .carousel-pag.main-color .owl-page.active, .pagiation-carousel.main-color .owl-page.active, .contact-form input:not(.cws-button):focus, .contact-form textarea:focus, .selection-box select:focus, .message-form-subject input:focus, n.message-form-author input:focus, .message-form-website input:focus, .message-form-email input:focus, .message-form-message textarea:focus, .filter-button.active, .filter-button:hover, #list-or-grid .switch-button.active, .shop-data #list-grid > div.active, .color-filter ul .cat-item.main-color.active:before, .color-filter ul .cat-item.main-color:hover:before, .brand-filter ul .cat-item.main-color.active:before, .brand-filter ul .cat-item.main-color:hover:before, .size-filter .size:hover, .size-filter .size.active, .login-popup .login-popup-wrap .login-content input.form-row:focus, .review-popup .review-popup-wrap .review-content input.form-row:focus, .review-popup .review-popup-wrap .review-content textarea:focus, ins.alt-3 ul.style-1 li:before , .cws_divider, hr, .divider-slash, .mn-sub, .site-top-panel, .search-hotels.room-search .search-room-title, .slider-info-wrap .slider-info-content .slider-info-item .info-item-content .main-title .button, .features-tours-full-width .features-tours-wrap .features-tours-item .features-media .features-info-bot .button, .breadcrumbs .breadcrumbs-item .location a, .cws-icon.only-border, .cws-icon.type-3, .cws-icon.type-3:after, .counter-block.with-divider:before, .pagination li:first-child:hover a, .pagination li:last-child:hover a, footer.footer h4, .quote.alt-2, .cws-widget .widget-title, .contact-form .cws-button, .border-t, .border-b, .shop-post img, .inner-nav li.menu-shop-card .mn-sub li .shop-cart-menu a.cws-button, .inner-nav.mobile_nav .shop-cart-menu a.cws-button, .map-full-width.border-t, .twitter-1 .twitt-icon, .review-popup .review-popup-wrap .title-wrap, .dropcap, .tuner, .tuner .page-style.active, .tuner .page-style.active.boxed:before, .widget-contact-form input.error:focus, .widget-contact-form textarea.error:focus, footer a img  { border-color: #<span>cws_theme_main#</span>; }    .pricing-tables a.cws-button:hover  { border-color: #<span>cws_theme_main#</span> !important; }    ins.alt-2, ul.style-1 li:before, .bg-main, .magic-line-main .magic-line-main-li, .main-nav li.search:after, .inner-nav:after, .inner-nav .mobile_menu_switcher, .main-nav:not(.transparent) .inner-nav.desktop-nav.switch-menu .menu-bar .ham, .main-nav:not(.transparent) .inner-nav.desktop-nav.switch-menu .menu-bar .ham:before, .main-nav:not(.transparent) .inner-nav.desktop-nav.switch-menu .menu-bar .ham:after, .search-tours-wrap .search-tours-content .tours-container .button-search:before, .search-tours-wrap .search-tours-content .tours-container .buttons-wrap .tour-button:hover, .search-hotels .tours-container .button-search:before, .search-hotels .tours-container .buttons-wrap .tour-button:hover, .search-hotels .tours-container .buttons-wrap .tour-button:hover, .slider-info-wrap .slider-info-content .slider-info-item .info-item-content .main-title .button:hover, .features-tours-full-width .features-tours-wrap .features-tours-item .features-media .features-info-bot .button:hover, .recom-item .recom-item-body .cws-button:before, .recom-item .recom-item-body .action, .cws-button:hover, .cws-button.border-left:hover:before, .cws-button.alt, .cws-button.alt.border-left:before, .cws-button.gray-dark.alt:hover, .cws-button.gray-dark.border-left:hover:before, .cws-button.with-icon:hover, .cws-button.with-icon.alt, .cws-icon.border-icon:hover, .cws-icon.border-icon.alt, .service-item:hover .cws-icon.border-icon, .cws-icon.type-3:after, .service-bg-icon:before, .service-center-icon:before, .accordion .content-title.active i.active-icon, .toggle .content-title.active i.active-icon, .alert.alert-info, .skill-bar.st-main-color .bar span, .divider, .pagination li a:hover, .pagination li a.active, .pagination li a:focus, #flex-carousel.flexslider .flex-viewport ul li.flex-active-slide:before, #flex-carousel.flexslider .flex-direction-nav .flex-nav-prev a, #flex-carousel.flexslider .flex-direction-nav .flex-nav-next a, #flex-carousel.flexslider .flex-direction-nav .flex-nav-prev a:after, #flex-carousel.flexslider .flex-direction-nav .flex-nav-next a:after, .testimonial-item .testimonial-body .testimonial-button:before, .blog-item .blog-media .pic:before, .blog-date .date:before, .widget-categories ul li:before, .widget-archive ul li:before, .widget-items ul li:before, .widget-custom-filter ul li:before, .menu-widget .magic-line #magic-line, .carousel-pag.main-color .owl-page.active, .pagiation-carousel.main-color .owl-page.active, .ui-state-default.ui-state-active:before, td.ui-datepicker-today:before, .portfolio-item .portfolio-media:before, .filter-button.active, .filter-button:hover, .shop-item .shop-item-body .price-review .cws-button:before, .shop-item .shop-item-body .action, .price_slider .ui-slider-handle:before, .color-filter ul .cat-item.main-color.active:before, .color-filter ul .cat-item.main-color:hover:before, .brand-filter ul .cat-item.main-color.active:before, .brand-filter ul .cat-item.main-color:hover:before, .single-product .summary .price-review .cws-button:before, .single-product .pic:before, form input[type*="radio"]:checked:before, .contact-address .contact-icon-wrap .contact-icon:before, .login-popup .login-popup-wrap .title-wrap, .login-popup .login-popup-wrap .login-bot, .dropcap.alt-2, .dropcap.alt-4, .tuner i, .price_slider .ui-slider-range    { background: #<span>cws_theme_main#</span>; }   .pricing-tables a.cws-button:hover   { background: #<span>cws_theme_main#</span> !important; }   .blog-date .date .date-cont > span.day:before, .tabs .tabs-btn:before  { border-color: #<span>cws_theme_main#</span> transparent transparent transparent; }  </div> <div id="tuner-style-2" class="tuner-style" style="display: none;">   <style id="cws-cp-1"></style>')

		jQuery('#tuner-switcher').on('click', function()
		{
			jQuery('#tuner').toggleClass('tuner-visible');
		});

		jQuery('.color-picker').each( function(){
			var el = jQuery(this);
			var def_color = el.data( 'color' );
			var id = el.attr('id');
			var matches = /color-(\d+)/.exec( id );
			if ( matches != null ){
				var index = matches[1];
				var tuner_id = 'tuner-style-' + index;
				var style_id = 'cws-cp-' + index;
				var tuner_el = jQuery( '#' + tuner_id );
				var style_el = jQuery( '#' + style_id );
				if ( tuner_el.length && style_el.length ){
					
					el.ColorPicker({
						color: def_color,
						onShow: function(colpkr)
						{
							jQuery(colpkr).fadeIn(300);
							return false;
						},
						onHide: function(colpkr)
						{
							jQuery(colpkr).fadeOut(300);
							return false;
						},
						onChange: function (hsb, hex, rgb) {
							el.css('background-color', '#' + hex);
							tuner_el.find('span').text(hex);
							tuner_el.find('span.darknest').text(cws_Hex2RGBwithdark(hex,1.14));
							style_el.text(tuner_el.text());
						}
					});
				}

			}
		});
		$("html").addClass("t-pattern-1");
		jQuery('#tuner').on('click', '.patterns li', function()
		{
			jQuery(".tuner .patterns li").removeClass('active');
			jQuery(this).addClass("active");
			var body_el, body_cls, matches, old_pattern, new_pattern_index, new_pattern;
			body_el = jQuery('html');
			body_cls = body_el.attr('class');
			matches = /t-pattern-(\d+)/.exec( body_cls );
			if ( matches != null ){
				old_pattern = matches[0];
				body_el.removeClass(old_pattern);
			}
			new_pattern_index = jQuery(this).data('pattern');
			new_pattern = "t-pattern-" + new_pattern_index;
			body_el.addClass(new_pattern);
		});
		jQuery('#tuner').on('click', '.page-style', function() {
			$('.tuner .page-style').removeClass('active');
			$(this).addClass("active");
			if ( $(this).hasClass("boxed") ) {
				$("body").addClass("boxed");
			} else {
				$("body").removeClass("boxed");
			}
			width_sticky ();
			$(window).resize(function(){
				width_sticky();
			})
		})
	}
});
function width_sticky () {
	if ( $("body").hasClass("boxed") ) {
		var width_body = $("body").innerWidth();
		$("body.boxed .sticky-menu").css({"width":width_body+"px"});
	} else {
		$("body .sticky-menu").css({"width":"100%","left":"0"});
	}
}
function cws_Hex2RGBwithdark(hex,coef_color) {

  var coef_color = coef_color == undefined ? 1 : coef_color;
  var hex = hex.replace("#", "");

  var color = '';

  if (hex.length == 3) {
   color = Math.round(hexdec(hex.substr(0,1))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(1,1))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(2,1))/coef_color);
  }else if(hex.length == 6){
   color = Math.round(hexdec(hex.substr(0,2))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(2,2))/coef_color)+',';
   color = color + Math.round(hexdec(hex.substr(4,2))/coef_color);
  }
  return color;
 }
 function hexdec(hex_string) {
  hex_string = (hex_string + '')
  .replace(/[^a-f0-9]/gi, '');
  return parseInt(hex_string, 16);
 }