<?php if( !defined('WPINC') ) die;

/**
 * Leyka functions and template tags, irrelevant to a donation form.
 **/

if( !function_exists('mb_substr') ) {
    function mb_substr($str, $start, $length = null) {
        return substr($str, $start, $length);
    }
}

if( !function_exists('mb_ucfirst') ) {
    function mb_ucfirst($str) {
        return mb_strtoupper(mb_substr($str, 0, 1)).mb_substr($str, 1);
    }
}

if( !function_exists('mb_lcfirst') ) {
    function mb_lcfirst($str) {
        return mb_strtolower(mb_substr($str, 0, 1)).mb_substr($str, 1);
    }
}

if( !function_exists('mb_strtolower') ) {
    function mb_strtolower($str) {
        return strtolower($str);
    }
}

if( !function_exists('mb_strtoupper') ) {
    function mb_strtoupper($str) {
        return strtoupper($str);
    }
}

if( !function_exists('array_key_first') ) {
    function array_key_first(array $array) {

        foreach($array as $key => $unused) {
            return $key;
        }
        return NULL;

    }
}

if( !function_exists('array_key_last') ) {
    function array_key_last(array $array) {
        return $array ? key(array_slice($array, -1)) : null;
    }
}

if ( ! function_exists( 'leyka_safe_style_css' ) ) {
    function leyka_safe_style_css( $styles ){
        $styles[] = 'display';
        return $styles;
    }
    add_filter( 'safe_style_css', 'leyka_safe_style_css' );
}

if ( ! function_exists( 'leyka_kses_allowed_html' ) ) {
    /**
     * Filters the HTML that is allowed for a given context.
     *
     * @param array  $tags    Tags by.
     * @param string $context Context name.
     */
    function leyka_kses_allowed_html( $tags, $context ) {

        if ( 'content' === $context ) {
            $tags = array(
                'h2' => array(
                    'id'     => true,
                    'class'  => true,
                    'data-*' => true,
                    'style'  => true,
                ),
                'h3' => array(
                    'id'     => true,
                    'class'  => true,
                    'data-*' => true,
                    'style'  => true,
                ),
                'div' => array(
                    'id'     => true,
                    'class'  => true,
                    'data-*' => true,
                    'style'  => true,
                ),
                'span' => array(
                    'id'    => true,
                    'class' => true,
                    'style' => true,
                    'data-*' => true,
                ),
                'b'      => array(),
                'strong' => array(),
                'p' => array(
                    'id'    => true,
                    'style' => true,
                    'data-*' => true,
                ),
                'br' => array(),
                'a' => array(
                    'id'     => true,
                    'href'   => true,
                    'target' => true,
                    'class'  => true,
                    'data-*' => true,
                    'style'  => true,
                ),
                'img' => array(
                    'id'    => true,
                    'src'   => true,
                    'class' => true,
                    'alt'   => true,
                    'style' => true,
                    'data-*' => true,
                ),
                'button' => array(
                    'id'     => true,
                    'class'  => true,
                    'type'   => true,
                    'title'  => true,
                    'data-*' => true,
                    'style'  => true,
                ),
                'label' => array(
                    'id'    => true,
                    'class' => true,
                    'for'   => true,
                    'style' => true,
                    'data-*' => true,
                ),
                'select' => array(
                    'id'     => true,
                    'class'  => true,
                    'name'   => true,
                    'data-*' => true,
                ),
                'input' => array(
                    'id'          => true,
                    'class'       => true,
                    'type'        => true,
                    'name'        => true,
                    'value'       => true,
                    'placeholder' => true,
                    'data-*'      => true,
                    'maxlength'   => true,
                    'inputmode'   => true,
                    'style'       => true,
                    'readonly'    => true,
                ),
                'textarea' => array(
                    'id'          => true,
                    'name'        => true,
                    'class'       => true,
                    'type'        => true,
                    'value'       => true,
                    'placeholder' => true,
                    'data-*'      => true,
                    'rows'        => true,
                    'cols'        => true,
                    'style'       => true,
                ),
                'option' => array(
                    'value'    => true,
                    'requred'  => true,
                    'selected' => true,
                    'style'    => true,
                    'data-*'   => true,
                ),
                'ul' => array(
                    'class'  => true,
                    'data-*' => true,
                ),
                'li' => array(
                    'class'  => true,
                    'data-*' => true,
                ),
                'table' => array(
                    'class' => true,
                ),
                'tbody' => array(),
                'tr'    => array(),
                'th'    => array(
                    'class' => true,
                ),
                'td'    => array(
                    'class' => true,
                ),
                'iframe' => array(
                    'id'     => true,
                    'width'  => true,
                    'height' => true,
                    'src'    => true,
                    'data-*' => true,
                ),
                'svg'   => array(
                    'class'           => true,
                    'aria-hidden'     => true,
                    'aria-labelledby' => true,
                    'role'            => true,
                    'xmlns'           => true,
                    'width'           => true,
                    'height'          => true,
                    'viewbox'         => true,
                    'fill'            => true,
                    'id'              => true,
                    'style'           => true,
                ),
                'g'     => array(
                    'id'           => true,
                    'fill'         => true,
                    'full-rule'    => true,
                    'stroke'       => true,
                    'stroke-width' => true,
                    'transform'    => true,
                    'style'        => true,
                ),
                'path'  => array(
                    'id'              => true,
                    'd'               => true,
                    'fill'            => true,
                    'fill-rule'       => true,
                    'fill-opacity'    => true,
                    'stroke'          => true,
                    'stroke-width'    => true,
                    'stroke-linecap'  => true,
                    'stroke-linejoin' => true,
                    'clip-rule'       => true,
                    'opacity'         => true,
                    'transform'       => true,
                ),
                'rect' => array(
                    'id'           => true,
                    'width'        => true,
                    'height'       => true,
                    'fill'         => true,
                    'fill-opacity' => true,
                    'rx'           => true,
                    'transform'    => true,
                ),
                'circle' => array(
                    'cx'      => true,
                    'cy'      => true,
                    'r'       => true,
                    'opacity' => true,
                ),
                'polygon' => array(
                    'points' => true,
                ),
                'defs' => array(),
                'clipPath' => array(
                    'id' => true,
                ),
            );
        }

        return $tags;
    }
    add_filter( 'wp_kses_allowed_html', 'leyka_kses_allowed_html', 10, 2 );
}

if( !function_exists('leyka_strip_string_by_words') ) {
    function leyka_strip_string_by_words($string, $length = 350, $strip_tags_shortcodes = true) {

        if( !!$strip_tags_shortcodes ) {
            $string = wp_strip_all_tags(strip_shortcodes($string));
        }

        if(mb_strlen($string) <= $length || stripos($string, ' ') === false) {
            return $string;
        }

        $characters_count = 0;
        $result_string = [];
        foreach(explode(' ', $string) as $word) {

            $characters_count += mb_strlen($word);
            if($characters_count <= $length) {
                $result_string[] = $word;
            } else {
                break;
            }

        }

        return implode(' ', $result_string);
    }
}

if( !function_exists('leyka_string_has_rus_chars')) {
    /**
     * @param $text string
     * @return boolean True if given string contains at least 1 cyrillic character, false otherwise.
     */
    function leyka_string_has_rus_chars($text) {
        return preg_match('/[А-Яа-яЁё]/u', $text);
    }
}

if( !function_exists('leyka_cyr2lat') ) {
    function leyka_cyr2lat($string) {

        $converter = [
            'а' => 'a',   'б' => 'b',   'в' => 'v', 'г' => 'g',   'д' => 'd',   'е' => 'e',
            'ё' => 'e',   'ж' => 'zh',  'з' => 'z', 'и' => 'i',   'й' => 'y',   'к' => 'k',
            'л' => 'l',   'м' => 'm',   'н' => 'n', 'о' => 'o',   'п' => 'p',   'р' => 'r',
            'с' => 's',   'т' => 't',   'у' => 'u', 'ф' => 'f',   'х' => 'h',   'ц' => 'c',
            'ч' => 'ch',  'ш' => 'sh',  'щ' => 'sch', 'ь' => '',    'ы' => 'y',   'ъ' => '',
            'э' => 'e',   'ю' => 'yu',  'я' => 'ya',

            'А' => 'A',   'Б' => 'B',   'В' => 'V', 'Г' => 'G',   'Д' => 'D',   'Е' => 'E',
            'Ё' => 'E',   'Ж' => 'Zh',  'З' => 'Z', 'И' => 'I',   'Й' => 'Y',   'К' => 'K',
            'Л' => 'L',   'М' => 'M',   'Н' => 'N', 'О' => 'O',   'П' => 'P',   'Р' => 'R',
            'С' => 'S',   'Т' => 'T',   'У' => 'U', 'Ф' => 'F',   'Х' => 'H',   'Ц' => 'C',
            'Ч' => 'CH',  'Ш' => 'SH',  'Щ' => 'SCH', 'Ь' => '',  'Ы' => 'Y',   'Ъ' => '',
            'Э' => 'E',   'Ю' => 'Yu',  'Я' => 'Ya',
        ];

        return strtr($string, $converter);

    }
}

if( !function_exists('leyka_maybe_encode_hostname_to_punycode') ) {
    /**
     * @param $url string
     * @return string
     */
    function leyka_maybe_encode_hostname_to_punycode($url) {

        $hostname = explode('/', str_replace(['http://', 'https://'], '', $url));
        $hostname = reset($hostname);

        if(leyka_string_has_rus_chars($hostname)) {

            require_once LEYKA_PLUGIN_DIR.'/lib/class-punycode.php';
            return str_replace($hostname, Punycode::encodeHostName($hostname), $url);

        } else {
            return $url;
        }

    }
}
// require_once LEYKA_PLUGIN_DIR.'/lib/class-punycode.php';

if( !function_exists('leyka_set_html_content_type') ) {
    function leyka_set_html_content_type() {
        return 'text/html';
    }
}

function leyka_user_has_role($role, $is_only_role = false, $user = false) {

    if($user && is_numeric($user)) {
        $user = get_userdata($user);
    } else if( !$user || !is_a($user, 'WP_User') ) {
        $user = wp_get_current_user();
    }

    if( !$user ) {
        return false;
    }

    return !!$is_only_role ?
        (array)$user->roles == [$role] :
        in_array($role, (array)$user->roles);

}

/**
 * @param $donation mixed
 * @return Leyka_Donation_Base|false A donation object, if parameter is valid in one way or another; false otherwise.
 *
 * @deprecated Just use Leyka_Donations::get_instance()->get_donation($donation);
 */
function leyka_get_validated_donation($donation) {

    if(is_numeric($donation) && absint($donation)) {
        $donation = Leyka_Donations::get_instance()->get_donation(absint($donation));
    } else if(is_a($donation, 'WP_Post')) {
        $donation = Leyka_Donations::get_instance()->get_donation($donation);
    } elseif( !is_a($donation, 'Leyka_Donation_Base') ) {
        return false;
    }

    return $donation ? : false;

}

/**
 * @param $user int|string|WP_User|Leyka_Donor
 * @return WP_User|WP_Error
 */
function leyka_get_validated_user($user) {

    if(is_int($user) || is_string($user)) {

        if(absint($user) > 0 && !strstr($user, '@')) {
            $user = get_user_by('id', absint($user));
        } else {
            $user = get_user_by('email', esc_sql($user));
        }

        if( !$user ) {
            return new WP_Error(__('Incorrect Donor identification data', 'leyka'));
        }

    } else if(is_a($user, 'Leyka_Donor')) {
        $user = get_user_by('id', $user->id);
    } else if( !is_a($user, 'WP_User') ) {
        return new WP_Error(__('Incorrect Donor identification data', 'leyka'));
    }

    return $user;
    
}

/**
 * @param $campaign mixed
 * @return Leyka_Campaign|false A Leyka_Campaign instance if parameter is valid in one way or another; false otherwise.
 */
function leyka_get_validated_campaign($campaign) {

    if(is_numeric($campaign) && (int)$campaign > 0) {
        $campaign = get_post((int)$campaign);
    }

    if(is_a($campaign, 'WP_Post') && $campaign->post_type === Leyka_Campaign_Management::$post_type) {
        $campaign = new Leyka_Campaign($campaign);
    } else if( !is_a($campaign, 'Leyka_Campaign') ) {
        return false;
    }

    return $campaign ? : false;

}

/** Get WP pages list as an array. Used mainly to form a dropdowns. */
function leyka_get_posts_list($post_types = ['post']) {

    global $wpdb;

    $params = apply_filters('leyka_pages_list_query', ['post_status' => 'publish', 'post_type' => $post_types,]);
    foreach($params as $name => &$value) {

        if(is_array($value)) {

            $value_string = "'".implode("','", $value)."'";
            $value = "`$name` IN ($value_string)";

        } else {
            $value = "`$name` = '$value'";
        }

    }

    $res = $wpdb->get_results("SELECT ID, post_title FROM $wpdb->posts WHERE ".implode(' AND ', $params));

    $pages = [0 => __('Website main page', 'leyka'),];
    foreach($res as $page) {
        $pages[$page->ID] = $page->post_title;
    }

    return $pages;

}

