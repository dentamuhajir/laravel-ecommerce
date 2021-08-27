<?php
namespace App\Http\Controllers;

ini_set('max_execution_time', 0); // Unlimited execution time

use App\Order;
use App\Product;
use Cache;
use Cart;
use DB;
use Illuminate\Http\Request;
use URL;

class PageController extends Controller {

	private $subTotalCart;
	private $countCart;
	public $platform;

	public function __construct() {

		$useragent = $_SERVER['HTTP_USER_AGENT'];

		$this->platform = Cache::remember('cache_platform', 60, function () use ($useragent) {

			if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {

				return "MOBILE";

			} else {

				return "DESKTOP";
			}
		});
	}

	public function index() {
		$breadcrumb = "";

		$this->subTotalCart = Cart::subtotal();
		$this->countCart = Cart::count();

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

		//print_r($dataProductAllSecOne->whereNotIn('PRODUCT_ID', $notIDs));

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

		return view('template_womensfashion.homepage')->with('BASE_URL', URL::to('/'))->with('GET_PRODUCT_ALL_ONE', $dataProductAllSecOne)->with('GET_PRODUCT_ALL_TWO', $dataProductAllSecTwo)->with('GET_PRODUCT_HOT', $dataProductHot)->with('GET_MERCH', $dataSidebarCategory)->with('COUNT_PRODUCT', $countProduct)->with('BREADCRUMB', $breadcrumb)->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))->with('COUNT_ITEM_CART', $this->countCart)->with('TODAY_NEW', $this->todayNew());
	}

	public function category($category, $merch) {

		$this->subTotalCart = Cart::subtotal();
		$this->countCart = Cart::count();
		$breadcrumb = str_replace('-', ' ', strToUpper($merch));
		$page = 'CATEGORY';
		$todayNew = $this->todayNew();
		$pageTodayNew = 0;

		if (strpos($merch, 'all-') === false) {

			$dataProductPerCategory = Cache::remember('dataProductPerCategory-' . $merch, 30, function () use ($merch, $category) {
				return DB::select('select `PRODUCT_MAIN_IMAGE`, `PRODUCT_NAME_SLUG`, `PRODUCT_ID`, `PRODUCT_NO_DISCOUNT`, `PRODUCT_CJT_PRICE`, `PRODUCT_PROFIT`, `PRODUCT_DATE_CREATED`, `PRODUCT_NAME`, `PRODUCT_CJT_CODE`, `PRODUCT_HOT_SALE` from `product` inner join `master_category` on `master_category`.`CATEGORY_ID` = `product`.`PRODUCT_CATEGORY_ID` where `master_category`.`CATEGORY_MERCH_SLUG` = ? and `master_category`.`CATEGORY_NAME_SLUG` = ? and `PRODUCT_STATUS` = ? order by RAND()', [$merch, $category, 1]);

				/*DB::table('product')
						->join('master_category', 'master_category.CATEGORY_ID', 'product.PRODUCT_CATEGORY_ID')
					    ->select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_CJT_CODE', 'PRODUCT_HOT_SALE')
						->where('master_category.CATEGORY_MERCH_SLUG', $merch)
						->where('master_category.CATEGORY_NAME_SLUG', $category)
						->where('PRODUCT_STATUS', 1)
						->inRandomOrder()
						->get()
				*/

			});
		} else if ($merch == 'all-product') {

			/*		$dataProductPerCategory = Cache::remember('dataAllProduct', 60, function () {
					return DB::select('product')
						->select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_CJT_CODE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_HOT_SALE', 'PRODUCT_DATE_CREATED')
						->where('PRODUCT_STATUS', 1)
						->inRandomOrder()
						->get();
				});
			*/

			$dataProductPerCategory = Cache::remember('dataAllProduct', 60, function () {
				return DB::select('select `PRODUCT_MAIN_IMAGE`, `PRODUCT_NAME_SLUG`, `PRODUCT_ID`, `PRODUCT_NO_DISCOUNT`, `PRODUCT_CJT_PRICE`, `PRODUCT_CJT_CODE`, `PRODUCT_PROFIT`, `PRODUCT_TODAY_NEW`, `PRODUCT_NAME`, `PRODUCT_HOT_SALE`, `PRODUCT_DATE_CREATED` from `product` where `PRODUCT_STATUS` = ? order by RAND()', [1]);
			});

		} else if ($merch == 'all-new') {

			if ($todayNew == 0) {
				$dataProductPerCategory = DB::table('product')
					->join('master_category', 'master_category.CATEGORY_ID', 'product.PRODUCT_CATEGORY_ID')
					->select('PRODUCT_MAIN_IMAGE', 'PRODUCT_NAME_SLUG', 'PRODUCT_ID', 'PRODUCT_NO_DISCOUNT', 'PRODUCT_CJT_PRICE', 'PRODUCT_PROFIT', 'PRODUCT_TODAY_NEW', 'PRODUCT_NAME', 'PRODUCT_CJT_CODE', 'PRODUCT_DATE_CREATED')
					->where('PRODUCT_STATUS', 1)
					->orderbY('PRODUCT_ID', 'desc')
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

		return view('template_womensfashion.category-page')->with('BASE_URL', URL::to('/'))->with('GET_PRODUCT', $dataProductPerCategory)->with('GET_MERCH', $dataSidebarCategory)->with('BREADCRUMB', $breadcrumb)->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))->with('COUNT_ITEM_CART', $this->countCart)->with('GET_NAME_MERCH', str_replace('-', ' ', strToUpper($merch)))->with('IS_PAGE', $page)->with('TODAY_NEW', $todayNew)->with('PAGE_TODAY_NEW', $pageTodayNew);
	}
	public function detail($slug) {
		$page = 'DETAIL';
		$this->countCart = Cart::count();
		$this->subTotalCart = Cart::subtotal();

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

		return view('template_womensfashion.detail-page')->with('DETAIL', $dataProductDetail)->with('BASE_URL', URL::to('/'))->with('BREADCRUMB', $breadcrumb)->with('RELATED_PRODUCT', $dataRelatedProduct)->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))->with('COUNT_ITEM_CART', $this->countCart)->with('IS_PAGE', $page)->with('GET_NAME_MERCH', $dataProductDetail->CATEGORY_MERCH)->with('TODAY_NEW', $this->todayNew());
	}
	public function cart() {

		$dataRelatedProduct = $this->widgetRelatedProduct();
		$cartTotal = str_replace('.00', '', str_replace(',', '', Cart::subtotal()));

		return view('template_womensfashion.cart-page')->with('BASE_URL', URL::to('/'))->with('GET_PROVINCE', app('App\Http\Controllers\FunctionController')->ONGKIR__listProvince())->with('CART_TOTAL', $cartTotal)->with('RELATED_PRODUCT', $dataRelatedProduct)->with('TODAY_NEW', $this->todayNew());
	}

	public function formBill() {

		$dataRelatedProduct = $this->widgetRelatedProduct();
		$cartTotal = str_replace('.00', '', str_replace(',', '', Cart::subtotal()));

		return view('template_womensfashion.form-bill-page')->with('BASE_URL', URL::to('/'))->with('GET_PROVINCE', app('App\Http\Controllers\FunctionController')->ONGKIR__listProvince())->with('CART_TOTAL', $cartTotal)->with('RELATED_PRODUCT', $dataRelatedProduct)->with('TODAY_NEW', $this->todayNew());
	}
	public function widgetIframeFormBill() {

		$cartTotal = str_replace('.00', '', str_replace(',', '', Cart::subtotal()));

		return view('template_womensfashion.blocks.widget-bill-form')->with('BASE_URL', URL::to('/'))->with('GET_PROVINCE', app('App\Http\Controllers\FunctionController')->ONGKIR__listProvince())->with('CART_TOTAL', $cartTotal)->with('TODAY_NEW', $this->todayNew());
	}

	public function thankYouPage($hash) {

		$orderDetail = DB::table('master_order')
			->select('ORDER_NEW_EMAIL', 'ORDER_NEW_PHONE', 'ORDER_NOTIF_SEND')
			->where('ORDER_GENERATE_ID', $hash)
			->first();

		$this->subTotalCart = 0;

		Cart::destroy();

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$breadcrumb = "thanks you";

		return view('template_womensfashion.thanks-you')->with('BASE_URL', URL::to('/'))->with('SUB_TOTAL_CART', 0)->with('RELATED_PRODUCT', $dataRelatedProduct)->with('HASH_GENERATE', $hash)->with('CUST_EMAIL', print_r($orderDetail->ORDER_NEW_EMAIL, true))->with('CUST_PONSEL', $orderDetail->ORDER_NEW_PHONE)->with('TODAY_NEW', $this->todayNew());
	}

	public function aboutUs() {

		$page = 'ABOUTUS';
		$this->countCart = Cart::count();
		$this->subTotalCart = Cart::subtotal();

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$breadcrumb = 'Tentang Kami';

		return view('template_womensfashion.info-page')->with('BASE_URL', URL::to('/'))->with('BREADCRUMB', $breadcrumb)->with('RELATED_PRODUCT', $dataRelatedProduct)->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))->with('COUNT_ITEM_CART', $this->countCart)->with('IS_PAGE', $page)->with('TODAY_NEW', $this->todayNew());
	}

	public function caraBelanja() {

		$page = 'CARABELANJA';
		$this->countCart = Cart::count();
		$this->subTotalCart = Cart::subtotal();

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$breadcrumb = 'Cara Belanja';

		return view('template_womensfashion.info-page')->with('BASE_URL', URL::to('/'))->with('BREADCRUMB', $breadcrumb)->with('RELATED_PRODUCT', $dataRelatedProduct)->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))->with('COUNT_ITEM_CART', $this->countCart)->with('IS_PAGE', $page)->with('TODAY_NEW', $this->todayNew());
	}
	public function faq() {

		$page = 'FAQ';
		$this->countCart = Cart::count();
		$this->subTotalCart = Cart::subtotal();

		$dataRelatedProduct = $this->widgetRelatedProduct();

		$breadcrumb = 'Frequently Asking Question';

		return view('template_womensfashion.info-page')->with('BASE_URL', URL::to('/'))->with('BREADCRUMB', $breadcrumb)->with('RELATED_PRODUCT', $dataRelatedProduct)->with('SUB_TOTAL_CART', substr(str_replace(',', '.', strToUpper($this->subTotalCart)), 0, -3))->with('COUNT_ITEM_CART', $this->countCart)->with('IS_PAGE', $page)->with('TODAY_NEW', $this->todayNew());
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
		return DB::table('product')->whereDate('PRODUCT_DATE_CREATED', '>=', date('Y-m-d') . ' 00:00:00')->count();

	}

}
