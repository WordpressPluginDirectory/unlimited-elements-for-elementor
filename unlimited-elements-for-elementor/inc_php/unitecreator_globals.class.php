<?php
/**
 * @package Unlimited Elements
 * @author unlimited-elements.com
 * @copyright (C) 2021 Unlimited Elements, All Rights Reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
if ( ! defined( 'ABSPATH' ) ) exit;

	class GlobalsUC{

		public static $inDev = false;

		public static $debugAjaxErrors = false;
		
		public static $SHOW_TRACE = false;
		public static $SHOW_TRACE_FRONT = false;

		const ENABLE_TRANSLATIONS = false;

		const PLUGIN_TITLE = "Unlimited Elements";
		const PLUGIN_NAME = "unlimitedelements";

		const TABLE_ADDONS_NAME = "addonlibrary_addons";
		const TABLE_LAYOUTS_NAME = "addonlibrary_layouts";
		const TABLE_CATEGORIES_NAME = "addonlibrary_categories";
		const TABLE_CHANGELOG_NAME = "addonlibrary_changelog";
		const TABLE_FORM_ENTRIES_NAME = "ue_form_entries";
		const TABLE_FORM_ENTRY_FIELDS_NAME = "ue_form_entry_fields";

		const VIEW_ADDONS_LIST = "addons";
		const VIEW_DEVIDERS_LIST = "deviders";
		const VIEW_SHAPES_LIST = "shapes";

		const VIEW_EDIT_ADDON = "addon";
		const VIEW_ASSETS = "assets";
		const VIEW_SETTINGS = "settings";
		const VIEW_TEST_ADDON = "testaddon";
		const VIEW_ADDON_DEFAULTS = "addondefaults";
		const VIEW_MEDIA_SELECT = "mediaselect";
		const VIEW_LAYOUTS_LIST = "layouts";
		const VIEW_LAYOUT = "layout_outer";
		const VIEW_LAYOUT_IFRAME = "layout";
		const VIEW_LAYOUT_PREVIEW = "layout_preview";
		const VIEW_TEMPLATES_LIST = "templates";
		const VIEW_LIBRARY = "library";

		const VIEW_LICENSE = "license";

		const VIEW_LAYOUTS_SETTINGS = "layouts_settings";

		const DEFAULT_JPG_QUALITY = 81;
		const THUMB_WIDTH = 300;
		const THUMB_WIDTH_LARGE = 700;

		const THUMB_SIZE_NORMAL = "size_normal";
		const THUMB_SIZE_LARGE = "size_large";

		const DIR_THUMBS = "blox_thumbs";
		const DIR_SCREENSHOTS = "blox_screenshots";
		const DIR_THUMBS_ELFINDER = "elfinder_tmb";

		const DIR_THEME_ADDONS = "ue_widgets";

		const URL_API = "https://api.unlimited-elements.com/index.php";
		//const URL_API = "http://api.bloxbuilder.me/index.php";

		const URL_SITE = "https://unlimited-elements.com/";
		const URL_WIDGETS = "https://unlimited-elements.com/elementor-widgets/";
		const URL_BUY = "https://unlimited-elements.com/pricing/";
		const URL_BLOG = "https://unlimited-elements.com/category/blog/";
		const URL_DOCS = "https://unlimited-elements.com/docs/";
		const URL_DOUBLY = "https://unlimited-elements.com/live-copy-paste/";
		const URL_FEATURES = "https://unlimited-elements.com/features/";
		const URL_SUPPORT = "http://unitecms.ticksy.com";
		const URL_DOWNLOAD_PRO = "https://users.freemius.com/login";
		const URL_PREVIEW_WIDGETS = "https://unlimited-elements.com/";
		const URL_RATE = "https://wordpress.org/support/plugin/unlimited-elements-for-elementor/reviews/?filter=5";
		const URL_FACEBOOK = "https://facebook.com/groups/468327430642626";
		const URL_YOUTUBE = "https://youtube.com/channel/UCNYLnevs1ewIxKQqPiat0xQ";

		const ADDON_TYPE_REGULAR_ADDON = "regular_addon";
		const ADDON_TYPE_ELEMENTOR = "elementor";
		const ADDON_TYPE_SHAPE_DEVIDER = "shape_devider";
		const ADDON_TYPE_SHAPES = "shapes";
		const ADDON_TYPE_REGULAR_LAYOUT = "layout";
		const ADDON_TYPE_LAYOUT_SECTION = "layout_section";
		const ADDON_TYPE_LAYOUT_PAGE_TEMPLATE = "page_template";
		const ADDON_TYPE_LAYOUT_GENERAL = "layout_general";
		const ADDON_TYPE_BGADDON = "bg_addon";

		const LAYOUT_TYPE_HEADER = "header";
		const LAYOUT_TYPE_FOOTER = "footer";

		const VALUE_EMPTY_ARRAY = "[[uc_empty_array]]";
		const LINK_TWIG = "https://twig.symfony.com/doc/2.x/templates.html";

		const ENABLE_CATALOG_SHORTPIXEL = true;
		const SHORTPIXEL_PREFIX = "https://cdn.shortpixel.ai/spai/q_glossy+w_323+to_auto+ret_img/";

		const VERSION_ELEMENTOR = "elementor";
		const VERSION_GUTENBERG = "gutenberg";
		
		const ATTR_CATID = "__attr_catid__";
		
		public static $permisison_add = false;
		public static $blankWindowMode = false;

		public static $view_default;
		
		public static $isAjaxAction = false;
		public static $ajaxAction;
		public static $isTesting = false;
		
		
		public static $table_addons;
		public static $table_categories;
		public static $table_layouts;
		public static $table_prefix;

		public static $pathSettings;
		public static $filepathItemSettings;
		public static $pathPlugin;
		public static $pathPluginRel;
		public static $pathPluginFile;

		public static $pathTemplates;
		public static $pathViews;
		public static $pathViewsObjects;
		public static $pathFramework;
		public static $pathLibrary;
		public static $pathAssets;
		public static $pathProvider;
		public static $pathProviderViews;
		public static $pathProviderTemplates;
		public static $pathWPLanguages;
		public static $pathPro;

		public static $current_host;
		public static $current_page_url;
		public static $current_protocol;

		public static $url_base;
		public static $url_site;
		public static $url_images;
		public static $url_images_screenshots;
		public static $url_no_image_placeholder;
		public static $url_video_thumbnail;

		public static $url_component_client;
		public static $url_component_admin;
		public static $url_component_admin_nowindow;
		public static $url_ajax;
		public static $url_ajax_full;
		public static $url_ajax_front;
		public static $url_default_addon_icon;

		public static $urlPlugin;
		public static $urlPluginImages;

		public static $url_provider;
		public static $url_assets;
		public static $url_assets_libraries;
		public static $url_assets_internal;

		public static $is_admin;
		public static $isLocal;		//if website located in localhost
		public static $is_admin_debug_mode = false;
		public static $isDOUBLYSupported = true;
		public static $is_ssl;
		public static $path_base;
		public static $path_cache;
		public static $path_images;
		public static $path_images_screenshots;

		public static $layoutShortcodeName = "blox_page";

		public static $arrClientSideText = array();
		public static $arrServerSideText = array();

		public static $isProductActive = false;
		public static $defaultAddonType = "";
		public static $enableWebCatalog = true;
		public static $arrSizes = array("tablet","mobile");

		public static $arrAdminViewPaths = array();
		public static $alterViewHeaderPrefix = null;
		public static $arrViewAliases = array();
		public static $arrDatasetTypes = array();		
		public static $objActiveAddonForAssets = null;
		public static $isProVersion = false;
		public static $isAdminRTL = false;
		public static $enableInsideWidgetFreeVersionNotifiaction = true;
		public static $colorPickerType = "spectrum";
		public static $showQueryDebugByUrl = false;
		public static $isInsidePlugin = false;	//set in provider_admin
		
		
		/**
		 * init globals
		 */
		public static function initGlobals(){

			//set dev mode
			if(defined("UC_DEVMODE") && UC_DEVMODE === true)
				self::$inDev = true;

			if(defined("UC_DEBUG_AJAX_ERRORS") && UC_DEBUG_AJAX_ERRORS === true)
				self::$debugAjaxErrors = true;
							
			UniteProviderFunctionsUC::initGlobalsBase();

			self::$current_protocol = "http://";
			if(self::$is_ssl == true)
				self::$current_protocol = "https://";

			self::$current_host = UniteFunctionsUC::getVal($_SERVER, "HTTP_HOST");

			//add https:// prefix
			if(strpos(self::$current_host, "https://") === false && strpos(self::$current_host, "http://") === false)
				self::$current_host = self::$current_protocol.self::$current_host;

			self::$current_page_url = self::$current_host.UniteFunctionsUC::getVal($_SERVER, "REQUEST_URI");

			self::$pathPluginRel = basename(self::$pathPlugin)."/";
			self::$pathWPLanguages = self::$pathPluginRel."languages/";

			self::$pathProvider = self::$pathPlugin."provider/";
			self::$pathTemplates = self::$pathPlugin."views/templates/";
			self::$pathViews = self::$pathPlugin."views/";
			self::$pathViewsObjects = self::$pathPlugin."views/objects/";
			self::$pathSettings = self::$pathPlugin."settings/";
			self::$pathPro = self::$pathPlugin."pro/";
			self::$pathFramework = self::$pathPlugin."inc_php/framework/";

			if(file_exists(self::$pathPro))
				self::$isProVersion = true;

			if(defined("UC_TEST_FREE_VERSION"))
				self::$isProVersion = false;

			Global $mainFilepath;		//defined at plugin start
			self::$pathPluginFile = $mainFilepath;

			self::$pathProviderViews = self::$pathProvider."views/";
			self::$pathProviderTemplates = self::$pathProvider."views/templates/";

			self::$filepathItemSettings = self::$pathSettings."item_settings.php";

			self::$path_images_screenshots = self::$path_images.self::DIR_SCREENSHOTS."/";
			self::$url_images_screenshots = self::$url_images.self::DIR_SCREENSHOTS."/";

			self::$urlPluginImages = self::$urlPlugin."images/";

			self::$url_no_image_placeholder = self::$urlPluginImages."placeholder.png";

			self::$url_video_thumbnail = self::$urlPluginImages."video_thumbnail.png";

			self::$pathLibrary = self::$pathPlugin."assets_libraries/";

			//check for wp version
			UniteFunctionsUC::validateNotEmpty(GlobalsUC::$url_assets_internal, "assets internal");

			self::$isLocal = UniteFunctionsUC::isLocal();
		
			UniteProviderFunctionsUC::doAction(UniteCreatorFilters::ACTION_AFTER_INIT_GLOBALS);

			if(self::$is_admin){

				$isDebugMode = UniteFunctionsUC::getGetVar("debug", "", UniteFunctionsUC::SANITIZE_KEY);
				self::$is_admin_debug_mode = UniteFunctionsUC::strToBool($isDebugMode);
			}
			
		}

		/**
		 * init after the includes done
		 * //check if active only if in admin side
		 */
		public static function initAfterIncludes(){
			
			$product = HelperUC::getProductFromRequest();
			if(empty($product))
				$product = self::PLUGIN_NAME;

			$webAPI = new UniteCreatorWebAPI();
			if(!empty($product))
				$webAPI->setProduct($product);

			self::$isProductActive = $webAPI->isProductActive();

			//show trace by get url

			$isShowTrace = HelperUC::hasPermissionsFromQuery("uctrace");
			
			if($isShowTrace == true){
				GlobalsUC::$SHOW_TRACE_FRONT = true;
				GlobalsUC::$SHOW_TRACE = true;
			}
						
		}
		
		/**
		 * init after init action trigger
		 */
		public static function initAfterInitTrigger(){
			
			load_plugin_textdomain("unlimited-elements-for-elementor", false, GlobalsUC::$pathWPLanguages);

			//init client text
			ugelInitClientText();
		}
		
		/**
		 * init after plugins loaded
		 */
		public static function initAfterPluginsLoaded(){
			
			//show errors by url
			$showAjaxErrors = HelperUC::hasPermissionsFromQuery("showajaxerrors");
			
			if($showAjaxErrors == true)	
				self::$debugAjaxErrors = true;
			
			//show debug query
			
			$showQueryDebugByUrl = HelperUC::hasPermissionsFromQuery("ucquerydebug");
			if($showQueryDebugByUrl == true)
				self::$showQueryDebugByUrl = true;
			
						
			//test free version
			
			$isTestFree = HelperUC::hasPermissionsFromQuery("testfreeversion");
			if($isTestFree == true)
				GlobalsUC::$isProVersion = false;
			
		}

		/**
		 * init globals after admin init
		 */
		public static function initAfterAdminInit(){
			global $wp_locale;

			if(!empty($wp_locale)){
				GlobalsUC::$isAdminRTL = $wp_locale->is_rtl();
			}

		}

		/**
		 * print all globals variables
		 */
		public static function printVars(){
			
			UniteFunctionsUC::showClassStaticVariables("GlobalsUC");
			
		}

	}

	//init the globals
	GlobalsUC::initGlobals();