/** A service function to get a list of full IDs for all currently used PMs. The list is countries-oblivious. */
function leyka_get_pm_full_ids_used() {

    global $wpdb;

    $pm_full_ids = [];

    $gateway_ids = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT {$wpdb->postmeta}.meta_value
        FROM {$wpdb->postmeta}
            LEFT JOIN {$wpdb->posts} ON {$wpdb->posts}.ID = {$wpdb->postmeta}.post_id
        WHERE {$wpdb->postmeta}.meta_key = %s
            AND {$wpdb->posts}.post_type = %s",
        'leyka_gateway',
        Leyka_Donation_Management::$post_type
    ));

    foreach($gateway_ids as $gateway_id) {

        if( !$gateway_id ) {
            continue;
        }

        $gateway_pm_ids = $wpdb->get_col($wpdb->prepare("SELECT DISTINCT CONCAT(%s, '-', postmeta2.meta_value) 
            FROM {$wpdb->postmeta} postmeta1
                LEFT JOIN {$wpdb->postmeta} postmeta2 ON postmeta1.post_id = postmeta2.post_id
            WHERE postmeta1.meta_key = %s 
                AND postmeta1.meta_value = %s
                AND postmeta2.meta_key = %s",
            $gateway_id,
            'leyka_gateway',
            $gateway_id,
            'leyka_payment_method'
        ));

        $pm_full_ids = array_merge($pm_full_ids, $gateway_pm_ids);

    }

    return array_unique($pm_full_ids);

}

function leyka_get_pd_usage_info_links() {
    return __('<a href="https://te-st.org/reports/personal-data-perm/" target="_blank" rel="noopener noreferrer">the Teplitsa article</a>.', 'leyka');
}

function leyka_get_default_email_from() {

    $domain = explode('/', trim(str_replace('http://', '', home_url('', 'http')), '/'));
    return 'no_reply@'.$domain[0];

}

/** DM is for "donation manager" */
//function leyka_get_default_dm_list() {
//    return get_bloginfo('admin_email').',';
//}

function leyka_get_default_pd_terms_page() {

    $default_page = get_option('leyka_pd_terms_page');
    if($default_page) {
        return $default_page;
    }

    $page = get_posts(apply_filters('leyka_default_pd_terms_page_query', [
        'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'private', 'future', 'inherit', 'trash'],
        'post_type' => 'page',
        'post_name__in' => ['personal-data-usage-terms'],
        'posts_per_page' => 1,
    ]));
    $page = reset($page);

    if($page) {

        if($page->post_status != 'publish') {
            wp_update_post(['ID' => $page->ID, 'post_status' => 'publish',]);
        }

        $page = $page->ID;

    } else {

        // Can't use wp_insert_post due to some strange get_permastruct() notice, so insert the post manually:
        $page = leyka_manually_insert_page([
            'post_title' => leyka_tmp__('Terms of personal data usage'),
            'post_content' => leyka_tmp__('Terms of personal data usage full text. Use <br> for line-breaks.'),
            'post_name' => 'personal-data-usage-terms',
        ]);
        if((int)$page > 0) {
            do_action('leyka_default_pd_terms_page_created', $page);
        }

    }

    if($page) {
        update_option('leyka_pd_terms_page', $page);
    }

    return $page ? : 0;

}

function leyka_get_default_service_terms_page() {

    $default_page = get_option('leyka_terms_of_service_page');
    if($default_page) {
        return $default_page;
    }

    $page = get_posts(apply_filters('leyka_default_service_terms_page_query', [
        'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'private', 'future', 'inherit', 'trash'],
        'post_type' => 'page',
        'post_name__in' => ['donation-service-terms'],
        'posts_per_page' => 1,
    ]));
    $page = reset($page);

    if($page) {

        if($page->post_status != 'publish') {
            wp_update_post(['ID' => $page->ID, 'post_status' => 'publish',]);
        }

        $page = $page->ID;

    } else {

        // Can't use wp_insert_post due to some strange get_permastruct() notice, so insert the post manually:
        $page = leyka_manually_insert_page([
            'post_title' => leyka_tmp__('Terms of donation service'),
            'post_content' => leyka_tmp__('Terms of donation service text. Use <br /> for line-breaks, please.'),
            'post_name' => 'donation-service-terms',
        ]);
        if((int)$page > 0) {
            do_action('leyka_default_terms_of_service_page_created', $page);
        }

    }

    if($page) {
        update_option('leyka_terms_of_service_page', $page);
    }

    return $page ? : 0;

}

function leyka_get_terms_of_service_page_url() {

    $url = leyka_options()->opt('terms_of_service_page') ?
        get_permalink(leyka_options()->opt('terms_of_service_page')) : home_url();

    if( !$url ) { // It can be in case when "last posts" is selected for homepage
        $url = home_url();
    }

    return $url;

}

function leyka_get_terms_of_pd_usage_page_url() {

    $url = leyka_options()->opt('pd_terms_page') ?
        get_permalink(leyka_options()->opt('pd_terms_page')) : home_url();

    if( !$url ) { // It can be in case when "last posts" is selected for homepage
        $url = home_url();
    }

    return $url;

}

function leyka_get_default_success_page() {

    $default_page = get_option('leyka_success_page');
    if($default_page) {
        return $default_page;
    }

    $page = get_posts(apply_filters('leyka_default_success_page_query', [
        'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'private', 'future', 'inherit', 'trash'],
        'post_type' => 'page',
        'post_name__in' => ['thank-you-for-your-donation'],
        'posts_per_page' => 1,
    ]));
    $page = reset($page);

    if($page) {

        if($page->post_status != 'publish') {
            wp_update_post(['ID' => $page->ID, 'post_status' => 'publish',]);
        }

        $page = $page->ID;

    } else {

        // Can't use wp_insert_post due to some strange get_permastruct() notice, so insert the post manually:
        $page = leyka_manually_insert_page([
            'post_title' => leyka_tmp__('Thank you!'),
            'post_content' => leyka_tmp__('Your donation completed. We are grateful for your help.'),
            'post_name' => 'thank-you-for-your-donation',
        ]);
        if((int)$page > 0) {
            do_action('leyka_default_success_page_created', $page);
        }

    }

    if($page) {
        update_option('leyka_success_page', $page);
    }

    return $page ? : 0;

}

function leyka_get_success_page_url() {

    $url = leyka_options()->opt('success_page') ? get_permalink(leyka_options()->opt('success_page')) : home_url();
    $url = $url ? $url : home_url(); // The case when "last posts" is selected for homepage

    $leyka_template_data = leyka_get_current_template_data();
    if( !empty($leyka_template_data['id']) ) {
        leyka_remembered_data('template_id', $leyka_template_data['id']);
    }

    return $url;

}

function leyka_get_default_failure_page() {

    $default_page = get_option('leyka_failure_page');
    if($default_page) {
        return $default_page;
    }

    $page = get_posts(apply_filters('leyka_default_failure_page_query', [
        'post_status' => ['publish', 'pending', 'draft', 'auto-draft', 'private', 'future', 'inherit', 'trash'],
        'post_type' => 'page',
        'post_name__in' => ['sorry-donation-failure'],
        'posts_per_page' => 1,
    ]));
    $page = reset($page);

    if($page) {

        if($page->post_status != 'publish') {
            wp_update_post(['ID' => $page->ID, 'post_status' => 'publish',]);
        }

        $page = $page->ID;

    } else {

        // Can't use wp_insert_post due to some strange get_permastruct() notice, so insert the post manually:
        $page = leyka_manually_insert_page([
            'post_title' => leyka_tmp__('Payment failure'),
            'post_content' => leyka_tmp__('We are deeply sorry, but for some technical reason we failed to receive your donation. Your money are intact. Please try again later!'),
            'post_name' => 'sorry-donation-failure',
        ]);
        if((int)$page > 0) {
            do_action('leyka_default_failure_page_created', $page);
        }

    }

    if($page) {
        update_option('leyka_failure_page', $page);
    }

    return $page ? : 0;

}

function leyka_get_failure_page_url() {

    $url = leyka_options()->opt('failure_page') ? get_permalink(leyka_options()->opt('failure_page')) : home_url();
    $url = $url ? $url : home_url(); // The case when "last posts" is selected for homepage

    $leyka_template_data = leyka_get_current_template_data();
    if( !empty($leyka_template_data['id']) ) {
        leyka_remembered_data('template_id', $leyka_template_data['id']);
    }
    
    return $url;

}

/**
 * Get a list of donation form templates as an array.
 *
 * @deprecated From v3.5, use leyka()->get_templates().
 */
function leyka_get_form_templates_list() {

    $list = [];
    foreach(leyka()->get_templates() as $template) {

        if( !leyka_options()->opt('plugin_debug_mode') && !empty($template['debug_only']) ) {
            continue;
        }

        $name = $template['name'] == __($template['name'], 'leyka') ? $template['name'] : __($template['name'], 'leyka');
        $description = $template['description'] == __($template['description'], 'leyka') ?
            $template['description'] : __($template['description'], 'leyka');

        $list[$template['id']] = $name.' ('.mb_strtolower($description).')';

    }

    return $list;

}

function leyka_get_problematic_recurring_subscriptions_count() {

    return Leyka_Donations::get_instance()->get_count([
        'status' => 'funded',
        'recurring_only_init' => true,
        'recurring_subscription_status' => 'problematic',
        'get_all' => true
    ]);

}

function leyka_update_recurring_subscriptions_statuses($no_date_constraints = false) {

    $params = ['status' => 'funded', 'recurring_only_init' => true, 'get_all' => true,];

    if( !$no_date_constraints ) {

        $current_day = (int)gmdate('j');
        $max_days_in_month = (int)gmdate('t');

        $date_params[] = [
            'day' => [
                $current_day < 4 ? 1 : $current_day - 3,
                $max_days_in_month < 31 && $current_day === $max_days_in_month ? 31 : $current_day
            ],
            'compare' => 'BETWEEN'
        ];

        $params['date_query'] =  $date_params;

    }

    $init_recurring_donations = Leyka_Donations::get_instance()->get($params);


    foreach($init_recurring_donations as $init_recurring_donation) {

        $gateway = leyka_get_gateway_by_id($init_recurring_donation->gateway_id);

        if( !$gateway ) {
            continue;
        }

        $init_recurring_donation->update_recurring_subscription_status();

    }

}

function leyka_get_recurring_subscription_status_list() {
    return Leyka::get_recurring_subscription_statuses();
}


/**
 * Get possible Donation status list as an array.
 *
 * @param $with_hidden boolean
 * @return array
 */
function leyka_get_donation_status_list($with_hidden = true) {
    return Leyka::get_donation_statuses($with_hidden);
}

function leyka_get_donation_status_description($status) {

    $status_descriptions = Leyka::get_donation_statuses_descriptions();
    return $status && isset($status_descriptions[$status]) ? $status_descriptions[$status] : '';

}

function leyka_get_donation_types() {
    return Leyka::get_donation_types();
}

function leyka_get_donation_type_description($type) {

    $type = $type === 'rebill' ? 'recurring' : $type;
    $types = Leyka::get_donation_types_descriptions();

    return $type && isset($types[$type]) ? $types[$type] : '';

}

function leyka_get_donor_types() {
    return Leyka::get_donor_types();
}

/**
 ** Get donor's phone
 *
 * @param int|WP_Post|Leyka_Donation_Base $donation
 * @return string
 */
function leyka_get_donor_phone($donation) {

    $donation = Leyka_Donations::get_instance()->get_donation($donation);
    $donation_additional_fields = $donation->additional_fields;
    $common_additional_fields = leyka_options()->opt('additional_donation_form_fields_library');

    if($donation->gateway_id === 'mixplat') {
        $phone = $donation->mixplat_phone;
    }

    if(empty($phone)) {

        foreach($common_additional_fields as $additional_field_title => $additional_field_data) {

            if(in_array($additional_field_title, array_keys($donation_additional_fields)) &&
                $additional_field_data['type'] === 'phone') {

                $phone = $donation_additional_fields[$additional_field_title];

            }

        }

    }

    return empty($phone) ? '' : $phone;

}

function leyka_get_pm_categories_list() {
    return apply_filters('leyka_pm_categories', [
        'bank_cards' => __('Bank cards', 'leyka'),
        'digital_currencies' => __('Digital currrencies', 'leyka'),
        'online_banking' => __('Online banking', 'leyka'),
        'mobile_payments' => __('Mobile payments', 'leyka'),
        'misc' => __('Miscellaneous', 'leyka'),
        'offline' => __('Offline', 'leyka'),
    ]);
}

function leyka_get_pm_category_label($category_id) {

    $category_id = esc_attr(trim($category_id));
    $categories_list = leyka_get_pm_categories_list();

    return $category_id && !empty($categories_list[$category_id]) ? $categories_list[$category_id] : false;

}

/**
 * Gateways filter categories main source
 * @return array
 */
function leyka_get_gateways_filter_categories_list() {
    return apply_filters('leyka_gateways_filter_categories', [
        'legal' => esc_attr__('Legal persons', 'leyka'),
        'physical' => esc_attr__('Physical persons', 'leyka'),
        'recurring' => mb_ucfirst(esc_html_x('recurring', 'a "recurring donations" in one word (like "recurrings")', 'leyka')),
    ]);
}

function leyka_get_filter_category_label($category_id) {

    $category_id = esc_attr(trim($category_id));
    $categories_list = leyka_get_gateways_filter_categories_list();

    return $category_id && !empty($categories_list[$category_id]) ? $categories_list[$category_id] : false;

}

/**
 * Gateway activation status labels.
 *
 * @param $activation_status string
 * @return string
 */
function leyka_get_gateway_activation_status_label($activation_status) {

    $activation_status_labels = [
        'active' => __('Active', 'leyka'),
        'inactive' => __('Inactive', 'leyka'),
        'activating' => __('Connection is in process', 'leyka'),
    ];

    return $activation_status && !empty($activation_status_labels[$activation_status]) ?
        $activation_status_labels[$activation_status] : false;

}

/**
 *
 */
