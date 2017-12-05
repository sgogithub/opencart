<?php

class ControllerCheckoutOrderpay extends Controller {

    private $error = array();

    public function index() {
        $this->language->load('checkout/orderpay');

        //echo $this->request->post['espayproduct']."<br>";
        //echo $this->request->post['sgopayment_credit_card_mdr'];

        if (isset($this->request->post['espayproduct'])) { // 	
            $MODULE_PAYMENT_ESPAY_MODE = $this->config->get('sgopayment_environment');
            $this->data ['MODULE_PAYMENT_ESPAY_MODE'] = $MODULE_PAYMENT_ESPAY_MODE;

            // fee
            $espayproductOri = $this->request->post['espayproduct'];
            $espayproduct = explode(":", $espayproductOri);

            $bankCode = $espayproduct[0];
            $productCode = $espayproduct[1];
            $productName = $espayproduct[2];
            $orderId = $this->request->post['cartid'];

            $feeTransaction = 0;
            $feeMDR = 0;
            if ($productCode == 'BCAKLIKPAY') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_bca_klikpay'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_bca_klikpay'];
            } elseif ($productCode == 'EPAYBRI') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_epay_bri'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_epay_bri'];
            } elseif ($productCode == 'MANDIRIIB') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_mandiri_ib'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_mandiri_ib'];
            } elseif ($productCode == 'MANDIRIECASH') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_mandiri_ecash'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_mandiri_ecash'];
            } elseif ($productCode == 'CREDITCARD') {
                $this->load->model('total/transaction_fee');

                $totalorder = $this->model_total_transaction_fee->gettotalorder($orderId);

                $feeMDR = str_replace('%', '', $this->request->post['sgopayment_credit_card_mdr']);

                $feeCreditCard = ($this->request->post['sgopayment_transaction_fee_credit_card'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_credit_card'];

                $feeTransaction = floatval($feeCreditCard) + ((floatval($totalorder) + floatval($feeCreditCard)) * floatval($feeMDR) / 100);
            } elseif ($productCode == 'PERMATAATM') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_permata_atm'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_permata_atm'];
            } elseif ($productCode == 'PERMATANETPAY') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_permata_netpay'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_permata_netpay'];
            } elseif ($productCode == 'DANAMONATM') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_danamon_atm'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_danamon_atm'];
            } elseif ($productCode == 'DANAMONOB') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_danamon_ob'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_danamon_ob'];
            } elseif ($productCode == 'BIIATM') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_bii_atm'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_bii_atm'];
            } elseif ($productCode == 'NOBUPAY') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_nobupay'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_nobupay'];
            } elseif ($productCode == 'FINPAY195') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_finpay'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_finpay'];
            } elseif ($productCode == 'MAYAPADAIB') {
                $feeTransaction = ($this->request->post['sgopayment_transaction_fee_mayapada_ib'] == '') ? 0 : $this->request->post['sgopayment_transaction_fee_mayapada_ib'];
            } elseif ($productCode == 'BNIDBO') {
                $feeTransaction = ($this->request->post['test'] == '') ? 0 : $this->request->post['test'];
            } elseif ($productCode == 'DKIIB') {
                $feeTransaction = ($this->request->post['test'] == '') ? 0 : $this->request->post['test'];
            } elseif ($productCode == 'MANDIRISMS') {
                $feeTransaction = ($this->request->post['test'] == '') ? 0 : $this->request->post['test'];
            } elseif ($productCode == 'MUAMALATATM') {
                $feeTransaction = ($this->request->post['test'] == '') ? 0 : $this->request->post['test'];
            } elseif ($productCode == 'XLTUNAI') {
                $feeTransaction = ($this->request->post['test'] == '') ? 0 : $this->request->post['test'];
            }
            $this->data ['fee'] = $feeTransaction;
            // end fee

            if (!isset($this->session->data['vouchers'])) {
                $this->session->data['vouchers'] = array();
            }


            if ($this->cart->hasProducts() || !empty($this->session->data['vouchers'])) {

                $this->data['heading_title'] = $this->language->get('heading_title');

                $this->data['column_name'] = $this->language->get('column_name');
                $this->data['column_model'] = $this->language->get('column_model');
                $this->data['column_quantity'] = $this->language->get('column_quantity');
                $this->data['column_price'] = $this->language->get('column_price');
                $this->data['column_total'] = $this->language->get('column_total');
                $this->data ['espay_product_name'] = $productName;


                $this->data['button_confirm_and_pay'] = $this->language->get('button_confirm_and_pay');


                if (isset($this->session->data['success'])) {
                    $this->data['success'] = $this->session->data['success'];

                    unset($this->session->data['success']);
                } else {
                    $this->data['success'] = '';
                }

                $this->data['action'] = $this->url->link('checkout/orderpay');


                $this->data['products'] = array();

                $products = $this->cart->getProducts();

                foreach ($products as $product) {
                    $product_total = 0;

                    foreach ($products as $product_2) {
                        if ($product_2['product_id'] == $product['product_id']) {
                            $product_total += $product_2['quantity'];
                        }
                    }

                    if ($product['minimum'] > $product_total) {
                        $this->data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
                    }


                    $option_data = array();

                    foreach ($product['option'] as $option) {
                        if ($option['type'] != 'file') {
                            $value = $option['option_value'];
                        } else {
                            $filename = $this->encryption->decrypt($option['option_value']);

                            $value = utf8_substr($filename, 0, utf8_strrpos($filename, '.'));
                        }

                        $option_data[] = array(
                            'name' => $option['name'],
                            'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                        );
                    }

                    // Display prices
                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                        $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')));
                    } else {
                        $price = false;
                    }

                    // Display prices
                    if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                        $total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity']);
                    } else {
                        $total = false;
                    }

                    $profile_description = '';

                    if ($product['recurring']) {
                        $frequencies = array(
                            'day' => $this->language->get('text_day'),
                            'week' => $this->language->get('text_week'),
                            'semi_month' => $this->language->get('text_semi_month'),
                            'month' => $this->language->get('text_month'),
                            'year' => $this->language->get('text_year'),
                        );

                        if ($product['recurring_trial']) {
                            $recurring_price = $this->currency->format($this->tax->calculate($product['recurring_trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')));
                            $profile_description = sprintf($this->language->get('text_trial_description'), $recurring_price, $product['recurring_trial_cycle'], $frequencies[$product['recurring_trial_frequency']], $product['recurring_trial_duration']) . ' ';
                        }

                        $recurring_price = $this->currency->format($this->tax->calculate($product['recurring_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')));

                        if ($product['recurring_duration']) {
                            $profile_description .= sprintf($this->language->get('text_payment_description'), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration']);
                        } else {
                            $profile_description .= sprintf($this->language->get('text_payment_until_canceled_description'), $recurring_price, $product['recurring_cycle'], $frequencies[$product['recurring_frequency']], $product['recurring_duration']);
                        }
                    }

                    $this->data['products'][] = array(
                        'key' => $product['key'],
                        'name' => $product['name'],
                        'model' => $product['model'],
                        'option' => $option_data,
                        'quantity' => $product['quantity'],
                        'stock' => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
                        'reward' => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
                        'price' => $price,
                        'total' => $total,
                        'href' => $this->url->link('product/product', 'product_id=' . $product['product_id']),
                        'remove' => $this->url->link('checkout/cart', 'remove=' . $product['key']),
                        'recurring' => $product['recurring'],
                        'profile_name' => $product['profile_name'],
                        'profile_description' => $profile_description,
                    );
                }


                $this->data['products_recurring'] = array();

                // Gift Voucher
                $this->data['vouchers'] = array();

                if (!empty($this->session->data['vouchers'])) {
                    foreach ($this->session->data['vouchers'] as $key => $voucher) {
                        $this->data['vouchers'][] = array(
                            'key' => $key,
                            'description' => $voucher['description'],
                            'amount' => $this->currency->format($voucher['amount']),
                            'remove' => $this->url->link('checkout/cart', 'remove=' . $key)
                        );
                    }
                }

                if (isset($this->request->post['next'])) {
                    $this->data['next'] = $this->request->post['next'];
                } else {
                    $this->data['next'] = '';
                }

                // Totals
                $this->load->model('setting/extension');

                $total_data = array();
                $total = 0;
                $taxes = $this->cart->getTaxes();

                // Display prices
                if (($this->config->get('config_customer_price') && $this->customer->isLogged()) || !$this->config->get('config_customer_price')) {
                    $sort_order = array();

                    $results = $this->model_setting_extension->getExtensions('total');
                    /* echo '<pre>';
                      var_dump($results);
                      echo '</pre>'; */
                    foreach ($results as $key => $value) {
                        $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                    }

                    array_multisort($sort_order, SORT_ASC, $results);

                    /* echo '<pre>';
                      var_dump($results);
                      echo '</pre>'; */
                    foreach ($results as $result) {

                        /* echo '<pre>';
                          var_dump($result['code'] . '_status');
                          echo '</pre>'; */


                        if ($this->config->get($result['code'] . '_status')) {
                            /* echo '<pre>';
                              var_dump($result['code'] . '_status');
                              echo '</pre>'; */

                            $this->load->model('total/' . $result['code']);

                            $this->{'model_total_' . $result['code']}->getTotal($total_data, $total, $taxes);
                        }

                        $sort_order = array();

                        /* echo '<pre>';
                          var_dump($total_data);
                          echo '</pre>'; */

                        foreach ($total_data as $key => $value) {
                            $sort_order[$key] = $value['sort_order'];
                        }

                        array_multisort($sort_order, SORT_ASC, $total_data);
                    }
                }

                /* echo '<pre>';
                  var_dump($total_data);
                  echo '</pre>'; */

                $this->data['totals'] = $total_data;

                //$this->data['continue'] = $this->url->link('common/home');

                $this->data['checkout'] = $this->url->link('checkout/checkout', '', 'SSL');

                $this->data ['dir_js'] = HTTPS_SERVER . "catalog/view/javascript/";

                $this->load->model('setting/extension');

                $this->data['checkout_buttons'] = array();

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/checkout/orderpay.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/checkout/orderpay.tpl';
                } else {
                    $this->template = 'default/template/checkout/orderpay.tpl';
                }

                $this->children = array(
                    'common/column_left',
                    'common/column_right',
                    'common/content_bottom',
                    'common/content_top',
                    'common/footer',
                    'common/header'
                );

                $this->response->setOutput($this->render());
            } else {
                $this->data['heading_title'] = $this->language->get('heading_title');

                $this->data['text_error'] = $this->language->get('text_empty');

                $this->data['button_continue'] = $this->language->get('button_continue');

                $this->data['continue'] = $this->url->link('common/home');

                unset($this->session->data['success']);

                if (file_exists(DIR_TEMPLATE . $this->config->get('config_template') . '/template/error/not_found.tpl')) {
                    $this->template = $this->config->get('config_template') . '/template/error/not_found.tpl';
                } else {
                    $this->template = 'default/template/error/not_found.tpl';
                }

                $this->children = array(
                    'common/column_left',
                    'common/column_right',
                    'common/content_top',
                    'common/content_bottom',
                    'common/footer',
                    'common/header'
                );

                $this->response->setOutput($this->render());
            }
        } else {
            $this->redirect($this->url->link('common/home', '', 'SSL'));
        }
    }

}

?>
