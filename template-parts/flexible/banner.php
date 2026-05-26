<?php
if (! defined('ABSPATH')) exit;
?>

<section class="bg-brown text-white rounded-4xl py-20">
    <?php if (have_rows('items')) : ?>
        <div class="flex flex-wrap justify-center gap-y-6 gap-x-5 mx-auto max-w-[78.42%] text-[5.5rem] leading-[1.2] font-clash-display font-semibold tracking-[-1.2px]">
            <?php
            while (have_rows('items')) :
                the_row();
            ?>

                <?php if ('text' === get_row_layout()) : ?>
                    <?php $text = get_sub_field('text'); ?>

                    <?php if ($text) : ?>
                        <span><?php echo esc_html($text); ?></span>
                    <?php endif; ?>
                <?php endif; ?>

                <?php if ('image' === get_row_layout()) : ?>
                    <?php $image = get_sub_field('image'); ?>

                    <?php if ($image) : ?>
                        <?php
                        if (is_array($image) && ! empty($image['ID'])) {
                            echo wp_get_attachment_image(
                                $image['ID'],
                                'full',
                                false,
                                array(
                                    'class' => 'rounded-xl',
                                )
                            );
                        } elseif (is_numeric($image)) {
                            echo wp_get_attachment_image(
                                $image,
                                'full',
                                false,
                                array(
                                    'class' => 'rounded-xl',
                                )
                            );
                        } else {
                            $image_url = is_array($image) && ! empty($image['url']) ? $image['url'] : $image;
                        ?>
                            <img class="rounded-xl" src="<?php echo esc_url($image_url); ?>" alt="">
                        <?php
                        }
                        ?>
                    <?php endif; ?>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    <?php endif; ?>
</section>
