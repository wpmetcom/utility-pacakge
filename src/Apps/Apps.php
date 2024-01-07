<?php

namespace Wpmet\UtilityPackage\Apps;

defined( 'ABSPATH' ) || exit;

/**
 * Description: Wpmet Apps class. This class is used to display the wpmet other plugins
 * 
 * @package Apps
 * @author Wpmet
 * 
 * @since 1.0.0
 */
class Apps
{

	private static $instance;
	private $text_domain;
	private $parent_menu_slug;
	private $menu_slug = '_wpmet_apps';
	private $submenu_name = 'Apps';
	private $plugins = [];
	protected $script_version = '1.0.0';

	/**
	 * Get version of this script
	 *
	 * @return string Version name
	 * 
	 * @since 1.0.0
	 */
	public function get_version() {

		return $this->script_version;
	}

	/**
	 * Creates and returns an instance of the class.
	 *
	 * @return self
	 * 
	 * @since 1.0.0
	 */
	public static function instance() {
		
		if ( !self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}
	
	/**
	 * Initializes the function.
	 *
	 * @param string $text_domain The text domain.
	 * @return $this
	 * 
	 * @since 1.0.0
	 */
	public function init( $text_domain ) {
		
		$this->set_text_domain( $text_domain );
		
		add_action('admin_head', [$this, 'enqueue_scripts']);

		return $this;
	}
	
	/**
	 * Enqueues scripts for the plugin.
	 *
	 * This function is responsible for enqueueing the necessary JavaScript scripts for the plugin.
	 *
	 * @return void
	 * 
	 * @since 1.0.0
	 */
	public static function enqueue_scripts() {
		?>
		<script type="text/javascript">
			jQuery( document ).ready( function( $ ) {
				$(document).on('click', '.wpmet_apps_action_button', function(event){
					
					let $button = $(this);
					let action_url = $button.data('action_url');
					let plugin_status = $button.data('plugin_status');
					// let activation_url = $button.data('activation_url');
					// let installation_url = $button.data('installation_url');
	
					if(plugin_status === 'status-missing' || plugin_status === 'status-installed'){
						
						$.ajax({
							type : "GET",
							url : action_url,
							beforeSend: () => {
								plugin_status === 'status-missing' ? $button.text('Installing...') : $button.text('Activating...');
							},
							success: (response) => {

								if(plugin_status === 'status-missing'){
									$button.text('Activate Now');
								}else{
									$button.text('Activated')
								}
								location.reload();
							}
						});
					}
				});
			} );
		</script>
		<?php
	}

	/**
	 * Set the text domain for the object.
	 *
	 * @param mixed $val The value to set as the text domain.
	 * @return $this The current object instance.
	 * 
	 * @since 1.0.0
	 */
	protected function set_text_domain( $val ) {

		$this->text_domain = $val;

		return $this;
	}

	/**
	 * Sets the submenu name.
	 *
	 * @param string $submenu_name The name of the submenu.
	 * @return $this The current instance of the class.
	 * 
	 * @since 1.0.0
	 */
	public function set_submenu_name( $submenu_name ){

		$this->submenu_name = $submenu_name;
		
		return $this;
	}

	/**
	 * Set the parent menu slug.
	 *
	 * @param string $slug The slug of the parent menu.
	 * @return $this The current object.
	 */
	public function set_parent_menu_slug( $slug ) {

		$this->parent_menu_slug = $slug;

		return $this;
	}

	/**
	 * Sets the menu slug for the object.
	 *
	 * @param string $slug The slug to set for the menu.
	 * @return $this Returns the current object.
	 * 
	 * @since 1.0.0
	 */
	public function set_menu_slug( $slug ) {

		$this->menu_slug = $slug;

		return $this;
	}

	/**
	 * Set the plugins for the object.
	 *
	 * @param array $plugins An array of plugins.
	 * @return $this The current instance.
	 * 
	 * @since 1.0.0
	 */
	public function set_plugins( $plugins = [] ) {
		
		$this->plugins = $plugins;

		return $this;
	}

	/**
	 * Retrieves the plugin slug from a given name.
	 *
	 * @param string $name The name of the plugin.
	 * @return string|null The plugin slug if found, otherwise null.
	 * 
	 * @since 1.0.0
	 */
	public function get_plugin_slug( $name ) {

		$split = explode( '/', $name );

		return isset( $split[0] ) ? $split[0] : null;
	}

	/**
	 * Generates an installation URL for a given plugin name.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @return string The installation URL for the plugin.
	 * 
	 * @since 1.0.0
	 */
	public function installation_url( $plugin_name ) {
		$action     = 'install-plugin';
		$plugin_slug = $this->get_plugin_slug( $plugin_name );

		return wp_nonce_url(
			add_query_arg(
				array(
					'action' => $action,
					'plugin' => $plugin_slug
				),
				admin_url( 'update.php' )
			),
			$action . '_' . $plugin_slug
		);
	}

	/**
	 * Generates the activation URL for a plugin.
	 *
	 * @param string $plugin_name The name of the plugin.
	 * @return string The activation URL for the plugin.
	 * 
	 * @since 1.0.0
	 */
	public function activation_url( $plugin_name ) {

		return wp_nonce_url( add_query_arg(
			array(
				'action'        => 'activate',
				'plugin'        => $plugin_name,
				'plugin_status' => 'all',
				'paged'         => '1&s',
			),
			admin_url( 'plugins.php' )
		), 'activate-plugin_' . $plugin_name );
	}

	/**
	 * Registers a menu in the WordPress admin dashboard.
	 *
	 * @return void
	 * 
	 * @since 1.0.0
	 */
	protected function register_menu() {

		add_submenu_page( 
			$this->parent_menu_slug, 
			$this->submenu_name, 
			$this->submenu_name, 
			'manage_options', 
			$this->text_domain . $this->menu_slug, 
			[$this, 'wpmet_apps_renderer'] 
		);
	}

	/**
	 * Generates the menus.
	 *
	 * @return void
	 * 
	 * @since 1.0.0
	 */
	public function generate_menus() {
		
		if( !empty($this->parent_menu_slug) ) {

			$this->register_menu();
		}
	}

	/**
	 * Admin menu registration hook.
	 *
	 * @return void
	 * 
	 * @since 1.0.0
	 */
	public function call() {
		
		add_action('admin_menu', [$this, 'generate_menus'], 99999);
	}

	/**
	 * Display the Wpmet apps section.
	 * 
	 * @return void
	 *
	 * @since 1.0.0
	 */
	public function wpmet_apps_renderer() {

		$all_plugins = get_plugins();
		$wpmet_plugins = $this->get_wpmet_plugins();
		$can_install_plugins  = current_user_can( 'install_plugins' );
		$can_activate_plugins = current_user_can( 'activate_plugins' );			
		?>

		<div class="wpmet-apps-wrapper">
			<div class="wpmet-apps">
				<?php
				foreach ( $wpmet_plugins as $plugin => $details ) :

					$plugin_data = $this->get_plugin_data( $plugin, $details, $all_plugins );
					$plugin_ready_to_activate = $can_activate_plugins && isset( $plugin_data['status_class'] ) && $plugin_data['status_class'] === 'status-installed';
					$plugin_not_activated = ! isset( $plugin_data['status_class'] ) || $plugin_data['status_class'] !== 'status-active';
					$plugin_actvate = isset( $plugin_data['status_class'] ) && $plugin_data['status_class'] === 'status-active';
					$image_url = isset( $plugin_data['icon'] ) ? $plugin_data['icon'] : '#';
					$action_url = '#';						

					if( $plugin_ready_to_activate ){
						$action_url = $this->activation_url( $plugin );
					}elseif( $plugin_not_activated ) {
						$action_url = $this->installation_url( $plugin );
					}
					
					?>
					<div class="attr-col-lg-4" style="padding: 20px; background: white; display: inline-block;">
						<div class="mf-onboard-single-plugin">
							<div>
								<img width="100" class="mf-onboard-single-plugin--logo" src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr(isset( $plugin_data['name']) ? $plugin_data['name'] : '' ); ?>" title="<?php echo esc_attr( isset($plugin_data['name']) ? $plugin_data['name'] : '' ); ?>">
								<p class="mf-onboard-single-plugin--description"><?php echo esc_html(isset($plugin_data['desc']) ? $plugin_data['desc'] : ''); ?></p>
								<button <?php echo esc_attr($plugin_actvate ? 'disabled' : '' ); ?> data-installation_url="<?php echo esc_url( $this->installation_url( $plugin ) ); ?>" data-activation_url="<?php echo esc_url( $this->activation_url( $plugin ) ); ?>" data-plugin_status="<?php echo esc_attr( isset($plugin_data['status_class']) ? $plugin_data['status_class'] : '' ); ?>" data-action_url="<?php echo esc_url( $action_url ); ?>" class="button button-primary wpmet_apps_action_button"><?php echo esc_html( isset( $plugin_data['action_text'] ) ? $plugin_data['action_text'] : "Learn More" ); ?></button>
							</div>
						</div>
					</div>
					
				<?php endforeach; ?>
			</div>
		</div>
		<?php
	}

	/**
	 * Retrieves the list of WP Met plugins for installation.
	 *
	 * This function returns the list of WP Met plugins for installation by applying the 'wpmet_plugins_for_install'
	 * filter to the `$this->plugins` array.
	 *
	 * @return array The list of WP Met plugins for installation.
	 * 
	 * @since 1.0.0
	 */
	protected function get_wpmet_plugins() {

		return apply_filters( 'wpmet_plugins_for_install', $this->plugins );
	}

	/**
	 * Get wpmet plugins details data.
	 *
	 * @param string $plugin Plugin slug.
	 * @param array  $details Plugin details.
	 * @param array  $all_plugins List of all plugins.
	 *
	 * @return array Plugins data.
	 * 
	 * @since 1.0.0
	 */
	protected function get_plugin_data( $plugin, $details, $all_plugins ) {

		$plugin_data = [];

		// Check if the plugin is installed.
		if ( array_key_exists( $plugin, $all_plugins ) ) {
			
			// Check if the plugin is active.
			if ( is_plugin_active( $plugin ) ) {
				
				$plugin_data['status_class'] = 'status-active';
				$plugin_data['status_text']  = esc_html__( 'Active', 'wpforms-lite' );
				$plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-secondary disabled';
				$plugin_data['action_text']  = esc_html__( 'Activated', 'wpforms-lite' );
				$plugin_data['plugin_src']   = esc_attr( $plugin );

			} else {

				// Plugin is not active.
				$plugin_data['status_class'] = 'status-installed';
				$plugin_data['status_text']  = esc_html__( 'Inactive', 'wpforms-lite' );
				$plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-secondary';
				$plugin_data['action_text']  = esc_html__( 'Activate Now', 'wpforms-lite' );
				$plugin_data['plugin_src']   = esc_attr( $plugin );

			}
		} else {

			// Plugin is not installed.
			$plugin_data['status_class'] = 'status-missing';
			$plugin_data['status_text'] = esc_html__( 'Not Installed', 'wpforms-lite' );
			$plugin_data['action_class'] = $plugin_data['status_class'] . ' button button-primary';
			$plugin_data['action_text']  = esc_html__( 'Install Now', 'wpforms-lite' );

		}

		$plugin_data = array_merge( $plugin_data, $details );

		return $plugin_data;
	}
}