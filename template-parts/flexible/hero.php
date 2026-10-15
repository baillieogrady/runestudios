<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$heading = get_sub_field( 'heading' );
$image   = get_sub_field( 'image' );
?>

<section>
    <?php if ( $heading ) : ?>
        <h1 class="w-full max-w-none text-[clamp(4rem,13.2vw,14rem)] font-semibold leading-none tracking-normal mb-12.5 lg:mb-5 [&_span]:block [&_span]:lg:inline-block text-center"><?php echo $heading; ?></h1>
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
                        'class'    => 'rounded-4xl w-full object-cover aspect-374/862 lg:aspect-1400/860',
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
                        'class'    => 'rounded-4xl w-full object-cover aspect-374/862 lg:aspect-1400/860',
                        'loading'  => 'eager',
                        'decoding' => 'async',
                    )
                );
            } else {
                $image_url = is_array( $image ) && ! empty( $image['url'] ) ? $image['url'] : $image;
                $image_alt = is_array( $image ) && isset( $image['alt'] ) ? $image['alt'] : '';

                if ( '' === $image_alt ) {
                    $attachment_id = attachment_url_to_postid( $image_url );
                    $image_alt     = $attachment_id ? get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) : '';
                }
                ?>
                <img src="<?php echo esc_url( $image_url ); ?>" alt="<?php echo esc_attr( $image_alt ); ?>" class="object-cover aspect-374/862 lg:aspect-1400/860">
                <?php
            }
            ?>
        </figure>
    <?php endif; ?>
</section>
