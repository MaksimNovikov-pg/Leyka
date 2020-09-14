<?php if( !defined('WPINC') ) die;
/**
 * Leyka_Yandex_Gateway class
 */

class Leyka_Yandex_Gateway extends Leyka_Gateway {

    protected static $_instance;

    protected $_new_api_redirect_url = '';

    protected function _set_attributes() {

        $this->_id = 'yandex';
        $this->_title = __('Yandex.Kassa', 'leyka');

        $this->_description = apply_filters(
            'leyka_gateway_description',
            __('Yandex.Kassa allows a simple and safe way to pay for goods and services with bank cards through internet. You will have to fill a payment form, you will be redirected to the <a href="https://money.yandex.ru/">Yandex.Kassa website</a> to enter your bank card data and to confirm your payment.', 'leyka'),
            $this->_id
        );

        $this->_docs_link = '//leyka.te-st.ru/docs/yandex-dengi/';
        $this->_registration_link = 'https://kassa.yandex.ru/joinups';
        $this->_has_wizard = true;

        $this->_min_commission = 2.8;
        $this->_receiver_types = array('legal');
        $this->_may_support_recurring = true;

    }

    protected function _set_options_defaults() {

        if($this->_options) { // Create Gateway options, if needed
            return;
        }

        $this->_options = array(
            $this->_id.'_new_api' => array(
                'type' => 'checkbox',
                'default' => true,
                'title' => __('Use Yandex.Kassa new API', 'leyka'),
                'comment' => __('Check if your Yandex.Kassa connection uses the new API', 'leyka'),
                'short_format' => true,
            ),
            $this->_id.'_shop_id' => array(
                'type' => 'text',
                'title' => __('ShopID', 'leyka'),
                'comment' => __('Please, enter your Yandex.Kassa shopID here. It can be found in your Yandex contract and in your .', 'leyka'),
                'required' => true,
                'placeholder' => sprintf(__('E.g., %s', 'leyka'), '12345'),
            ),
            $this->_id.'_scid' => array(
                'type' => 'text',
                'title' => __('ScID', 'leyka'),
                'comment' => __('Please, enter your Yandex.Kassa shop showcase ID (SCID) here. It can be found in your Yandex contract.', 'leyka'),
                'required' => true,
                'placeholder' => sprintf(__('E.g., %s', 'leyka'), '12345'),
                'field_classes' => array('old-api'),
            ),
            $this->_id.'_shop_article_id' => array(
                'type' => 'text',
                'title' => __('ShopArticleID', 'leyka'),
                'comment' => __('Please, enter your Yandex.Kassa shop article ID here, if it exists. It can be found in your Yandex contract, also you can ask your Yandex.Kassa manager for it.', 'leyka'),
                'placeholder' => sprintf(__('E.g., %s', 'leyka'), '12345'),
                'field_classes' => array('old-api'),
            ),
            $this->_id.'_shop_password' => array(
                'type' => 'text',
                'title' => __('shopPassword', 'leyka'),
                'comment' => __("Please, enter a shopPassword parameter value that you filled in Yandex.Kassa technical questionaire. If it's set, Leyka will perform MD5 hash checks of each incoming donation data integrity.", 'leyka'),
                'placeholder' => sprintf(__('E.g., %s', 'leyka'), '1^2@3#&84nDsOmE5h1T'),
                'is_password' => true,
                'field_classes' => array('old-api'),
            ),
            $this->_id.'_secret_key' => array(
                'type' => 'text',
                'title' => __('Secret key for API', 'leyka'),
                'comment' => __("Please, enter a secret key parameter value that you filled in Yandex.Kassa technical questionaire. If it's set, Leyka will perform MD5 hash checks of each incoming donation data integrity. More information  <a href='https://kassa.yandex.ru/help/merchant/keys.html' target='_blank'>here</a>.", 'leyka'),
                'required' => true,
                'placeholder' => sprintf(__('E.g., %s', 'leyka'), 'test_OkT0flRaEnS0fWqMFZuTg01hu_8SxSkxZuAVIw7CMgB'),
                'is_password' => true,
                'field_classes' => array('new-api'),
            ),
            $this->_id.'_test_mode' => array(
                'type' => 'checkbox',
                'default' => true,
                'title' => __('Payments testing mode', 'leyka'),
                'comment' => __('Check if the gateway integration is in test mode.', 'leyka'),
                'short_format' => true,
                'field_classes' => array('old-api'),
            ),
        );

    }

    public function is_setup_complete($pm_id = false) {
        if(leyka_options()->opt('yandex_new_api')) {
            return leyka_options()->opt('yandex_shop_id') && leyka_options()->opt('yandex_secret_key');
        } else {
            return leyka_options()->opt('yandex_shop_id') && leyka_options()->opt('yandex_scid');
        }
    }

    protected function _initialize_pm_list() {

        if(empty($this->_payment_methods['yandex_all'])) {
            $this->_payment_methods['yandex_all'] = Leyka_Yandex_All::get_instance();
        }
        if(empty($this->_payment_methods['yandex_card'])) {
            $this->_payment_methods['yandex_card'] = Leyka_Yandex_Card::get_instance();
        }
        if(empty($this->_payment_methods['yandex_money'])) {
            $this->_payment_methods['yandex_money'] = Leyka_Yandex_Money::get_instance();
        }
        if(empty($this->_payment_methods['yandex_wm'])) {
            $this->_payment_methods['yandex_wm'] = Leyka_Yandex_Webmoney::get_instance();
        }
        if(empty($this->_payment_methods['yandex_sb'])) {
            $this->_payment_methods['yandex_sb'] = Leyka_Yandex_Sberbank_Online::get_instance();
        }
        if(empty($this->_payment_methods['yandex_ab'])) {
            $this->_payment_methods['yandex_ab'] = Leyka_Yandex_Alpha_Click::get_instance();
        }
        if(empty($this->_payment_methods['yandex_pb'])) {
            $this->_payment_methods['yandex_pb'] = Leyka_Yandex_Promvzyazbank::get_instance();
        }

    }

