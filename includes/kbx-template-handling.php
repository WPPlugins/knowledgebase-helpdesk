<?php

/**
 * Replace the archive temlate for the knowledgebase. Functions archive_template.
 *
 * @param  string $template Default Archive Template location.
 * @return string Modified Archive Template location
 */

function kbx_load_archive_template( $template ) {

	$template_name = '';

	if ( is_post_type_archive( 'kbx_knowledgebase' ) ) 
	{
		$template_name = 'archive-kbx_knowledgebase.php';
	}

	if ( is_tax( 'kbx_tag' ) ) 
	{
		$template_name = 'archive-kbx_knowledgebase.php';
	}

	if ( is_search() && isset($_GET['kbx-query']) && $_GET['kbx-query'] != "") 
	{
		$template_name = 'search-kbx_knowledgebase.php';
	}

	if ( is_tax( 'kbx_category' ) && ! is_search() ) 
	{
		$template_name = 'taxonomy-kbx_category.php';
	}

	if ( '' !== $template_name && '' === locate_template( array( $template_name ) ) ) 
	{
		$template = KBX_DIR . '/views/general/' . $template_name;
	}

	return $template;

}

add_filter( 'template_include', 'kbx_load_archive_template' );


/**
 * For knowledgebase search results, set posts_per_page 10.
 *
 * @since 1.1.0
 *
 * @param  object $query The search query object.
 * @return object $query Updated search query object
 */
function wzkb_posts_per_search_page( $query ) {

	if ( ! is_admin() && is_search() && isset( $query->query_vars['post_type'] ) && $query->query_vars['post_type'] === 'wz_knowledgebase' ) {
		$query->query_vars['posts_per_page'] = 10;
	}

	return $query;
}
add_filter( 'pre_get_posts', 'wzkb_posts_per_search_page' );