<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$heading = get_sub_field( 'heading' );
?>

<section class="text-center bg-beige-200 rounded-4xl py-20">
    <?php if ( $heading ) : ?>
        <h2 class="pb-20 font-inter-tight text-2xl font-semibold"><?php echo esc_html( $heading ); ?></h2>
    <?php endif; ?>

    <?php if ( have_rows( 'items' ) ) : ?>
        <ul>
            <?php
            while ( have_rows( 'items' ) ) :
                the_row();

                $item_heading = get_sub_field( 'heading' );
                ?>
                <?php if ( $item_heading ) : ?>
                    <li class="py-16 font-clash-display text-5xl font-medium tracking-[-2px] leading-[1.2] rounded-4xl text-[#00000066] hover:text-black hover:bg-white mx-5"><?php echo esc_html( $item_heading ); ?></h3></li>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    <?php endif; ?>
</section>
