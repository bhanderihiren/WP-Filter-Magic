<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://profiles.wordpress.org/hirenbhanderi/
 * @since      1.0.0
 *
 * @package    Wp_Filter_Magic
 * @subpackage Wp_Filter_Magic/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Wp_Filter_Magic
 * @subpackage Wp_Filter_Magic/public
 * @author     Hiren Bhanderi <hirenbhanderi568@gmail.com>
 */
class Wp_Filter_Magic_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/wp-filter-magic-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/wp-filter-magic-public.js', array( 'jquery' ), $this->version, false );

	}
	public function  fn_wp_magic_filter_shortcode($attr) {

		$postTypes     = isset($attr['post-types']) ? $attr['post-types'] : 'post';
		$postPerPage   = isset($attr['post-per-page']) ? $attr['post-per-page'] : 12;
		$shortingOrder = isset($attr['shorting-order']) ? $attr['shorting-order'] : 'date'; 
		$order         = isset($attr['order']) ? $attr['order'] : 'ASC'; 
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;


		$ajax          = isset($attr['methode']) ? $attr['methode'] : 0; 
	    
		$pagination    = isset($attr['top']) ? $attr['top'] : 'Loadmore';
		
		$serchMethode  = isset($attr['serch_methode']) ? $attr['serch_methode'] : 0;
		
		$serch_value =  isset($_REQUEST['serch']) ? $_REQUEST['serch'] : '';

		$args = array(
			'post_type'      => $postTypes,
			'posts_per_page' => $postPerPage,
			'orderby'        => $shortingOrder,
			'order'          => $order,
			'paged'          => $paged,
			's'              => $serch_value
			
		);
	
		$query = new WP_Query($args);
		ob_start(); ?>
		<div class="main-container">
			<div class="filter-area">
				<form class="my-form" id="" method="post">
					<?php if($serchMethode == 1): ?>
						<div class="serch-form">
							<label for="serch-form">Serch By Title</label>
							<input type="text" name="serch" id="serch-form" value="<?php echo $serch_value; ?>">
						</div>
					<?php endif; ?>
				</form>
			</div>
			<?php if ( $query->have_posts() ) : ?> 
				<div class="main-<?php echo $postTypes; ?>" id="rend-<?php echo $postTypes; ?>">
					<?php while( $query->have_posts() ) : $query->the_post(); ?>
						<div>
							<?php echo get_the_title(); ?>
						</div>
					<?php endwhile; ?>
				</div>

				<?php $total = $query->max_num_pages; ?>
				<div class="pagination">
					<?php if( $pagination == "Loadmore" && $ajax == 1 ): ?>
						<button class="load-more"> <?php echo _e('Load More'); ?> </button>
					<?php elseif( $pagination == "Infinite-scroll" && $ajax == 1): ?>
						
					<?php else: ?>
						<?php $big = 999999999;
						$current_page = 1;
						if( get_option('permalink_structure') ) {
							$format = 'page/%#%/';
						} else {
							$format = '&paged=%#%';
						}
						$prev_arrow = is_rtl() ? '<span class="arrow-right"></span><span class="direction-text">Next</span>' : '<span class="arrow-left"></span><span class="direction-text">Prev</span>';
						$next_arrow = is_rtl() ? '<span class="arrow-left"></span><span class="direction-text">Prev</span>' : '<span class="arrow-right"></span><span class="direction-text">Next</span>';
						echo paginate_links(array(
							'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
							'format' => $format,
							'current' => max( 1, get_query_var('paged') ),
							'total' => $total,
							'mid_size' => 3,
							'type' => 'list',
							'prev_text' => $prev_arrow,
							'next_text' => $next_arrow,
						)); ?>	
						
					<?php endif; ?>
				</div>
			<?php else : ?>
				<p>No any <?php echo $postTypes; ?> found.</p>
			<?php endif; wp_reset_postdata(); ?>
		</div>
		<?php $shortcode = ob_get_clean();
		return $shortcode;
	}

	public function fn_wp_magic_filter_register_shortcodes(){
		add_shortcode( 'wpmagicfilter', array( $this, 'fn_wp_magic_filter_shortcode') );
	}

}
