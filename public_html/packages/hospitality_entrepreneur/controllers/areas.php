<?php  defined('C5_EXECUTE') or die(_("Access Denied."));

Loader::model('cart', 'core_commerce');
Loader::model('order/current', 'core_commerce');
Loader::model('order/product', 'core_commerce');
class AreasController extends Controller {
	
	/**
	 * @var boolean
	 */
	protected $allowRedirect = true;

	
	
}