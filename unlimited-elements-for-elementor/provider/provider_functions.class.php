<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class UniteProviderFunctionsUC{

	private static $arrScripts = array();
	private static $arrStyles = array();
	private static $arrInlineHtml = array();
	public static $tablePrefix = null;
	public static $tablePosts = null;
	public static $tablePostMeta = null;
	public static $counterScripts = 0;
	public static $counterStyles = 0;


	/**
	 * init base variables of the globals
	 */
	public static function initGlobalsBase(){
		global $wpdb;

		$tablePrefix = $wpdb->prefix;

		self::$tablePrefix = $tablePrefix;
		GlobalsUC::$table_prefix = $tablePrefix;

		self::$tablePosts = $tablePrefix."posts";
		self::$tablePostMeta = $tablePrefix."postmeta";

		GlobalsUC::$table_addons = $tablePrefix.GlobalsUC::TABLE_ADDONS_NAME;
		GlobalsUC::$table_categories = $tablePrefix.GlobalsUC::TABLE_CATEGORIES_NAME;

		$pluginUrlAdminBase = GlobalsUC::PLUGIN_NAME;

		GlobalsUC::$pathPlugin = realpath(dirname(__FILE__)."/../")."/";

		$pluginName = basename(GlobalsUC::$pathPlugin);

		GlobalsUC::$path_base = ABSPATH;

		GlobalsUC::$pathPlugin = UniteFunctionsUC::pathToUnix(GlobalsUC::$pathPlugin);
		GlobalsUC::$path_base = UniteFunctionsUC::pathToUnix(GlobalsUC::$path_base);

		//protection against wrong base path (happends at some hostings subdomain)
		if(strpos(GlobalsUC::$path_base, GlobalsUC::$pathPlugin) === false){
			GlobalsUC::$path_base = realpath(GlobalsUC::$pathPlugin."../../../")."/";
			GlobalsUC::$path_base = UniteFunctionsUC::pathToUnix(GlobalsUC::$path_base);
		}

		$arrUploadDir = wp_upload_dir();

		$uploadPath = $arrUploadDir["basedir"]."/";

		GlobalsUC::$path_images = $arrUploadDir["basedir"]."/";

		//set cache folder

		try{

			GlobalsUC::$path_cache = GlobalsUC::$path_images."unlimited_elements_cache/";
			UniteFunctionsUC::mkdirValidate(GlobalsUC::$path_cache, "cache folder");

			//create index.html
			UniteFunctionsUC::writeFile("", GlobalsUC::$path_cache."index.html");

		}catch(Exception $e){

			GlobalsUC::$path_cache = GlobalsUC::$pathPlugin."cache/";
		}

		GlobalsUC::$url_base = site_url()."/";
		GlobalsUC::$urlPlugin = plugins_url($pluginName)."/";

		GlobalsUC::$url_component_admin = admin_url()."admin.php?page=$pluginUrlAdminBase";
		GlobalsUC::$url_component_client = GlobalsUC::$url_component_admin;
		GlobalsUC::$url_component_admin_nowindow = GlobalsUC::$url_component_admin."&ucwindow=blank";

		GlobalsUC::$url_images = $arrUploadDir["baseurl"]."/";

		GlobalsUC::$url_ajax = admin_url("admin-ajax.php","relative");
		GlobalsUC::$url_ajax_full = admin_url("admin-ajax.php");

		GlobalsUC::$url_ajax_front = GlobalsUC::$url_ajax;

		GlobalsUC::$is_admin = self::isAdmin();

		GlobalsUC::$url_provider = GlobalsUC::$urlPlugin."provider/";

		GlobalsUC::$url_default_addon_icon = GlobalsUC::$url_provider."assets/images/icon_default_addon.png";

		GlobalsUC::$is_ssl = is_ssl();

		self::setAssetsPath();

		GlobalsUC::$url_assets_libraries = GlobalsUC::$urlPlugin."assets_libraries/";

		//GlobalsUC::$view_default set in admin class

		GlobalsUC::$url_assets_internal = GlobalsUC::$urlPlugin."assets_internal/";

		GlobalsUC::$layoutShortcodeName = "blox_layout";

		GlobalsUC::$enableWebCatalog = true;

		$window = UniteFunctionsUC::getGetVar("ucwindow","",UniteFunctionsUC::SANITIZE_KEY);
		if($window === "blank")
			GlobalsUC::$blankWindowMode = true;

	}


	/**
	 * set assets path
	*/
	public static function setAssetsPath($dirAssets = null, $returnValues = false){
		if(empty($dirAssets))
			$dirAssets = "ac_assets";

		$arrUploads = wp_upload_dir();

		if(empty($arrUploads))
			return(false);

		$uploadsBaseDir = UniteFunctionsUC::getVal($arrUploads, "basedir");
		$uploadsBaseUrl = UniteFunctionsUC::getVal($arrUploads, "baseurl");

		//convert to ssl if needed
		if(GlobalsUC::$is_ssl == true)
			$uploadsBaseUrl = str_replace("http://", "https://", $uploadsBaseUrl);


		$urlBase = null;

		if(is_dir($uploadsBaseDir)){
			$pathBase = UniteFunctionsUC::addPathEndingSlash($uploadsBaseDir);
			$urlBase = UniteFunctionsUC::addPathEndingSlash($uploadsBaseUrl);
		}

		if(empty($pathBase))
			return(false);

		//make base path
		$pathAssets = $pathBase.$dirAssets."/";
		if(is_dir($pathAssets) == false)
		UniteFunctionsUC::mkdir($pathAssets);

		if(is_dir($pathAssets) == false)
			UniteFunctionsUC::throwError("Can't create folder: {$pathAssets}");

		//--- make url assets
		$urlAssets = $urlBase.$dirAssets."/";


		if(empty($pathAssets))
			UniteFunctionsUC::throwError("Cannot set assets path");

		if(empty($urlAssets))
			UniteFunctionsUC::throwError("Cannot set assets url");

		if($returnValues == true){

			$arrReturn = array();
			$arrReturn["path_assets"] = $pathAssets;
			$arrReturn["url_assets"] = $urlAssets;

			return($arrReturn);
		}else{
			GlobalsUC::$pathAssets = $pathAssets;
			GlobalsUC::$url_assets = $urlAssets;
		}

	}



	/**
	 * is admin function
	 */
	public static function isAdmin(){

		$isAdmin = is_admin();

		return($isAdmin);
	}

	public static function a________SCRIPTS_________(){}


	/**
	 * add scripts and styles framework
	 * $specialSettings - (nojqueryui)
	 */
	public static function addScriptsFramework($specialSettings = ""){

		UniteFunctionsWPUC::addMediaUploadIncludes();

		//add jquery
		self::addAdminJQueryInclude();

		//add jquery ui
		wp_enqueue_script("jquery-ui-core");
		wp_enqueue_script("jquery-ui-widget");
		wp_enqueue_script("jquery-ui-dialog");
		wp_enqueue_script("jquery-ui-resizable");
		wp_enqueue_script("jquery-ui-draggable");
		wp_enqueue_script("jquery-ui-droppable");
		wp_enqueue_script("jquery-ui-position");
		wp_enqueue_script("jquery-ui-selectable");
		wp_enqueue_script("jquery-ui-sortable");
		wp_enqueue_script("jquery-ui-autocomplete");
		wp_enqueue_script("jquery-ui-slider");

		//no jquery ui style
		if($specialSettings != "nojqueryui"){
			HelperUC::addStyle("jquery-ui.structure.min","jui-smoothness-structure","css/jui/new");
			HelperUC::addStyle("jquery-ui.theme.min","jui-smoothness-theme","css/jui/new");
		}

		if(function_exists("wp_enqueue_media"))
			wp_enqueue_media();

	}


	/**
	 * add jquery include
	 */
	public static function addAdminJQueryInclude(){

		wp_enqueue_script("jquery");

	}


	/**
	 *
	 * register script
	 */
	public static function addScript($handle, $url, $inFooter = false, $deps = array()){

		if(empty($url))
			UniteFunctionsUC::throwError("empty script url, handle: $handle");

		$version = UNLIMITED_ELEMENTS_VERSION;
		if(GlobalsUC::$inDev == true)	//add script
			$version = time();
		
		wp_register_script($handle , $url, $deps, $version, $inFooter);
		wp_enqueue_script($handle);
	}


	/**
	 * register script
	 */
	public static function addStyle($handle, $url, $deps = array()){

		if(empty($url))
			UniteFunctionsUC::throwError("empty style url, handle: $handle");

		$version = UNLIMITED_ELEMENTS_VERSION;
		if(GlobalsUC::$inDev == true)	//add script
			$version = time();

		wp_register_style($handle, $url, $deps, $version);
		wp_enqueue_style($handle);

	}


	/**
	 * print some script at some place in the page
	 * handle meanwhile inactive
	 */
	public static function printCustomScript($script, $hardCoded = false, $isModule = false, $handle = null, $isPutOnce = false){
		
		
		self::$counterScripts++;

		if(empty($handle))
			$handle = "script_".self::$counterScripts;

		if($isModule == true)
			$handle = "module_".$handle;

		if(isset(self::$arrScripts[$handle])){

			if($isPutOnce === true)
				return(false);

			$handle .= "_". UniteFunctionsUC::getRandomString(5, true);
		}
				
		if($hardCoded == false)
			self::$arrScripts[$handle] = $script;
		else{
			 
			if($isModule == true)
				uelm_echo( "<script type='module' id='{$handle}'>{$script}</script>" );
			else
				uelm_echo( "<script type='text/javascript' id='{$handle}'>{$script}</script>" );
			
		}
				
	}


	/**
	 * print custom style
	 */
	public static function printCustomStyle($style, $hardCoded = false){
		
		if($hardCoded == false)
			self::$arrStyles[] = $style;
		else
			uelm_echo( "<style type='text/css'>{$style}</style>");
		
	}


	/**
	* get all custom scrips, delete the scripts array later
	*/
	public static function getCustomScripts(){

	    $arrScripts = self::$arrScripts;

	    self::$arrScripts = array();

		return($arrScripts);
	}


	/**
	 * get custom styles, delete the styles later
	 */
	public static function getCustomStyles(){

	    $arrStyles = self::$arrStyles;

	    self::$arrStyles = array();

		return($arrStyles);
	}


	/**
	 * get url jquery include
	 */
	public static function getUrlJQueryInclude(){

		$url = GlobalsUC::$url_base."wp-includes/js/jquery/jquery".".js";

		return($url);
	}

	/**
	 * get jquery migrate url include
	 */
	public static function getUrlJQueryMigrateInclude(){

		$url = GlobalsUC::$url_base."wp-includes/js/jquery/jquery-migrate".".js";

		return($url);
	}


	public static function a_________SANITIZE________(){}


	/**
	 * filter variable
	 */
	public static function sanitizeVar($var, $type){

		switch($type){
			case UniteFunctionsUC::SANITIZE_ID:

				if(is_array($var))
					return(null);

				if(empty($var))
					return("");

				$var = (int)$var;
				$var = abs($var);

				if($var == 0)
					return("");

			break;
			case UniteFunctionsUC::SANITIZE_KEY:

				if(is_array($var))
					return(null);

				$var = sanitize_key($var);
			break;
			case UniteFunctionsUC::SANITIZE_TEXT_FIELD:
				$var = sanitize_text_field($var);
			break;
			case UniteFunctionsUC::SANITIZE_NOTHING:
			break;
			default:
				UniteFunctionsUC::throwError("Wrong sanitize type: " . $type);
			break;
		}

		return($var);
	}

	/**
	 * escape html
	 */
	public static function escHtml($html){

		$html = esc_html($html);

		return($html);
	}

	public static function a_________GENERAL_________(){}



	/**
	 * get image url from image id
	 */
	public static function getImageUrlFromImageID($imageID, $size = UniteFunctionsWPUC::THUMB_FULL){

		$urlImage = UniteFunctionsWPUC::getUrlAttachmentImage($imageID, $size);

		return $urlImage;
	}

	/**
	 * get image url from image id
	 */
	public static function getThumbUrlFromImageID($imageID, $size = UniteFunctionsWPUC::THUMB_MEDIUM){

		if(empty($imageID) === true)
			return "";

		switch($size){
			case GlobalsUC::THUMB_SIZE_NORMAL:
				$size = UniteFunctionsWPUC::THUMB_MEDIUM;
			break;
			case GlobalsUC::THUMB_SIZE_LARGE:
				$size = UniteFunctionsWPUC::THUMB_LARGE;
			break;
		}

		$urlThumb = UniteFunctionsWPUC::getUrlAttachmentImage($imageID, $size);

		return $urlThumb;
	}

	/**
	 * get image id from url
	 * if not, return null or 0
	 */
	public static function getImageIDFromUrl($urlImage){

		$imageID = UniteFunctionsWPUC::getAttachmentIDFromImageUrl($urlImage);

		return($imageID);
	}


	/**
	 * strip slashes from ajax input data
	 */
	public static function normalizeAjaxInputData($arrData){

		if(!is_array($arrData))
			return($arrData);

		foreach($arrData as $key=>$item){

			if(is_string($item))
				$arrData[$key] = stripslashes($item);

			//second level
			if(is_array($item)){

				foreach($item as $subkey=>$subitem){
					if(is_string($subitem))
						$arrData[$key][$subkey] = stripslashes($subitem);

					//third level
					if(is_array($subitem)){

						foreach($subitem as $thirdkey=>$thirdItem){
							if(is_string($thirdItem))
								$arrData[$key][$subkey][$thirdkey] = stripslashes($thirdItem);
						}

					}

				}
			}

		}

		return($arrData);
	}

	
	/**
	 * put footer text line
	 */
	public static function putFooterTextLine(){
		?>
			&copy; <?php esc_html_e("All rights reserved","unlimited-elements-for-elementor")?>, <a href="https://unlimited-elements.com" target="_blank"><?php echo esc_attr(GlobalsUnlimitedElements::$pluginTitleCurrent) ?></a>. &nbsp;&nbsp;
		<?php
	}


	/**
	 * add jquery include
	 */
	public static function addjQueryInclude($app="", $urljQuery = null){

		wp_enqueue_script("jquery");
	}



	/**
	 * print some custom html to the page
	 */
	public static function printInlineHtml($html){
		self::$arrInlineHtml[] = $html;
	}


	/**
	 * get custom html
	 */
	public static function getInlineHtml(){

		return(self::$arrInlineHtml);
	}


	/**
	 * add system contsant data to template engine
	 */
	public static function addSystemConstantData($data){

		$data["uc_url_home"] = get_home_url();
		$data["uc_url_blog"] = UniteFunctionsWPUC::getUrlBlog();

		$isWPMLExists = UniteCreatorWpmlIntegrate::isWpmlExists();
		if($isWPMLExists == true){

			$objWpml = new UniteCreatorWpmlIntegrate();
			$activeLanguage = $objWpml->getActiveLanguage();

			$data["uc_lang"] = $activeLanguage;
		}else{

			$data["uc_lang"] = UniteFunctionsWPUC::getLanguage();
		}

		$isInsideEditor = GlobalsProviderUC::$isInsideEditor;

		$isAdminUser = current_user_can('manage_options');

		$data["uc_inside_editor"] = $isInsideEditor?"yes":"no";
		$data["uc_admin_user"] = $isAdminUser?"yes":"no";

		return($data);
	}



	/**
	 * put addon view add html
	 */
	public static function putAddonViewAddHtml(){
		//put nothing meanwhile
	}




	/**
	 * get nonce (for protection)
	 */
	public static function getNonce(){

		$nonceName = self::getNonceName();

		$nonce = wp_create_nonce($nonceName);

		return($nonce);
	}


	/**
	 * get nonce name
	 */
	public static function getNonceName(){

		$userID = get_current_user_id();

		if(empty($userID))
			$userID = "none";

		$name = GlobalsUC::PLUGIN_NAME."_actions_{$userID}";

		return($name);
	}

	/**
	 * veryfy nonce
	 */
	public static function verifyNonce($nonce){

		if(function_exists("wp_verify_nonce") == false){

			dmp("verify nonce function not found. some other plugin interrupting this call");
			dmp("please find it in this trace by follow 'wp-content/plugins'");

			UniteFunctionsUC::showTrace();
			exit();
		}

		$nonceName = self::getNonceName();


		$verified = wp_verify_nonce($nonce, $nonceName);
		if($verified == false)
			UniteFunctionsUC::throwError("Action security failed, please refresh the page and try again.");

	}


	/**
	 * put helper editor to help init other editors that has put by ajax
	 */
	public static function putInitHelperHtmlEditor($unhide = false){

		$style = "display:none";
		if($unhide == true)
			$style = "";


		?>
		<div style="<?php echo esc_attr($style)?>">

			<?php
				wp_editor("init helper editor","uc_editor_helper");
			?>

		</div>
		<?php

	}

	/**
	 * send email, throw error on fail
	 */
	public static function sendEmail($emailTo, $subject, $message){

		$isSent = wp_mail( $emailTo, $subject, $message);
		if($isSent == false)
			UniteFunctionsUC::throwError("The mail is not sent");

		//TODO: return real message
	}


	/**
	 * set admin title
	 */
	public static function setAdminTitle($title){

		if(GlobalsUC::$is_admin == false)
			UniteFunctionsUC::throwError("The function works only in admin area");

		UniteProviderAdminUC::$adminTitle = $title;
	}

	/**
	 * set admin page title
	 */
	public static function setAdminPageTitle($title){

	}

	/**
	 * get post title by ID
	 */
	public static function getPostTitleByID($postID){

		$post = get_post($postID);
		if(empty($post))
			return("");

		$title = $post->post_title;

		return($title);
	}

	private static function a_________OPTIONS_________(){}


	/**
	 * get option
	 */
	public static function getOption($option, $default = false, $supportMultisite = false){

		if($supportMultisite == true && is_multisite())
			return(get_site_option($option, $default));
		else
			return get_option($option, $default);

	}

	/**
	 * get transient
	 */
	public static function getTransient($transient, $supportMultisite = false){

		if($supportMultisite == true && is_multisite())
			return get_site_transient($transient);
		else
			return get_transient($transient);
	}

	/**
	 * set transient
	 */
	public static function setTransient($transient, $value, $expiration, $supportMultisite = false){

		if($supportMultisite == true && is_multisite()){
			set_site_transient($transient, $value, $expiration);
		}else
			set_transient($transient, $value, $expiration);
	}

	/**
	 * remember transient
	 */
	public static function rememberTransient($transient, $expiration, $callback, $supportMultisite = false){

		if($expiration <= 0){
			$value = $callback();

			return $value;
		}

		$value = self::getTransient($transient, $supportMultisite);

		if(empty($value)){
			$value = $callback();

			self::setTransient($transient, $value, $expiration, $supportMultisite);
		}

		return $value;
	}

	/**
	 * delete option
	 */
	public static function deleteOption($option, $supportMultisite = false){

		if($supportMultisite == true && is_multisite()){
			delete_site_option($option);
		}else
			delete_option($option);

	}

	/**
	 * update option
	 */
	public static function updateOption($option, $value, $supportMultisite = false,$autoload = null){

		if($supportMultisite == true && is_multisite()){
			$response = update_site_option($option, $value);
		}else
			$response = update_option($option, $value, $autoload);
		
		return($response);
	}

	
	public static function a________ACTIONS_FILTERS_______(){}


	/**
	 * add filter
	 */
	public static function addFilter($tag, $function_to_add, $priority = 10, $accepted_args = 1 ){
		add_filter($tag, $function_to_add, $priority, $accepted_args);
	}


	/**
	 * wrap shortcode
	 */
	public static function wrapShortcode($shortcode){
		$shortcode = "[".$shortcode."]";
		return($shortcode);
	}


	/**
	 * apply filters
	 */
	public static function applyFilters($func, $value){
		$args = func_get_args();

		return call_user_func_array("apply_filters",$args);
	}


	/**
	 * add action function
	 */
	public static function addAction($action, $func){
		$args = func_get_args();

		call_user_func_array("add_action", $args);
	}


	/**
	 * convert url to new window
	 */
	public static function convertUrlToBlankWindow($url){
		$params = "ucwindow=blank";

		$url = UniteFunctionsUC::addUrlParams($url, $params);

		return($url);
	}


	/**
	 * do action
	 */
	public static function doAction($tag){
		$args = func_get_args();

		call_user_func_array("do_action", $args);
	}


}
?>
