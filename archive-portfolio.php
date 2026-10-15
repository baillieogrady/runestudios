<?php
if ( ! defined( 'ABSPATH' ) ) exit;

get_header();

$archive_title = post_type_archive_title( '', false );
?>

<main class="flex flex-col gap-y-10 lg:gap-y-5">
    <section class="flex flex-col gap-y-10">
        <h1 class="font-clash-display text-[clamp(4rem,13.2vw,14rem)] leading-none font-semibold uppercase">
            <?php echo esc_html( $archive_title ); ?>
        </h1>

        <?php if ( have_posts() ) : ?>
            <ul class="m-0 grid list-none grid-cols-1 gap-x-5 gap-y-10 p-0 lg:grid-cols-2">
                <?php while ( have_posts() ) : the_post(); ?>
                    <li>
                        <article>
                            <a href="<?php the_permalink(); ?>" class="group flex flex-col gap-5">
                                <?php if ( has_post_thumbnail() ) : ?>
                                    <?php
                                    echo get_the_post_thumbnail(
                                        get_the_ID(),
                                        'large',
                                        array(
                                            'class'    => 'block aspect-374/482 w-full rounded-4xl object-cover lg:aspect-square',
                                            'loading'  => 'lazy',
                                            'decoding' => 'async',
                                        )
                                    );
                                    ?>
                                <?php endif; ?>

                                <h2 class="flex items-center justify-between text-[2rem] leading-[1.2] tracking-[-1px]">
                                    <span><?php echo esc_html( get_the_title() ); ?></span>
                                    <span aria-hidden="true" class="flex h-15 w-15 items-center justify-center rounded-full bg-[#0000000D] transition-colors group-hover:bg-black">
                                        <svg class="max-w-6 group-hover:[&_path]:stroke-white" width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M0 8.8H24M24 8.8C20.9748 8.8 14.9244 7.04 14.9244 0M24 8.8C20.9748 8.8 14.9244 10.56 14.9244 17.6" stroke="black" stroke-width="4" />
                                        </svg>
                                    </span>
                                </h2>
                            </a>
                        </article>
                    </li>
                <?php endwhile; ?>
            </ul>

            <?php
            the_posts_pagination(
                array(
                    'mid_size'           => 1,
                    'prev_text'          => esc_html__( 'Previous', 'runestudios' ),
                    'next_text'          => esc_html__( 'Next', 'runestudios' ),
                    'screen_reader_text' => esc_html__( 'Portfolio navigation', 'runestudios' ),
                )
            );
            ?>
        <?php else : ?>
            <p><?php esc_html_e( 'No portfolio projects found.', 'runestudios' ); ?></p>
        <?php endif; ?>
    </section>
</main>

<?php get_footer(); ?>