    public function process_form($gateway_id, $pm_id, $donation_id, $form_data) {

        $donation = new Leyka_Donation($donation_id);

        if( !empty($form_data['leyka_recurring']) ) {

            $donation->payment_type = 'rebill';
            $donation->recurring_is_active = true; // So we could turn it on/off later

        }

        if(leyka_options()->opt('yandex_new_api')) {

            require_once LEYKA_PLUGIN_DIR.'gateways/yandex/lib/autoload.php';

            $client = new YandexCheckout\Client();
            $client->setAuth(leyka_options()->opt('yandex_shop_id'), leyka_options()->opt('yandex_secret_key'));

            try {

                $payment_data = array(
                    'amount' => array(
                        'value' => round($form_data['leyka_donation_amount'], 2),
                        'currency' => 'RUB', /** @todo Change to $form_data[leyka_donation_currency], but fix "rur" -> "RUB" */
                    ),
                    'confirmation' => array(
                        'type' => 'redirect',
                        'return_url' => empty($form_data['leyka_success_page_url']) ?
                            leyka_get_success_page_url() : $form_data['leyka_success_page_url'],
                    ),
                    'capture' => true, // Make payment at once, don't wait for shop confirmation
                    'description' =>
                        ( !empty($form_data['leyka_recurring']) ? _x('[RS]', 'For "recurring subscription"', 'leyka').' ' : '' )
                        .$donation->payment_title." (№ $donation_id)",
                    'metadata' => array('donation_id' => $donation_id,),
                    'save_payment_method' => !empty($form_data['leyka_recurring']),
                );
                if($pm_id !== 'yandex_all') {
                    $payment_data['payment_method_data'] = array(
                        'type' => $this->_get_gateway_pm_id($pm_id),
                    );
                }

                $payment = $client->createPayment($payment_data, uniqid('', true));

                $donation->add_gateway_response($payment); // On callback the response will be re-written

                if( !empty($form_data['leyka_recurring']) ) {
                    $donation->recurring_id = $payment->id;
                }

                $this->_new_api_redirect_url = $payment->confirmation->confirmation_url;

            } catch(Exception $ex) {

                $donation->add_gateway_response($ex);

                leyka()->add_payment_form_error( new WP_Error('leyka_donation_error', sprintf(__('Error while processing the payment: %s. Your money will remain intact. Please report to the <a href="mailto:%s" target="_blank">website tech support</a>.', 'leyka'), $ex->getMessage(), leyka_get_website_tech_support_email())) );
                return;

            }

        } else { // Old API - for backward compatibility

            if(
                $pm_id === 'yandex_sb'
                && $form_data['leyka_donation_currency'] == 'rur'
                && $form_data['leyka_donation_amount'] < 10.0
            ) {

                leyka()->add_payment_form_error(new WP_Error('leyka_donation_amount_too_small', __('The amount of donations via Sberbank Online should be at least 10 RUB.', 'leyka')));
                return;

            }

        }

    }

    public function submission_redirect_type($redirect_type, $pm_id, $donation_id) {
        return leyka_options()->opt('yandex_new_api') ? 'redirect' : $redirect_type;
    }

    public function submission_redirect_url($current_url, $pm_id) {

        if(leyka_options()->opt('yandex_new_api')) {
            return $this->_new_api_redirect_url;
        }

        switch($pm_id) {
            case 'yandex_all':
            case 'yandex_money':
            case 'yandex_card':
            case 'yandex_wm':
                return leyka_options()->opt('yandex_test_mode') ?
                    'https://demomoney.yandex.ru/eshop.xml' : 'https://money.yandex.ru/eshop.xml';
            case 'yandex_sb':
            case 'yandex_ab':
            case 'yandex_pb':
                return 'https://money.yandex.ru/eshop.xml';
            default:
                return $current_url;
        }

    }

    public function submission_form_data($form_data, $pm_id, $donation_id) {

        // New Yandex.Kassa API doesn't require the data to be sent with redirect:
        if(leyka_options()->opt('yandex_new_api')) {
            return apply_filters('leyka_yandex_custom_submission_data', array(), $pm_id);
        }

        $donation = new Leyka_Donation($donation_id);

        $payment_type = $this->_get_gateway_pm_id($pm_id);
        $payment_type = $payment_type ? $payment_type : apply_filters('leyka_yandex_custom_payment_type', '', $pm_id);

        $data = array(
            'scid' => leyka_options()->opt('yandex_scid'),
            'shopId' => leyka_options()->opt('yandex_shop_id'),
            'sum' => $donation->amount,
            'customerNumber' => $donation->donor_email,
            'orderNumber' => $donation_id,
            'orderDetails' => $donation->payment_title." (№ $donation_id)",
            'paymentType' => $payment_type,
            'shopSuccessURL' => leyka_get_success_page_url(),
            'shopFailURL' => leyka_get_failure_page_url(),
            'cps_email' => $donation->donor_email,
            'cms_name' => 'wp-leyka', // Service parameter, added by Yandex request
        );
        if(leyka_options()->opt('yandex_shop_article_id')) {
            $data['shopArticleId'] = leyka_options()->opt('yandex_shop_article_id');
        }
        if( !empty($_POST['leyka_recurring']) ) {
            $data['rebillingOn'] = 'true';
        }

        return apply_filters('leyka_yandex_custom_submission_data', $data, $pm_id);

    }

