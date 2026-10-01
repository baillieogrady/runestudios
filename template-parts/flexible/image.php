<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$image = get_sub_field( 'image' );

if ( ! $image ) {
    return;
}

$image_id = is_array( $image ) && ! empty( $image['ID'] )
    ? absint( $image['ID'] )
    : ( is_numeric( $image ) ? absint( $image ) : 0 );
?>

<figure class="mx-5">
    <?php if ( $image_id ) : ?>
        <?php
        echo wp_get_attachment_image(
            $image_id,
            'full',
            false,
            array(
                'class'    => 'block w-full rounded-4xl',
                'loading'  => 'lazy',
                'decoding' => 'async',
            )
        );
        ?>
    <?php else : ?>
        <?php
        $image_url = is_array( $image ) && ! empty( $image['url'] ) ? $image['url'] : '';
        $image_alt = is_array( $image ) && ! empty( $image['alt'] ) ? $image['alt'] : '';
        ?>
        <?php if ( $image_url ) : ?>
            <img
                class="block w-full rounded-4xl"
                src="<?php echo esc_url( $image_url ); ?>"
                alt="<?php echo esc_attr( $image_alt ); ?>"
                loading="lazy"
                decoding="async"
            >
        <?php endif; ?>
    <?php endif; ?>
</figure>