function leyka_get_donation_gateway_description(Leyka_Donation_Base $donation, $max_length) {

    $max_length = absint($max_length);
    if( !$max_length ) {
        return false;
    }

    $description = '';
    if($donation->payment_type === 'rebill') {
        $description = $donation->is_init_recurring_donation ?
            _x('[RS]', 'For "recurring subscription"', 'leyka') : _x('[R]', 'For "rebill"', 'leyka');
    }

    $description_maybe = ($description ? $description.' ' : '').$donation->payment_title." (№ {$donation->id});";

    if(mb_strlen($description_maybe) <= $max_length) { // Payment title length is OK, try to add Donor's data

        $description = $description_maybe;
        $description_maybe = $description." {$donation->donor_name}; {$donation->donor_email}";

        if(mb_strlen($description_maybe) <= $max_length) {
            $description = $description_maybe;
        }

    } else { // Even payment title is critically long

        $description .= leyka_strip_string_by_words(
                $donation->payment_title, $max_length - mb_strlen("… (№ {$donation->id});")
            )."… (№ {$donation->id});";

    }

    return $description;

}

/**
 * @param string $wizard_id
 * @return bool
 */
function leyka_wizard_started($wizard_id) {

    try {
        $wizard_controller = Leyka_Settings_Factory::get_instance()->get_controller($wizard_id);
    } catch(Exception $e) {
        return false;
    }

    return count($wizard_controller->history) > 0;

}

/**
 * @param $extension_id string
 * @return Leyka_Extension|false An extension object or false if none found.
 */
function leyka_get_extension_by_id($extension_id) {
    return Leyka_Extension::get_by_id($extension_id);
}

/**
 * @param Leyka_Extension $extension
 * @return string
 */
function leyka_get_extension_settings_url(Leyka_Extension $extension) {
    return $extension->get_settings_url();
}

/**
 * @param Leyka_Extension $extension
 * @return string|false A Wizard suffix or false if wizard unavailable for given extension.
 */
function leyka_extension_setup_wizard(Leyka_Extension $extension) {
    return $extension->wizard_id;
}

/**
 * Gateway receiver description.
 *
 * @param $receiver_types array Receiver types array.
 * @return string
 */
function leyka_get_receiver_description($receiver_types) {

    $type = count($receiver_types) > 1 ? 'all' : $receiver_types[0];

    $labels = [
        'all' => esc_attr__('Legal & physical persons allowed as a receiver.', 'leyka'),
        'legal' => esc_attr__('Only legal persons allowed as a receiver.', 'leyka'),
        'physical' => esc_attr__('Only physical persons allowed as a receiver.', 'leyka'),
    ];

    return $type && !empty($labels[$type]) ? $labels[$type] : '';
    
}

/** Get all possible campaign target states. */
function leyka_get_campaign_target_states_list() {
    return Leyka::get_campaign_target_states();
}

/**
 * Get campaign target - template tag
 * 
 * @var $campaign integer Campaign ID.
 * @return array|false|0 Array of campaign target info, false if wrong campaign ID given, or int 0 if a campaign doesn't have a target.
 */
function leyka_get_campaign_target($campaign) {

    $campaign = (int)$campaign;
    if($campaign <= 0) {
        return false;
    }

    $campaign = new Leyka_Campaign($campaign);
    if( !$campaign->id ) {
        return false;
    }

    // Currently, target is always in RUB:
    return $campaign->target ? ['amount' => $campaign->target, 'currency' => 'rur',] : 0;

}

/**
 * Get campaign collected amount - template tag
 * 
 * @var $campaign integer Campaign ID.
 * @return mixed Array of campaign collected amount info, or false if wrong campaign ID given.
 */
function leyka_get_campaign_collections($campaign) {

    $campaign = (int)$campaign;
    if($campaign <= 0) {
        return false;
    }

    $campaign = new Leyka_Campaign($campaign);
    if( !$campaign->id ) {
        return false;
    }

    // Currently, collections are all in RUB:
    return ['amount' => $campaign->total_funded, 'currency' => 'rub',];

}

/**
 * Scale
 **/
function leyka_scale_compact($campaign) {
    
    if( !is_a($campaign, 'Leyka_Campaign') ) {
        $campaign = new Leyka_Campaign($campaign);
    }

    $target = (float)$campaign->target;
    if($target <= 0.0) {
        return;
    }

    $curr_label = leyka_get_currency_label();

    $percentage = round(($campaign->total_funded/$target)*100);
    if($percentage > 100) {
        $percentage = 100;
    }?>

<div class="leyka-scale-compact">
    <div class="leyka-scale-scale">
        <div class="target">
            <div style="width:<?php echo esc_attr( $percentage ); ?>%" class="collected">&nbsp;</div>
        </div>
    </div>
    <div class="leyka-scale-label">
    <?php $target_f = number_format($target, ($target - round($target) > 0.0 ? 2 : 0), '.', ' ');
    $collected_f = number_format($campaign->total_funded, ($campaign->total_funded - round($campaign->total_funded) > 0.0 ? 2 : 0), '.', ' ');

    if($campaign->total_funded == 0) {
        printf(esc_html__('Needed %s %s', 'leyka'), '<b>'.esc_html($target_f).'</b>', esc_html($curr_label));
    } else {
        printf(esc_html__('Collected %s of %s %s', 'leyka'), '<b>'.esc_html($collected_f).'</b>', '<b>'.esc_html($target_f).'</b>', esc_html($curr_label));
    }?>
    </div>
</div>
<?php
}

function leyka_scale_ultra($campaign) {

    if( !is_a($campaign, 'Leyka_Campaign') ) {
        $campaign = new Leyka_Campaign($campaign);
    }

    $target = (float)$campaign->target;

    if( !$target ) {
        return;
    }

    $percentage = round(($campaign->total_funded/$target)*100);
    $percentage = $percentage > 100 ? 100 : $percentage;?>

<div class="leyka-scale-ultra">
    <div class="leyka-scale-scale">
        <div class="target">
            <div style="width:<?php echo esc_attr( $percentage );?>%" class="collected">&nbsp;</div>
        </div>
    </div>
    <div class="leyka-scale-label">
        <span>

        <?php $target_f = number_format($target, ($target - round($target) > 0.0 ? 2 : 0), '.', ' ');
        $collected_f = number_format($campaign->total_funded, ($campaign->total_funded - round($campaign->total_funded) > 0.0 ? 2 : 0), '.', ' ');

        printf(esc_html_x('%s of %s %s', 'Label on ultra-compact scale', 'leyka'), '<b>'.esc_html($collected_f).'</b>', '<b>'.esc_html($target_f).'</b>', esc_html(leyka_get_currency_label($campaign->currency)));?>

        </span>
    </div>
</div>
<?php  
}

function leyka_fake_scale_ultra($campaign) {
    
    if( !is_a($campaign, 'Leyka_Campaign') ) {
        $campaign = new Leyka_Campaign($campaign);
    }

    $curr_label = leyka_get_currency_label($campaign->currency);
    $collected_f = number_format($campaign->total_funded, ($campaign->total_funded - round($campaign->total_funded) > 0.0 ? 2 : 0), '.', ' ');?>

<div class="leyka-scale-ultra-fake">
    <div class="leyka-scale-scale">
        <div class="target"> </div>
    </div>
    <div class="leyka-scale-label"><span>
        <?php printf(esc_html_x('Collected: %s', 'Label on ultra-compact fake scale', 'leyka'), '<b>' . esc_html($collected_f) . '</b> ' . esc_html($curr_label));?>
    </span></div>
</div>

<?php
}

/**
 * @param $type_id string|false
 * @return array|string Either type label or false if the $type_id given, or an array of all types w/labels.
 */
function leyka_get_payment_types_list($type_id = false) {

    $types = [
        'single' => _x('Single', '[donation]', 'leyka'),
        'rebill' => _x('All recurring payments', '[donation]', 'leyka'),
        'rebill-init' => _x('Recurring subscriptions', '[donation]', 'leyka'),
        'rebill-auto-payment' => _x('Recurring auto-payments', '[donation]', 'leyka'),
        'correction' => _x('Correctional', '[donation]', 'leyka'),
    ];

    return $type_id ? (in_array($type_id, array_keys($types)) ? $types[$type_id] : false) : $types;

}

/**
 * @param $type_id string
 * @return string|false
 * @deprecated Use leyka_get_payment_types_list($type_id) instead.
 */
function leyka_get_payment_type_label($type_id) {

    if( !$type_id ) {
        return false;
    }

    return leyka_get_payment_types_list($type_id);

}

function leyka_get_countries_full_info($country_id = null) {

    $countries = apply_filters('leyka_supported_countries_full_info', [
        'ru' => ['title' => __('Russia', 'leyka'), 'currency' => 'rub',],
        'by' => ['title' => __('Belarus Republic', 'leyka'), 'currency' => 'byn'],
        'ua' => ['title' => __('Ukraine', 'leyka'), 'currency' => 'uah'],
        'eu' => ['title' => __('European Union ', 'leyka'), 'currency' => 'eur'],
        'kg' => ['title' => __('Kyrgyzstan', 'leyka'), 'currency' => 'kgs']
    ]);

    if(empty($country_id)) {
        return $countries;
    }

    return empty($countries[$country_id]) ? false : $countries[$country_id];

}

function leyka_get_phone_formats_full_info($phone_format_id = null) {

    $phone_formats = apply_filters('leyka_phone_formats_full_info', [
        'ru' => ['title' => '+_ ( _ _ _ ) _ _ _ - _ _ - _ _', 'mask' => '+9(999)999-99-99'],
        'kg' => ['title' => '+_ _ _ ( _ _ _ ) _ _ - _ _ - _ _', 'mask' => '+999(999)99-99-99']
    ]);

    if(empty($phone_format_id)) {
        return $phone_formats;
    }

    return empty($phone_formats[$phone_format_id]) ? false : $phone_formats[$phone_format_id];

}

/**
 * A service function to get phone formats list as an array.
 *
 * @return array
 */
function leyka_get_phone_formats_list() {

    $phone_formats_list = [];
    foreach(leyka_get_phone_formats_full_info() as $phone_format_id => $info) {
        $phone_formats_list[$phone_format_id] = $info['title'];
    }

    return apply_filters('leyka_phone_formats_list', $phone_formats_list);

}

/** A service function to get the default phone format ID */
function leyka_get_default_phone_format_id() {
    return 'ru';
}

/**
 * A service function to get countries list as a simple array of [country_id => country_title] pairs.
 *
 * @return array
 */
function leyka_get_countries_list() {

    $countries_simple_list = [];
    foreach(leyka_get_countries_full_info() as $country_id => $info) {
        $countries_simple_list[$country_id] = $info['title'];
    }

    return apply_filters('leyka_supported_countries_list', $countries_simple_list);

}

/** A service function to get the default receiver country ID */
function leyka_get_default_receiver_country_id() {
    return 'ru';
}

/**
 * A high-level function to get country associated with given currency ID.
 *
 * @param string $currency_id
 * @return string|false Either country ID, or false if no coountry found for given currency ID.
 */
function leyka_get_currency_country($currency_id) {

    foreach(leyka_get_countries_full_info() as $country_id => $data) {

        if($data['currency'] === $currency_id) {
            return $country_id;
        }

    }

    return false;

}

/**
 * A service function to get currencies list as a simple array of [currency_id => currency_title] pairs.
 *
 * @return array
 */
function leyka_get_currencies_list() {

    $currencies_simple_list = [];

    foreach(leyka_get_main_currencies_full_info() as $currency_id => $data) {
        $currencies_simple_list[$currency_id] = $data['title'].' ('.$data['label'].')';
    }

    return apply_filters('leyka_supported_currencies_list', $currencies_simple_list);

}


/**
 * A service function to get all currencies data.
 *
 * @return mixed
 */
function leyka_get_main_currencies_full_info() {
    return apply_filters('leyka_main_currencies_list', [
        'rub' => [
            'title' => __('Russian Rouble', 'leyka'),
            'label' => __('₽', 'leyka'),
            'min_amount' => 10,
            'max_amount' => 30000,
            'flexible_default_amount' => 500,
            'fixed_amounts' => '100,300,500,1000',
            'iso_code' => 643
        ],
        'byn' => [
            'title' => __('Belarus Rouble', 'leyka'),
            'label' => __('BYN', 'leyka'),
            'min_amount' => 1,
            'max_amount' => 30000,
            'flexible_default_amount' => 10,
            'fixed_amounts' => '5,10,20,50',
            'iso_code' => 933
        ],
        'uah' => [
            'title' => __('Ukraine Hryvnia', 'leyka'),
            'label' => __('₴', 'leyka'),
            'min_amount' => 10,
            'max_amount' => 30000,
            'flexible_default_amount' => 500,
            'fixed_amounts' => '100,300,500,1000',
            'iso_code' => 980
        ],
        'usd' => [
            'title' => __('US Dollar', 'leyka'),
            'label' => __('$', 'leyka'),
            'min_amount' => 1,
            'max_amount' => 1000,
            'flexible_default_amount' => 10,
            'fixed_amounts' => '1,3,5,10,15,50',
            'iso_code' => 840
        ],
        'eur' => [
            'title' => __('Euro', 'leyka'),
            'label' => __('€', 'leyka'),
            'min_amount' => 1,
            'max_amount' => 650,
            'flexible_default_amount' => 5,
            'fixed_amounts' => '1,3,5,10,100',
            'iso_code' => 978
        ],
        'kgs' => [
            'title' => __('Kyrgyzstani som', 'leyka'),
            'label' => __('COM', 'leyka'),
            'min_amount' => 10,
            'max_amount' => 30000,
            'flexible_default_amount' => 500,
            'fixed_amounts' => '100,300,500,1000',
            'iso_code' => 417
        ]
    ]);
}

