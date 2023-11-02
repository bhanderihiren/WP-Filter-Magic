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
		wp_localize_script( $this->plugin_name, 'my_ajax_object', array('ajax_url' => admin_url('admin-ajax.php')));	
	}

	public function  fn_wp_magic_filter_shortcode($attr) {

		$postTypes     = isset($attr['post-types']) ? $attr['post-types'] : 'post';
		$postPerPage   = (int) isset($attr['post-per-page']) ? $attr['post-per-page'] : 12;
		$shortingOrder = isset($attr['shorting-order']) ? $attr['shorting-order'] : 'date'; 
		$order         = isset($attr['order']) ? $attr['order'] : 'ASC'; 
		$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;


		$ajax          = isset($attr['method']) ? $attr['method'] : 0; 
	    
		$pagination    = isset($attr['top']) ? $attr['top'] : 'Loadmore';
		
		$serchMethode  = isset($attr['serch_methode']) ? $attr['serch_methode'] : 0;
		
		$serch_value =  isset($_REQUEST['serch']) ? $_REQUEST['serch'] : '';

		$taxonomy    =  isset($attr['taxonomy']) ? $attr['taxonomy'] : '';

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
		<div class="main-container ">
			<div class="filter-area">
				<form class="my-form" id="" method="post">
					<?php if( $serchMethode == 1 ): ?>
						<div class="serch-form">
							<label for="serch-form">Serch By Title</label>
							<input type="text" name="serch" id="serch-form" value="<?php echo $serch_value; ?>">
						</div>
					<?php endif; ?>
					<?php if( $taxonomy != "" ): 
						$taxonomies = explode(", ", $taxonomy);
						if(!empty($taxonomies)): 
							foreach( $taxonomies as $taxonomy ): 
								$taxonomydetail = get_taxonomy( $taxonomy ); ?>
								<h5><?php echo _e($taxonomydetail->label); ?></h5>
								<?php $this->fn_wp_magic_filter_taxonomy( $taxonomy, "single");
							endforeach;
						endif; ?>
					<?php endif; ?>
				</form>
			</div>
			<?php if ( $query->have_posts() ) : ?> 
				<div class="main-magic-filter main-<?php echo $postTypes; ?>" id="rend-<?php echo $postTypes; ?>">
					<?php while( $query->have_posts() ) : $query->the_post(); ?>
						<div>
							<?php echo get_the_title(); ?>
						</div>
					<?php endwhile; ?>
				</div>
				<?php $total = $query->max_num_pages; ?>
				<?php if($ajax == 1 && $total > $postPerPage): ?>
					<div class="loader-gift-image" style="display: none;">
						<img src="<?php echo plugin_dir_url(__FILE__).'/image/giphy.gif'; ?>" class="loader-gift-image-mgfi" id="loader-gift-image-mgfi"/>
					</div>
				<?php endif; ?>
				
				<div class="pagination">
					<?php if( $pagination == "Loadmore" && $ajax == 1 ): ?>
						<form name="load-more-form" class="load-more-form" id="load-more-form">
							<input type="hidden" name="paged" id="paged" value="2">
							<input type="hidden" name="post-types" id="post-types" value="<?php echo $postTypes; ?>">
							<input type="hidden" name="postPerPage" id="postPerPage" value="<?php echo $postPerPage; ?>">
							<input type="hidden" name="shortingOrder" id="shortingOrder" value="<?php echo $shortingOrder; ?>">
							<input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
							<input type="hidden" name="action" value="load_more_form_filter">
						</form>	
						<button class="load-more" style=" <?php echo ($total > $postPerPage) ? '' : 'display:none;'; ?>"> <?php echo _e('Load More'); ?> </button>
					<?php elseif( $pagination == "Infinite-scroll" && $ajax == 1): ?>
						<input type="hidden" name="total_page" id="total_page" value="<?php echo $total; ?>">
						<form name="infinity-form" class="infinity-form" id="infinity-form">
							<input type="hidden" name="paged" id="paged" value="2">
							<input type="hidden" name="post-types" id="post-types" value="<?php echo $postTypes; ?>">
							<input type="hidden" name="postPerPage" id="postPerPage" value="<?php echo $postPerPage; ?>">
							<input type="hidden" name="shortingOrder" id="shortingOrder" value="<?php echo $shortingOrder; ?>">
							<input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
							<input type="hidden" name="action" value="load_more_form_filter">
						</form>	
					<?php else: ?>
						<form name="load-more-form" class="load-more-form" id="load-more-form">
							<input type="hidden" name="post-types" id="post-types" value="<?php echo $postTypes; ?>">
							<input type="hidden" name="postPerPage" id="postPerPage" value="<?php echo $postPerPage; ?>">
							<input type="hidden" name="shortingOrder" id="shortingOrder" value="<?php echo $shortingOrder; ?>">
							<input type="hidden" name="order" id="order" value="<?php echo $order; ?>">
							<input type="hidden" name="action" value="load_more_form_filter">
						</form>	
						<div class="paginate <?php echo ($ajax == 1)?'ajax':''; ?>" id="paginate">
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
						</div>
					<?php endif; ?>
				</div>
			<?php else : ?>
				<p>No any <?php echo $postTypes; ?> found.</p>
			<?php endif; wp_reset_postdata(); ?>
		</div>
		<?php $shortcode = ob_get_clean();
		return $shortcode;
	}

	public function  fn_wp_magic_filter_taxonomy($taxonomy , $type){

		$terms = get_terms( array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => false,
		) );
		if(isset($terms) && !empty($terms)):
			$type = ($type == "single") ? "radio" : "checkbox";
			foreach($terms as $key => $term):
				echo $this->fn_wp_magic_filter_element($term->term_id, $taxonomy, $term->name , $type);
			endforeach; 
		endif; 
	}

	public function fn_wp_magic_filter_element( $id, $name ,$text, $type){ 
		ob_start(); ?>
			<div class="sub_taxonomy">
				<label for="related_<?php echo $id; ?>"><?php echo $text; ?></label>
				<input type="<?php echo $type; ?>" class="taxonomy" name="<?php echo $name; ?>" id="related_<?php echo $id; ?>" value="<?php echo $id; ?>">
			</div>
		<?php 
		$element = ob_get_clean();
		return $element;
	}

	public function fn_wp_magic_filter_register_shortcodes(){
		add_shortcode( 'wpmagicfilter', array( $this, 'fn_wp_magic_filter_shortcode') );
	}


	public function fn_wp_magic_filter_load_more_form_filter(){
		$postTypes     = isset($_POST['post-types']) ? $_POST['post-types'] : 'post';
		$postPerPage   = isset($_POST['postPerPage']) ? $_POST['postPerPage'] : 12;
		$shortingOrder = isset($_POST['shortingOrder']) ? $_POST['shortingOrder'] : 'date'; 
		$order         = isset($_POST['order']) ? $_POST['order'] : 'ASC'; 
		$paged         = isset($_POST['paged']) ? $_POST['paged'] : 1;
		$serch_value =  isset($_POST['serch']) ? $_POST['serch'] : '';
		$ajax_by     =  isset($_POST['ajax_by']) ? $_POST['ajax_by'] : '';
		$args = array(
			'post_type'      => $postTypes,
			'posts_per_page' => $postPerPage,
			'orderby'        => $shortingOrder,
			'order'          => $order,
			'paged'          => $paged,
			's'              => $serch_value
			
		);
		
		ob_start();
		
		$query = new WP_Query($args);

		if ( $query->have_posts() ) : ?>
			<?php while( $query->have_posts() ) : $query->the_post(); ?>
				<div>
					<?php echo get_the_title(); ?>
				</div>
			<?php endwhile; ?>
		<?php else : ?>
			<p>No any <?php echo $postTypes; ?> found.</p>
		<?php endif; wp_reset_postdata();

		$element = ob_get_clean();

		if($ajax_by == 'page-numbers'){
			ob_start();

			$pagination = ob_get_clean();
			if( get_option('permalink_structure') ) {
				$format = 'page/%#%/';
			} else {
				$format = '&paged=%#%';
			}
			$total = $query->max_num_pages;
			$prev_arrow = is_rtl() ? '<span class="arrow-right"></span><span class="direction-text">Next</span>' : '<span class="arrow-left"></span><span class="direction-text">Prev</span>';
			$next_arrow = is_rtl() ? '<span class="arrow-left"></span><span class="direction-text">Prev</span>' : '<span class="arrow-right"></span><span class="direction-text">Next</span>';
			$big = 999999999;

			echo paginate_links(array(
				'base' => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
				'format' => $format,
				'current' => max( 1, $paged),
				'total' => $total,
				'mid_size' => 3,
				'type' => 'list',
				'prev_text' => $prev_arrow,
				'next_text' => $next_arrow,
			)); 
			$paginate = ob_get_clean();

			echo json_encode( array( 'status' => 1, "data" => $element, "paginate" => $paginate ) ); exit();
		} elseif ($ajax_by == 'infinity') {
			$paged++;
			if($total < $page){
				$loadmore = 0;
			}
			echo json_encode( array( 'status' => 1, "data" => $element , "loadmore" => $loadmore, "page" => $paged ) ); exit();
		} else { 
			$page = ++$paged;
			$total = $query->max_num_pages;

			if($total < $page){
				$loadmore = 0;
			}
			echo json_encode( array( 'status' => 1, "data" => $element , "loadmore" => $loadmore, "page" => $page ) ); exit();
			
		}
	}

}
