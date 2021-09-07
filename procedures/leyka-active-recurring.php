<?php /** The default procedure of doing all active recurring donations of the currenct date. */

require_once 'procedures-common.php';

if( !defined('WPINC') ) die;

// The method should be called no more than once per day:
if(get_transient('leyka_last_active_recurring_date') === date('d.m.Y') && !leyka_options()->opt('plugin_debug_mode')) {
    return;
} else {
    set_transient('leyka_last_active_recurring_date', date('d.m.Y'), 60*60*24);
}

ini_set('max_execution_time', 0);
set_time_limit(0);
ini_set('memory_limit', 536870912); // 512 Mb, just in case

// Get all active initial donations for the recurring subscriptions:
$current_day = (int)date('j');
$max_days_in_month = (int)date('t');
$current_day_param = array('relation' => 'AND',);
if( !leyka_options()->opt('plugin_debug_mode') ) { // In production mode, rebill only subscriptions older than 1 full day
    $current_day_param[] = array('before' => '-1 day');
}
$current_day_param[] = $max_days_in_month < 31 && $max_days_in_month === $current_day ? // Last day of short month
    array(array('day' => $current_day, 'compare' => '>='), array('day' => 31, 'compare' => '<=')) :
    array(array('day' => (int)date('j')));

$donations = Leyka_Donations::get_instance()->get(array(
    'status' => 'funded',
    'recurring_only_init' => true,
    'recurring_active' => true,
    'pm_full_id' => array_keys(leyka_get_active_recurring_pm_list()),
    'get_all' => true,
));

foreach($donations as $init_recurring_donation) {

    $gateway = leyka_get_gateway_by_id($init_recurring_donation->gateway_id);
    if($gateway) {

        $new_recurring_donation = $gateway->do_recurring_donation($init_recurring_donation);
        if($new_recurring_donation && is_a($new_recurring_donation, 'Leyka_Donation_Base')) {
            Leyka_Donation_Management::send_all_recurring_emails($new_recurring_donation);
        } // else if( !$new_recurring_donation || is_wp_error($new_recurring_donation) ) { ... } /** @todo Log & handle error */

    }

}