    /** Wrapper method to answer the old API callbacks - checkOrder and paymentAviso type calls */
    private function _callback_answer($is_error = false, $callback_type = 'co', $message = '', $tech_message = '') {

        $is_error = !!$is_error;
        $tech_message = $tech_message ? $tech_message : $message;
        $callback_type = $callback_type == 'co' ? 'checkOrderResponse' : 'paymentAvisoResponse';

        if($is_error) {
            die('<?xml version="1.0" encoding="UTF-8"?><'.$callback_type.' performedDatetime="'.date(DATE_ATOM).'"
code="1000" invoiceId="'.$_POST['invoiceId'].'" shopId="'.leyka_options()->opt('yandex_shop_id').'" message="'.$message.'"
techMessage="'.$tech_message.'"/>');
        } else {
            die('<?xml version="1.0" encoding="UTF-8"?><'.$callback_type.' performedDatetime="'.date(DATE_ATOM).'" code="0" invoiceId="'.$_POST['invoiceId'].'" shopId="'.leyka_options()->opt('yandex_shop_id').'"/>');
        }

    }

    public function _handle_service_calls($call_type = '') {
        switch($call_type) {

            // New Yandex.Kassa API callbacks processing:
            case 'process':
            case 'response':
            case 'notify':

                require_once LEYKA_PLUGIN_DIR.'gateways/yandex/lib/autoload.php';

                $notification = json_decode(file_get_contents('php://input'), true);

                if(empty($notification['event'])) {
                    /** @todo Process the error somehow */
                    exit(500);
                }

                try {
                    $notification = ($notification['event'] === YandexCheckout\Model\NotificationEventType::PAYMENT_SUCCEEDED) ?
                        new YandexCheckout\Model\Notification\NotificationSucceeded($notification) :
                        new YandexCheckout\Model\Notification\NotificationWaitingForCapture($notification);
                } catch (Exception $e) {
                    /** @todo Process the error somehow */
                    exit(500);
                }

                $payment = $notification->getObject();
                $donation = new Leyka_Donation($payment->metadata->donation_id);

                if( !$donation ) {
                    /** @todo Process the error somehow */
                    exit(500);
                }

                $donation->add_gateway_response($payment);

                switch($payment->status) {
                    case 'succeeded':
                        $donation->status = 'funded';
                        Leyka_Donation_Management::send_all_emails($donation->id);

                        if( // GUA direct integration - "purchase" event:
                            leyka_options()->opt('use_gtm_ua_integration') === 'enchanced_ua_only'
                            && leyka_options()->opt('gtm_ua_tracking_id')
                            && in_array('purchase', leyka_options()->opt('gtm_ua_enchanced_events'))
                        ) {

                            require_once LEYKA_PLUGIN_DIR.'vendor/autoload.php';

                            $analytics = new TheIconic\Tracking\GoogleAnalytics\Analytics(true);
                            $analytics // Main params:
                                ->setProtocolVersion('1')
                                ->setTrackingId(leyka_options()->opt('gtm_ua_tracking_id'))
                                ->setClientId($donation->ga_client_id ? $donation->ga_client_id : leyka_gua_get_client_id())
                                // Transaction params:
                                ->setTransactionId($donation->id)
                                ->setAffiliation(get_bloginfo('name'))
                                ->setRevenue($donation->amount)
                                ->addProduct(array( // Donation params
                                    'name' => $donation->payment_title,
                                    'price' => $donation->amount,
                                    'brand' => get_bloginfo('name'), // Mb, it won't work with it
                                    'category' => $donation->type_label, // Mb, it won't work with it
                                    'quantity' => 1,
                                ))
                                ->setProductActionToPurchase()
                                ->setEventCategory('Checkout')
                                ->setEventAction('Purchase')
                                ->sendEvent();

                        }
                        // GUA direct integration - "purchase" event END

                        break;
                    case 'canceled':
                        $donation->status = 'failed';

                        if(leyka_options()->opt('notify_tech_support_on_failed_donations')) {
                            Leyka_Donation_Management::send_error_notifications($donation);
                        }

                        break;
                    case 'refund.succeeded':
                        $donation->status = 'refunded';
                        break;
                    default: // Also possible yandex payment statuses: 'pending', 'waiting_for_capture'
                }

                exit(200);

            // Old Yandex.Kassa API callbacks processing:
            case 'check_order':

                if($_POST['action'] != 'checkOrder') { // Payment isn't correct, we're not allowing it
                    $this->_callback_answer(1, 'co', __('Wrong service operation', 'leyka'));
                }

				if((int)$_POST['orderNumber'] <= 0) { // Recurring donation callback

					$_POST['orderNumber'] = explode('-', $_POST['orderNumber']);
                    if(
                        count($_POST['orderNumber']) == 3 &&
                        $_POST['orderNumber'][0] == 'recurring' &&
                        (int)$_POST['orderNumber'][2] > 0
                    ) {
                        $_POST['orderNumber'] = (int)$_POST['orderNumber'][2];
                    } else { // Order number is wrong
                        $_POST['orderNumber'] = false;
                    }

				} else { // Single donation callback
					$_POST['orderNumber'] = (int)$_POST['orderNumber'];
				}

                if( !$_POST['orderNumber'] ) {
                    $this->_callback_answer(1, 'co', __('Sorry, there is some tech error on our side. Your payment will be cancelled.', 'leyka'), __('OrderNumber is not set', 'leyka'));
                }

                $donation = new Leyka_Donation($_POST['orderNumber']);

                if($donation->sum != $_POST['orderSumAmount']) {
                    $this->_callback_answer(1, 'co', __('Sorry, there is some tech error on our side. Your payment will be cancelled.', 'leyka'), __('Donation sum is unmatched', 'leyka'));
                }

                $donation->add_gateway_response($_POST);

                $this->_callback_answer(); // OK for Yandex.Kassa payment
                break; // Not needed, just for my IDE could relax

            case 'payment_aviso':

                if($_POST['action'] != 'paymentAviso') { // Payment isn't correct, we're not allowing it
                    $this->_callback_answer(1, 'pa', __('Wrong service operation', 'leyka'));
                }

                if((int)$_POST['orderNumber'] <= 0) { // Recurring donation callback

					$_POST['orderNumber'] = explode('-', $_POST['orderNumber']);
                    if(
                        count($_POST['orderNumber']) == 3 &&
                        $_POST['orderNumber'][0] == 'recurring' &&
                        (int)$_POST['orderNumber'][2] > 0
                    ) {
                        $_POST['orderNumber'] = (int)$_POST['orderNumber'][2];
                    } else { // Order number is wrong
                        $_POST['orderNumber'] = false;
                    }

				} else { // Single donation callback
					$_POST['orderNumber'] = (int)$_POST['orderNumber'];
				}

                if( !$_POST['orderNumber'] ) {
                    $this->_callback_answer(1, 'pa', __('Sorry, there is some tech error on our side. Your payment will be cancelled.', 'leyka'), __('OrderNumber is not set', 'leyka'));
                }

                $donation = new Leyka_Donation($_POST['orderNumber']);

                if($donation->sum != $_POST['orderSumAmount']) {
                    $this->_callback_answer(1, 'pa', __('Sorry, there is some tech error on our side. Your payment will be cancelled.', 'leyka'), __('Donation sum is unmatched', 'leyka'));
                }

                if($donation->status !== 'funded') {

                    $donation->add_gateway_response($_POST);
                    $donation->status = 'funded';

                    // Change PM if needed. Mostly for Smart Payments:
                    if($_POST['paymentType'] != $this->_get_gateway_pm_id($donation->pm_id)) {
                        $donation->pm_id = $this->_get_gateway_pm_id($_POST['paymentType']);
                    }

                    if($donation->type === 'rebill' && !empty($_POST['invoiceId'])) {
                        $donation->recurring_id = $_POST['invoiceId'];
                    }

                    Leyka_Donation_Management::send_all_emails($donation->id);

                    if( // GUA direct integration - "purchase" event:
                        leyka_options()->opt('use_gtm_ua_integration') === 'enchanced_ua_only'
                        && leyka_options()->opt('gtm_ua_tracking_id')
                        && in_array('purchase', leyka_options()->opt('gtm_ua_enchanced_events'))
                    ) {

                        require_once LEYKA_PLUGIN_DIR.'vendor/autoload.php';

                        $analytics = new TheIconic\Tracking\GoogleAnalytics\Analytics(true);
                        $analytics // Main params:
                            ->setProtocolVersion('1')
                            ->setTrackingId(leyka_options()->opt('gtm_ua_tracking_id'))
                            ->setClientId($donation->ga_client_id ? $donation->ga_client_id : leyka_gua_get_client_id())
                            // Transaction params:
                            ->setTransactionId($donation->id)
                            ->setAffiliation(get_bloginfo('name'))
                            ->setRevenue($donation->amount)
                            ->addProduct(array( // Donation params
                                'name' => $donation->payment_title,
                                'price' => $donation->amount,
                                'brand' => get_bloginfo('name'), // Mb, it won't work with it
                                'category' => $donation->type_label, // Mb, it won't work with it
                                'quantity' => 1,
                            ))
                            ->setProductActionToPurchase()
                            ->setEventCategory('Checkout')
                            ->setEventAction('Purchase')
                            ->sendEvent();

                    }
                    // GUA direct integration - "purchase" event END

                }

				do_action('leyka_yandex_payment_aviso_success', $donation);

                $this->_callback_answer(0, 'pa'); // OK for yandex money payment
                break; // Not needed, just for my IDE could relax

            default:
				$this->_callback_answer(1, 'unknown', __('Unknown service operation', 'leyka'), 'Unknown callback type: '.$call_type);
        }
    }

    public function get_gateway_response_formatted(Leyka_Donation $donation) {

        if( !$donation->gateway_response ) {
            return array();
        }

        require_once LEYKA_PLUGIN_DIR.'gateways/yandex/lib/autoload.php';

        $response = is_object($donation->gateway_response) || is_array($donation->gateway_response) ?
            serialize($donation->gateway_response) : $donation->gateway_response;

        if(stristr($response, 'YandexCheckout')) { // New API

            $response = maybe_unserialize($response);

            if(
                is_a($response, 'YandexCheckout\Request\Payments\PaymentResponse')
                || is_a($response, 'YandexCheckout\Request\Payments\CreatePaymentResponse')
            ) { // Payment proceeded normally
                $response = array(
                    __('Yandex.Kassa payment ID:', 'leyka') => $response->id,
                    __('Yandex.Kassa payment status:', 'leyka') => $response->status,
                    __('Payment is done:', 'leyka') => !!$response->paid ? __('Yes') : __('No'),
                    __('Amount:', 'leyka') => round($response->amount->value, 2).' '
                        .leyka_get_currency_label($response->amount->currency),
                    __('Created at:', 'leyka') => leyka_get_i18n_datetime(strtotime($response->created_at->date)),
                    __('Captured at:', 'leyka') => empty($response->captured_at->date) ?
                        __('No') : leyka_get_i18n_datetime(strtotime($response->captured_at->date)),
                    __('Description:', 'leyka') => $response->description,
                    __('Payment method:', 'leyka') => empty($response->payment_method->title) ?
                        (empty($response->payment_method->type) ? __('No') : $response->payment_method->type) :
                        $response->payment_method->title,
//                    __('Is test payment:', 'leyka') => !!$response->test ? __('Yes') : __('No'),
                );
            } else if(is_a($response, 'Exception')) { // Exceptions were thrown
                $response = array(
                    __('Failure type:', 'leyka') => empty($response->type) ? __('unknown', 'leyka') : $response->type,
                    __('Failure code:', 'leyka') => $response->getCode(),
                    __('Failure message:', 'leyka') => $response->getMessage(),
                );
            }

        } else { // Old API

            $response = maybe_unserialize($donation->gateway_response);
            if( !$response ) {
                $response = array();
            } else if( !is_array($response) ) {
                $response = array('' => ucfirst($response));
            }

            $response = array(
                __('Last response operation:', 'leyka') => empty($response['action']) ?
                    __('Unknown', 'leyka') :
                    ($response['action'] == 'checkOrder' ? __('Donation confirmation', 'leyka') : __('Donation approval notice', 'leyka')),
                __('Gateway invoice ID:', 'leyka') => empty($response['invoiceId']) ? '' : $response['invoiceId'],
                __('Full donation amount:', 'leyka') => empty($response['orderSumAmount']) ?
                    '' : (float)$response['orderSumAmount'].' '.$donation->currency_label,
                __('Donation amount after gateway commission:', 'leyka') => empty($response['shopSumAmount']) ?
                    '' : (float)$response['shopSumAmount'].' '.$donation->currency_label,
                __('Gateway donor ID:', 'leyka') => empty($response['customerNumber']) ? '' : $response['customerNumber'],
                __('Response date:', 'leyka') => empty($response['requestDatetime']) ?
                    '' : date('d.m.Y, H:i:s', strtotime($response['requestDatetime'])),
            );

        }

        return $response;

    }

    public function get_recurring_subscription_cancelling_link($link_text, Leyka_Donation $donation) {

        $init_recurring_donation = Leyka_Donation::get_init_recurring_donation($donation);
        $cancelling_url = (get_option('permalink_structure') ?
            home_url("leyka/service/cancel_recurring/{$donation->id}") :
            home_url("?page=leyka/service/cancel_recurring/{$donation->id}"))
            .'/'.md5($donation->id.'_'.$init_recurring_donation->id.'_leyka_cancel_recurring_subscription');

        return sprintf(__('<a href="%s" target="_blank" rel="noopener noreferrer">click here</a>', 'leyka'), $cancelling_url);

    }

    public function cancel_recurring_subscription(Leyka_Donation $donation) {

        if($donation->type !== 'rebill') {
            return new WP_Error(
                'wrong_recurring_donation_to_cancel',
                __('Wrong donation given to cancel a recurring subscription.', 'leyka')
            );
        }

        $init_recurring_donation = Leyka_Donation::get_init_recurring_donation($donation);
        if($init_recurring_donation) {

            $init_recurring_donation->recurring_is_active = false;

            return true;

        } else {
            return false;
        }

    }

    public function cancel_recurring_subscription_by_link(Leyka_Donation $donation) {

        if($donation->type !== 'rebill') {
            die();
        }

        header('Content-type: text/html; charset=utf-8');

        $recurring_cancelling_result = $this->cancel_recurring_subscription($donation);

        if($recurring_cancelling_result === true) {
            die(__('Recurring subscription cancelled successfully.', 'leyka'));
        } else if(is_wp_error($recurring_cancelling_result)) {
            die($recurring_cancelling_result->get_error_message());
        } else {
            die( sprintf(__('Error while trying to cancel the recurring subscription.<br><br>Please, email abount this to the <a href="%s" target="_blank">website tech. support</a>.<br><br>We are very sorry for inconvenience.', 'leyka'), leyka_get_website_tech_support_email()) );
        }

    }

    public function do_recurring_donation(Leyka_Donation $init_recurring_donation) {

        if( !$init_recurring_donation->recurring_id ) {
            return false;
        }

        $new_recurring_donation = Leyka_Donation::add_clone(
            $init_recurring_donation,
            array(
                'status' => 'submitted',
                'payment_type' => 'rebill',
                'init_recurring_donation' => $init_recurring_donation->id,
                'yandex_recurring_id' => $init_recurring_donation->recurring_id,
            ),
            array('recalculate_total_amount' => true,)
        );

        if(is_wp_error($new_recurring_donation)) {
            return false;
        }

        if(leyka_options()->opt('yandex_new_api')) {

            require_once LEYKA_PLUGIN_DIR.'gateways/yandex/lib/autoload.php';

            $client = new YandexCheckout\Client();
            $client->setAuth(leyka_options()->opt('yandex_shop_id'), leyka_options()->opt('yandex_secret_key'));

            try {

                $payment = $client->createPayment(
                    array(
                        'amount' => array(
                            'value' => round($new_recurring_donation->amount, 2),
                            'currency' => 'RUB', /** @todo Change to $new_recurring_donation->currency_id, but fix "rur" -> "RUB" */
                        ),
                        'payment_method_id' => $init_recurring_donation->recurring_id,
                        'capture' => true,
                        'description' =>
                            ( !empty($form_data['leyka_recurring']) ? _x('[R]', 'For "rebill"', 'leyka').' ' : '' )
                            .$new_recurring_donation->payment_title." (№ {$new_recurring_donation->id})",
                        'metadata' => array('donation_id' => $new_recurring_donation->id),
                    ),
                    uniqid('', true)
                );

                $new_recurring_donation->add_gateway_response($payment); // On callback the response will be re-written
                $new_recurring_donation->recurring_id = $payment->id;

            } catch(Exception $ex) {

                $new_recurring_donation->status = 'failed';
                $new_recurring_donation->add_gateway_response($ex);

                if(leyka_options()->opt('notify_tech_support_on_failed_donations')) {
                    Leyka_Donation_Management::send_error_notifications($new_recurring_donation);
                }

            }

        } else {

            $ch = curl_init();
            $params = array(
                CURLOPT_URL => leyka_options()->opt('yandex_test_mode') ?
                    'https://penelope-demo.yamoney.ru/webservice/mws/api/repeatCardPayment' :
                    'https://penelope.yamoney.ru/webservice/mws/api/repeatCardPayment',
                CURLOPT_PORT => leyka_options()->opt('yandex_test_mode') ? 8083 : 443,
                CURLOPT_HEADER => false,
                CURLOPT_HTTPHEADER => array('Content-Type: application/x-www-form-urlencoded'),
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => http_build_query(array(
                    'clientOrderId' => $new_recurring_donation->id,
                    'invoiceId' => $init_recurring_donation->recurring_id,
                    'orderNumber' => 'recurring-'.$init_recurring_donation->id.'-'.$new_recurring_donation->id,
                    'amount' => $init_recurring_donation->amount,
                )),
                CURLOPT_VERBOSE => false,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_CONNECTTIMEOUT => 60,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_FORBID_REUSE => true,
                CURLOPT_FRESH_CONNECT => true,
                CURLOPT_SSLCERT => leyka_options()->opt('yandex-yandex_card_certificate_path') ?
                    WP_CONTENT_DIR.'/'.trim(leyka_options()->opt('yandex-yandex_card_certificate_path'), '/') : false,
                CURLOPT_SSLKEY => leyka_options()->opt('yandex-yandex_card_private_key_path') ?
                    WP_CONTENT_DIR.'/'.trim(leyka_options()->opt('yandex-yandex_card_private_key_path'), '/') : false,
                CURLOPT_SSLKEYPASSWD => leyka_options()->opt('yandex-yandex_card_private_key_password'),
            );
            if(leyka_options()->opt('yandex_outer_ip_to_inner')) {
                $params[CURLOPT_INTERFACE] = gethostbyname(gethostname());
            }
            curl_setopt_array($ch, $params);

            $answer = curl_exec($ch);
            if($answer) {

                $p = xml_parser_create();
                xml_parse_into_struct($p, $answer, $vals, $index);
                xml_parser_free($p);

                $new_recurring_donation->add_gateway_response($answer);

                if(isset($vals[0]['attributes']['STATUS']) && $vals[0]['attributes']['STATUS'] == 0) {

                    // Recurring payment isn't funded here yet! Only its possibility is confirmed.
                    // To fund a payment, we should wait for a normal callbacks.

                } else { // Some error on payment test run

                    $error_num = empty($vals[0]['attributes']['error']) ? 'unknown' : $vals[0]['attributes']['error'];
                    $error_text = empty($vals[0]['attributes']['techMessage']) ?
                        __('Some error while repeatCardPayment call. Please ask your Yandex.Kassa manager for details.', 'leyka') : $vals[0]['attributes']['techMessage'];

                    $new_recurring_donation->add_gateway_response('Error '.$error_num.': '.$error_text);

                }

            } else {
                $new_recurring_donation->add_gateway_response('Error '.curl_errno($ch).': '.curl_error($ch));
            }

            curl_close($ch);

        }

        return $new_recurring_donation;

    }

    public function display_donation_specific_data_fields($donation = false) {

        if($donation) { // Edit donation page displayed

            $donation = leyka_get_validated_donation($donation);

            if($donation->type !== 'rebill') {
                return;
            }?>

            <label><?php _e('Yandex.Kassa recurring subscription ID', 'leyka');?>:</label>
            <div class="leyka-ddata-field">

                <?php if($donation->type == 'correction') {?>
                <input type="text" id="yandex-recurring-id" name="yandex-recurring-id" placeholder="<?php _e('Enter Yandex.Kassa invoice ID', 'leyka');?>" value="<?php echo $donation->recurring_id;?>">
                <?php } else {?>
                <span class="fake-input"><?php echo $donation->recurring_id;?></span>
                <?php }?>
            </div>

        <?php $init_recurring_donation = $donation->init_recurring_donation;?>

            <div class="recurring-is-active-field">
                <label for="yandex-recurring-is-active"><?php _e('Recurring subscription is active', 'leyka');?>:</label>
                <div class="leyka-ddata-field">
                    <input type="checkbox" id="yandex-recurring-is-active" name="yandex-recurring-is-active" value="1" <?php echo $init_recurring_donation->recurring_is_active ? 'checked="checked"' : '';?>>
                </div>
            </div>

        <?php } else { // New donation page displayed ?>

            <label for="yandex-recurring-id"><?php _e('Yandex.Kassa recurring subscription ID', 'leyka');?>:</label>
            <div class="leyka-ddata-field">
                <input type="text" id="yandex-recurring-id" name="yandex-recurring-id" placeholder="<?php _e('Enter Yandex.Kassa invoice ID', 'leyka');?>" value="">
            </div>
            <?php
        }

    }

    public function get_specific_data_value($value, $field_name, Leyka_Donation $donation) {
        switch($field_name) {
            case 'recurring_id':
            case 'recurrent_id':
            case 'invoice_id':
            case 'payment_id':
            case 'yandex_recurrent_id':
            case 'yandex_recurring_id':
            case 'yandex_invoice_id':
            case 'yandex_payment_id':
                return get_post_meta($donation->id, '_yandex_invoice_id', true);
            default: return $value;
        }
    }

    public function set_specific_data_value($field_name, $value, Leyka_Donation $donation) {
        switch($field_name) {
            case 'recurring_id':
            case 'recurrent_id':
            case 'invoice_id':
            case 'payment_id':
            case 'yandex_recurrent_id':
            case 'yandex_recurring_id':
            case 'yandex_invoice_id':
            case 'yandex_payment_id':
                return update_post_meta($donation->id, '_yandex_invoice_id', $value);
            default: return false;
        }
    }

    public function save_donation_specific_data(Leyka_Donation $donation) {

        if(isset($_POST['yandex-recurring-id']) && $donation->recurring_id != $_POST['yandex-recurring-id']) {
            $donation->recurring_id = $_POST['yandex-recurring-id'];
        }

        $donation->recurring_is_active = !empty($_POST['yandex-recurring-is-active']);

    }

    public function add_donation_specific_data($donation_id, array $donation_params) {
        if( !empty($donation_params['recurring_id']) ) {
            update_post_meta($donation_id, '_yandex_invoice_id', $donation_params['recurring_id']);
        }
    }

    protected function _get_gateway_pm_id($pm_id) {

        $all_pm_ids = leyka_options()->opt('yandex_new_api') ? array(
            'yandex_card' => 'bank_card',
            'yandex_money' => 'yandex_money',
            'yandex_wm' => 'webmoney',
            'yandex_sb' => 'sberbank',
            'yandex_ab' => 'alfabank',
            'yandex_pb' => 'psb',
        ) : array(
            'yandex_all' => '',
            'yandex_card' => 'AC',
            'yandex_money' => 'PC',
            'yandex_wm' => 'WM',
            'yandex_sb' => 'SB',
            'yandex_ab' => 'AB',
            'yandex_pb' => 'PB',
        );

        if(array_key_exists($pm_id, $all_pm_ids)) {
            return $all_pm_ids[$pm_id];
        } else if(in_array($pm_id, $all_pm_ids)) {
            return array_search($pm_id, $all_pm_ids);
        } else {
            return false;
        }

    }

}


class Leyka_Yandex_All extends Leyka_Payment_Method {

