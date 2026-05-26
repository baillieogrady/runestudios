<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>

<?php if ( have_rows( 'items' ) ) : ?>
    <div class="py-1.5">
        <ul class="flex gap-x-2.5 text-lg leading-[1.2] font-medium overflow-x-scroll">
            <?php
            while ( have_rows( 'items' ) ) :
                the_row();

                $text = get_sub_field( 'text' );
                ?>
                <?php if ( $text ) : ?>
                    <li class="py-5 px-6 text-nowrap"><?php echo esc_html( $text ); ?></li>
                <?php endif; ?>
            <?php endwhile; ?>
        </ul>
    </div>
<?php endif; ?>
