<?php 
defined('C5_EXECUTE') or die(_("Access Denied."));
Loader::library('payment/controller', 'core_commerce');
Loader::helper('utilities','hospitality_entrepreneur');
Loader::model('membershipproducts','hospitality_entrepreneur');

class CoreCommerceHospitalityEntrepreneurPaymentMethodController extends CoreCommercePaymentController {

	public function method_form() {
		$pkg = Package::getByHandle('core_commerce');
		$this->set('PAYMENT_METHOD_PAYPAL_STANDARD_EMAIL', $pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_EMAIL'));
		$this->set('PAYMENT_METHOD_PAYPAL_STANDARD_TEST_MODE', $pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_TEST_MODE'));
		$this->set('PAYMENT_METHOD_PAYPAL_STANDARD_TRANSACTION_TYPE', $pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_TRANSACTION_TYPE'));
		$this->set('PAYMENT_METHOD_PAYPAL_STANDARD_CURRENCY_CODE', 
			(strlen($pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_CURRENCY_CODE'))?$pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_CURRENCY_CODE'):'USD')
			);
		$this->set('PAYMENT_METHOD_PAYPAL_STANDARD_PASS_ADDRESS',$pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_PASS_ADDRESS'));
		
		$paypal_currency_codes = array(
			'AUD'=>t('Australian Dollar'),
			'CAD'=>t('Canadian Dollar'),
			'CZK'=>t('Czech Koruna'),
			'DKK'=>t('Danish Krone'),
			'EUR'=>t('Euro'),
			'HKD'=>t('Hong Kong Dollar'),
			'HUF'=>t('Hungarian Forint'),
			'ILS'=>t('Israeli New Sheqel'),
			'JPY'=>t('Japanese Yen'),
			'MXN'=>t('Mexican Peso'),
			'NOK'=>t('Norwegian Krone'),
			'NZD'=>t('New Zealand Dollar'),
			'PLN'=>t('Polish Zloty'),
			'GBP'=>t('Pound Sterling'),
			'SGD'=>t('Singapore Dollar'),
			'SEK'=>t('Swedish Krona'),
			'CHF'=>t('Swiss Franc'),
			'USD'=>t('U.S. Dollar')
		);
		asort($paypal_currency_codes);
		$this->set('paypal_currency_codes',$paypal_currency_codes);	
	}
	
	public function validate() {
		$e = parent::validate();
		$ve = Loader::helper('validation/strings');
		
		if ($this->post('PAYMENT_METHOD_PAYPAL_STANDARD_EMAIL') == '') {
			$e->add(t('You must specify your Paypal ID, which is an email address.'));
		}

		return $e;
	}
	
	public function action_notify_complete() {
		$success = false;
       Loader::model('order/model', 'core_commerce');
		$pkg = Package::getByHandle('core_commerce');

		if ($this->validateIPN()) {
			$eh = Loader::helper('encryption');
			$orderID = $eh->decrypt($_REQUEST['invoice']);
			$o = CoreCommerceOrder::getByID($orderID);
			if ($o) {
				// deal with float comparison problems
				$order_total = number_format($o->getOrderTotal(),2,'.','');
				$paid_total = 0;
				if(isset($_REQUEST['mc_gross']))
				{
					$paid_total = number_format($_REQUEST['mc_gross'],2,'.','');
				}
				elseif(isset($_REQUEST['mc_amount3']))
				{
					$paid_total = number_format($_REQUEST['mc_amount3'],2,'.','');
				}
				
				if ($paid_total >= $order_total) {
					if ($_REQUEST['payment_status'] == 'Pending') {
						$o->setStatus(CoreCommerceOrder::STATUS_PENDING);
						parent::finishOrder($o, 'Paypal - Website Payments Standard');
					} else if ($_REQUEST['payment_status'] == 'Processed' || $_REQUEST['payment_status'] == 'Completed' || 
								$_REQUEST['payer_status'] == 'verified') {
							
						$o->setStatus(CoreCommerceOrder::STATUS_AUTHORIZED);
						
						//successful payment. Lets start with the infusion process.
						
						
										
						parent::finishOrder($o, 'Paypal - Website Payments Standard');
					} else {
						
						$returnInformation = '';
						
						foreach($_REQUEST as $key => $value) {
							//do something with your $key and $value;
							$returnInformation .= "| $key = $value";
						}
						
						Log::addEntry('Unable to set status for Paypal HE Payment. Status received: ' . $returnInformation);
					}			
				} else {
					Log::addEntry('Invalid payment for order# '.$o->getOrderID() . " Requested ". $pkg->config('CURRENCY_SYMBOL').$order_total.', got '.$pkg->config('CURRENCY_SYMBOL').$paid_total );
					Log::addEntry('Invalid payment debug info for order# '.$o->getOrderID().'\n'.var_export($_REQUEST,true) . var_export($o,true));
				}
				
			} else {
				Log::addEntry('Received order notification with unknown order: '.$orderID);
			}
		}
	}
	
	public function form() {
		$pkg = Package::getByHandle('core_commerce');
		if ($pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_TEST_MODE') == 'test') { 
			$this->set('action', 'https://www.sandbox.paypal.com/cgi-bin/webscr');
		} else {
			$this->set('action', 'https://www.paypal.com/cgi-bin/webscr');
		}
		$o = CoreCommerceCurrentOrder::get();
		
		$membershipProduct = $this->get_membership_product($o);
		
		$trialPeriod = 0;
		$membershipProductPrice = 0;
		$membershipAdded = false;
		
		
		if($membershipProduct instanceof CoreCommerceOrderProduct)
		{
			//get the actual product so we can get the definitation.
			$productObject = $membershipProduct->getProductObject();
			
			//ok, we have a membershp.  Lets get the trial period if there is one, followed by the price of membership.
			$trialPeriod = $productObject->getAttribute('trial_period');
			
			//If the membership product is the FREE membership...
			if(strtolower($productObject->getProductName()) == 'free')
			{
				//lets set the price to that of the STARTER membership.
				$membershipProductObj = new HospitalityEntrepreneurMembershipProductsModel();
				
				//get the starter membereship.
				$membershipProductObj->filterByMembershipName('Starter');
				if(count($membershipProductObj) > 0)
				{
					//get the membership product.
					$starterMembership = $membershipProductObj->get(1);
					$starterMembership = $starterMembership[0];
					//and set the price.
					$membershipProductPrice = $starterMembership->getProductPrice();
					
					
					
				}
				
				$fields['a3'] = $membershipProductPrice;
				$fields['p3'] = 30;
				$fields['t3'] = 'D';
				
				
			}
			else {
				//set to whatever the product price is.
				$membershipProductPrice = $productObject->getProductPrice();
				
				$fields['a3'] = $membershipProductPrice;
				$fields['p3'] = 1;
				$fields['t3'] = 'M';
				
			}
			
			//set flag to indicate that membership has been added.
			$membershipAdded = true;
		}
		
		
      //would it be possible to set the status here
      //then we would have a legitimate invoice number
      $o->setStatus(CoreCommerceOrder::STATUS_INCOMPLETE);
		$this->set('item_name', SITE);

		// paypal fields
		
		
		$fields['cmd'] = '_xclick';
		
		if($membershipAdded)
		{
			//membership is added, we need to change the cmd and set some additional fields
			$fields['cmd'] = '_xclick-subscriptions';
			$fields['src'] = 1;
			
			if(isset($trialPeriod) && $trialPeriod > 0)
			{
				$fields['a1'] = 0;	
				$fields['p1'] = $trialPeriod;
				$fields['t1'] = 'D';
				
				
				
			}
			
			
				
		}
		
		
		$fields['address_override'] = 0;
		$fields['rm'] = 2;
		$fields['no_note'] = 1;
		
		// address information
		$fields['item_name'] = t('Purchase from %s', SITE)." - ".t('Order #').$o->getInvoiceNumber();
		
		$shipping_address = $o->getAttribute('shipping_address');
		if(($pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_PASS_ADDRESS') =='shipping') && is_object($shipping_address)) {
			$fields['first_name'] = $o->getAttribute('shipping_first_name');
			$fields['last_name'] = $o->getAttribute('shipping_last_name');
			$fields['address1'] = $shipping_address->getAddress1();
			$fields['address2'] = $shipping_address->getAddress2();
			$fields['city'] = $shipping_address->getCity();
			$fields['state'] = $shipping_address->getStateProvince();
			$fields['zip'] = $shipping_address->getPostalCode();
			$fields['country'] = $shipping_address->getCountry();
			$fields['night_phone_a'] = $o->getAttribute('shipping_phone');
		} else {
			$fields['first_name'] = $o->getAttribute('billing_first_name');
			$fields['last_name'] = $o->getAttribute('billing_last_name');
			$fields['address1'] = $o->getAttribute('billing_address')->getAddress1();
			$fields['address2'] = $o->getAttribute('billing_address')->getAddress2();
			$fields['city'] = $o->getAttribute('billing_address')->getCity();
			$fields['state'] = $o->getAttribute('billing_address')->getStateProvince();
			$fields['zip'] = $o->getAttribute('billing_address')->getPostalCode();
			$fields['country'] = $o->getAttribute('billing_address')->getCountry();
			$fields['night_phone_a'] = $o->getAttribute('billing_phone');
		}
		
		$fields['amount'] = $o->getOrderTotal();
		
		$fields['currency_code'] = $pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_CURRENCY_CODE');
		
		// email
		$fields['business'] = $pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_EMAIL');
		if(($u = new User) && $u->isLoggedIn()) {
			$fields['email'] = UserInfo::getByID($u->getUserID())->getUserEmail();
		} else {
			$fields['email'] = $o->getOrderEmail();
		}
		$fields['paymentaction'] = $pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_TRANSACTION_TYPE');
		
		$fields['address_override'] = 1;
		$fields['no_shipping'] = 1;
		
 		//callback
		$fields['notify_url'] = $this->action('notify_complete');
		
		
		$ch = Loader::helper('checkout/step', 'core_commerce');
		$ns = $ch->getNextCheckoutStep();
		$ps = $ch->getCheckoutStep();
		$returnURL = $ns->getURL();
		$fields['return'] = $returnURL;
		$fields['cancel_return'] = $ps->getURL();
		$eh = Loader::helper('encryption');
		$fields['invoice'] = $eh->encrypt($o->getOrderID());
		$this->set('fields', $fields);
	}
		
	public function save() {
		$pkg = Package::getByHandle('core_commerce');
		$pkg->saveConfig('PAYMENT_METHOD_PAYPAL_STANDARD_EMAIL', $this->post('PAYMENT_METHOD_PAYPAL_STANDARD_EMAIL'));
		$pkg->saveConfig('PAYMENT_METHOD_PAYPAL_STANDARD_TEST_MODE', $this->post('PAYMENT_METHOD_PAYPAL_STANDARD_TEST_MODE'));
		$pkg->saveConfig('PAYMENT_METHOD_PAYPAL_STANDARD_TRANSACTION_TYPE', $this->post('PAYMENT_METHOD_PAYPAL_STANDARD_TRANSACTION_TYPE'));
		$pkg->saveConfig('PAYMENT_METHOD_PAYPAL_STANDARD_CURRENCY_CODE', $this->post('PAYMENT_METHOD_PAYPAL_STANDARD_CURRENCY_CODE'));
		$pkg->saveConfig('PAYMENT_METHOD_PAYPAL_STANDARD_PASS_ADDRESS', $this->post('PAYMENT_METHOD_PAYPAL_STANDARD_PASS_ADDRESS'));
	}
	
	/**
	 * Checks all products of an order to see what membership is defined.
	 * @param $order The order that contains the products.
	 * 
	 * @return The membership product from the order
	 */
	private function get_membership_product($order)
	{
		Loader::model('product/set','core_commerce');	
		Loader::helper('utilities','hospitality_entrepreneur');
		$utils = new HospitalityEntrepreneurUtilitiesHelper();
			
			
		$productsOrdered = $order->getProducts();
		
		//get the membership product set.
		$membershipProductSet = $utils->get_membership_set();
		
		if($membershipProductSet instanceof CoreCommerceProductSet)
		{
			//search all products
			foreach($productsOrdered as $productOrdered)
			{
				if($productOrdered->inProductSet($membershipProductSet))
				{
					//its a membership product.  Lets get this one.  We get the first one that is in the list of orders.
					return $productOrdered;
				}
			}
			
			
			
		}
		
		return null;
		
		
	}		

   private function validateIPN() {
      $pkg = Package::getByHandle('core_commerce');
      $req = 'cmd=' . urlencode('_notify-validate');

      foreach ($_POST as $key => $value) {
         $value = urlencode(stripslashes($value));
         $req .= "&$key=$value";
      }

      $sandbox = '';
		if ($pkg->config('PAYMENT_METHOD_PAYPAL_STANDARD_TEST_MODE') == 'test') { 
         $sandbox = ".sandbox";
      }

      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL, 'https://www'.$sandbox.'.paypal.com/cgi-bin/webscr');
      curl_setopt($ch, CURLOPT_HEADER, 0);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
      curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Host: www'.$sandbox.'.paypal.com'));
      $res = curl_exec($ch);
      curl_close($ch);
 
 
// assign posted variables to local variables
      $item_name = $_POST['item_name'];
      $item_number = $_POST['item_number'];
      $payment_status = $_POST['payment_status'];
      $payment_amount = $_POST['mc_gross'];
      $payment_currency = $_POST['mc_currency'];
      $txn_id = $_POST['txn_id'];
      $receiver_email = $_POST['receiver_email'];
      $payer_email = $_POST['payer_email'];

      if (strcmp ($res, "VERIFIED") == 0) {
      // check the payment_status is Completed
      // check that txn_id has not been previously processed
      // check that receiver_email is your Primary PayPal email
      // check that payment_amount/payment_currency are correct
      // process payment
         return true;
      }
      else if (strcmp ($res, "INVALID") == 0) {
         // log for manual investigation
         Log::addEntry(t("Paypal had an IPN issue : ").var_export($res));
         return false;
      }
	}
	
}