    protected static $_instance = null;

    public function _set_attributes() {

        $this->_id = 'yandex_all';
        $this->_gateway_id = 'yandex';
        $this->_category = 'misc';

        $this->_description = apply_filters(
            'leyka_pm_description',
            __('Yandex.Kassa allows a simple and safe way to pay for goods and services with bank cards through internet. You will have to fill a payment form, you will be redirected to the <a href="https://money.yandex.ru/">Yandex.Kassa website</a> to enter your bank card data and to confirm your payment.', 'leyka'),
            $this->_id,
            $this->_gateway_id,
            $this->_category
        );

        $this->_label_backend = __('Yandex.Kassa smart payment', 'leyka');
        $this->_label = __('Yandex.Kassa smart payment', 'leyka');

        // The description won't be setted here - it requires the PM option being configured at this time (which is not)

        $this->_icons = apply_filters('leyka_icons_'.$this->_gateway_id.'_'.$this->_id, array(
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/card-visa.svg',
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/card-mastercard.svg',
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/card-maestro.svg',
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/card-mir.svg',
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/yandex-money.svg',
        ));

        $this->_custom_fields = apply_filters('leyka_pm_custom_fields_'.$this->_gateway_id.'-'.$this->_id, array());

        $this->_supported_currencies[] = 'rur';
        $this->_default_currency = 'rur';

    }

}

class Leyka_Yandex_Card extends Leyka_Payment_Method {

