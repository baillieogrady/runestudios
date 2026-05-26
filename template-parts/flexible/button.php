<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$link = get_sub_field( 'link' );

$link_url    = '';
$link_title  = '';
$link_target = '';

if ( is_array( $link ) ) {
    $link_url    = $link['url'] ?? '';
    $link_title  = $link['title'] ?? '';
    $link_target = $link['target'] ?? '';
} elseif ( $link ) {
    $link_url   = $link;
    $link_title = $link;
}
?>

<?php if ( $link_url ) : ?>
    <section class="bg-black text-white text-center rounded-4xl">
        <h2 class="text-[4rem] tracking-[-2px] leading-[1.2]">
            <a class="py-28 block" href="<?php echo esc_url( $link_url ); ?>"<?php echo $link_target ? ' target="' . esc_attr( $link_target ) . '" rel="noopener noreferrer"' : ''; ?>>
                <?php echo esc_html( $link_title ); ?>
            </a>
        </h2>
    </section>
<?php endif; ?>
