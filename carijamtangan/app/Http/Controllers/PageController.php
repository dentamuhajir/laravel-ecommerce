<?php
namespace App\Http\Controllers;

ini_set('max_execution_time', 0); // Unlimited execution time

use App\Order;
use App\Product;
use Cache;
use DB;
use Illuminate\Http\Request;
use URL;



class PageController extends FunctionController {

	const MOBILE = 'template_karl_mobile';
	const DESKTOP = 'template_womensfashion';

	private $subTotalCart;
	private $countCart;
	public $platform;

	public function __construct() {
		$this->platform = FunctionController::PLATFORM__detectDevice();
	}

	public function index() {

		$breadcrumb = "";

		$this->subTotalCart = FunctionController::CART__subTotal();
		$this->countCart = FunctionController::CART__itemQty();

		$dataProductAllSecOne = Cache::remember('dataProductAllSecOne', 10, function () {
			return Product::select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_CJT_CODE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_HOT_SALE', 'PRODUCT_DATE_CREATED')
				->where('PRODUCT_STATUS', 1)
				->where('PRODUCT_HOT_SALE', 0)
				->inRandomOrder()
				->limit(9)
				->get();

		});

		$notIDs = [];

		foreach ($dataProductAllSecOne as $val) {
			$notIDs[] = $val->PRODUCT_ID;
		}

		$dataProductHot = Cache::remember('dataProductHot', 10, function () {
			return DB::table('product')
				->select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_CJT_CODE', 'PRODUCT_DATE_CREATED')
				->where('PRODUCT_STATUS', 1)
				->where('PRODUCT_NAME', 'Like', '%HOT%')
				->limit(6)
				->get();

		});

		$dataProductAllSecTwo = Cache::remember('dataProductAllSecTwo', 10, function () use ($notIDs) {
			return DB::table('product')
				->select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_CJT_CODE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_HOT_SALE', 'PRODUCT_DATE_CREATED')
				->inRandomOrder()
				->where('PRODUCT_STATUS', 1)
				->where('PRODUCT_HOT_SALE', 0)
				->whereNotIn('PRODUCT_ID', $notIDs)
				->limit(30)
				->get();

		});

		$countProduct = DB::table('product')->where('PRODUCT_STATUS', 1)->count();
		$dataSidebarCategory = $this->widgetSidebarMerch();

		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.home-page' : self::DESKTOP . '.homepage';

		return view($platform)
			->with('BASE_URL', URL::to('/'))
			->with('GET_PRODUCT_ALL_ONE', $dataProductAllSecOne)
			->with('GET_PRODUCT_ALL_TWO', $dataProductAllSecTwo)
			->with('GET_PRODUCT_HOT', $dataProductHot)
			->with('GET_MERCH', $dataSidebarCategory)
			->with('COUNT_PRODUCT', $countProduct)
			->with('BREADCRUMB', $breadcrumb)
			->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))
			->with('COUNT_ITEM_CART', $this->countCart)
			->with('TODAY_NEW', $this->todayNew());
	}

	public function category($category, $merch) {

		$this->subTotalCart = FunctionController::CART__subTotal();
		$this->countCart = FunctionController::CART__itemQty();
		$breadcrumb = str_replace('-', ' ', strToUpper($merch));
		$page = 'CATEGORY';
		$todayNew = $this->todayNew();
		$pageTodayNew = 0;

		if (strpos($merch, 'all-') === false) {

			$dataProductPerCategory = Cache::remember('dataProductPerCategory-' . $merch, 30, function () use ($merch, $category) {
				return DB::select('select `PRODUCT_MAIN_IMAGE`, `PRODUCT_NAME_SLUG`, `PRODUCT_ID`, `PRODUCT_NO_DISCOUNT`, `PRODUCT_CJT_PRICE`, `PRODUCT_PROFIT`, `PRODUCT_DATE_CREATED`, `PRODUCT_NAME`, `PRODUCT_CJT_CODE`, `PRODUCT_HOT_SALE` from `product` inner join `master_category` on `master_category`.`CATEGORY_ID` = `product`.`PRODUCT_CATEGORY_ID` where `master_category`.`CATEGORY_MERCH_SLUG` = ? and `master_category`.`CATEGORY_NAME_SLUG` = ? and `PRODUCT_STATUS` = ? order by RAND()', [$merch, $category, 1]);

			});
		} else if ($merch == 'all-product') {

			$dataProductPerCategory = Cache::remember('dataAllProduct', 60, function () {
				return DB::select('select `PRODUCT_MAIN_IMAGE`, `PRODUCT_NAME_SLUG`, `PRODUCT_ID`, `PRODUCT_NO_DISCOUNT`, `PRODUCT_CJT_PRICE`, `PRODUCT_CJT_CODE`, `PRODUCT_PROFIT`, `PRODUCT_TODAY_NEW`, `PRODUCT_NAME`, `PRODUCT_HOT_SALE`, `PRODUCT_DATE_CREATED` from `product` where `PRODUCT_STATUS` = ? order by RAND()', [1]);
			});

		} else if ($merch == 'all-new') {

			if ($todayNew == 0) {
				$dataProductPerCategory = DB::table('product')
					->join('master_category', 'master_category.CATEGORY_ID', 'product.PRODUCT_CATEGORY_ID')
					->select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_CJT_CODE', 'PRODUCT_DATE_CREATED')
					->where('PRODUCT_STATUS', 1)
					->orderBy('PRODUCT_ID', 'desc')
					->limit(30)
					->get();
			} else {

				$pageTodayNew = 1;

				$dataProductPerCategory = DB::table('product')
					->join('master_category', 'master_category.CATEGORY_ID', 'product.PRODUCT_CATEGORY_ID')
					->select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_CJT_CODE', 'PRODUCT_DATE_CREATED')->where('PRODUCT_NAME', 'Like', '%HOT%')
					->whereDate('PRODUCT_DATE_CREATED', '>=', date('Y-m-d') . ' 00:00:00')
					->get();

			}

		} else if ($merch == 'all-hot-sale') {
			$dataProductPerCategory = DB::table('product')
				->join('master_category', 'master_category.CATEGORY_ID', 'product.PRODUCT_CATEGORY_ID')
				->select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_CJT_CODE', 'PRODUCT_HOT_SALE', 'PRODUCT_DATE_CREATED')
				->where('PRODUCT_NAME', 'Like', '%HOT%')
				->where('PRODUCT_STATUS', 1)
				->get();
		}

		$dataSidebarCategory = $this->widgetSidebarMerch();

		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.category-page' : self::DESKTOP . '.category-page';

		return view($platform)
			->with('BASE_URL', URL::to('/'))
			->with('GET_PRODUCT', $dataProductPerCategory)
			->with('GET_MERCH', $dataSidebarCategory)
			->with('BREADCRUMB', $breadcrumb)
			->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))
			->with('COUNT_ITEM_CART', $this->countCart)
			->with('GET_NAME_MERCH', str_replace('-', ' ', strToUpper($merch)))
			->with('IS_PAGE', $page)
			->with('TODAY_NEW', $todayNew)
			->with('PAGE_TODAY_NEW', $pageTodayNew);
	}
	public function detail($slug) {
		$page = 'DETAIL';
		
		$this->subTotalCart = FunctionController::CART__subTotal();
		$this->countCart = FunctionController::CART__itemQty();

		preg_match('/(.*?)-/', $slug, $resultIdRegex);
		$idProduct = $resultIdRegex[1];
		$dataRelatedProduct = $this->widgetRelatedProduct();

		$dataProductDetail = Cache::remember('dataProductDetail-' . $idProduct, 60, function () use ($idProduct) {

			return DB::table('product')
				->join('master_category', 'master_category.CATEGORY_ID', 'product.PRODUCT_CATEGORY_ID')
				->select('PRODUCT_DESCRIPTION', 'PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_CJT_CODE', 'PRODUCT_HOT_SALE', 'PRODUCT_DATE_CREATED', 'master_category.CATEGORY_MERCH', 'master_category.CATEGORY_MERCH_SLUG')
				->where('product.PRODUCT_ID', $idProduct)
				->where(function ($q) {
					$q->where('product.PRODUCT_STATUS', 1)
						->orWhereDate('product.PRODUCT_DATE_CREATED', '>=', date('Y-m-d') . ' 00:00:00');
				})
				->first();

		});

		$breadcrumb = $dataProductDetail->PRODUCT_NAME;
		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.detail-page' : self::DESKTOP . '.detail-page';

		return view($platform)
			->with('DETAIL', $dataProductDetail)
			->with('BASE_URL', URL::to('/'))
			->with('BREADCRUMB', $breadcrumb)
			->with('RELATED_PRODUCT', $dataRelatedProduct)
			->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))
			->with('COUNT_ITEM_CART', $this->countCart)
			->with('IS_PAGE', $page)
			->with('GET_NAME_MERCH', $dataProductDetail->CATEGORY_MERCH)
			->with('TODAY_NEW', $this->todayNew())
			->with('GET_MERCH', $this->widgetSidebarMerch());

	}
	public function cart() {

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$page = 'CART';
 
		$cartTotal = str_replace('.00', '', str_replace(',', '', FunctionController::CART__subTotal()));

		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.cart-page' : self::DESKTOP . '.cart-page';

		return view($platform)
			->with('BASE_URL', URL::to('/'))
			->with('GET_PROVINCE', FunctionController::ONGKIR__listProvince())
			->with('CART_TOTAL', $cartTotal)
			->with('RELATED_PRODUCT', $dataRelatedProduct)
			->with('TODAY_NEW', $this->todayNew())
			->with('IS_PAGE',$page)
			->with('GET_MERCH', $this->widgetSidebarMerch());
	}

	public function formBill() {

		$dataRelatedProduct = $this->widgetRelatedProduct();
		$cartTotal = str_replace('.00', '', str_replace(',', '', FunctionController::CART__subTotal()));
		$page = 'FORMBILL';

		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.checkout-page' : self::DESKTOP . '.form-bill-page';

		return view($platform)
			->with('BASE_URL', URL::to('/'))
			->with('GET_PROVINCE', FunctionController::ONGKIR__listProvince())
			->with('CART_TOTAL', $cartTotal)
			->with('RELATED_PRODUCT', $dataRelatedProduct)
			->with('TODAY_NEW', $this->todayNew())
			->with('IS_PAGE',$page)
			->with('GET_MERCH', $this->widgetSidebarMerch());
	}
	public function widgetIframeFormBill() {

		$cartTotal = str_replace('.00', '', str_replace(',', '', FunctionController::CART__subTotal()));

		return view('template_womensfashion.blocks.widget-bill-form')
		             ->with('BASE_URL', URL::to('/'))
		             ->with('GET_PROVINCE', FunctionController::ONGKIR__listProvince())
		             ->with('CART_TOTAL', $cartTotal)
		             ->with('TODAY_NEW', $this->todayNew());
	}

	public function thankYouPage($hash) {

		$page = 'THANK YOU';
 
		$orderDetail = DB::table('master_order')
			->select('ORDER_NEW_EMAIL', 'ORDER_NEW_PHONE', 'ORDER_NOTIF_SEND')
			->where('ORDER_GENERATE_ID', $hash)
			->first();

		$this->subTotalCart = 0;

		Cart::destroy();

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$page = "THANKS YOU";

		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.static-page' : self::DESKTOP . '.thanks-you';


		return view($platform)->with('BASE_URL', URL::to('/'))
		                      ->with('SUB_TOTAL_CART', 0)
		                      ->with('COUNT_ITEM_CART', 0)
		                      ->with('RELATED_PRODUCT', $dataRelatedProduct)
		                      ->with('HASH_GENERATE', $hash)
		                      ->with('CUST_EMAIL', print_r($orderDetail->ORDER_NEW_EMAIL, true))
		                      ->with('CUST_PONSEL', $orderDetail->ORDER_NEW_PHONE)
		                      ->with('TODAY_NEW', $this->todayNew())
		                      ->with('IS_PAGE', $page)
		                      ->with('GET_MERCH', $this->widgetSidebarMerch());

	}

	public function aboutUs() {

		$page = 'ABOUTUS';
	
		$this->subTotalCart = FunctionController::CART__subTotal();
		$this->countCart = FunctionController::CART__itemQty();

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$breadcrumb = 'Tentang Kami';

		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.static-page' : self::DESKTOP . '.info-page';


		return view($platform)->with('BASE_URL', URL::to('/'))
		                      ->with('BREADCRUMB', $breadcrumb)
		                      ->with('RELATED_PRODUCT', $dataRelatedProduct)
		                      ->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))
		                      ->with('COUNT_ITEM_CART', $this->countCart)
		                      ->with('IS_PAGE', $page)
		                      ->with('TODAY_NEW', $this->todayNew())
		                      ->with('GET_MERCH', $this->widgetSidebarMerch());

	}

	public function caraBelanja() {

		$page = 'CARABELANJA';
		
		$this->subTotalCart = FunctionController::CART__subTotal();
		$this->countCart = FunctionController::CART__itemQty();

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$breadcrumb = 'Cara Belanja';

		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.static-page' : self::DESKTOP . '.info-page';

		return view($platform)->with('BASE_URL', URL::to('/'))
		                      ->with('BREADCRUMB', $breadcrumb)
		                      ->with('RELATED_PRODUCT', $dataRelatedProduct)
		                      ->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))
		                      ->with('COUNT_ITEM_CART', $this->countCart)
		                      ->with('IS_PAGE', $page)
		                      ->with('TODAY_NEW', $this->todayNew())
		                      ->with('GET_MERCH', $this->widgetSidebarMerch());

	}
	public function faq() {

		$page = 'FAQ';
		
		$this->subTotalCart = FunctionController::CART__subTotal();
		$this->countCart = FunctionController::CART__itemQty();

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$breadcrumb = 'Frequently Asking Question';

		$platform = ($this->platform == 'MOBILE') ? self::MOBILE . '.static-page' : self::DESKTOP . '.info-page';

		return view($platform)->with('BASE_URL', URL::to('/'))
		                      ->with('BREADCRUMB', $breadcrumb)
		                      ->with('RELATED_PRODUCT', $dataRelatedProduct)
		                      ->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))
		                      ->with('COUNT_ITEM_CART', $this->countCart)
		                      ->with('IS_PAGE', $page)
		                      ->with('TODAY_NEW', $this->todayNew())
		                      ->with('GET_MERCH', $this->widgetSidebarMerch());

	}

	public function widgetRelatedProduct() {
		return DB::table('product')
			->select('*')
			->inRandomOrder()
			->where('PRODUCT_STATUS', 1)
			->limit(8)
			->get();
	}

	public function widgetSidebarMerch() {

		return Cache::remember('widgetSidebarMerch', 30, function () {
			return DB::table('master_category')
				->select('CATEGORY_MERCH', 'CATEGORY_MERCH_SLUG', 'CATEGORY_NAME_SLUG', 'CATEGORY_ORIGINAL')
				->where('CATEGORY_STATUS', 1)
				->orderBy('CATEGORY_MERCH', 'asc')
				->get();
		});

	}

	public function saveOrderForm(Request $request) {
		$uniqueCode = rand(10, 99);
		$generateHash = uniqid();

		$order_table = new Order;
		$order_table->ORDER_PRODUCT_ALL = $request->getProductCart;
		$order_table->ORDER_GENERATE_ID = $generateHash;
		$order_table->ORDER_ID_CUSTOMER = 0;
		$order_table->ORDER_NEW_NAME = $request->getNama;
		$order_table->ORDER_NEW_EMAIL = $request->getEmail;
		$order_table->ORDER_NEW_PHONE = $request->getTelphone;
		$order_table->ORDER_NEW_ADDRESS = $request->getAddress;
		$order_table->ORDER_NEW_CITY = $request->getCity;
		$order_table->ORDER_SUB_TOTAL = $request->getSubTotal;
		$order_table->ORDER_ONGKIR = $request->getOngkir;
		$order_table->ORDER_UNIQUE_CODE = $uniqueCode;
		$order_table->save();

		return $generateHash;

	}

	public function todayNew() {
		return DB::table('product')
		                ->whereDate('PRODUCT_DATE_CREATED', '>=', date('Y-m-d') . ' 00:00:00')
		                ->count();

	}

}