/**
 * A low-level function to get all supported currencies & their default settings for all supported countries.
 *
 * @param string $currency_id
 * @return array|false Either an array of all currencies default settings, or an array of given currency settings,
 * or false if no given currency found.
 */
function leyka_get_currencies_full_info($currency_id = null) {

    $currencies = leyka_get_main_currencies_full_info();

    if(empty($currency_id)) {
        return $currencies;
    }

    return empty($currencies[$currency_id]) ? false : $currencies[$currency_id];

}

/**
 * Get the default main currency for given country.
 * If none given, currently selected receiver county will be used.
 *
 * @param string $country_id
 * @return mixed Either string Country ID, or false if no given Country found.
 */
function leyka_get_country_currency($country_id = null) {

    $country_id = $country_id ? trim($country_id) : Leyka_Options_Controller::get_option_value('leyka_receiver_country');
    $country_id = $country_id ? : leyka_get_default_receiver_country_id();

    $country = leyka_get_countries_full_info($country_id);

    return $country && !empty($country['currency']) ? $country['currency'] : false;

}

/**
 * Get the main currency.
 *
 * @return mixed string Currency ID
 */
function leyka_get_main_currency($to_upper_case = false) {

    if( !Leyka_Options_Controller::get_option_value('currency_main') ) {
        leyka_set_main_currency();
    }

    $main_currency_id = is_string(Leyka_Options_Controller::get_option_value('currency_main')) ?
        strtolower(Leyka_Options_Controller::get_option_value('currency_main')) :
        Leyka_Options_Controller::get_option_value('currency_main');

    return $to_upper_case ? mb_strtoupper($main_currency_id) : $main_currency_id;

}

/**
 * Service function to set 'currency_main' option and make sure that it will not be empty
 *
 * @param $currency_id
 * @return void
 */
function leyka_set_main_currency($currency_id = null) {

    if( !$currency_id && !Leyka_Options_Controller::get_option_value('currency_main') ) {

        $country = Leyka_Options_Controller::get_option_value('receiver_country') ?: 'ru';

        switch ($country){
            case 'ru':
                $currency_id = 'rub';
                break;

            case 'ua':
                $currency_id = 'uah';
                break;

            case 'by':
                $currency_id = 'byn';
                break;

            case 'eu':
                $currency_id = 'eur';
                break;

            case 'kg':
                $currency_id = 'kgs';
                break;

        }

    }

    Leyka_Options_Controller::set_option_value('currency_main', $currency_id);

}

/**
 * A high-level function to get all supported currencies ACTUAL (not default) data.
 * The client code users should use it.
 *
 * @param string $currency_id
 * @return mixed If $currency_id is given, either it's data will return, or false (if the ID is not found). If no $currency_id is geiven, all currencies data will be returned as an array of [currency_id => currency_data] pairs.
 */
function leyka_get_currencies_data($currency_id = null) {

    $currencies = [];

    foreach(leyka_get_currencies_full_info() as $id => $data) {
        $currencies[$id] = [
            'label' => leyka_options()->opt('currency_'.$id.'_label'),
            'top' => leyka_options()->opt('currency_'.$id.'_max_sum'),
            'bottom' => leyka_options()->opt('currency_'.$id.'_min_sum'),
            'amount_settings' => [
                'flexible' => leyka_options()->opt('currency_'.$id.'_flexible_default_amount'),
                'fixed' => leyka_options()->opt('currency_'.$id.'_fixed_amounts'),
            ],
        ];
    }

    if(empty($currencies['rub']) && !empty($currencies['rur'])) {
        $currencies['rub'] = $currencies['rur'];
    }

    return $currency_id && !empty($currencies[$currency_id]) ? $currencies[$currency_id] : $currencies;

}

function leyka_get_actual_currencies_data($currency_id = null) {
    return leyka_get_currencies_data($currency_id);
}

/**
 * @deprecated Use leyka_get_currencies_data($currency_id) instead.
 * @param bool $currency_id string
 * @return array|false
 */
function leyka_get_active_currencies($currency_id = null) {
    return leyka_get_currencies_data($currency_id);
}

function leyka_get_currency_id_by_symbol($currency_symbol) {

    $currency_symbol = trim($currency_symbol);
    $currency_id = false;

    switch(trim(mb_strtoupper($currency_symbol), '.')) {
        case '₽':
        case 'RUR':
        case 'Р':
        case 'РУБ':
        case 'RUB':
            $currency_id = 'RUB'; break;
        case '$':
        case 'USD':
            $currency_id = 'USD';
            break;
        case '€':
        case 'EUR':
            $currency_id = 'EUR'; break;
        case '₴':
        case 'UAH':
            $currency_id = 'UAH'; break;
        case 'Br':
        case 'BYN':
            $currency_id = 'BYN'; break;
        case 'лв':
        case 'KGS':
            $currency_id = 'KGS'; break;
        default:
    }

    return apply_filters('leyka_currency_id_by_symbol', $currency_id, $currency_symbol);

}

/**
 * A high-level function to get all current settings of given currency ID.
 *
 * @param string $currency_id If none given, the current main currency is used.
 * @return string|false A current currency settings, or false if no given currency ID is found.
 */
function leyka_get_currency_data($currency_id = null) {

    $currency_id = empty($currency_id) ? leyka_options()->opt_safe('currency_main') : mb_strtolower($currency_id);
    $currency = leyka_get_currencies_data($currency_id);

    return empty($currency) ? false : apply_filters('leyka_'.$currency_id.'_currency_data', $currency);

}

/**
 * A high-level function to get a label of given currency ID.
 *
 * @param string $currency_id If none given, the current main currency is used.
 * @return string|false A current currency label, or false if no given currency ID is found.
 */
function leyka_get_currency_label($currency_id = null) {

    $currency_id = empty($currency_id) ? leyka_options()->opt_safe('currency_main') : mb_strtolower($currency_id);
    $currency = leyka_get_currencies_data($currency_id);

    return empty($currency['label']) ? false : apply_filters('leyka_'.$currency_id.'_currency_label', $currency['label']);

}

/**
 * Service function to get an actual rates from cbr.ru
 * @return array An assoc array of currency_code => it's rate to RUB
 */
function leyka_get_actual_currency_rates() {
    // Implement it...
    return [];
}

/**
 * Get payments amounts options by the given payment type and currency.
 * If no currency given, then currently selected receiver county currency will be used.
 *
 * @param string $currency_id
 * @return mixed
 */
function leyka_get_payments_amounts_options($payment_type, $currency_id = null) {

    // WARNING: Don't use leyka_options()->opt() & ->opt_safe() here - it creates an infinite recursion when Polylang is active:
    $currency_id = $currency_id ? : Leyka_Options_Controller::get_option_value('currency_main', false);
    $currency_id = $currency_id ? : leyka_get_country_currency(); // There are no 'currency_main' value in DB on new installations

    return Leyka_Options_Controller::get_option_value('leyka_payments_'.$payment_type.'_amounts_options_'.$currency_id, false) ? :
        leyka_get_fixed_payments_amounts_options($currency_id);

}

/**
 * Get fixed payments amounts options by the given currency.
 *
 * @param string $currency_id
 * @return array|false
 */
function leyka_get_fixed_payments_amounts_options($currency_id) {

    if (!$currency_id) {
        return false;
    }

    $currency = leyka_get_currencies_data($currency_id);

    $fixed_amounts_options = [];

    if( !empty($currency['amount_settings']['fixed']) ) {

        foreach(explode(',', $currency['amount_settings']['fixed']) as $fixed_amount) {

            $fixed_amounts_options[leyka_get_random_string(4)] = [
                'amount' => $fixed_amount,
                'description' => ''
            ];

        }

    }

    return $fixed_amounts_options;

}

function leyka_get_campaigns_list($params = [], $simple_format = true) {

    $campaigns = get_posts(array_merge([
        'post_type' => Leyka_Campaign_Management::$post_type,
        'posts_per_page' => 20,
    ], $params));



    $list = [];
    foreach($campaigns as $campaign) {

        $campaign = new Leyka_Campaign($campaign);

        // "Simple format" results in simple assoc. array of ID => title
        $list[$campaign->id] = !!$simple_format ? $campaign->title : $campaign;

    }

    return $list;

}

/**
 * Search for Campaign by its post title (or payment title, if needed).
 *
 * @param $campaign_title string
 * @param bool $get_default_if_not_found
 * @return WP_Post|false Campaign post if found, false otherwise.
 */
function leyka_get_campaign_by_title($campaign_title, $get_default_if_not_found = true) {

    $campaign_title = trim($campaign_title);

    $campaign = get_posts([ // Try to find Campaign by its post title
        'post_type' => Leyka_Campaign_Management::$post_type,
        'post_status' => 'publish',
        'title' => $campaign_title,
        'posts_per_page' => 1,
    ]);

    if($campaign) {
        return $campaign[0];
    }

    $campaign = get_posts([ // Try to find Campaign by its payment title meta value
        'post_type' => Leyka_Campaign_Management::$post_type,
        'post_status' => 'publish',
        'meta_query' => [
            'relation' => 'OR',
            ['key' => 'payment_title', 'value' => $campaign_title, 'compare' => 'LIKE',],
            ['key' => 'payment_title', 'value' => htmlentities($campaign_title, ENT_COMPAT, 'UTF-8'), 'compare' => 'LIKE',],
        ],
        'posts_per_page' => 1,
    ]);

    if($campaign) {
        return $campaign[0];
    }

    if( !$get_default_if_not_found ) {
        return false;
    }

    $campaign = get_posts([ // Try to find any published Campaign
        'post_type' => Leyka_Campaign_Management::$post_type,
        'post_status' => 'publish',
        'order' => 'ASC',
        'posts_per_page' => 1,
    ]);

    return $campaign ? $campaign[0] : false;

}

function leyka_get_campaigns_select_default() {

    $default_campaign = get_transient('leyka_default_campaign_id'); // Default campaign ID cache

    if( !$default_campaign ) {

        $default_campaign = array_keys(
            leyka_get_campaigns_list(['orderby' => 'title', 'order' => 'ASC', 'posts_per_page' => 1,], true)
        );
        set_transient('leyka_default_campaign_id', reset($default_campaign));

    }

    return $default_campaign;

}

function leyka_get_terms_text() {
    $terms_text = apply_filters(
        'leyka_terms_of_service_text',
        leyka_options()->opt('receiver_legal_type') === 'legal' ?
            leyka_options()->opt('terms_of_service_text') :
            leyka_options()->opt('person_terms_of_service_text')
    );
    return wp_kses_post($terms_text);
}

function leyka_get_pd_terms_text() {
    $pd_terms_text = apply_filters(
        'leyka_terms_of_pd_usage_text',
        leyka_options()->opt('receiver_legal_type') === 'legal' ?
            leyka_options()->opt('pd_terms_text') : leyka_options()->opt('person_pd_terms_text')
    );
    return wp_kses_post($pd_terms_text);
}

/** Default campaign ID cache invalidation */
function leyka_flush_cache_default_campaign_id($new_status, $old_status, $campaign) {

    if((is_int($campaign) || is_string($campaign)) && absint($campaign)) {
        $campaign = get_post($campaign);
    }

    if(
        !is_object($campaign)
        || empty($campaign->post_type)
        || $campaign->post_type !== Leyka_Campaign_Management::$post_type
        || ($old_status !== 'publish'  &&  $new_status !== 'publish')
    ) {
        return;
    }

    delete_transient('leyka_default_campaign_id');

}
add_action('transition_post_status', 'leyka_flush_cache_default_campaign_id', 10, 3);

function leyka_is_widget_active() {

    // is_active_widget() is not working for some reason, so emulate it:
    foreach(wp_get_sidebars_widgets() as $sidebar => $widgets) {
        foreach((array)$widgets as $widget) {
            if(stristr($widget, 'leyka_') !== false) {
                return true;
            }
        }
    }

    return false;

}

/** @return boolean */
function leyka_are_bank_essentials_set() {

    if(leyka_options()->opt('receiver_legal_type') === 'legal') {
        return !!leyka_options()->opt('org_full_name')
            && !!leyka_options()->opt('org_inn')
            && !!leyka_options()->opt('org_kpp')
            && !!leyka_options()->opt('org_bank_account')
            && !!leyka_options()->opt('org_bank_name')
            && !!leyka_options()->opt('org_bank_bic')
            && !!leyka_options()->opt('org_bank_corr_account')
            && !!leyka_options()->opt('org_state_reg_number');
    } else {
        return !!leyka_options()->opt('person_full_name')
            && !!leyka_options()->opt('person_inn')
            && !!leyka_options()->opt('person_bank_name')
            && !!leyka_options()->opt('person_bank_account')
            && !!leyka_options()->opt('person_bank_bic')
            && !!leyka_options()->opt('person_bank_corr_account');
    }

}

function leyka_get_empty_bank_essentials_options() {

    if(leyka_are_bank_essentials_set()) {
        return [];
    }

    $bank_essentials_options = leyka_options()->opt('receiver_legal_type') === 'legal' ?
        ['org_full_name', 'org_inn', 'org_kpp', 'org_bank_account', 'org_bank_name', 'org_bank_bic', 'org_bank_corr_account', 'org_state_reg_number'] :
        ['person_full_name', 'person_inn', 'person_bank_name', 'person_bank_account', 'person_bank_bic', 'person_bank_corr_account',];

    $result = [];
    foreach($bank_essentials_options as $option_id) {
        if( !leyka_options()->opt($option_id) ) {
            $result[] = $option_id;
        }
    }

    return $result;

}

