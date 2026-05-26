<?php
if (! defined('ABSPATH')) exit;

$footer_link = function_exists('get_field') ? get_field('link', 'option') : null;
$footer_image = function_exists('get_field') ? get_field('image', 'option') : null;
$footer_text = function_exists('get_field') ? get_field('text', 'option') : null;

$footer_link_url    = '';
$footer_link_title  = '';
$footer_link_target = '';

if (is_array($footer_link)) {
    $footer_link_url    = $footer_link['url'] ?? '';
    $footer_link_title  = $footer_link['title'] ?? '';
    $footer_link_target = $footer_link['target'] ?? '';
} elseif ($footer_link) {
    $footer_link_url = $footer_link;
}

$footer_link_label = $footer_link_title;
?>
<footer class="bg-black rounded-4xl p-10 mb-5 flex flex-col gap-y-20">
    <div>
        <?php if ($footer_image || $footer_link_label) : ?>
            <?php if ($footer_link_label) : ?>
                <?php if ($footer_link_url) : ?>
                    <a href="<?php echo esc_url($footer_link_url); ?>" <?php echo $footer_link_target ? ' target="' . esc_attr($footer_link_target) . '" rel="noopener noreferrer"' : ''; ?> class="flex items-center gap-x-10 w-full max-w-none text-[clamp(4rem,10.45vw,14rem)] font-medium leading-none tracking-normal text-white font-clash-display">
                        <?php echo esc_html($footer_link_label); ?>
    
                        <?php
                        if ($footer_image) {
                            if (is_array($footer_image) && ! empty($footer_image['ID'])) {
                                echo wp_get_attachment_image(
                                    $footer_image['ID'],
                                    'full',
                                    false,
                                    array(
                                        'alt' => '',
                                    )
                                );
                            } elseif (is_numeric($footer_image)) {
                                echo wp_get_attachment_image(
                                    $footer_image,
                                    'full',
                                    false,
                                    array(
                                        'alt' => '',
                                    )
                                );
                            } else {
                                $footer_image_url = is_array($footer_image) && ! empty($footer_image['url']) ? $footer_image['url'] : $footer_image;
                        ?>
                                <img src="<?php echo esc_url($footer_image_url); ?>" alt="">
                        <?php
                            }
                        }
                        ?>
                    </a>
                <?php else : ?>
                    <span class="block w-full max-w-none text-[clamp(4rem,10.45vw,14rem)] font-semibold leading-none tracking-normal"><?php echo esc_html($footer_link_label); ?></span>
                <?php endif; ?>
            <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="py-10 text-white flex gap-x-60">
        <p><?php echo esc_html($footer_text); ?></p>

        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'socials',
                'container'      => 'nav',
                'container_id'   => 'site-navigation',
                'container_aria_label' => 'socials navigation',
                'menu_class'     => 'flex flex-col gap-y-2.5',
                'fallback_cb'    => false,
                'depth'          => 1,
            )
        );
        ?>

        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer',
                'container'      => 'nav',
                'container_id'   => 'site-navigation',
                'container_aria_label' => 'footer navigation',
                'menu_class'     => 'flex flex-col gap-y-5',
                'fallback_cb'    => false,
                'depth'          => 1,
            )
        );
        ?>
    </div>
</footer>
</div>
<?php wp_footer(); ?>
</body>

</html>
