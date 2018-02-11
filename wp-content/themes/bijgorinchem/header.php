<?php
/**
 * The header for our theme
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js no-svg">
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="../../favicon.ico">
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js" async></script>
    <script>
        FontAwesomeConfig = { searchPseudoElements: true };
    </script>
<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php if ( has_nav_menu( 'top' ) ) : ?>
    <?php get_template_part( 'template-parts/navigation/navigation', 'top' ); ?>
<?php endif; ?>

<div class="banner col-xs-12"  style="background-image: url(<?php if ( has_post_thumbnail() ) { the_post_thumbnail_url( 'banner-img' ); } else { ?> http://www.bijgorinchem.nl/wordpress/wp-content/uploads/2017/04/honeysweet-1900x400.jpg<?php } ?>)"></div>
<?php
if ( ! is_front_page() ) {
?>
    <div class="breadcrumb-container col-xs-12">
        <div class="container">
            <ul class="breadcrumb">
                <?php if ( function_exists('yoast_breadcrumb') ) {
                    yoast_breadcrumb('<li>','</li>');
                } ?>
            </ul>
        </div>
</div>
<?php
}
?>
<!--<div class="container quick-tools">-->
<!--    <div class="row">-->
<!--        <div class="col-xs-3 quick-block">-->
<!--            <a href="help/do_you_have_a_swarm.php"><img src="https://www.bbka.org.uk/files/cta_7.jpg"></a>-->
<!--        </div>-->
<!--        <div class="col-xs-3 quick-block">-->
<!--            <a href="help/do_you_have_a_swarm.php"><img src="https://www.bbka.org.uk/files/cta_7.jpg"></a>-->
<!--        </div>-->
<!--        <div class="col-xs-3 quick-block">-->
<!--            <a href="help/do_you_have_a_swarm.php"><img src="https://www.bbka.org.uk/files/cta_7.jpg"></a>-->
<!--        </div>-->
<!--        <div class="col-xs-3 quick-block">-->
<!--            <a href="help/do_you_have_a_swarm.php"><img src="https://www.bbka.org.uk/files/cta_7.jpg"></a>-->
<!--        </div>-->
<!--    </div>-->
<!--</div>-->