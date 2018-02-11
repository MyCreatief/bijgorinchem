<?php
/**
 * Template for displaying search forms in Twenty Seventeen
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */
?>

<?php $unique_id = esc_attr( uniqid( 'search-form-' ) ); ?>

<div class="inner-addon right-addon enjoy-cssx">

    <form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
        <i class="fa fa-search "></i>
        <input type="text" placeholder="Zoeken" class="form-control enjoy-css" value="<?php echo get_search_query(); ?>" name="s" />
    </form>
</div>