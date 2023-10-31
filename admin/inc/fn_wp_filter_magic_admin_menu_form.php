<main class="wp-filter-magic" id="wp-filter-magic">
    <h1><?php _e( 'WP Filter Magic' ); ?></h1>
    <div class="wp-filter-magic-form">
        <form method="post">

            <div class="field-group">
                <label for="post-types">Post Type</label>
                <?php $post_types = get_post_types(array('publicly_queryable' => true));  asort($post_types); 
                      $selected = "post";
                ?>
                <select name="post-types" id="post-types" class="post-types">
                    <?php echo Wp_Filter_Magic_Admin::fn_wp_filter_magic_post_types($post_types, $selected) ?>
                </select>
            </div>

            <div class="field-group">
                <label for="post-per-page">Post per page</label>
                <input type="number" name="post-per-page" class="post-per-page" id="post-per-page" min="1" value="12">
            </div>

            <div class="field-group">
                <p>Select Methode</p>
                <div class="sub-field">
                    <label for="whiout-ajax">Whiout Ajax</label>
                    <input type="radio" name="methode" class="whiout-ajax" id="whiout-ajax" value="0" checked>
                </div>
                <div class="sub-field">
                    <label for="whiout-ajax">with Ajax</label>
                    <input type="radio" name="methode" class="whiout-ajax" id="whiout-ajax" value="1">
                </div>
            </div>

            <div class="field-group" id="select-categories" style="display:none">
                <p>Select Categories</p>
                <div class="categories-list">

                </div>
            </div>

            <div class="field-group">
                <lable for="shorting-order">Order by</lable>
                <?php $order_by = array('date', 'title', 'author', 'rand', 'meta_value', 'menu_order'); 
                      $selected2 = "date";
                ?>
                <select name="shorting-order" id="shorting-order" class="shorting-order">
                <?php echo Wp_Filter_Magic_Admin::fn_wp_filter_magic_post_types($order_by, $selected2) ?>
                </select>
            </div> 
            
            <div class="field-group">
                <p>Order</p>
                <div class="sub-field">
                    <label for="whiout-ajax">Ascending</label>
                    <input type="radio" name="order" class="whiout-ajax" id="whiout-ajax" value="ASc" checked>
                </div>
                <div class="sub-field">
                    <label for="whiout-ajax">Descending</label>
                    <input type="radio" name="order" class="whiout-ajax" id="whiout-ajax" value="DESC">
                </div>
            </div>

            <div class="field-group">
                <lable for="top">Type of pagination</lable>
                <?php $top = array('Infinite-scroll', 'Pagination', 'Loadmore'); 
                      $selected3 = "Loadmore";
                ?>
                <select name="top" id="top" class="top"> 
                <?php echo Wp_Filter_Magic_Admin::fn_wp_filter_magic_post_types($top, $selected3); ?>
                </select>
            </div>

            <div class="field-group">
                <p>Serch Option</p>
                <div class="sub-field">
                    <label for="whiout-serch">Whiout Serch</label>
                    <input type="radio" name="serch_methode" class="whiout-serch" id="whiout-ajax" value="1" checked>
                </div>
                <div class="sub-field">
                    <label for="with-serch">With Serch</label>
                    <input type="radio" name="serch_methode" class="with-serch" id="with-ajax" value="0">
                </div>
            </div>

            <input type="submit" value="submit" name="sumit">
        </form>
    </div>
    <?php if(isset($_POST['sumit']) && !empty($_POST['sumit'])){
        unset($_POST['sumit']);
        $shortcode = "[wpmagicfilter ";
        foreach( $_POST as $key => $value ){
            
            if( is_array( $value ) ){
                $value = implode( ", ", $value );
            }

            if(isset($value) && !empty($value)){
                $shortcode .=  $key."='".$value."' ";
            }
        }
        $shortcode .= " ]";

        echo $shortcode;
    } ?>
</main>