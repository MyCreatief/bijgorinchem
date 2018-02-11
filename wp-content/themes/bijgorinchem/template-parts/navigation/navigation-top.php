<?php
/**
 * Displays top navigation
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
<nav class="navbar navbar-default navbar-fixed-top">
    <div class="quick-contact">
        <div class="container">
            <a href="mailto:info@bijgorinchem.nl" title="Mail us"><i class="fas fa-envelope" aria-hidden="true"></i> info@bijgorinchem.nl</a>
            <a href="tel:+18444233533" title="Give us a call"><i class="fas fa-mobile-alt" aria-hidden="true"></i> 06 123456789</a>  &nbsp; &nbsp;
        </div>
    </div>

    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">BIJGorinchem</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
            <a class="home-link" href="/wordpress/">home</a>
            <?php wp_nav_menu_my( array(
                'theme_location' => 'top',
                'menu_id'        => 'top-menu',
            ) ); ?>

            <div class="search-container pull-right">
                <?php get_search_form_my() ?>
            </div>
        </div><!--/.nav-collapse -->
    </div>
</nav>