    protected static $_instance = null;

    public function _set_attributes() {

        $this->_id = 'yandex_card';
        $this->_gateway_id = 'yandex';
        $this->_category = 'bank_cards';

        $this->_description = apply_filters(
            'leyka_pm_description',
            __('Yandex.Kassa allows a simple and safe way to pay for goods and services with bank cards through internet. You will have to fill a payment form, you will be redirected to the <a href="https://money.yandex.ru/">Yandex.Kassa website</a> to enter your bank card data and to confirm your payment.', 'leyka'),
            $this->_id,
            $this->_gateway_id,
            $this->_category
        );

        $this->_label_backend = __('Bank card', 'leyka');
        $this->_label = __('Bank card', 'leyka');

        $this->_icons = apply_filters('leyka_icons_'.$this->_gateway_id.'_'.$this->_id, array(
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/card-visa.svg',
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/card-mastercard.svg',
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/card-maestro.svg',
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/card-mir.svg',
        ));

        $this->_supported_currencies[] = 'rur';
        $this->_default_currency = 'rur';

    }

    protected function _set_options_defaults() {

        if($this->_options) {
            return;
        }

        $this->_options = array(
            $this->full_id.'_rebilling_available' => array(
                'type' => 'checkbox',
                'default' => false,
                'title' => __('Monthly recurring subscriptions are available', 'leyka'),
                'comment' => __('Check if Yandex.Kassa allows you to create recurrent subscriptions to do regular automatic payments.', 'leyka'),
                'short_format' => true,
            ),
            $this->full_id.'_certificate_path' => array(
                'type' => 'text',
                'default' => '',
                'title' => __('Yandex.Kassa recurring payments certificate path', 'leyka'),
                'comment' => __("Please, enter the path to your SSL certificate given to you by Yandex.Kassa. <strong>Warning!</strong> The path should include the certificate's filename intself. Also it should be relative to wp-content directory.", 'leyka'),
                'placeholder' => sprintf(__('E.g., %s', 'leyka'), '/uploads/leyka/your-cert-file.cer'),
                'field_classes' => array('old-api'),
            ),
            $this->full_id.'_private_key_path' => array(
                'type' => 'text',
                'default' => '',
                'title' => __("Yandex.Kassa recurring payments certificate's private key path", 'leyka'),
                'comment' => __("Please, enter the path to your SSL certificate's private key given to you by Yandex.Kassa.<li><li>The path should include the certificate's filename intself.</li><li>The path should be relative to wp-content directory. </li></ul>", 'leyka'),
                'placeholder' => sprintf(__('E.g., %s', 'leyka'), '/uploads/leyka/your-private.key'),
                'field_classes' => array('old-api'),
            ),
            $this->full_id.'_private_key_password' => array(
                'type' => 'text',
                'default' => '',
                'title' => __("Yandex.Kassa recurring payments certificate's private key password", 'leyka'),
                'comment' => __("Please, enter a password for your SSL certificate's private key, if you set this password during the generation of your sertificate request file.", 'leyka'),
                'placeholder' => sprintf(__('E.g., %s', 'leyka'), 'fW!^12@3#&8A4'),
                'is_password' => true,
                'field_classes' => array('old-api'),
            ),
        );

    }