function leyka_is_campaign_link_in_menu() {

//    foreach(get_registered_nav_menus() as $menu_id => $menu_name) {
//        wp_get_nav_menu_items($menu_id);
//    }

    return false;

}

function leyka_get_shortcodes() {

    global $shortcode_tags;

    $leyka_shortcodes = [];

    foreach($shortcode_tags as $shortcode_tag => $function_name) {
        if(stripos($shortcode_tag, 'leyka') !== false) {
            $leyka_shortcodes[] = $shortcode_tag;
        }
    }

    return $leyka_shortcodes;

}

/** @return boolean True if at least one Leyka form is currently on the screen, false otherwise */
function leyka_form_is_displayed($widgets_also = true) {

    if( !leyka_options()->opt('load_scripts_if_need') || apply_filters('leyka_form_is_screening', false)) {
        return true;
    }

    $template = get_page_template_slug();

    $content_has_shortcode = false;
    $content_has_block     = false;
    if(get_post()) {
        foreach(leyka_get_shortcodes() as $shortcode_tag) {
            if(has_shortcode(get_post()->post_content, $shortcode_tag)) {

                $content_has_shortcode = true;
                break;

            }
        }
        if(has_block('leyka/form', get_post()->ID)) {
            $content_has_block = true;
        }
    }

    return leyka()->form_is_screening ||
        is_singular(Leyka_Campaign_Management::$post_type) ||
        stristr($template, 'home-campaign_one') !== false ||
        stripos($template, 'leyka') !== false ||
        $content_has_shortcode ||
        $content_has_block ||
        ( !!$widgets_also && leyka_is_widget_active() );

}

/**
 * @depracated Use leyka_form_is_displayed() instead.
 */
function leyka_form_is_screening($widgets_also = true) {
    return leyka_form_is_displayed( !!$widgets_also );
}

function leyka_revo_template_displayed() {

    $revo_displayed = false;

    if(is_singular(Leyka_Campaign_Management::$post_type)) {

        $campaign = new Leyka_Campaign(get_post());
        if($campaign->template == 'default') {

            $leyka_template_data = leyka_get_current_template_data();
            $revo_displayed = $leyka_template_data['id'] == 'revo';

        } else {
            $revo_displayed = $campaign->template == 'revo';
        }

    } else if(get_post() && has_shortcode(get_post()->post_content, 'leyka_inline_campaign')) {
        $revo_displayed = true;
    }

    return apply_filters('leyka_revo_template_displayed', $revo_displayed);

}

function leyka_modern_template_displayed($template_id = false) {

    $modern_template_displayed = false;
    $modern_templates = $template_id ? [$template_id] : ['revo', 'star', 'need-help',];

    $post = get_post();

    if(get_query_var('leyka-screen')) {
        return true; // No filters here - sometimes for some reason the usual filter returns false on Donor's account login page
    } else if(is_singular(Leyka_Campaign_Management::$post_type)) {

        $campaign = new Leyka_Campaign(get_post());
        if($campaign->template === 'default') {

            $leyka_template_data = leyka_get_current_template_data();
            $modern_template_displayed = in_array($leyka_template_data['id'], $modern_templates);

        } else {
            $modern_template_displayed = in_array($campaign->template, $modern_templates);
        }

    } else if($post) {

        $content_has_shortcodes = false;
        foreach(leyka_get_shortcodes() as $shortcode_tag) {
            if(has_shortcode(get_post()->post_content, $shortcode_tag)) {

                $content_has_shortcodes = true;
                break;

            }
        }

        if($content_has_shortcodes) {
            $modern_template_displayed = true;
        } else if(
            has_shortcode($post->post_content, 'leyka_campaign_form')
            || has_shortcode($post->post_content, 'leyka_payment_form')
        ) {

            if(preg_match_all('/'.get_shortcode_regex().'/s', $post->post_content, $matches)) {

                $attr_id_match = [];
                foreach($matches[2] as $key => $value) {
                    if(in_array($value, ['leyka_campaign_form', 'leyka_payment_form',])) {

                        $get = str_replace(' ', '&', $matches[3][$key]);
                        parse_str($get, $atts);

                        if(array_key_exists('id', $atts)) {

                            $campaign_id = preg_match_all("/(\d+)/", $atts['id'], $attr_id_match);
                            $campaign_id = isset($attr_id_match[1][0]) ? (int)$attr_id_match[1][0] : 0;

                            if( !$campaign_id ) {
                                continue;
                            }

                            $campaign = new Leyka_Campaign($campaign_id);
                            if(in_array($campaign->template, $modern_templates)) {

                                $modern_template_displayed = true;
                                break;

                            }

                        }
                    }
                }

            }

        }

    }

    return apply_filters('leyka_modern_template_displayed', $modern_template_displayed);

}

function leyka_persistent_campaign_donated() {

    $result = is_page(leyka_options()->opt('success_page')) || is_page(leyka_options()->opt('failure_page'));

    if($result) {

        $donation_id = leyka_remembered_data('donation_id');
        $donation = $donation_id ? Leyka_Donations::get_instance()->get($donation_id) : null;
        $campaign_id = $donation ? $donation->campaign_id : null;
        $campaign = $campaign_id ? new Leyka_Campaign($campaign_id) : null;

        $result = $campaign && $campaign->campaign_type === 'persistent' && $campaign->template == 'star';

    }

    return $result;

}

function leyka_success_widget_displayed() {
    return leyka_options()->opt_template('show_success_widget_on_success') && is_page(leyka_options()->opt('success_page'));
}

function leyka_failure_widget_displayed() {
    return leyka_options()->opt_template('show_failure_widget_on_failure') && is_page(leyka_options()->opt('failure_page'));
}

function leyka_validate_donor_name($name, $is_correctional = false) {
    return $name && !$is_correctional ? !preg_match('/[^\\x{0410}-\\x{044F}\w\s\-_\'\.]/iu', $name) : true;
}

function leyka_validate_email($email) {
    return $email ? preg_match("/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|expert|[a-z]+)|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i", leyka_str_to_translit($email)) : true;
}

if( !function_exists('leyka_is_phone_number') ) {
    /**
     * @param string $phone A phone number to validate. If empty, will always return true.
     * @return boolean True if given phone is valid (or empty), false otherwise.
     * @deprecated Please use leyka_validate_donor_phone($phone) instead.
     */
    function leyka_is_phone_number($phone) {
        return leyka_validate_donor_phone($phone);
    }
}

if( !function_exists('leyka_validate_donor_phone') ) {
    /**
     * @param string $phone A phone number to validate. If empty, will always return true.
     * @return boolean True if given phone is valid (or empty), false otherwise.
     */
    function leyka_validate_donor_phone($phone) {

        $phone = trim($phone);
        return $phone ? preg_match('/^[0-9\+\-\. ]{10,}$/i', $phone) : true;

    }
}

if( !function_exists('leyka_validate_donor_date') ) {
    /**
     * @param string $date A date to validate (format: DD.MM.YYYY). If empty, will always return true.
     * @return boolean True if given date is valid (or empty), false otherwise.
     */
    function leyka_validate_donor_date($date) {

        $date = trim($date);
        return $date ? preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/i', $date) : true;

    }
}

/** @return string URL of a current page, according to permalinks stucture setting. */
function leyka_get_current_url() {

    global $wp;
    return add_query_arg($wp->query_string, '', home_url($wp->request));

}

// For some reason wp_validate_redirect() aren't get defined in WP 3.6.1, so define it if needed:
if( !function_exists('wp_validate_redirect') ) {
    function wp_validate_redirect($location, $default = '') {

        $location = trim($location);

        // browsers will assume 'http' is your protocol, and will obey a redirect to a URL starting with '//'
        if(substr($location, 0, 2) == '//') {
            $location = 'http:' . $location;
        }

        // In php 5 parse_url may fail if the URL query part contains http://, bug #38143
        $test = ($cut = strpos($location, '?')) ? substr($location, 0, $cut) : $location;

        $lp  = wp_parse_url($test);

        // Give up if malformed URL
        if ( false === $lp )
            return $default;

        // Allow only http and https schemes. No data:, etc.
        if ( isset($lp['scheme']) && !('http' == $lp['scheme'] || 'https' == $lp['scheme']) )
            return $default;

        // Reject if scheme is set but host is not. This catches urls like https:host.com
        // for which parse_url does not set the host field:
        if ( isset($lp['scheme'])  && !isset($lp['host']) )
            return $default;

        $wpp = wp_parse_url(home_url());
        $allowed_hosts = (array)apply_filters('allowed_redirect_hosts', [$wpp['host']], isset($lp['host']) ? $lp['host'] : '');

        if( isset($lp['host']) && ( !in_array($lp['host'], $allowed_hosts) && $lp['host'] != strtolower($wpp['host'])) ) {
            $location = $default;
        }

        return $location;

    }
}

/**
 * A filter function to remove the DB access details from the $_SERVER fields that sometimes are publically sent
 * (e.g. in Gateways errors reports).
 */
if( !function_exists('leyka_clear_server_data') ) {

    function leyka_clear_server_data(array $server_data = []) {

        if( !empty($server_data['WORDPRESS_DB_USER'])) {
            $server_data['WORDPRESS_DB_USER'] = 'XXXXXXXXXXXX';
        }

        if( !empty($server_data['WORDPRESS_DB_NAME'])) {
            $server_data['WORDPRESS_DB_NAME'] = 'XXXXXXXXXXXX';
        }

        if( !empty($server_data['WORDPRESS_DB_HOST'])) {
            $server_data['WORDPRESS_DB_HOST'] = 'XXXXXXXXXXXXXXXXXXXX';
        }

        if( !empty($server_data['WORDPRESS_DB_PASSWORD']) ) {
            $server_data['WORDPRESS_DB_PASSWORD'] = 'XXXXXXXXXXXXXXXXXXXX';
        }

        return $server_data;

    }
    add_filter('leyka_notification_server_data', 'leyka_clear_server_data');

}

/**
 * @param $campaign_id int
 * @param $limit int|false False to get all donations (unlimited number).
 * @return array|false An array of Leyka_Donation_Base objects, or false if wrong campaign ID given.
 */
function leyka_get_campaign_donations($campaign_id = false, $limit = false) {

    $campaign_id = $campaign_id ? absint($campaign_id) : false;
    $limit = (int)$limit > 0 ? (int)$limit : false;

    $params = ['status' => 'funded',];
    if($campaign_id) {
        $params['campaign_id'] = $campaign_id;
    }

    if($limit) {
        $params['results_limit'] = $limit;
    } else {
        $params['nopaging'] = true;
    }

    return Leyka_Donations::get_instance()->get($params);

}

function leyka_get_donations_archive_url($campaign_id = false) {

    if(absint($campaign_id) > 0) {

        $campaign = get_post($campaign_id);

        $donations_permalink = trim(get_permalink($campaign_id), '/');
        if(mb_strpos($donations_permalink, '?')) {
            $donations_permalink = home_url('?post_type='.Leyka_Donation_Management::$post_type.'&leyka_campaign_filter='.$campaign->post_name);
        } else {
            $donations_permalink = $donations_permalink.'/donations/';
        }

    } else {
        $donations_permalink = get_option('permalink-structure') ?
            home_url('/donations/') : home_url('?post_type='.Leyka_Donation_Management::$post_type);
    }

    return $donations_permalink;

}

function leyka_remembered_data($name, $value = null, $delete = false) {

    $name = mb_stripos($name, 'leyka_') === false ? 'leyka_'.$name : $name;

    if($value) {
        return headers_sent() ?
            null : setcookie($name, trim($value), current_time('timestamp') + 60*60, COOKIEPATH, COOKIE_DOMAIN, false);
    } else if( !!$delete ) {
        return headers_sent() ?
            null : setcookie($name, '', current_time('timestamp') - 3600, COOKIEPATH, COOKIE_DOMAIN, false);
    } else {
        return empty($_COOKIE[$name]) ? '' : trim($_COOKIE[$name]);
    }

}

function leyka_calculate_donation_total_amount($donation = false, $amount = 0.0, $pm_full_id = '') {

    if($donation) {
        $donation = Leyka_Donations::get_instance()->get_donation($donation);
    }

    $amount = $amount ? : ($donation ? $donation->amount : floatval($amount));
    $pm_full_id = $pm_full_id ? : ($donation ? $donation->pm_full_id : false);

    if( !$amount || !$pm_full_id ) {
        return 0.0;
    }

    $commission = leyka_options()->opt('commission');
    $commission = empty($commission[$pm_full_id]) ? 0.0 : $commission[$pm_full_id]/100.0;

    return $commission && $commission > 0.0 ? $amount - round($amount*$commission, 2) : $amount;

}

function leyka_get_pm_commission($pm_full_id) {

    $commission = leyka_options()->opt('commission');

    return empty($commission[$pm_full_id]) ? 0.0 : $commission[$pm_full_id]/100.0;

}

/**
 * A helper function to insert posts manually. Used only when wp_insert_post() leads to notices & fatal errors.
 *
 * @param $post_data array New page data.
 * @return integer|false
 */
function leyka_manually_insert_page(array $post_data) {

    global $wpdb;

    $post_date = current_time('mysql');
    $wpdb->insert($wpdb->prefix.'posts', [
        'post_type' => 'page',
        'post_status' => 'publish',
        'post_title' => $post_data['post_title'],
        'post_content' => $post_data['post_content'],
        'post_name' => $post_data['post_name'],
        'post_author' => get_current_user_id(),
        'post_excerpt' => '',
        'post_date' => $post_date,
        'post_date_gmt' => get_gmt_from_date($post_date),
        'post_modified' => $post_date,
        'post_modified_gmt' => get_gmt_from_date($post_date),
    ]);

    return $wpdb->insert_id;

}

