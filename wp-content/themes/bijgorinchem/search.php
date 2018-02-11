<?php
/**
 * The template for displaying search results pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#search-result
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>


    <!-- Begin page content -->
    <div class="container search-page">
        <div class="col-xs-12">
            <?php
            if ( have_posts() ) :
                /* Start the Loop */
                while ( have_posts() ) : the_post();

                    /**
                     * Run the loop for the search to output the results.
                     * If you want to overload this in a child theme then include a file
                     * called content-search.php and that will be used instead.
                     */
                    get_template_part( 'template-parts/post/content-search', 'excerpt' );

                endwhile; // End of the loop.

                the_posts_pagination( array(
                    'prev_text' => twentyseventeen_get_svg( array( 'icon' => 'arrow-left' ) ) . '<span class="screen-reader-text">' . __( 'Previous page', 'twentyseventeen' ) . '</span>',
                    'next_text' => '<span class="screen-reader-text">' . __( 'Next page', 'twentyseventeen' ) . '</span>' . twentyseventeen_get_svg( array( 'icon' => 'arrow-right' ) ),
                    'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentyseventeen' ) . ' </span>',
                ) );

            else : ?>
                <?php
                echo'<div class="search-container">';
                get_search_form();
                echo'</div>';?>
                <p><?php _e( 'Sorry, maar niets voldoen aan je zoektermen. Probeer het opnieuw met een aantal verschillende zoekwoorden.', 'twentyseventeen' ); ?></p>
            <?php

            endif;
            ?>
        </div>

    </div>





<?php get_footer();