    public function has_recurring_support() {
        return !!leyka_options()->opt($this->full_id.'_rebilling_available');
    }

}

class Leyka_Yandex_Money extends Leyka_Payment_Method {

    protected static $_instance = null;

    public function _set_attributes() {

        $this->_id = 'yandex_money';
        $this->_gateway_id = 'yandex';
        $this->_category = 'digital_currencies';

        $this->_description = apply_filters(
            'leyka_pm_description',
            __("Yandex.Kassa is a simple and safe payment system to pay for goods and services through internet. You will have to fill a payment form, you will be redirected to the <a href='https://money.yandex.ru/'>Yandex.Kassa website</a> to confirm your payment. If you haven't aquired a Yandex.Money account yet, you can create it there.", 'leyka'),
            $this->_id,
            $this->_gateway_id,
            $this->_category
        );

        $this->_label_backend = __('Yandex.Money', 'leyka');
        $this->_label = __('Yandex.Money', 'leyka');

        $this->_icons = apply_filters('leyka_icons_'.$this->_gateway_id.'_'.$this->_id, array(
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/yandex-money.svg',
        ));

        $this->_custom_fields = apply_filters('leyka_pm_custom_fields_'.$this->_gateway_id.'-'.$this->_id, array());

        $this->_supported_currencies[] = 'rur';
        $this->_default_currency = 'rur';

    }

}

class Leyka_Yandex_Webmoney extends Leyka_Payment_Method {

