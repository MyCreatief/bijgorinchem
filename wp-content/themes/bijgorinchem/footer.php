<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Seventeen
 * @since 1.0
 * @version 1.0
 */

?>
</div><!-- #content -->

<footer id="colophon" class="footer site-footer" role="contentinfo">

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-sm-6 footerleft ">
                <?php dynamic_sidebar('sidebar-bij3'); ?>

            </div>
            <div class="col-md-4 col-sm-6">
                <?php dynamic_sidebar('sidebar-bij4'); ?>
            </div>
<!--            <div class="col-md-2 col-sm-6">-->
<!---->
<!--                --><?php //dynamic_sidebar('sidebar-bij5'); ?>
<!--            </div>-->
            <div class="col-md-4 col-sm-6">
                <?php dynamic_sidebar('sidebar-bij6'); ?>
            </div>
        </div>
    </div>
    <!--footer start from here-->

    <div class="copyright">
        <div class="container">

            <?php
            get_template_part('template-parts/footer/site', 'info');
            ?>
        </div>
    </div>

</footer><!-- #colophon -->
</div><!-- .site-content-contain -->
</div><!-- #page -->
<?php wp_footer(); ?>

<a id="back-to-top" href="#" class="btn btn-primary btn-lg back-to-top" role="button" title="Click to return on the top page" data-toggle="tooltip" data-placement="left"><span class="fa fa-chevron-up"></span></a>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="<?php $path = get_home_path(); ?>node_modules/jquery/dist/jquery.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/bootstrap.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/bootstrap-sprockets.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/javascripts/custom.js"></script>
</body>
</html>
