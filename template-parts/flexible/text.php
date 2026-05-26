<?php
if ( ! defined( 'ABSPATH' ) ) exit;

$text = get_sub_field( 'text' );
?>

<?php if ( $text ) : ?>
    <div class="py-20">
        <p class="text-[2rem] leading-[1.2] tracking-[-1px] font-medium max-w-[68.35%] indent-[9rem]"><?php echo esc_html( $text ); ?></p>
    </div>
<?php endif; ?>
