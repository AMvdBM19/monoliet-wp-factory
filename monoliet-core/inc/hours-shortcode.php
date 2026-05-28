<?php
/**
 * Business Hours shortcode.
 *
 * Usage: [monoliet_hours]
 *
 * Reads hours from Site Settings ACF fields (hours_monday through hours_sunday).
 * Fields are registered in base-theme/inc/acf-fields.php under group_site_settings.
 *
 * @package MonolietCore
 */

/**
 * Render business hours table.
 */
function monoliet_hours_shortcode($atts) {
    if (!function_exists('monoliet_get_settings_page_id')) {
        return '';
    }

    $settings_id = monoliet_get_settings_page_id();
    if (!$settings_id || !function_exists('get_field')) {
        return '';
    }

    $days = array(
        'monday'    => __('Monday', 'monoliet-core'),
        'tuesday'   => __('Tuesday', 'monoliet-core'),
        'wednesday' => __('Wednesday', 'monoliet-core'),
        'thursday'  => __('Thursday', 'monoliet-core'),
        'friday'    => __('Friday', 'monoliet-core'),
        'saturday'  => __('Saturday', 'monoliet-core'),
        'sunday'    => __('Sunday', 'monoliet-core'),
    );

    $php_day_map = array(
        1 => 'monday',
        2 => 'tuesday',
        3 => 'wednesday',
        4 => 'thursday',
        5 => 'friday',
        6 => 'saturday',
        0 => 'sunday',
    );

    $today_key = $php_day_map[(int) date('w')];
    $has_hours = false;

    $rows = array();
    foreach ($days as $key => $label) {
        $value = get_field('hours_' . $key, $settings_id);
        if ($value) {
            $has_hours = true;
        }
        $rows[] = array(
            'key'   => $key,
            'label' => $label,
            'value' => $value ?: __('Closed', 'monoliet-core'),
        );
    }

    if (!$has_hours) {
        return '';
    }

    ob_start();
    ?>
    <table class="hours-table">
        <tbody>
            <?php foreach ($rows as $row) : ?>
                <tr class="<?php echo ($row['key'] === $today_key) ? 'is-today' : ''; ?>">
                    <td><?php echo esc_html($row['label']); ?></td>
                    <td><?php echo esc_html($row['value']); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php
    return ob_get_clean();
}
add_shortcode('monoliet_hours', 'monoliet_hours_shortcode');
