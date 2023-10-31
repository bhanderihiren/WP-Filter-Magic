<?php 

function post_type_taxonomy_list_detailes($postType){
    $taxonomies = get_object_taxonomies($postType);
    
    ob_start();
        if(!empty($taxonomies)){
            foreach( $taxonomies as $taxonomy ){
                $taxonomydetail = get_taxonomy( $taxonomy ); ?>
                <div class="taxonomy">
                    <label for="<?php echo $taxonomy; ?>"><?php echo $taxonomydetail->label; ?></label>
                    <input type="checkbox" class="taxonomy-tag" name="taxonomy[]" id="<?php echo $taxonomy; ?>" value="<?php echo $taxonomy; ?>">
                </div>
            <?php }
        } else{ ?>
            <p><?php echo _e('There are no assigned taxonomies to this post.'); ?></p>
        <?php }
    $taxonomy_list = ob_get_clean();
    return $taxonomy_list;
}


?>