<?php
function wp_nav_menu_my( $args = array() ) {
static $menu_id_slugs = array();

$defaults = array( 'menu' => '', 'container' => 'div', 'container_class' => '', 'container_id' => '', 'menu_class' => 'menu', 'menu_id' => '',
'echo' => true, 'fallback_cb' => 'wp_page_menu', 'before' => '', 'after' => '', 'link_before' => '', 'link_after' => '', 'items_wrap' => '<ul id="%1$s" class="nav navbar-nav">%3$s', 'item_spacing' => 'preserve',
'depth' => 0, 'walker' => '', 'theme_location' => '' );

$args = wp_parse_args( $args, $defaults );

if ( ! in_array( $args['item_spacing'], array( 'preserve', 'discard' ), true ) ) {
// invalid value, fall back to default.
$args['item_spacing'] = $defaults['item_spacing'];
}

/**
* Filters the arguments used to display a navigation menu.
*
* @since 3.0.0
*
* @see wp_nav_menu()
*
* @param array $args Array of wp_nav_menu() arguments.
*/
$args = apply_filters( 'wp_nav_menu_args', $args );
$args = (object) $args;

/**
* Filters whether to short-circuit the wp_nav_menu() output.
*
* Returning a non-null value to the filter will short-circuit
* wp_nav_menu(), echoing that value if $args->echo is true,
* returning that value otherwise.
*
* @since 3.9.0
*
* @see wp_nav_menu()
*
* @param string|null $output Nav menu output to short-circuit with. Default null.
* @param stdClass    $args   An object containing wp_nav_menu() arguments.
*/
$nav_menu = apply_filters( 'pre_wp_nav_menu', null, $args );

if ( null !== $nav_menu ) {
if ( $args->echo ) {
echo $nav_menu;
return;
}

return $nav_menu;
}

// Get the nav menu based on the requested menu
$menu = wp_get_nav_menu_object( $args->menu );

// Get the nav menu based on the theme_location
if ( ! $menu && $args->theme_location && ( $locations = get_nav_menu_locations() ) && isset( $locations[ $args->theme_location ] ) )
$menu = wp_get_nav_menu_object( $locations[ $args->theme_location ] );

// get the first menu that has items if we still can't find a menu
if ( ! $menu && !$args->theme_location ) {
$menus = wp_get_nav_menus();
foreach ( $menus as $menu_maybe ) {
if ( $menu_items = wp_get_nav_menu_items( $menu_maybe->term_id, array( 'update_post_term_cache' => false ) ) ) {
$menu = $menu_maybe;
break;
}
}
}

if ( empty( $args->menu ) ) {
$args->menu = $menu;
}

// If the menu exists, get its items.
if ( $menu && ! is_wp_error($menu) && !isset($menu_items) )
$menu_items = wp_get_nav_menu_items( $menu->term_id, array( 'update_post_term_cache' => false ) );

/*
* If no menu was found:
*  - Fall back (if one was specified), or bail.
*
* If no menu items were found:
*  - Fall back, but only if no theme location was specified.
*  - Otherwise, bail.
*/
if ( ( !$menu || is_wp_error($menu) || ( isset($menu_items) && empty($menu_items) && !$args->theme_location ) )
&& isset( $args->fallback_cb ) && $args->fallback_cb && is_callable( $args->fallback_cb ) )
return call_user_func( $args->fallback_cb, (array) $args );

if ( ! $menu || is_wp_error( $menu ) )
return false;

$nav_menu = $items = '';

$show_container = false;
if ( $args->container ) {
/**
* Filters the list of HTML tags that are valid for use as menu containers.
*
* @since 3.0.0
*
* @param array $tags The acceptable HTML tags for use as menu containers.
*                    Default is array containing 'div' and 'nav'.
*/
$allowed_tags = apply_filters( 'wp_nav_menu_container_allowedtags', array( 'div', 'nav' ) );
if ( is_string( $args->container ) && in_array( $args->container, $allowed_tags ) ) {
$show_container = true;
$class = $args->container_class ? ' class="' . esc_attr( $args->container_class ) . '"' : ' class="menu-'. $menu->slug .'-container"';
$id = $args->container_id ? ' id="' . esc_attr( $args->container_id ) . '"' : '';
$nav_menu .= '<'. $args->container . $id . $class . '>';
}
}

// Set up the $menu_item variables
_wp_menu_item_classes_by_context( $menu_items );

$sorted_menu_items = $menu_items_with_children = array();
foreach ( (array) $menu_items as $menu_item ) {
$sorted_menu_items[ $menu_item->menu_order ] = $menu_item;
if ( $menu_item->menu_item_parent )
$menu_items_with_children[ $menu_item->menu_item_parent ] = true;
}

// Add the menu-item-has-children class where applicable
if ( $menu_items_with_children ) {
foreach ( $sorted_menu_items as &$menu_item ) {
if ( isset( $menu_items_with_children[ $menu_item->ID ] ) )
$menu_item->classes[] = 'menu-item-has-children';
}
}

unset( $menu_items, $menu_item );

/**
* Filters the sorted list of menu item objects before generating the menu's HTML.
*
* @since 3.1.0
*
* @param array    $sorted_menu_items The menu items, sorted by each menu item's menu order.
* @param stdClass $args              An object containing wp_nav_menu() arguments.
*/
$sorted_menu_items = apply_filters( 'wp_nav_menu_objects', $sorted_menu_items, $args );

$items .= walk_nav_menu_tree( $sorted_menu_items, $args->depth, $args );
unset($sorted_menu_items);

// Attributes
if ( ! empty( $args->menu_id ) ) {
$wrap_id = $args->menu_id;
} else {
$wrap_id = 'menu-' . $menu->slug;
while ( in_array( $wrap_id, $menu_id_slugs ) ) {
if ( preg_match( '#-(\d+)$#', $wrap_id, $matches ) )
$wrap_id = preg_replace('#-(\d+)$#', '-' . ++$matches[1], $wrap_id );
else
$wrap_id = $wrap_id . '-1';
}
}
$menu_id_slugs[] = $wrap_id;

$wrap_class = $args->menu_class ? $args->menu_class : '';

/**
* Filters the HTML list content for navigation menus.
*
* @since 3.0.0
*
* @see wp_nav_menu()
*
* @param string   $items The HTML list content for the menu items.
* @param stdClass $args  An object containing wp_nav_menu() arguments.
*/
$items = apply_filters( 'wp_nav_menu_items', $items, $args );
/**
* Filters the HTML list content for a specific navigation menu.
*
* @since 3.0.0
*
* @see wp_nav_menu()
*
* @param string   $items The HTML list content for the menu items.
* @param stdClass $args  An object containing wp_nav_menu() arguments.
*/
$items = apply_filters( "wp_nav_menu_{$menu->slug}_items", $items, $args );

// Don't print any markup if there are no items at this point.
if ( empty( $items ) )
return false;

$nav_menu .= sprintf( $args->items_wrap, esc_attr( $wrap_id ), esc_attr( $wrap_class ), $items );
unset( $items );

if ( $show_container )
$nav_menu .= '</' . $args->container . '>';

/**
* Filters the HTML content for navigation menus.
*
* @since 3.0.0
*
* @see wp_nav_menu()
*
* @param string   $nav_menu The HTML content for the navigation menu.
* @param stdClass $args     An object containing wp_nav_menu() arguments.
*/
$nav_menu = apply_filters( 'wp_nav_menu', $nav_menu, $args );

if ( $args->echo )
echo $nav_menu;
else
return $nav_menu;
}