/** @return array An assoc array of all Leyka options from leyka-option-meta file and some environment data */
function leyka_get_env_and_options() {
    return array_merge(leyka_get_all_options(), leyka_get_env(), leyka_get_db_stats());
}

function humanaize_debug_data($debug_data) {

    $humanized_options = [];

    foreach($debug_data['options'] as $k => $v) {
        $option_info = leyka_options()->get_info_of($k);
        $option_title = empty($option_info['title']) || $option_info['title'] == $k ? $k : $option_info['title'];
        $humanized_options[$option_title] = $v;
    }
    $debug_data['options'] = $humanized_options;

    foreach(array_keys($debug_data['plugins']) as $status) {

        $humanized_options = [];

        foreach($debug_data['plugins'][$status] as $plugin) {
            $humanized_options[] = sprintf("%s %s", $plugin['name'], $plugin['ver']);
        }

        $debug_data['plugins'][$status] = $humanized_options;

    }

    return $debug_data;

}

function format_debug_data($list, $level = 0) {

    $fomatted_ret = '';

    if($level > 0) {
        ksort($list);
    }

    foreach($list as $k => $v) {
        $fomatted_ret .= str_repeat("    ", $level) . "<strong>$k:</strong> ";
        if(is_array($v)) {
            $fomatted_ret .= "\n" . format_debug_data($v, $level + 1) . ($level == 0 ? "\n" : "");
        }
        else {
            $fomatted_ret .= trim($v) . "\n";
        }
    }

    return $fomatted_ret;

}

/** @return array An assoc array of some db stats */
function leyka_get_db_stats() {

    global $wpdb;

    $query_time_start = microtime(true);

    $payments_count = $wpdb->get_var(
        $wpdb->prepare("SELECT COUNT(*) FROM $wpdb->posts WHERE post_type = %s", Leyka_Donation_Management::$post_type)
    );

    $all_posts_count = $wpdb->get_var("SELECT COUNT(*) FROM $wpdb->posts");

    return [
        'db_stats' => [
            'all_posts_count' => $all_posts_count,
            'payments_count' => $payments_count,
            'query_exec_time' => sprintf("%.10f", microtime(true) - $query_time_start),
        ],
    ];

}

/** @return array An assoc array of some environment data */
function leyka_get_env() {

    if( !function_exists('get_plugins') ) {
        require_once ABSPATH.'wp-admin/includes/plugin.php';
    }

    global $wp_version;

    $res = [
        'wp_core' => $wp_version,
        'env' => ['php_version' => phpversion(), 'php_extensions' => get_loaded_extensions()],
    ];

    // Server data:
    $forbidden_data = [
        'MIBDIRS', 'OPENSSL_CONF', 'HTTP_COOKIE', 'PATH', 'SystemRoot', 'COMSPEC', 'WINDIR', 'DOCUMENT_ROOT',
        'CONTEXT_DOCUMENT_ROOT', 'SCRIPT_FILENAME', 'APACHE_LOG_DIR', 'APACHE_RUN_GROUP', 'APACHE_RUN_USER', 'LANG', 'PWD',
        'APACHE_LOCK_DIR', 'APACHE_PID_FILE', 'APACHE_RUN_DIR', 'APACHE_CONFDIR', 'argc', 'argv', 'PHP_SELF', 'SCRIPT_NAME',
        'REDIRECT_URL', 'REMOTE_PORT', 'REQUEST_SCHEME', 'SERVER_PORT', 'SERVER_ADDR', 'SERVER_SIGNATURE', 'CONTENT_TYPE',
        'HTTP_ACCEPT', 'CONTENT_LENGTH', 'HTTP_CONNECTION', 'REQUEST_URI', 'REMOTE_ADDR',
    ];
    foreach($_SERVER as $key => $value) {

        if(in_array($key, $forbidden_data)) {
            continue;
        }

        $res['env']['server_'.$key] = is_array($value) ? serialize($value) : wp_strip_all_tags($value);

    }
    foreach($_ENV as $key => $value) {

        if(in_array($key, $forbidden_data)) {
            continue;
        }

        $res['env']['env_'.$key] = is_array($value) ? serialize($value) : wp_strip_all_tags($value);

    }

    // WP core/Theme/plugins data:
    $res['plugins'] = ['active' => [], 'inactive' => [],];

    foreach(get_plugins() as $key => $plugin_data) {
        if(in_array($key, get_option('active_plugins'))) {
            $res['plugins']['active'][] = ['name' => $plugin_data['Name'], 'ver' => $plugin_data['Version'],];
        } else {
            $res['plugins']['inactive'][] = ['name' => $plugin_data['Name'], 'ver' => $plugin_data['Version'],];
        }
    }

    $theme = wp_get_theme();
    $res['theme'] = [
        'name' => $theme->Name,
        'ver' => $theme->Version,
        'template' => $theme->template,
        'parent' => $theme->parent ?
            ['name' => $theme->Name, 'ver' => $theme->Version, 'template' => $theme->parent->template,] : [],
    ];

    return $res;

}

/** @return array An assoc array of Leyka options (from leyka-options-meta) & settings (other "leyka_something"-named options) */
function leyka_get_all_options() {

    $res = ['options' => [], 'settings' => [],];
    $leyka_options_keys = leyka_options()->get_options_names();

    $forbidden_options = [
        'person_pd_terms_text', 'person_terms_of_service_text', 'pd_terms_text', 'terms_of_service_text', 'org_bank_account',
        'email_thanks_text', 'org_face_fio_ip', 'org_face_fio_rp', 'org_address', 'person_full_name', 'person_address',
        '_transient_leyka_wizards_activities', '_transient_leyka_default_campaign_id', 'permalinks_flushed', 'org_bank_name',
        'org_actual_address_differs', 'plugin_stats_option_sync_done', 'widget_leyka_donations_list', 'org_bank_bic', 'org_inn',
        'widget_leyka_campaigns_list', 'paypal_client_id', 'paypal_api_signature', 'paypal_api_password', 'paypal_api_username',
        'quittance_redirect_page', 'rbk_api_web_hook_key', 'rbk_api_key', 'rbk_shop_id', 'chronopay_ip', 'chronopay_shared_sec',
        'chronopay_use_payment_uniqueness_control', 'chronopay_card_rebill_product_id_eur', 'org_bank_corr_account', 'org_kpp',
        'chronopay_card_rebill_product_id_usd', 'chronopay_card_rebill_product_id_rur', 'yandex-yandex_card_private_key_password',
        'yandex-yandex_card_private_key_path', 'yandex-yandex_card_certificate_path', 'org_face_position', 'yandex_secret_key',
        'yandex_shop_password', 'yandex_shop_article_id', 'yandex_scid', 'yandex_shop_id', 'cp_ip', 'cp_public_id',
        'options:robokassa_shop_password2', 'robokassa_shop_password1', 'robokassa_shop_id', 'chronopay_card_product_id_rur',
        'chronopay_card_product_id_usd', 'chronopay_card_product_id_eur', 'text_box_details', 'yandex_money_account',
        'yandex_money_secret', 'mixplat-mobile_details', 'mixplat-sms_default_campaign_id', 'mixplat-sms_description',
        'mixplat-sms_details', 'mixplat_service_id', 'mixplat_secret_key', 'paymaster_merchant_id', 'paymaster_secret_word',
        'paymaster_hash_method', 'failure_page', 'success_page', 'pd_terms_page', 'terms_of_service_page', 'cryptocurrencies_text'
    ];

    foreach(wp_load_alloptions() as $name => $value) {

        $name_clear = strpos($name, 'leyka_') === 0 ? substr_replace($name, '', 0, strlen('leyka_')) : $name;

        if(in_array($name_clear, $forbidden_options) || preg_match("/^knd_val_hash_leyka_/", $name)) {
            continue;
        } else if(in_array($name_clear, $leyka_options_keys)) {
            $res['options'][$name_clear] = $value;
        } else if(stristr($name, 'leyka_') !== false && !preg_match('/^(leyka_)(.+)(_description)$/i', $name)) {
            $res['settings'][$name] = $value;
        }

    }

    return $res;

}

if( !function_exists('array_key_last') ) {
    function array_key_last($array) {

        if( !is_array($array) || empty($array) ) {
            return null;
        }

        return array_keys($array)[count($array) - 1];

    }
}

if( !function_exists('leyka_get_delta_percent') ) {
    function leyka_get_delta_percent($prev_value, $new_value, $handle_incomparabe_cases = true) {

        $handle_incomparabe_cases = !!$handle_incomparabe_cases;

        if( !$prev_value ) {
            $delta_percent = $handle_incomparabe_cases ? NULL : ($new_value ? 100.0 : 0);
        } else {
            $delta_percent = $handle_incomparabe_cases && !$new_value ?
                NULL : round(100.0*($new_value - $prev_value)/$prev_value, 2);
        }

        return $delta_percent;

    }
}

if( !function_exists('leyka_amount_format') ) {
    /** @depracated Use leyka_format_amount() instead. */
    function leyka_amount_format($amount) {
        return leyka_format_amount($amount);
    }
}

if( !function_exists('leyka_format_amount') ) {
    function leyka_format_amount($amount, $use_number_format_l10n = false) {

        $amount_is_float = abs((float)$amount) - abs((int)$amount) > 0;

        return !!$use_number_format_l10n ?
            ($amount_is_float ? number_format_i18n($amount, 2) : number_format_i18n($amount)) :
            number_format((float)$amount, $amount_is_float ? 2 : 0, '.', ' ');

    }
}

abstract class Leyka_Singleton {

    protected static $_instance = null;

    /**
     * @param $params array Assoc. array of Singleton object params. Not required.
     * @return static
     */
    public static function get_instance(array $params = []) {

        if(null === static::$_instance) {
            static::$_instance = new static($params);
        }

        return static::$_instance;

    }

    final protected function __clone() {}

    protected function __construct(array $params = []) {
    }

}

if( !function_exists('leyka_save_option') ) {
    function leyka_save_option($setting_id) {

        $option_type = leyka_options()->get_type_of($setting_id);

        if($option_type === 'checkbox') {
            leyka_options()->opt($setting_id, isset($_POST["leyka_$setting_id"]) ? 1 : 0);
        } else if($option_type == 'multi_checkbox' || $option_type == 'multi_select') {

            if(isset($_POST["leyka_$setting_id"]) && leyka_options()->opt($setting_id) !== $_POST["leyka_$setting_id"]) {
                leyka_options()->opt($setting_id, (array)$_POST["leyka_$setting_id"]);
            } else if(empty($_POST["leyka_$setting_id"])) {
                leyka_options()->opt($setting_id, []);
            }

        } else if($option_type === 'html' || $option_type === 'rich_html') {

            if(isset($_POST["leyka_$setting_id"]) && leyka_options()->opt($setting_id) !== $_POST["leyka_$setting_id"]) {
                leyka_options()->opt($setting_id, esc_attr(stripslashes($_POST["leyka_$setting_id"])));
            }

        } else if(mb_stristr($option_type, 'custom_') !== false && isset($_POST["leyka_$setting_id"])) { // Custom field types
            do_action("leyka_save_custom_option-$setting_id", $_POST["leyka_$setting_id"], $setting_id);
        } else if(isset($_POST["leyka_$setting_id"])) { // Simple field types

            $old_value = leyka_options()->opt($setting_id);
            if($old_value != $_POST["leyka_$setting_id"]) {
                leyka_options()->opt($setting_id, esc_attr(stripslashes($_POST["leyka_$setting_id"])));
            }

            do_action("leyka_after_save_option-$setting_id", $old_value, $_POST["leyka_$setting_id"]);

        }

    }
}

if( !function_exists('leyka_save_commission_field') ) {
    /** A utility function to save the Gateways commission fields. For "leyka_save_custom_option-commission" hook only. */
    function leyka_save_commission_field() {
        if( !empty($_POST['leyka_commission']) && is_array($_POST['leyka_commission']) ) {

            foreach($_POST['leyka_commission'] as &$commission) {
                $commission = $commission >= 0.0 ? (float)$commission : 0.0;
            }

            leyka_options()->opt('commission', array_merge(leyka_options()->opt('commission'), $_POST['leyka_commission']));

        }
    }
}
add_action('leyka_save_custom_option-commission', 'leyka_save_commission_field');

if( !function_exists('leyka_add_editor_css') ) {
    function leyka_add_editor_css() {
        add_editor_style(LEYKA_PLUGIN_BASE_URL.'assets/css/editor.css');
    }
}
add_action('after_setup_theme', 'leyka_add_editor_css');

if( !function_exists('leyka_get_l18n_date') ) {
    function leyka_get_i18n_date($timestamp) {
        return date_i18n(get_option('date_format'), (int)$timestamp);
    }
}
if( !function_exists('leyka_get_l18n_time') ) {
    function leyka_get_i18n_time($timestamp) {
        return date_i18n(get_option('time_format'), (int)$timestamp);
    }
}
if( !function_exists('leyka_get_l18n_datetime') ) {
    function leyka_get_i18n_datetime($timestamp) {
        return date_i18n(get_option('date_format').', '.get_option('time_format'), (int)$timestamp);
    }
}

