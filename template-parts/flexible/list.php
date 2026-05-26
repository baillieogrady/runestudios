<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$heading = get_sub_field( 'heading' );
?>

<section class="text-center bg-beige-200 rounded-4xl">
    <?php if ( $heading ) : ?>
        <h2 class="py-20 font-inter-tight text-2xl"><?php echo esc_html( $heading ); ?></h2>
    <?php endif; ?>

    <?php if ( have_rows( 'items' ) ) : ?>
        <ul>
            <?php
            while ( have_rows( 'items' ) ) :
                the_row();

                $item_heading = get_sub_field( 'heading' );
                ?>
                <?php if ( $item_heading ) : ?>
                    <li><h3><?php echo esc_html( $item_heading ); ?></h3></li>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
</section>