function get_search_form_my( $echo = true ) {
    /**
     * Fires before the search form is retrieved, at the start of get_search_form().
     *
     * @since 2.7.0 as 'get_search_form' action.
     * @since 3.6.0
     *
     * @link https://core.trac.wordpress.org/ticket/19321
     */
    do_action( 'pre_get_search_form' );

    $format = current_theme_supports( 'html5', 'search-form' ) ? 'html5' : 'xhtml';

    /**
     * Filters the HTML format of the search form.
     *
     * @since 3.6.0
     *
     * @param string $format The type of markup to use in the search form.
     *                       Accepts 'html5', 'xhtml'.
     */
    $format = apply_filters( 'search_form_format', $format );

    $search_form_template = locate_template( 'searchform.php' );
    if ( '' != $search_form_template ) {
        ob_start();
        require( $search_form_template );
        $form = ob_get_clean();
    } else {
        if ( 'html5' == $format ) {
            $form = '
            <form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/content-search.php' ) ) . '">
                <i class="fa fa-search "></i>
                <input type="text" placeholder="Zoeken" class="form-control enjoy-css" value="' . get_search_query() . '" name="sa"/>
			</form>
            ';
        } else {
            $form = '
            <form role="search" method="get" class="search-form" action="' . esc_url( home_url( '/content-search.php' ) ) . '">
                <i class="fa fa-search "></i>
                <input type="text" placeholder="Zoeken" class="form-control enjoy-css" value="' . get_search_query() . '" name="sb"/>
			</form>';
        }
    }

    /**
     * Filters the HTML output of the search form.
     *
     * @since 2.7.0
     *
     * @param string $form The search form HTML output.
     */
    $result = apply_filters( 'get_search_form', $form );

    if ( null === $result )
        $result = $form;

    if ( $echo )
        echo $result;
    else
        return $result;
}

