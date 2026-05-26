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
    <header class="flex items-center justify-between pt-5 font-medium">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" aria-label="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
            <?php
            $logo = function_exists( 'get_field' ) ? get_field( 'logo', 'option' ) : null;

            if ( is_array( $logo ) && ! empty( $logo['ID'] ) ) {
                echo wp_get_attachment_image(
                    $logo['ID'],
                    'full',
                    false,
                    array(
                        'alt' => get_bloginfo( 'name' ),
                    )
                );
            } elseif ( is_numeric( $logo ) ) {
                echo wp_get_attachment_image(
                    $logo,
                    'full',
                    false,
                    array(
                        'alt' => get_bloginfo( 'name' ),
                    )
                );
            } elseif ( $logo ) {
                $logo_url = is_array( $logo ) && ! empty( $logo['url'] ) ? $logo['url'] : $logo;
                ?>
                <img src="<?php echo esc_url( $logo_url ); ?>" alt="<?php echo esc_attr( get_bloginfo( 'name' ) ); ?>">
                <?php
            } else {
                bloginfo( 'name' );
            }
            ?>
        </a>

        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'header',
                'container'      => 'nav',
                'container_id'   => 'site-navigation',
                'container_aria_label' => 'Header navigation',
                'menu_class'     => 'flex items-center gap-6',
                'fallback_cb'    => false,
                'depth'          => 1,
            )
        );
        ?>
    </header>