// Localize tags to replace in JS:
if( !function_exists('leyka_localize_rich_html_text_tags') ) {
    function leyka_localize_rich_html_text_tags() {

        $is_legal = leyka_options()->opt('receiver_legal_type') === 'legal';

        wp_localize_script('leyka-settings', 'leykaRichHTMLTags', [
            'termsKeys' => [
                [
                    '#LEGAL_NAME#',
                    '#LEGAL_FACE#',
                    '#LEGAL_FACE_POSITION#',
                    '#LEGAL_ADDRESS#',
                    '#STATE_REG_NUMBER#',
                    '#KPP#',
                    '#INN#',
                    '#BANK_ACCOUNT#',
                    '#BANK_NAME#',
                    '#BANK_BIC#',
                    '#BANK_CORR_ACCOUNT#',
                    '#SITE_NAME#',
                    '#SITE_URL#',
                    '#ORG_NAME#',
                    '#ORG_SHORT_NAME#',
                ],
                [
                    $is_legal ? leyka_options()->opt('org_full_name') : leyka_options()->opt('person_full_name'),
                    $is_legal ? leyka_options()->opt('org_face_fio_ip') : leyka_options()->opt('person_full_name'),
                    $is_legal ? leyka_options()->opt('org_face_position') : '',
                    $is_legal ? leyka_options()->opt('org_address') : leyka_options()->opt('person_address'),
                    $is_legal ? leyka_options()->opt('org_state_reg_number') : '',
                    $is_legal ? leyka_options()->opt('org_kpp') : '',
                    $is_legal ? leyka_options()->opt('org_inn') : leyka_options()->opt('person_inn'),
                    $is_legal ? leyka_options()->opt('org_bank_account') : leyka_options()->opt('person_bank_account'),
                    $is_legal ? leyka_options()->opt('org_bank_name') : leyka_options()->opt('person_bank_name'),
                    $is_legal ? leyka_options()->opt('org_bank_bic') : leyka_options()->opt('person_bank_bic'),
                    $is_legal ? leyka_options()->opt('org_bank_corr_account') : leyka_options()->opt('person_bank_corr_account'),
                    get_bloginfo('name'),
                    home_url(),
                    $is_legal ? leyka_options()->opt('org_full_name') : leyka_options()->opt('person_full_name'),
                    $is_legal ? leyka_options()->opt('org_short_name') : leyka_options()->opt('person_full_name'),
                ],
            ],
            'pdKeys' => [
                [
                    '#LEGAL_NAME#',
                    '#LEGAL_ADDRESS#',
                    '#SITE_URL#',
                    '#PD_TERMS_PAGE_URL#',
                    '#ADMIN_EMAIL#',
                ],
                [
                    $is_legal ? leyka_options()->opt('org_full_name') : leyka_options()->opt('person_full_name'),
                    $is_legal ? leyka_options()->opt('org_address') : leyka_options()->opt('person_address'),
                    home_url(),
                    leyka_get_terms_of_pd_usage_page_url(),
                    get_option('admin_email'),
                ],
            ],
        ]);

    }
}

function leyka_is_donor_account() {

    if( !leyka()->opt('donor_accounts_available') ) {
        return false;
    }

    return stristr($_SERVER['REQUEST_URI'], 'donor-account') !== false;

}

function leyka_get_upload_max_filesize() {

    if(defined('WP_MEMORY_LIMIT')) {
        $max_filesize = WP_MEMORY_LIMIT;
    } else {
        $max_filesize = ini_get('upload_max_filesize');
    }

    return $max_filesize;

}

function leyka_use_leyka_campaign_template($template) {

    $campaign_id = null;

    if(is_singular(Leyka_Campaign_Management::$post_type)) {
        $campaign_id = get_post()->ID;
    } else if(is_page(leyka_options()->opt('success_page')) || is_page(leyka_options()->opt('failure_page'))) {

        $donation_id = leyka_remembered_data('donation_id');
        $donation = $donation_id ? Leyka_Donations::get_instance()->get($donation_id) : null;
        $campaign_id = $donation ? $donation->campaign_id : null;

    }

    if($campaign_id) {

        $campaign = leyka_get_validated_campaign($campaign_id);

        if($campaign && $campaign->campaign_type === 'persistent' && $campaign->template === 'star') {
            $template = apply_filters(
                'leyka_persistent_campaign_template_address',
                LEYKA_PLUGIN_DIR.'templates/campaign/type-persistent.php'
            );
        }

    }

    return $template;

}
add_filter('single_template', 'leyka_use_leyka_campaign_template', 10, 1);
add_filter('page_template', 'leyka_use_leyka_campaign_template', 10, 1);

function leyka_get_website_tech_support_email() {

    // Warning: don't use leyka_options()->opt() here - this function is used on the first options meta controller call
    $leyka_tech_support_email = Leyka_Options_Controller::get_option_value('tech_support_email');

    return $leyka_tech_support_email ? : get_option('admin_email');

}

function leyka_get_recurring_subscription_cancelling_reasons() {
    return [
        'uncomfortable_pm' => __('Unconfortable payment method', 'leyka'),
        'too_much' => __('Too much donation', 'leyka'),
        'not_match' => __('Does not meet my interests', 'leyka'),
        'better_use' => __('I have found better use of money', 'leyka'),
        'other' => __('Other reason', 'leyka'),
    ];
}

/** @todo ATM the function doesn't support sep-Ds. Refactor it */
function get_donor_init_recurring_donation_for_campaign($donor_user, $campaign_id) {

    $donations = new WP_Query([
        'post_type' => Leyka_Donation_Management::$post_type,
        'post_status' => 'funded',
        'post_parent' => 0,
        'meta_query' => [
            'relation' => 'AND',
            ['key' => 'leyka_payment_type', 'value' => 'rebill'],
            ['key' => 'leyka_campaign_id', 'value' => $campaign_id],
            [
                'relation' => 'OR',
                ['key' => 'leyka_recurrents_cancelled', 'value' => false],
                ['key' => 'leyka_recurrents_cancelled', 'compare' => 'NOT EXISTS'],
            ],
            [
                'relation' => 'OR',
                ['key' => 'leyka_cancel_recurring_requested', 'value' => false],
                ['key' => 'leyka_cancel_recurring_requested', 'compare' => 'NOT EXISTS'],
            ],
            [
                'relation' => 'OR',
                ['key' => 'leyka_donor_email', 'value' => $donor_user->user_email],
                ['key' => 'leyka_donor_account', 'value' => $donor_user->ID],
            ],
        ],
        'posts_per_page' => 1,
        'orderby' => 'ID',
        'order'   => 'ASC',
    ]);

    return $donations->have_posts() ? Leyka_Donations::get_instance()->get_donation($donations->posts[0]) : null;

}

function leyka_get_dm_list_or_alternatives() {

    $dm_list = [];

    foreach(explode(',', leyka_options()->opt('leyka_donations_managers_emails')) as $email) {
        if($email) {
            $dm_list[] = $email;
        }
    }

    if( !$dm_list ) {

        $alt_emails = [leyka()->opt('tech_support_email'), get_bloginfo('admin_email'),];

        foreach($alt_emails as $alt_email) {

            $alt_email = trim($alt_email);
            if($alt_email) {
                $dm_list[] = $alt_email;
                break;
            }

        }

    }

    return $dm_list;

}

/** Service function to prepare a singular object data value for export as a CSV cell. */
function leyka_export_data_prepare($text) {
    return str_replace(['"'], [''], $text);
}

/** A service class - to use meta queries (à la WP_Query) with separate-stored Donations. */
class Leyka_Donations_Meta_Query extends WP_Meta_Query {

    public function get_sql( $type = null, $primary_table = null, $primary_id_column = null, $context = null ) {

        global $wpdb;

        $this->table_aliases = [];

        $this->meta_table = $wpdb->prefix.'leyka_donations_meta';
        $this->meta_id_column = sanitize_key('donation_id');

        $this->primary_table = $primary_table ? : $wpdb->prefix.'leyka_donations';
        $this->primary_id_column = $primary_id_column ? : 'ID';

        $sql = $this->get_sql_clauses();

        /*
         * If any JOINs are LEFT JOINs (as in the case of NOT EXISTS), then all JOINs should
         * be LEFT. Otherwise, posts with no metadata will be excluded from results.
         */
        if ( false !== strpos( $sql['join'], 'LEFT JOIN' ) ) {
            $sql['join'] = str_replace( 'INNER JOIN', 'LEFT JOIN', $sql['join'] );
        }

        return $sql;

    }

}

/** A service class - to use date queries (à la WP_Query) with separate-stored Donations. */
class Leyka_Donations_Date_Query extends WP_Date_Query {

    public function __construct($date_query, $default_column = 'post_date') {

        global $wpdb;
        $default_column = $wpdb->prefix.'leyka_donations.date_created';

        parent::__construct($date_query, $default_column);

    }

}

// By default, wp_attachment_is() doesn't treat SVGs as images. It's a f*ckin oppression, we think.
if( !function_exists('leyka_attachment_is') ) {
    function leyka_attachment_is($type, $attachment = null) {

        if($type !== 'image') {
            return wp_attachment_is($type, $attachment);
        }

        $attachment = get_post($attachment);
        if( !$attachment ) {
            return false;
        }

        $file = get_attached_file($attachment->ID);
        if( !$file ) {
            return false;
        }

        $check = wp_check_filetype($file);

        return empty($check['ext']) ? false : in_array($check['ext'], ['jpg', 'jpeg', 'jpe', 'gif', 'png', 'svg',]);

    }
}

if( !function_exists('leyka_delete_dir') ) {
    /**
     * Recursively delete given directory & all it's files.
     *
     * @param $path string Absolute path to dir.
     * @return boolean True if deletion succeeded, false otherwise.
     */
    function leyka_delete_dir($path) {

        if(leyka_options()->opt('plugin_debug_mode')) {
            return file_exists($path) && is_dir($path);
        }

        if( !$path || $path === '/' ) {
            return false;
        }
        // phpcs:ignore WordPress.WP.AlternativeFunctions.file_system_operations_rmdir
        return is_file($path) ? wp_delete_file($path) : (array_map(__FUNCTION__, glob($path.'/*')) == @rmdir($path));

    }
}

/** @todo Move the function to the special GA integration class */
if( !function_exists('leyka_gua_generate_uuid') ) {
    function leyka_gua_generate_uuid() {
        return '1234567890.1234567890';
    }
}

/** @todo Move the function to the special GA integration class */
if( !function_exists('leyka_gua_get_client_id') ) {
    function leyka_gua_get_client_id() {

        if( !empty($_COOKIE['_ga']) ) {

            list($version, $domain_depth, $cid1, $cid2) = explode('.', $_COOKIE['_ga'], 4);

            $contents = ['version' => $version, 'domainDepth' => $domain_depth, 'cid' => $cid1.'.'.$cid2,];
            $cid = $contents['cid'];

        } else {
            $cid = leyka_gua_generate_uuid();
        }

        return $cid;

    }
}

if( !function_exists('leyka_get_client_ip') ) {
    function leyka_get_client_ip() {

        $client_ip = getenv('HTTP_CLIENT_IP') ? :
            getenv('HTTP_X_FORWARDED_FOR') ? :
                getenv('HTTP_X_FORWARDED') ? :
                    getenv('HTTP_FORWARDED_FOR') ? :
                        getenv('HTTP_FORWARDED') ? :
                            getenv('REMOTE_ADDR');

        $client_ip = is_array($client_ip) ? reset($client_ip) : $client_ip;

        return trim($client_ip);

    }
}

/** Some gateways give their callbacks IPs only as CIDR ranges. */
if( !function_exists('is_ip_in_range') ) {
    function is_ip_in_range($ip, $range) {

        $range .= strpos(trim($range), '/') == false ? '/32' : ''; // No CIDR range is given, add the default one

        list($net, $mask) = explode('/', $range);

        $ip_net = ip2long($net);
        $ip_mask = ~((1 << (32 - $mask)) - 1);

        $ip_ip = ip2long($ip);

        $ip_ip_net = $ip_ip & $ip_mask;

        return $ip_ip_net == $ip_net;

    }
}

if( !function_exists('leyka_get_donations_storage_type') ) {
    function leyka_get_donations_storage_type() {
        return in_array(get_option('leyka_donations_storage_type'), ['sep', 'sep-incompleted']) ? 'sep' : 'post';
    }
}

function leyka_generate_csv($filename, array $rows, array $headings = [], $column_sep = "\t", $line_sep = "\n") {

    // 1. Use tab as column separator:
    $fputcsv = count($headings) ? '"'.implode('"'.$column_sep.'"', $headings).'"'.$line_sep : '';

    // 2. Loop over the * to export:
    if($rows) {
        foreach($rows as $row_array) {

            array_walk($row_array, function(&$item){ $item = leyka_export_data_prepare($item); });

            $fputcsv .= '"'.implode('"'.$column_sep.'"', $row_array).'"'.$line_sep;

        }
    }

    // 3. Output CSV-specific headers:
    header('Content-type: application/vnd.ms-excel');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Pragma: no-cache');
    header('Content-Disposition: attachment; filename="'.$filename.'.csv"');


    echo chr(255) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        .chr(254) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
        .mb_convert_encoding( // 4. PHP array, converted to string - encode it into UTF-16
            $fputcsv,
            apply_filters('leyka_export_content_charset', 'UTF-16LE'),
            'UTF-8'
        );

    exit;

}

if( !function_exists('leyka_get_random_string') ) {
    function leyka_get_random_string($length = 6) {

        $permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyz';
        $result = '';

        for($i = 0; $i < $length; $i++) {
            // phpcs:ignore WordPress.WP.AlternativeFunctions.rand_mt_rand
            $result .= $permitted_chars[ mt_rand(0, strlen($permitted_chars) - 1) ];
        }

        return $result;

    }
}

