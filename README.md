
# utility-package

## Over View of package 

* Wpmet Plugin Utility helper package for Banner, Notice, Stories, and Rating.
* We made a composer package for these classes together.
* By using this Helper package we are centralizing the feature of these Classes in a package manager
  (so that any update or modifications of these functionalities globally have  no need to give hand or keep any dependencies on our plugins)


## Installation

`` composer require wpmet/utility-package ``

* this command installs the latest version of our package.
* NB: we recommend you to use this package with PHP-Scoper. 

## Calling/Using feature example here :

```php 
/**
 * Show WPMET stories widget in the dashboard
 */
$filter_string = ''; // elementskit,metform-pro
$filter_string .= ((!in_array('elementskit/elementskit.php', apply_filters('active_plugins', get_option('active_plugins')))) ? '' : ',elementskit');
$filter_string .= (!class_exists('\MetForm\Plugin') ? '' : ',metform');
$filter_string .= (!class_exists('\MetForm_Pro\Plugin') ? '' : ',metform-pro');

\Wpmet\UtilityPackage\Stories\Stories::instance( 'elementskit-lite' )   # @plugin_slug
// ->is_test(true)                                                      # @check_interval
->set_filter( $filter_string )                                          # @active_plugins
->set_plugin( 'ElementsKit', 'https://wpmet.com/plugin/elementskit/' )  # @plugin_name  @plugin_url
->set_api_url( 'https://api.wpmet.com/public/stories/' )                # @api_url_for_stories
->call();

/**
 * Show elementskit Notice
 */
\Wpmet\UtilityPackage\Notice\Notice::instance( 'elementskit-lite', 'go-pro-noti2ce' )   # @plugin_slug @notice_name
->set_dismiss( 'global', ( 3600 * 24 * 300 ) )                                          # @global/user @time_period
->set_type( 'warning' )                                                                 # @notice_type
->set_html(
        '
        <div class="ekit-go-pro-notice">
            <strong>Thank you for using ElementsKit Lite.</strong> To get more amazing 
            features and the outstanding pro ready-made layouts, please get the 
            <a style="color: #FCB214;" target="_blank" 
            href="https://wpmet.com/elementskit-pricing">Premium Version</a>.
        </div>
    '
    )                                                                                     # @notice_massage_html
->call();

/**
 * Show WPMET banner (codename: jhanda)
 */
\Wpmet\UtilityPackage\Banner\Banner::instance( 'elementskit-lite' )     # @plugin_slug
// ->is_test(true)                                                      # @check_interval
->set_filter( ltrim( $filter_string, ',' ) )                            # @active_plugins
->set_api_url( 'https://api.wpmet.com/public/jhanda' )                  # @api_url_for_banners
->set_plugin_screens( 'edit-elementskit_template' )                     # @set_allowed_screen
->set_plugin_screens( 'toplevel_page_elementskit' )                     # @set_allowed_screen
->call();

/**
 * Ask for Ratings 
 */
\Wpmet\UtilityPackage\Rating\Rating::instance('metform')                    # @plugin_slug
->set_plugin_logo('https://ps.w.org/metform/assets/icon-128x128.png')       # @plugin_logo_url
->set_plugin('Metform', 'https://wpmet.com/wordpress.org/rating/metform')   # @plugin_name  @plugin_url
->set_allowed_screens('edit-metform-entry')                                 # @set_allowed_screen
->set_allowed_screens('edit-metform-form')                                  # @set_allowed_screen
->set_allowed_screens('metform_page_metform_get_help')                      # @set_allowed_screen
->set_priority(30)                                                          # @priority
->set_first_appear_day(7)                                                   # @time_interval_days
->set_condition(true)                                                       # @check_conditions
->call();

/**
 * Show our plugins menu for others wpmet plugins
 */
\Wpmet\UtilityPackage\Plugins\Plugins::instance()->init('metform')                # @text_domain
->set_parent_menu_slug('metform-menu')                                      # @plugin_slug
->set_submenu_name('Our Plugins')                                                  # @submenu_name (optional- default: Our Plugins)
->set_section_title('My Custom title')                                      # @section_title (optional)
->set_section_description('My custom description')                          # @section_description (optional)
->set_items_per_row(4)                                                      # @items_per_row (optional- default: 6)
->set_plugins(                                                              # @plugins
	[
		'elementskit-lite/elementskit-lite.php' => [
			'name' => esc_html__('ElementsKit', 'metform'),
			'url'  => 'https://wordpress.org/plugins/elementskit-lite/',
			'icon' => 'https://ps.w.org/elementskit-lite/assets/icon-256x256.gif?rev=2518175',
			'desc' => esc_html__('All-in-one Elementor addon trusted by 1 Million+ users, makes your website builder process easier with ultimate freedom.', 'metform'),
			'docs' => 'https://wpmet.com/docs/elementskit/',
		],
		'getgenie/getgenie.php' => [
			'name' => esc_html__('GetGenie AI', 'metform'),
			'url'  => 'https://wordpress.org/plugins/getgenie/',
			'icon' => 'https://ps.w.org/getgenie/assets/icon-256x256.gif?rev=2798355',
			'desc' => esc_html__('Your personal AI assistant for content and SEO. Write content that ranks on Google with NLP keywords and SERP analysis data.', 'metform'),
			'docs' => 'https://getgenie.ai/docs/',
		],
		'shopengine/shopengine.php' => [
			'name' => esc_html__('ShopEngine', 'metform'),
			'url'  => 'https://wordpress.org/plugins/shopengine/',
			'icon' => 'https://ps.w.org/shopengine/assets/icon-256x256.gif?rev=2505061',
			'desc' => esc_html__('Complete WooCommerce solution for Elementor to fully customize any pages including cart, checkout, shop page, and so on.', 'metform'),
			'docs' => 'https://wpmet.com/doc/shopengine/',
		],
		'metform/metform.php' => [
			'name' => esc_html__('MetForm', 'metform'),
			'url'  => 'https://wordpress.org/plugins/genie-image-ai/',
			'icon' => 'https://ps.w.org/genie-image-ai/assets/icon-256x256.png?rev=2977297',
			'desc' => esc_html__('Drag & drop form builder for Elementor to create contact forms, multi-step forms, and more — smoother, faster, and better!', 'metform'),
			'docs' => 'https://wpmet.com/doc/metform/',
		],
		'emailkit/EmailKit.php' => [
			'name' => esc_html__('EmailKit', 'metform'),
			'url'  => 'https://wordpress.org/plugins/genie-image-ai/',
			'icon' => 'https://ps.w.org/emailkit/assets/icon-256x256.png?rev=3003571',
			'desc' => esc_html__('Advanced email customizer for WooCommerce and WordPress. Build, customize, and send emails from WordPress to boost your sales!', 'metform'),
			'docs' => 'https://wpmet.com/doc/emailkit/',
		],
		'wp-social/wp-social.php' => [
			'name' => esc_html__('WP Social', 'metform'),
			'url'  => 'https://wordpress.org/plugins/wp-social/',
			'icon' => 'https://ps.w.org/wp-social/assets/icon-256x256.png?rev=2544214',
			'desc' => esc_html__('Add social share, login, and engagement counter — unified solution for all social media with tons of different styles for your website.', 'metform'),
			'docs' => 'https://wpmet.com/doc/wp-social/',
		],
		'wp-ultimate-review/wp-ultimate-review.php' => [
			'name' => esc_html__('WP Ultimate Review', 'metform'),
			'url'  => 'https://wordpress.org/plugins/wp-ultimate-review/',
			'icon' => 'https://ps.w.org/wp-ultimate-review/assets/icon-256x256.png?rev=2544187',
			'desc' => esc_html__('Collect and showcase reviews on your website to build brand credibility and social proof with the easiest solution.', 'metform'),
			'docs' => 'https://wpmet.com/doc/wp-ultimate-review/',
		],
		'wp-fundraising-donation/wp-fundraising.php' => [
			'name' => esc_html__('FundEngine', 'metform'),
			'url'  => 'https://wordpress.org/plugins/wp-fundraising-donation/',
			'icon' => 'https://ps.w.org/wp-fundraising-donation/assets/icon-256x256.png?rev=2544150',
			'desc' => esc_html__('Create fundraising, crowdfunding, and donation websites with PayPal and Stripe payment gateway integration.', 'metform'),
			'docs' => 'https://wpmet.com/doc/fundengine/',
		],
		'blocks-for-shopengine/shopengine-gutenberg-addon.php' => [
			'name' => esc_html__('Blocks for ShopEngine', 'metform'),
			'url'  => 'https://wordpress.org/plugins/blocks-for-shopengine/',
			'icon' => 'https://ps.w.org/blocks-for-shopengine/assets/icon-256x256.gif?rev=2702483',
			'desc' => esc_html__('All in one WooCommerce solution for Gutenberg! Build your WooCommerce pages in a block editor with full customization.', 'metform'),
			'docs' => 'https://wpmet.com/doc/shopengine/',
		],
		'genie-image-ai/genie-image-ai.php' => [
			'name' => esc_html__('Genie Image', 'metform'),
			'url'  => 'https://wordpress.org/plugins/genie-image-ai/',
			'icon' => 'https://ps.w.org/genie-image-ai/assets/icon-256x256.png?rev=2977297',
			'desc' => esc_html__('AI-powered text-to-image generator for WordPress with OpenAI’s DALL-E 2 technology to generate high-quality images in one click.', 'metform'),
			'docs' => 'https://getgenie.ai/docs/',
		],
	]
)
->call();

```

