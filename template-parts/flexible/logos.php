<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$items = get_sub_field( 'items' );
?>

<?php if ( $items ) : ?>
    <section class="p-20">
        <ul class="flex justify-between flex-wrap gap-x-20 gap-y-10">
            <?php foreach ( $items as $item ) : ?>
                <li class="my-2.5">
                    <?php
                    if ( is_array( $item ) && ! empty( $item['ID'] ) ) {
                        echo wp_get_attachment_image(
                            $item['ID'],
                            'full',
                            false,
                            array(
                                'class' => 'max-w-38',
                            )
                        );
                    } elseif ( is_numeric( $item ) ) {
                        echo wp_get_attachment_image(
                            $item,
                            'full',
                            false,
                            array(
                                'class' => 'max-w-38',
                            )
                        );
                    } else {
                        $item_url = is_array( $item ) && ! empty( $item['url'] ) ? $item['url'] : $item;
                        ?>
                        <img class="max-w-38" src="<?php echo esc_url( $item_url ); ?>" alt="">
                        <?php
                    }
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>