if( !function_exists('leyka_str_to_translit') ) {
    function leyka_str_to_translit($string) {

        $chars = ["а" => "a", "б"=> "b", "в"=> "v", "г"=> "g", "д"=> "d", "е"=> "e", "ё"=> "yo", "ж"=> "zh", "з"=> "z",
            "и"=> "i", "й"=> "j", "к"=> "k", "л"=> "l", "м"=> "m", "н"=> "n", "о"=> "o", "п"=> "p", "р"=> "r", "с"=> "s",
            "т"=> "t", "у"=> "u", "ф"=> "f", "х"=> "kh", "ц"=> "cz", "ч"=> "ch", "ш"=> "sh", "щ"=> "shh", "ъ"=> "qq",
            "ы"=> "y", "ь"=> "q", "э"=> "ie", "ю"=> "yu", "я"=> "ya", "А"=> "A", "Б"=> "B", "В"=> "V", "Г"=> "G",
            "Д"=> "D", "Е"=> "E", "Ё"=> "Yo", "Ж"=> "Zh", "З"=> "Z", "И"=> "I", "Й"=> "J", "К"=> "K", "Л"=> "L",
            "М"=> "M", "Н"=> "N", "О"=> "O", "П"=> "P", "Р"=> "R", "С"=> "S", "Т"=> "T", "У"=> "U", "Ф"=> "F",
            "Х"=> "Kh", "Ц"=> "Cz","Ч"=> "Ch","Ш"=> "Sh", "Щ"=> "Shh", "Ъ"=> "QQ", "Ы"=> "Y", "Ь"=> "Q", "Э"=> "IE",
            "Ю"=> "Yu", "Я"=> "Ya"];

        $cyr = array_keys($chars);
        $lat = array_keys(array_flip($chars));

        return str_replace($cyr, $lat, $string);

    }
}

if( !function_exists('leyka_is_email') ) {
    function leyka_is_email($email) {
        return is_email(leyka_str_to_translit($email));
    }
}

if( !function_exists('leyka_email_to_punycode') ) {
    function leyka_email_to_punycode($email) {

        $email_array = explode('@', $email);

        if( !leyka_validate_email($email) || count($email_array) < 2 ) {
            return $email;
        }

        require_once LEYKA_PLUGIN_DIR.'/lib/class-punycode.php';

        return $email_array[0].'@'.Punycode::encodeHostName($email_array[1]);

    }
}

/** Static text options fields content: */
if( !function_exists('leyka_get_active_recurring_setup_help_content') ) {
    function leyka_get_active_recurring_setup_help_content() {

        return '<ul>'
            .'<li>'
                .__('Copy your procedure absolute address:', 'leyka')
                .'<p><code>'.LEYKA_PLUGIN_DIR.'procedures/leyka-active-recurring.php</code></p>'
            .'</li>'
            .'<li>'
                .sprintf(__('Set the Cron job to call the procedure nightly (<a href="%s" target="_blank" class="leyka-outer-link">user manual for setting up Cron jobs</a>, chapter 3)', 'leyka'), 'https://leyka.org/docs/yandex-kassa-recurring/')
            .'</li>'
        .'</ul>';

    }
}
/** Static text options fields content - END */

function leyka_url_exists($url) {
    return stripos(get_headers($url)[0], '200 OK') !== false;
}

/** Count interval dates for portlets */
function leyka_count_interval_dates($interval) {

    $interval = empty($interval) ? '365 day' : $interval;

    if(strpos($interval, 'this') === false) {

        switch($interval) {
            case 'days_365': $interval = '365 day'; break;
            case 'days_180': $interval = '180 day'; break;
            case 'days_90': $interval = '90 day'; break;
            case 'days_30': $interval = '30 day'; break;
            case 'days_7': $interval = '7 day'; break;
            default: $interval = '365 day';
        }

        $curr_interval_begin_date = gmdate('Y-m-d 23:59:59', strtotime('-'.$interval));
        $prev_interval_begin_date = gmdate('Y-m-d 23:59:59', strtotime('-'.$interval, strtotime('-'.$interval)));
        $curr_interval_end_date = gmdate('Y-m-d 23:59:59');

    } else {

        switch($interval) {

            case 'this_year':

                $curr_interval_begin_date = gmdate('Y-m-d 23:59:59', strtotime('31-12-'.(gmdate('Y') - 1)));
                $prev_interval_begin_date = gmdate('Y-m-d 23:59:59', strtotime('31-12-'.(gmdate('Y') - 2)));
                $curr_interval_end_date = gmdate('Y-m-d 23:59:59', strtotime('31-12-'.gmdate('Y')));
                break;

            case 'this_half_year':

                $curr_interval_begin_date = gmdate('Y-m-d 23:59:59',
                    strtotime(gmdate('m') < 7 ? '31-12-'.(gmdate('Y') - 1) : '30-06-'.(gmdate('Y'))));
                $prev_interval_begin_date = gmdate('Y-m-d 23:59:59',
                    strtotime(gmdate('m') < 7 ? '30-06-'.(gmdate('Y') - 1) : '31-12-'.(gmdate('Y') - 1)));
                $curr_interval_end_date = gmdate('Y-m-d 23:59:59',
                    strtotime(gmdate('m') < 7 ? '30-06-'.gmdate('Y') : '31-12-'.gmdate('Y')));
                break;

            case 'this_quarter':

                $current_month = gmdate("m");
                if($current_month < 4) {
                    $date_from_month = '01';
                    $date_to_month = '04';
                } else if($current_month < 7) {
                    $date_from_month = '04';
                    $date_to_month = '07';
                } else if($current_month < 10) {
                    $date_from_month = '07';
                    $date_to_month = '10';
                } else {
                    $date_from_month = '10';
                    $date_to_month = '01';
                }

                $date_prev_from_month = $date_from_month == '01' ? '10' : '0'.($date_from_month - 3);

                $curr_interval_begin_date = gmdate('Y-m-d 23:59:59',
                    strtotime('- 1 day', strtotime('01-'.$date_from_month.'-'.gmdate('Y'))));
                $prev_interval_begin_date = gmdate('Y-m-d 23:59:59',
                    strtotime('- 1 day', strtotime('01-'.$date_prev_from_month.'-'.( $date_prev_from_month == '10' ? gmdate('Y') - 1 : gmdate('Y')))));
                $curr_interval_end_date = gmdate('Y-m-d 23:59:59',
                    strtotime('- 1 day', strtotime('01-'.$date_to_month.'-'.( $date_to_month == '01' ? gmdate('Y') + 1 : gmdate('Y')))));

                break;

            case 'this_month':

                $curr_interval_begin_date = gmdate('Y-m-d 23:59:59',
                    strtotime('- 1 day', strtotime('01-'.gmdate('m').'-'.gmdate('Y'))));
                $prev_interval_begin_date = gmdate('Y-m-d 23:59:59',
                    strtotime('- 1 day', strtotime('01-'.(gmdate('m') == 1 ? 12 : gmdate('m') - 1).'-'.(gmdate('m') == 1 ? gmdate('Y') - 1 : gmdate('Y')))));
                $curr_interval_end_date = gmdate('Y-m-d 23:59:59',
                    strtotime('- 1 day', strtotime('01-'.(gmdate('m') == 12 ? 1 : gmdate('m') + 1).'-'.(gmdate('m') == 12 ? gmdate('Y') + 1 : gmdate('Y')))));
                break;

            case 'this_week':

                $curr_interval_begin_date = gmdate('Y-m-d 23:59:59', strtotime('- 1 day', strtotime('Monday this week')));
                $prev_interval_begin_date = gmdate('Y-m-d 23:59:59', strtotime('- 1 day', strtotime('Monday previous week')));
                $curr_interval_end_date = gmdate('Y-m-d 23:59:59', strtotime('- 1 day', strtotime('Monday next week')));
                break;

        }

    }

    return [
        'curr_interval_begin_date' => $curr_interval_begin_date,
        'prev_interval_begin_date' => $prev_interval_begin_date,
        'curr_interval_end_date' => $curr_interval_end_date
    ];

}

/** Set transient */
function leyka_set_transient($name, $value, $expiration_date = null) {

    $expiration = $expiration_date ? strtotime($expiration_date) - time() : strtotime('tomorrow') - time();

    return set_transient($name, $value, $expiration);

}

/**
 * Function to get rates for one or all currencies
 *
 * @param $currencies_ids
 * @return array
 */
function leyka_get_currencies_rates($currencies_ids = []) {

    if(empty($currencies_ids)) {
        $currencies_ids = array_keys(leyka_get_main_currencies_full_info());
    }

    $rates = [];

    foreach($currencies_ids as $currency_id) {
        $rates[$currency_id] = leyka_options()->opt("leyka_currency_{$currency_id}_exchange_rate");
    }

    return $rates;

}

/**
 * Higl-level function to get currency rate
 *
 * @param $currency_id
 * @return mixed
 */
function leyka_get_currency_rate($currency_id) {

    $result = leyka_get_currencies_rates([$currency_id]);

    return $result[$currency_id];

}


/**
 * Function to convert amount from one currency to another (to main if not specified)
 *
 * @param $currency_amount
 * @param $from_currency_id
 * @param $to_currency_id
 * @return false|float|int
 */
function leyka_currency_convert($currency_amount, $from_currency_id, $to_currency_id = null) {

    if (empty($currency_amount) || empty($from_currency_id)) {
        return false;
    }

    $amount = $currency_amount / leyka_get_currency_rate(strtolower($from_currency_id));

    if($to_currency_id) {
        $amount = $amount * leyka_get_currency_rate(strtolower($to_currency_id));
    }

    return $amount;

}

/**
 * Function to refresh currencies rates from "exchangerate" service
 *
 * @return false|mixed|void
 */
function leyka_refresh_currencies_rates() {

    $currencies_info = leyka_get_main_currencies_full_info();
    $currencies_list = strtoupper(implode(',', array_keys($currencies_info)));
    $main_currency = leyka_get_main_currency();

    $req_url = 'https://api.exchangerate.host/latest?base='.$main_currency.'&symbols='.$currencies_list;
    // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
    $response_json = file_get_contents($req_url);

    if(false !== $response_json) {
        try {

            $response = json_decode($response_json, true);

            if($response['success'] === true) {

                foreach($response['rates'] as $currency_id => $currency_rate) {
                    leyka_options()->opt("leyka_currency_".strtolower($currency_id)."_exchange_rate", $currency_rate);
                }

                return $response['rates'];

            } else {
                return false;
            }

        } catch(Exception $e) {
            return false;
        }
    }

}

/**
 * Service function to update all campaigns numbers taking actual currency
 *
 * @param $real_recount
 * @return void
 */
function leyka_actualize_campaigns_money_values($real_recount = false) {

    $query_params = [
        'post_type' => Leyka_Campaign_Management::$post_type,
        'posts_per_page' => -1,
        'post_status' => 'any'
    ];

    $campaigns_data = new WP_Query($query_params);

    foreach($campaigns_data->posts as $campaign_data) {
        leyka_actualize_campaign_money_values($campaign_data->ID, $real_recount);
    }

}

/**
 * Service function to update single campaign numbers taking actual currency
 *
 * @param $campaign_id
 * @param $real_recount
 * @return false|void
 */
function leyka_actualize_campaign_money_values($campaign_id, $real_recount = false) {

    $campaign = new Leyka_Campaign($campaign_id);

    if( !$campaign || $campaign->currency === leyka_get_main_currency() ){
        return false;
    }

    if( !empty($campaign->target) || $campaign->target !== 'no_target' ) {
        $campaign->target = round(leyka_currency_convert($campaign->target, $campaign->currency));
    }

    if($real_recount) {
        $campaign->update_total_funded_amount();
    } else {
        $campaign->total_funded = round(leyka_currency_convert($campaign->total_funded, $campaign->currency), 2);
    }

    $campaign->currency = leyka_get_main_currency();

}

/**
 * Service function to drop all dashboard portlets cache
 *
 * @return void
 */
function leyka_clear_dashboard_cache() {

    global $wpdb;

    // TODO Vyacheslav - add code to the 'separate' donations storage case
    $wpdb->get_results(
        "DELETE FROM `{$wpdb->prefix}options` WHERE option_name LIKE '%transient_timeout_leyka_stats_donations%' OR option_name LIKE '%transient_leyka_stats_donations%'",
        'ARRAY_A');

}

/**
 * Get html from svg file
 */
function leyka_get_svg( $file_path = '' ) {
    if ( ! $file_path ) {
        return;
    }

    global $wp_filesystem;

    if( ! $wp_filesystem ){
        require_once ABSPATH . 'wp-admin/includes/file.php';
        WP_Filesystem();
    }

    $svg = '';

    if ( $wp_filesystem->exists( $file_path ) && $wp_filesystem->is_file( $file_path ) ) {
        $svg = $wp_filesystem->get_contents( $file_path );
        return $svg;
    }

    return false;
}

/**
 * Get file content
 */
function leyka_get_file_content( $file_path = '' ) {
    if ( ! $file_path ) {
        return;
    }

    global $wp_filesystem;

    if( ! $wp_filesystem ){
        require_once ABSPATH . 'wp-admin/includes/file.php';
        WP_Filesystem();
    }

    $content = '';

    if ( $wp_filesystem->exists( $file_path ) && $wp_filesystem->is_file( $file_path ) ) {
        $content = $wp_filesystem->get_contents( $file_path );
        return $content;
    }

    return false;
}
