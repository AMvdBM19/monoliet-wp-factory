<?php
/**
 * Template part: Social Proof Bar.
 *
 * @package MonolietStarter
 */

$score  = get_field('proof_rating_score');
$source = get_field('proof_rating_source');

if (!$score) {
    return;
}

$metrics = array();
for ($i = 1; $i <= 3; $i++) {
    $val   = get_field("proof_metric_{$i}_value");
    $label = get_field("proof_metric_{$i}_label");
    if ($val && $label) {
        $metrics[] = array('value' => $val, 'label' => $label);
    }
}
?>

<section id="section-social-proof" class="proof-bar">
    <div class="container">
        <div class="proof-bar__inner">
            <div class="proof-bar__rating">
                <span class="proof-bar__score"><?php echo esc_html($score); ?></span>
                <div>
                    <div class="stars">
                        <?php
                        $full_stars = min(5, floor(floatval($score) / 2));
                        for ($i = 1; $i <= 5; $i++) :
                        ?>
                            <svg class="stars__icon <?php echo $i > $full_stars ? 'stars__icon--empty' : ''; ?>" viewBox="0 0 20 20" aria-hidden="true"><path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/></svg>
                        <?php endfor; ?>
                    </div>
                    <?php if ($source) : ?>
                        <span class="proof-bar__source"><?php echo esc_html($source); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <?php foreach ($metrics as $metric) : ?>
                <div class="proof-bar__divider" aria-hidden="true"></div>
                <div class="proof-bar__metric">
                    <div class="proof-bar__metric-value"><?php echo esc_html($metric['value']); ?></div>
                    <div class="proof-bar__metric-label"><?php echo esc_html($metric['label']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
