<?php
if ( ! defined( 'ABSPATH' ) ) exit;
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    <div class="mx-5 flex flex-col gap-y-5">
    <header class="flex min-h-[60px] items-center justify-between px-5 py-2.5 font-medium">
        <a class="inline-flex shrink-0 items-center gap-2.5" href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
            <?php
            $logo = function_exists( 'get_field' ) ? get_field( 'logo', 'option' ) : null;

            if ( is_array( $logo ) && ! empty( $logo['ID'] ) ) {
                echo wp_get_attachment_image(
                    $logo['ID'],
                    'full',
                    false,
                    array(
                        'alt' => get_bloginfo( 'name' ),
                        'class' => 'block h-auto w-auto max-h-5 max-w-[140px]',
                    )
                );
            } elseif ( is_numeric( $logo ) ) {
                echo wp_get_attachment_image(
                    $logo,
                    'full',
                    false,
                    array(
                        'alt' => get_bloginfo( 'name' ),
                        'class' => 'block h-auto w-auto max-h-5 max-w-[140px]',
                    )
                );
            } elseif ( $logo ) {
                $logo_url = is_array( $logo ) && ! empty( $logo['url'] ) ? $logo['url'] : $logo;
                ?>
                <img class="block h-auto w-auto max-h-5 max-w-[140px]" src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                <?php
            } else {
                ?>
                <span aria-hidden="true" class="inline-block h-5 w-[51px] rounded-full border-4 border-black"></span>
                <?php
            }
            ?>
            <span class="text-[20px] leading-[1] font-semibold uppercase"><?php bloginfo( 'name' ); ?></span>
        </a>

        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'header',
                'container'      => 'nav',
                'container_id'   => 'site-navigation',
                'container_aria_label' => 'Primary navigation',
                'menu_class'     => 'm-0 flex list-none items-center gap-5 p-0 text-[20px] leading-[1] font-medium',
                'fallback_cb'    => false,
                'depth'          => 1,
            )
        );
        ?>
    </header>
