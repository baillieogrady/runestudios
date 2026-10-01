<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$heading = get_sub_field( 'heading' );
$text    = get_sub_field( 'text' );
?>

<?php if ( $heading || $text ) : ?>
    <section class="flex flex-col items-center rounded-4xl bg-[#fafafa] px-5 py-12 text-center lg:py-20">
        <?php if ( $heading ) : ?>
            <h2 class="mb-8 text-2xl leading-[1.2] font-medium uppercase">
                <?php echo esc_html( $heading ); ?>
            </h2>
        <?php endif; ?>

        <?php if ( $text ) : ?>
            <p class="max-w-full text-[1.5rem] leading-[1.2] tracking-[-0.6px] font-medium lg:max-w-[68%] lg:text-[3rem] lg:tracking-[-1.2px]">
                <?php echo esc_html( $text ); ?>
            </p>
        <?php endif; ?>
    </section>
<?php endif; ?>
