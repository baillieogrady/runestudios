<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$heading = get_sub_field( 'heading' );
$image   = get_sub_field( 'image' );
?>

<section>
    <?php if ( $heading ) : ?>
        <h1 class="w-full max-w-none text-[clamp(4rem,13.2vw,14rem)] font-semibold leading-none tracking-normal mb-5"><?php echo esc_html( $heading ); ?></h1>
    <?php endif; ?>

    <?php if ( $image ) : ?>
        <figure>
            <?php
            if ( is_array( $image ) && ! empty( $image['ID'] ) ) {
                echo wp_get_attachment_image(
                    $image['ID'],
                    'full',
                    false,
                    array(
                        'class'    => 'rounded-4xl w-full',
                        'loading'  => 'eager',
                        'decoding' => 'async',
                    )
                );
            } elseif ( is_numeric( $image ) ) {
                echo wp_get_attachment_image(
                    $image,
                    'full',
                    false,
                    array(
                        'class'    => 'rounded-4xl w-full',
                        'loading'  => 'eager',
                        'decoding' => 'async',
                    )
                );
            } else {
                $image_url = is_array( $image ) && ! empty( $image['url'] ) ? $image['url'] : $image;
                ?>
                <img src="<?php echo esc_url( $image_url ); ?>" alt="">
                <?php
            }
            ?>
        </figure>
    <?php endif; ?>
</section>
