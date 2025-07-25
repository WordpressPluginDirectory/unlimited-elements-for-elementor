<?php

if ( ! defined( 'ABSPATH' ) ) exit;

class GlobalsProviderUC{
			
	const META_KEY_LAYOUT_DATA = "_unelements_layout_data";
	const META_KEY_LAYOUT_PARAMS = "_unelements_layout_params";
	
	const META_KEY_BLOX_PAGE = "_unelements_page_enabled";
	const META_KEY_CATID = "_unelements_catid";
	const META_KEY_LAYOUT_TYPE = "_unelements_layout_type";

	
	const PAGE_TEMPLATE_LANDING_PAGE = "blox_landing_page";
	const POST_TYPE_LAYOUT = "unelements_library";
	
	const SHORTCODE_LAYOUT = "unlimited_layout";
	
	const ACTION_RUN_ADMIN = "unitecreator_run_admin";
	const ACTION_RUN_FRONT = "unitecreator_run_front";
	
	const RENDER_PLATFORM_ELEMENTOR = "elementor";
	const RENDER_PLATFORM_GUTENBERG = "gutenberg";
	
	public static $renderPlatform = null;
	public static $isGutenbergOutput = false;
	public static $widgetText = "";
	
	public static $arrJSHandlesModules = array();
	
	public static $activeAddonForSettings = null;
	public static $lastPostQuery = null;
	public static $lastPostQuery_page = null;
	public static $lastPostQuery_offset = null;
	public static $lastPostQuery_type = null;
	public static $lastPostQuery_paginationType = null;
	public static $skipRunPostQueryOnce = false;
		
	public static $lastQueryArgs = null;
	public static $lastQueryRequest = null;
	
	public static $isUnderAjaxSearch = false;
	public static $isUnderRenderPostItem = false;
	public static $isUnderItem = false;
	public static $lastItemParams = array();
	public static $lastObjectID = null;
	public static $isUnderDynamicTemplateLoop = false;
	public static $isUnderNoWidgetsToDisplay = false;
	public static $showPostsQueryDebug = false;
	
	public static $isInsideEditor = false;	//tells that it's inside editor
	public static $isInsideEditorBackend = false;	//tells that it's inside editor
	
	
	public static $arrTestTermIDs = null;	//test term id's for render taxonomies under ajax
	
	public static $disablePostContentFiltering = false;
	
	const QUERY_TYPE_CURRENT = "current";
	const QUERY_TYPE_CUSTOM = "custom";
	const QUERY_TYPE_MANUAL = "manual";
	
	public static $arrFetchedPostIDs = array();	
	public static $arrPostTermsCache = array();	
	public static $arrFetchedPostsObjectsCache = array();	
	
	public static $isUnderAjaxDynamicTemplate = false;
	public static $isUnderAjax = false;
	
	public static $renderJSForHiddenContent = false;		//render encoded js - for hidden templates
	public static $renderTemplateID = "";					//render template id (for the template switcher)
	public static $isInsideHiddenTemplate = false;				//for some output modification
	public static $showDebugFunction = false;
	
	public static $arrFilterPostTypes = array(		//filter post types that will not show
				"elementor_library", 
				"unelements_library", 
				"wpcf7_contact_form",
				"_pods_pod",
				"_pods_field",
				"_pods_template",
				"wp-types-group",
				"wp-types-user-group",
				"wp-types-term-group",
				"elementor_font",
				"elementor_icons"
	);
	
	public static $arrAttrConstantKeys = array(		//keys of constants that are added to the attributes
		"uc_serial",
		"uc_id",
		"uc_assets_url",
		"uc_url_home",
		"uc_url_blog",
		"uc_lang",
		"uc_num_items"
	);
	
	const POST_ADDITION_CUSTOMFIELDS = "customfields";
	const POST_ADDITION_CATEGORY = "category";
	const POST_ADDITION_WOO = "woo";
	
	
	/**
	 * init globals
	 */
	public static function initGlobals(){
		
		self::$widgetText = "widget";
		
		self::$arrFilterPostTypes = UniteFunctionsUC::arrayToAssoc(self::$arrFilterPostTypes);
		
	}
	
	/**
	 * set gutenberg platform options
	 */
	public static function setGutenbergPlatform(){
		
		self::$widgetText = "block";
		self::$renderPlatform = self::RENDER_PLATFORM_GUTENBERG;
		self::$isGutenbergOutput = true;
		
	}
	
}

GlobalsProviderUC::initGlobals();