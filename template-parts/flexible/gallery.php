<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$images = get_sub_field( 'images' );

if ( ! is_array( $images ) ) {
    $images = $images ? array( $images ) : array();
}

$images = array_filter( $images );
?>

<?php if ( $images ) : ?>
    <section aria-label="Image gallery">
        <ul class="m-0 grid list-none grid-cols-1 gap-5 p-0 lg:grid-cols-2">
            <?php foreach ( $images as $image ) : ?>
                <?php
                $image_id = is_array( $image ) && ! empty( $image['ID'] )
                    ? absint( $image['ID'] )
                    : ( is_numeric( $image ) ? absint( $image ) : 0 );
                ?>
                <li>
                    <?php if ( $image_id ) : ?>
                        <?php
                        echo wp_get_attachment_image(
                            $image_id,
                            'large',
                            false,
                            array(
                                'class'    => 'block aspect-[690/680] w-full rounded-4xl object-cover',
                                'loading'  => 'lazy',
                                'decoding' => 'async',
                            )
                        );
                        ?>
                    <?php else : ?>
                        <?php
                        $image_url = is_array( $image ) && ! empty( $image['url'] )
                            ? $image['url']
                            : ( is_string( $image ) ? $image : '' );
                        $image_alt = is_array( $image ) && ! empty( $image['alt'] ) ? $image['alt'] : '';
                        ?>
                        <?php if ( $image_url ) : ?>
                            <img
                                class="block aspect-[690/680] w-full rounded-4xl object-cover"
                                src="<?php echo esc_url( $image_url ); ?>"
                                alt="<?php echo esc_attr( $image_alt ); ?>"
                                loading="lazy"
                                decoding="async"
                            >
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