    protected static $_instance = null;

    public function _set_attributes() {

        $this->_id = 'yandex_wm';
        $this->_gateway_id = 'yandex';
        $this->_category = 'digital_currencies';

        $this->_description = apply_filters(
            'leyka_pm_description',
            __('<a href="http://www.webmoney.ru/">WebMoney Transfer</a> is an international financial transactions system and an environment for a business in Internet, founded in 1988. Up until now, WebMoney clients counts at more than 25 million people around the world. WebMoney system includes a services to account and exchange funds, attract new funding, solve quarrels and make a safe deals.', 'leyka'),
            $this->_id,
            $this->_gateway_id,
            $this->_category
        );

        $this->_label_backend = __('Webmoney', 'leyka');
        $this->_label = __('Webmoney', 'leyka');

        $this->_icons = apply_filters('leyka_icons_'.$this->_gateway_id.'_'.$this->_id, array(
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/webmoney.svg',
        ));

        $this->_custom_fields = apply_filters('leyka_pm_custom_fields_'.$this->_gateway_id.'-'.$this->_id, array());

        $this->_supported_currencies[] = 'rur';
        $this->_default_currency = 'rur';

    }

}

class Leyka_Yandex_Sberbank_Online extends Leyka_Payment_Method {

    protected static $_instance = null;

