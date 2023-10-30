<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/hirenbhanderi/
 * @since      1.0.0
 *
 * @package    Wp_Filter_Magic
 * @subpackage Wp_Filter_Magic/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Wp_Filter_Magic
 * @subpackage Wp_Filter_Magic/admin
 * @author     Hiren Bhanderi <hirenbhanderi568@gmail.com>
 */
class Wp_Filter_Magic_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Filter_Magic_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Filter_Magic_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-filter-magic-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Wp_Filter_Magic_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Wp_Filter_Magic_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-filter-magic-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function fn_wp_filter_magic_admin_menu() {
		add_menu_page(
			__( 'Create Shortcode', ' wp-filter-magic' ),
			'WP Filter Magic',
			'manage_options',
			'wp-filter-magic-create-shortcode',
			'fn_wp_filter_magic_admin_menu_form','dashicons-filter',
			6
		);
	}

	public static function fn_wp_filter_magic_post_types($allOptions = array() , $selectedValue = ""){
		ob_start(); 
			if(isset($allOptions) && !empty($allOptions)): ?>
				<option value=""><?php _e('Please select any value'); ?></option>
				<?php foreach($allOptions as $key => $allOption): ?>
					<option value="<?php _e($allOption); ?>" <?php echo ($selectedValue == $allOption) ? 'selected' : ''; ?> ><?php _e($allOption); ?></option>
				<?php endforeach;	
			endif;
		$videos = ob_get_clean();
		return $videos;
	}

}

function fn_wp_filter_magic_admin_menu_form(){
	require_once 'inc/fn_wp_filter_magic_admin_menu_form.php';
}