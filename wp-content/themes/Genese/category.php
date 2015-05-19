<?php
	function category_exists( $cat_name, $parent = null ) {
	        $id = term_exists($cat_name, 'category', $parent);
	        if ( is_array($id) )
	                $id = $id['term_id'];
	        return $id;
	}
	function get_category_to_edit( $id ) {
	        $category = get_term( $id, 'category', OBJECT, 'edit' );
	        _make_cat_compat( $category );
	        return $category;
	}


	function wp_create_category( $cat_name, $parent = 0 ) {
      if ( $id = category_exists($cat_name, $parent) )
                return $id;
	
	        return wp_insert_category( array('cat_name' => $cat_name, 'category_parent' => $parent) );
}
function wp_create_categories( $categories, $post_id = '' ) {
	        $cat_ids = array ();
	        foreach ( $categories as $category ) {
	                if ( $id = category_exists( $category ) ) {
	                        $cat_ids[] = $id;
	                } elseif ( $id = wp_create_category( $category ) ) {
	                        $cat_ids[] = $id;
	                }
	        }
	
	        if ( $post_id )
	                wp_set_post_categories($post_id, $cat_ids);
	
	        return $cat_ids;
	}

?>