    public function _set_attributes() {

        $this->_id = 'yandex_sb';
        $this->_gateway_id = 'yandex';
        $this->_category = 'online_banking';

        $this->_description = apply_filters(
            'leyka_pm_description',
            __('<a href="https://online.sberbank.ru/CSAFront/index.do">Sberbank Online</a> is an Internet banking service of Sberbank. It allows you to make many banking operations at any moment without applying to the bank department, using your computer.', 'leyka'),
            $this->_id,
            $this->_gateway_id,
            $this->_category
        );

        $this->_label_backend = __('Sberbank Online invoicing', 'leyka');
        $this->_label = __('Sberbank Online', 'leyka');

        $this->_icons = apply_filters('leyka_icons_'.$this->_gateway_id.'_'.$this->_id, array(
            LEYKA_PLUGIN_BASE_URL.'img/pm-icons/sber.svg',
        ));

        $this->_custom_fields = apply_filters('leyka_pm_custom_fields_'.$this->_gateway_id.'-'.$this->_id, array());

        $this->_supported_currencies[] = 'rur';
        $this->_default_currency = 'rur';

    }

}

class Leyka_Yandex_Alpha_Click extends Leyka_Payment_Method {

    protected static $_instance;

    public function _set_attributes() {

        $this->_id = 'yandex_ab';
        $this->_gateway_id = 'yandex';
        $this->_category = 'online_banking';

        $this->_description = apply_filters(
            'leyka_pm_description',
            __('<a href="https://alfabank.ru/retail/internet/">Alfa-Click</a> is an Internet banking service of Alfa bank. It allows you to make many banking operations at any moment without applying to the bank department, using your computer.', 'leyka'),
            $this->_id,
            $this->_gateway_id,
            $this->_category
        );

        $this->_label_backend = __('Alpha-Click invoicing', 'leyka');
        $this->_label = __('Alpha-Click', 'leyka');

        $this->_icons = apply_filters('leyka_icons_'.$this->_gateway_id.'_'.$this->_id, array(
            LEYKA_PLUGIN_BASE_URL.'gateways/yandex/icons/alfa-click.svg',
        ));

        $this->_custom_fields = apply_filters('leyka_pm_custom_fields_'.$this->_gateway_id.'-'.$this->_id, array());

        $this->_supported_currencies[] = 'rur';
        $this->_default_currency = 'rur';

    }

}

class Leyka_Yandex_Promvzyazbank extends Leyka_Payment_Method {

    protected static $_instance = null;

    public function _set_attributes() {

        $this->_id = 'yandex_pb';
        $this->_gateway_id = 'yandex';
        $this->_category = 'online_banking';

        $this->_description = apply_filters(
            'leyka_pm_description',
            __('<a href="http://www.psbank.ru/Personal/Everyday/Remote/">PSB-Retail</a> is an Internet banking service of Promsvyazbank. It allows you to make many banking operations at any moment without applying to the bank department, using your computer.', 'leyka'),
            $this->_id,
            $this->_gateway_id,
            $this->_category
        );

        $this->_label_backend = __('Promsvyazbank invoicing', 'leyka');
        $this->_label = __('Promsvyazbank', 'leyka');

        $this->_icons = apply_filters('leyka_icons_'.$this->_gateway_id.'_'.$this->_id, array(
            LEYKA_PLUGIN_BASE_URL.'gateways/yandex/icons/promsvyazbank.svg',
        ));

        $this->_custom_fields = apply_filters('leyka_pm_custom_fields_'.$this->_gateway_id.'-'.$this->_id, array());

        $this->_supported_currencies[] = 'rur';
        $this->_default_currency = 'rur';

    }

}

function leyka_add_gateway_yandex() { // Use named function to leave a possibility to remove/replace it on the hook
    leyka()->add_gateway(Leyka_Yandex_Gateway::get_instance());
}
add_action('leyka_init_actions', 'leyka_add_gateway_yandex');