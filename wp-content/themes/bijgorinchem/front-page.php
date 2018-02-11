<?php
/**
 * The front page template file
 *
 * If the user has selected a static page for their homepage, this is what will
 * appear.
 * Learn more: https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

get_header(); ?>
<div class="col-xs-12 margin-b-xl">
    <div class="container" style="margin-top:30px;">
        <?php query_posts('cat=5');
        while (have_posts()) : the_post(); ?>
            <div class="col-xs-12 col-md-4">
                <div class="block">
                    <h3><?php the_title(); ?></h3>
                    <div>
                        <p><?php echo the_content(); ?></p>
                    </div>
                    <?php
                    if ($keys = get_post_custom_keys()) {

                        foreach ((array)$keys as $key) {

                            $keyt = trim($key);
                            if (is_protected_meta($keyt, 'post'))
                                continue;
                            $values = array_map('trim', get_post_custom_values($key));
                            $value = implode($values, ', ');
                            if ($key == 'link') { ?>
                                <a href="<?php echo apply_filters('the_meta_key', "$value", $key, $value); ?>" class="btn btn-primary">Bekijk</a>
                            <?php
                            } else if ($key == 'link_new'){?>
                                <a target="_blank" href="<?php echo apply_filters('the_meta_key', "$value", $key, $value); ?>" class="btn btn-primary">Bekijk</a>
                            <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
</div>


    <div class="col-xs-12 bg-blue">
        <div class="container">

            <div class="row margin-b-l">
<!--                <div class="page-header text-center col-xs-12">-->
<!--                    <h2>--><?php //echo get_cat_name(6); ?><!--</h2>-->
<!--                </div>-->
                <div class="col-xs-12">
                    <div class="row">

                        <?php query_posts('cat=6');
                        while (have_posts()) : the_post(); ?>
                        <div class="col-xs-12 col-md-4" style="padding-left: 50px;padding-right: 50px;">
                            <h3><?php the_title(); ?></h3>
                            <?php echo excerpt(40); ?>
                        </div>
                        <?php endwhile; ?>

                        <?php wp_reset_query(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="row">
            <div class="page-header text-center col-xs-6">
                <div class="page-header text-center col-xs-12 text-center">
                    <h2><?php echo get_cat_name(7); ?></h2>
                </div>
                <div class="col-xs-12 latest-news">
                    <div class="row">
                        <div class="block col-xs-12">
                            <?php query_posts('cat=7&posts_per_page=4');
                            while (have_posts()) : the_post(); ?>
                            <div class="row margin-b-xl">
                                <div class="col-xs-12 col-md-3">
                                    <a href="http://placehold.it"><?php the_post_thumbnail( 'category-thumb' ); ?></a>
                                </div>
                                <div class="col-xs-12 col-md-9">
                                    <h3><?php the_title(); ?></h3>
                                    <?php echo excerpt(20); ?>
                                </div>
                            </div>
                            <?php endwhile; ?>
                            <?php wp_reset_query(); ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-header text-center col-xs-6">
                <div class="page-header text-center col-xs-12 text-center">
                    <h2><?php echo get_cat_name(31); ?></h2>
                </div>
                <div class="col-xs-12 latest-news">
                    <div class="row">
                        <div class="block col-xs-12">
                            <?php query_posts('cat=31&posts_per_page=4');
                            while (have_posts()) : the_post(); ?>
                            <div class="row margin-b-xl">
                                <div class="col-xs-12 col-md-3">
                                    <a href="http://placehold.it"><?php the_post_thumbnail( 'category-thumb' ); ?></a>
                                </div>
                                <div class="col-xs-12 col-md-9">
                                    <h3><?php the_title(); ?></h3>
                                    <?php echo excerpt(20); ?>
                                </div>
                            </div>
                            <?php endwhile; ?>
                            <?php wp_reset_query(); ?>
                        </div>
                    </div>
                </div>
            </div>

<!--            <div class="page-header text-center col-xs-6">-->
<!--                <div class="page-header text-center col-xs-12 text-center">-->
<!--                    <h2>Aankomende cursusen</h2>-->
<!--                </div>-->
<!--                <div class="col-xs-12 latest-news">-->
<!--                    <div class="row">-->
<!--                        <div class="block col-xs-12">-->
<!--                            <ul class="list-unstyled">-->
<!--                                <li class="margin-b-l">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-xs-2">-->
<!--                                            1 aug-->
<!--                                        </div>-->
<!--                                        <div class="col-xs-10">-->
<!--                                            <h3>Bassis cursus</h3>-->
<!--                                            <div>-->
<!--                                                De cursus begint met een theoriegedeelte om inzicht te verwerven in het functioneren van een bijenvolk. Vanuit deze theoretische kennis kan het praktisch handelen doelgericht worden uitgevoerd. <br>-->
<!--                                                <a href="#" class="btn btn-primary pull-left">Schrijf je in</a>-->
<!--                                                <a href="#" class="btn btn-default pull-right">meer info</a>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li class="margin-b-l">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-xs-2">-->
<!--                                            1 aug-->
<!--                                        </div>-->
<!--                                        <div class="col-xs-10">-->
<!--                                            <h3>vervolgcursus</h3>-->
<!--                                            <div>Deze cursus voorziet in de behoefte tot handhaving en verbetering van de kwaliteit van de bijenhouderij in Nederland. Deze cursus geeft imkers inzicht in alle aspecten van het bijenhouden en de winning en verwerking van bijenproducten. <br>-->
<!--                                                <a href="#" class="btn btn-primary pull-left">Schrijf je in</a>-->
<!--                                                <a href="#" class="btn btn-default pull-right">meer info</a>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                                <li class="margin-b-l">-->
<!--                                    <div class="row">-->
<!--                                        <div class="col-xs-2">-->
<!--                                            1 aug-->
<!--                                        </div>-->
<!--                                        <div class="col-xs-10">-->
<!--                                            <h3>Jeugdcursus</h3>-->
<!--                                            <div>Er bestaat bij kinderen veel belangstelling voor de natuur. Aan die belangstelling kan de imker met zijn kennis van bloeiende planten en daarbij behorende insecten tegemoet komen.<br>-->
<!--                                                <a href="#" class="btn btn-primary pull-left">Schrijf je in</a>-->
<!--                                                <a href="#" class="btn btn-default pull-right">meer info</a>-->
<!--                                            </div>-->
<!--                                        </div>-->
<!--                                    </div>-->
<!--                                </li>-->
<!--                            </ul>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
<?php get_footer();