// Replaces the excerpt "Read More" text by a link
// Replaces the excerpt "Read More" text by a link
function new_excerpt_more($more) {
    remove_filter( 'excerpt_more', 'twentyseventeen_excerpt_more' );
    global $post;
    return '... <div class="read-more"><a class="moretag btn btn-default" href="'. get_permalink($post->ID) . '"> Lees meer > </a></div>';
}
add_filter('excerpt_more', 'new_excerpt_more');



if ( ! function_exists( 'twentyseventeen_posted_on' ) ) :
    /**
     * Prints HTML with meta information for the current post-date/time and author.
     */
    function twentyseventeen_posted_on() {

// Get the author name; wrap it in a link.
        $byline = sprintf(
        /* translators: %s: post author */
            __( 'door: %s', 'twentyseventeen' ),
            '<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . get_the_author() . '</a></span>'
        );

// Finally, let's write all of this to the page.
        echo '<span class="posted-on">' . twentyseventeen_time_link() . '</span><span class="byline"> ' . $byline . '</span>';
    }
endif;


if ( ! function_exists( 'twentyseventeen_time_link' ) ) :
    /**
     * Gets a nicely formatted string for the published date.
     */
    function twentyseventeen_time_link() {
        $time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
        if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
            $time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time>';
        }

        $time_string = sprintf( $time_string,
            get_the_date( DATE_W3C ),
            get_the_date(),
            get_the_modified_date( DATE_W3C ),
            get_the_modified_date()
        );

// Wrap the time string in a link, and preface it with 'Posted on'.
        return sprintf(
        /* translators: %s: post date */
            __( '<span class="screen-reader-text">Aangemaakt op:</span> %s', 'twentyseventeen' ),
            '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
        );
    }
endif;

function remove_some_widgets(){

    // Unregister some of the TwentyTen sidebars
    unregister_sidebar( 'sidebar-1' );
    unregister_sidebar( 'sidebar-2' );
    unregister_sidebar( 'sidebar-3' );

}
add_action( 'widgets_init', 'remove_some_widgets', 11 );

function bijgorinchem_widgets_init() {

    register_sidebar( array(
        'name'          => __( 'Sidebar', 'bijgorinchem' ),
        'id'            => 'sidebar-bij',
        'description'   => __( 'Add widgets here to appear in your sidebar.', 'twentyseventeen' ),
        'before_widget' => '<section>',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer bottom info', 'bijgorinchem' ),
        'id'            => 'sidebar-bij2',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h4 class="widget-title">',
        'after_title'   => '</h4>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer contact', 'bijgorinchem' ),
        'id'            => 'sidebar-bij3',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer links', 'bijgorinchem' ),
        'id'            => 'sidebar-bij4',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer berichten', 'bijgorinchem' ),
        'id'            => 'sidebar-bij5',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );

    register_sidebar( array(
        'name'          => __( 'Footer social', 'bijgorinchem' ),
        'id'            => 'sidebar-bij6',
        'description'   => __( 'Add widgets here to appear in your footer.', 'twentyseventeen' ),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'bijgorinchem_widgets_init' );

add_image_size( 'twentyseventeen-featured-image', 2000, 1200, true );

function excerpt($limit) {
    $excerpt = explode(' ', get_the_excerpt(), $limit);
    if (count($excerpt)>=$limit) {
        array_pop($excerpt);
        $excerpt = implode(" ",$excerpt).'...';
    } else {
        $excerpt = implode(" ",$excerpt);
    }
    $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
    return $excerpt;
}

function content($limit) {
    $content = explode(' ', get_the_content(), $limit);
    if (count($content)>=$limit) {
        array_pop($content);
        $content = implode(" ",$content).'...';
    } else {
        $content = implode(" ",$content);
    }
    $content = preg_replace('/\[.+\]/','', $content);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    return $content;
}

add_filter('show_admin_bar', '__return_false');

add_theme_support( 'post-thumbnails' );
add_image_size( 'banner-img', 1900, 400, true );
add_image_size( 'gallerij', 195, 195, true );