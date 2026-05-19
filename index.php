<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

// Include the header
get_header(); ?>

<main class="flex flex-col gap-y-5">
    <?php
    if ( have_posts() ) :
        while ( have_posts() ) : the_post();
            if ( function_exists( 'have_rows' ) && have_rows( 'blocks' ) ) :
                while ( have_rows( 'blocks' ) ) : the_row();
                    get_template_part( 'template-parts/flexible/' . get_row_layout() );
                endwhile;
            else :
                the_content();
            endif;
        endwhile;
    else :
        echo '<p>No content found</p>';
    endif;
    ?>

</main>

<?php
// Include the footer
get_footer();
