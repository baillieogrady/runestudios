<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();
?>

<main class="flex flex-col gap-y-5">
    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <?php if ( has_post_thumbnail() ) : ?>
                <figure class="mx-5">
                    <?php
                    echo wp_get_attachment_image(
                        get_post_thumbnail_id(),
                        'full',
                        false,
                        array(
                            'class'         => 'block w-full rounded-4xl aspect-[16/9] object-cover',
                            'loading'       => 'eager',
                            'decoding'      => 'async',
                            'fetchpriority' => 'high',
                        )
                    );
                    ?>
                </figure>
            <?php endif; ?>

            <section class="flex flex-col items-center rounded-4xl bg-beige-200 px-5 py-12 text-center lg:py-20">
                <h1 class="mb-6 font-clash-display text-[2.5rem] leading-[1.1] font-semibold uppercase lg:mb-7 lg:text-[4rem]">
                    <?php echo esc_html( get_the_title() ); ?>
                </h1>

                <?php $excerpt = get_the_excerpt(); ?>
                <?php if ( $excerpt ) : ?>
                    <p class="max-w-full text-base leading-[1.2] font-medium lg:max-w-[47%] lg:text-xl">
                        <?php echo esc_html( wp_strip_all_tags( $excerpt ) ); ?>
                    </p>
                <?php endif; ?>
            </section>

            <?php if ( function_exists( 'have_rows' ) && have_rows( 'blocks' ) ) : ?>
                <?php while ( have_rows( 'blocks' ) ) : the_row(); ?>
                    <?php get_template_part( 'template-parts/flexible/' . get_row_layout() ); ?>
                <?php endwhile; ?>
            <?php elseif ( get_the_content() ) : ?>
                <?php the_content(); ?>
            <?php endif; ?>
        <?php endwhile; ?>
    <?php endif; ?>
</main>

<?php get_footer(); ?>
