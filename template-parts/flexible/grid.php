<?php
if (! defined('ABSPATH')) exit;

$items = get_sub_field('items');

if ($items && ! is_array($items)) {
    $items = array($items);
}

$items = $items ? array_slice($items, 0, 6) : array();
?>

<?php if ($items) : ?>
    <section>
        <ul class="grid grid-cols-2 gap-x-5 gap-y-10">
            <?php foreach ($items as $item) : ?>
                <?php
                $post_id = is_object($item) ? $item->ID : $item;

                if (! $post_id) {
                    continue;
                }
                ?>
                <li class="col-span-1">
                    <article>
                        <a href="<?php echo esc_url(get_permalink($post_id)); ?>" class="flex flex-col gap-5">
                            <?php if (has_post_thumbnail($post_id)) : ?>
                                <?php echo get_the_post_thumbnail($post_id, 'large',     array(
                                    'class' => 'rounded-4xl',   
                                )); ?>
                            <?php endif; ?>

                            <h2 class="flex items-center justify-between text-[2rem] leading-[1.2] tracking-[-1px]">
                                <span>
                                    <?php echo esc_html(get_the_title($post_id)); ?>
                                </span>
                                <span class="bg-[#0000000D] h-15 w-15 rounded-full flex items-center justify-center">
                                    <svg class="max-w-6" width="24" height="18" viewBox="0 0 24 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M0 8.8H24M24 8.8C20.9748 8.8 14.9244 7.04 14.9244 0M24 8.8C20.9748 8.8 14.9244 10.56 14.9244 17.6" stroke="black" stroke-width="4" />
                                    </svg>
                                </span>
                            </h2>
                        </a>
                    </article>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
<?php endif; ?>