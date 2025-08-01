<?php
/**
 * @package Unlimited Elements
 * @author unlimited-elements.com
 * @copyright (C) 2021 Unlimited Elements, All Rights Reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
if ( ! defined( 'ABSPATH' ) ) exit;

class UniteCreatorParamsProcessorWork{

	private $objShapes;
	protected $addon;
	protected $processType;
	private static $counter = 0;
	private $arrMainParamsValuesCache = array();
	protected $dynamicPopupParams = array();
	protected $dynamicPopupEnabled = false;

	const ITEMS_ATTRIBUTE_PREFIX = "uc_items_attribute_";
	const KEY_ITEM_INDEX = "_uc_item_index_";

	const PROCESS_TYPE_CONFIG = "config";	//process for output the config
	const PROCESS_TYPE_OUTPUT = "output";	//process for output
	const PROCESS_TYPE_OUTPUT_BACK = "output_back";	//process for backend live output
	const PROCESS_TYPE_SAVE = "save";		//process for save


	/**
	 * validate that the processor inited
	 */
	private function validateInited(){

		if(empty($this->addon))
			UniteFunctionsUC::throwError("The params processor is not inited");

	}

	/**
	 * validate that process type exists
	 */
	private function validateProcessTypeInited(){

		if(empty($this->processType))
			UniteFunctionsUC::throwError("The process type is not inited");

		self::validateProcessType($this->processType);
	}


	private function z____________GENERAL____________(){}

	/**
	 * validate process type
	 */
	public static function validateProcessType($type){
		UniteFunctionsUC::validateValueInArray($type, "process type",array(
				self::PROCESS_TYPE_CONFIG,
				self::PROCESS_TYPE_SAVE,
				self::PROCESS_TYPE_OUTPUT,
				self::PROCESS_TYPE_OUTPUT_BACK,
		));
	}


	/**
	 * convert from url assets
	 */
	private function convertFromUrlAssets($value){

		$urlAssets = $this->addon->getUrlAssets();

		if(!empty($urlAssets))
			$value = HelperUC::convertFromUrlAssets($value, $urlAssets);

		return($value);
	}

	/**
	 * process param value, by param type
	 * if it's url, convert to full
	 */
	protected function convertValueByType($value, $type, $param){

		if(empty($value))
			return($value);

		if(is_string($value)){

			$value = $this->convertFromUrlAssets($value);

			switch($type){
				case "uc_image":
				case "uc_mp3":
					$value = HelperUC::URLtoFull($value);
					break;
			}

		}
		
		switch($type){
			case UniteCreatorDialogParam::PARAM_NUMBER:		//modify number field
				
				if(is_array($value)){
					
					$defaultValue = UniteFunctionsUC::getVal($param, "default_value");
					$value = UniteFunctionsUC::getVal($value, "size", $defaultValue);
					
					if(is_numeric($value) == false)
						$value = 0;
					
				}
				
			break;
		}
		
		$addonType = $this->addon->getType();

		if($addonType == "elementor")
			$value = HelperProviderCoreUC_EL::processParamValueByType($value, $type, $param);

		return($value);
	}


	/**
	 * make sure the value is always taken from the options
	 */
	private function convertValueFromOptions($value, $options, $defaultValue){

		if(is_array($options) == false)
			return($value);

		if(empty($options))
			return($value);

		if(is_array($value))
			return($value);

		$key = array_search($value, $options, true);
		if($key !== false)
			return($value);

		//------- not found
		//in case of false / nothing
		if(empty($value)){
			$key = array_search("false", $options, true);
			if($key !== false)
				return("false");
		}

		//if still not found, return default value
		return($defaultValue);
	}

	/**
	 * check modify filter manually
	 */
	private function checkModifyParamOptions_manual($options, $phpFilter){

		switch($phpFilter){
			case "ue_sort_filter":

				$optionsSortBy = UniteFunctionsWPUC::getArrSortBy(true, true);

				$options = array_flip($options);

				$options = array_merge($options,$optionsSortBy);
			break;
		}

		return($options);
	}

	/**
	 * check for modify options
	 */
	private function checkModifyParamOptions($param){

		if(isset($param["options"]) === false)
			return $param;

		$phpFilter = UniteFunctionsUC::getVal($param, "php_filter_name");

		if(empty($phpFilter) === true)
			return $param;

		$options = $param["options"];

		//manual modify
		$options = $this->checkModifyParamOptions_manual($options, $phpFilter);

		//general modify
		$options = apply_filters("ue_modify_dropdown_" . $phpFilter, $options);

		if(empty($options) === true)
			$options = array();

		// bug: options shouldn't be flipped, because it swaps label-value pairs, which is wrong
		// keep for backward compatibility
		if(empty($options) === false)
			$options = array_flip($options);

		$value = UniteFunctionsUC::getVal($param, "value");

		if(is_string($value) === true && in_array($value, $options) === false)
			$value = UniteFunctionsUC::getArrFirstValue($options);

		$param["options"] = $options;
		$param["value"] = $value;

		return $param;
	}

	/**
	 * construct the object
	 */
	public function init($addon){

		//for auto complete
		//$this->addon = new UniteCreatorAddon();

		$this->addon = $addon;

	}


	/**
	 * set process type
	 */
	public function setProcessType($type){

		self::validateProcessType($type);
		$this->processType = $type;
	}


	/**
	* return if it's output process type
	 */
	public function isOutputProcessType($processType){

		if($processType == self::PROCESS_TYPE_OUTPUT || $processType == self::PROCESS_TYPE_OUTPUT_BACK)
			return(true);

		return(false);
	}

	/**
	 * process responsive param
	 */
	protected function getProcessedParamsValue_responsive($data, $param){

		$isResponsive = UniteFunctionsUC::getVal($param, "is_responsive");
		$isResponsive = UniteFunctionsUC::strToBool($isResponsive);

		if($isResponsive == false)
			return($data);

		$defaultValueTablet = UniteFunctionsUC::getVal($param, "default_value_tablet");
		$defaultValueMobile = UniteFunctionsUC::getVal($param, "default_value_mobile");

		$valueTablet = UniteFunctionsUC::getVal($param, "value_tablet", $defaultValueTablet);
		$valueMobile = UniteFunctionsUC::getVal($param, "value_mobile",$defaultValueMobile);

		$name = UniteFunctionsUC::getVal($param, "name");

		$data[$name."_tablet"] = $valueTablet;
		$data[$name."_mobile"] = $valueMobile;


		return($data);
	}

	/**
	 * get the addon
	 */
	public function getAddon(){

		return($this->addon);
	}

	private function a________RADIO_BOOLEAN_________(){}


	/**
	 * process values - radio boolean
	 */
	private function getProcessedParamsValue_radioBoolean($data, $param, $value){

		$data = $this->getProcessedParamsValue_responsive($data, $param);

		if(!empty($value))
			return($data);

		//handle empty value - set to false value instead

		$valueTrue = UniteFunctionsUC::getVal($param, "true_value");

		if(empty($valueTrue))
			return($data);

		$value = UniteFunctionsUC::getVal($param, "false_value");

		$name = UniteFunctionsUC::getVal($param, "name");

		$data[$name] = $value;

		return($data);
	}


	private function a________FONTS_________(){}


	/**
	 * process the font
	 */
	public function processFont($value, $arrFont, $isReturnCss = false, $cssSelector = null, $fontsKey=""){

		//$this->validateInited();

		$arrStyle = array();
		$spanClass = "";
		$addStyles = "";
		$arrGoogleFonts = null;
		$cssMobileSize = "";
		$fontTemplate = null;

		if(empty($arrFont))
			$arrFont = array();

		//UniteFunctionsUC::showTrace();
		//dmp($arrFont);exit();

		//on production don't return empty span
		if($this->processType == self::PROCESS_TYPE_OUTPUT && empty($arrFont) && $isReturnCss == false)
			return($value);

		//generate id
		if($isReturnCss == true){
			$spanClass = $cssSelector;
			$mobileSizeClass = $cssSelector;
		}
		else{
			self::$counter++;
			$spanClass = "uc-style-".self::$counter.UniteFunctionsUC::getRandomString(10, true);
			$mobileSizeClass = ".".$spanClass;
		}

		foreach($arrFont as $styleName => $styleValue){

			if(is_array($styleValue))
				continue;

			if(strpos($styleName, "typography_") === 0)
				continue;

			$styleValue = trim($styleValue);

			if(empty($styleValue))
				continue;

			if($styleValue == "not_chosen")
				continue;

			switch($styleName){
				case "font-family":

					if(strpos($styleValue, " ") !== false && strpos($styleValue, ",") === false)
						$arrStyle[$styleName] = "'$styleValue'";
					else
						$arrStyle[$styleName] = "$styleValue";

					//check google fonts
					if(empty($arrGoogleFonts)){
						$arrFontsPanelData = HelperUC::getFontPanelData();
						$arrGoogleFonts = $arrFontsPanelData["arrGoogleFonts"];
					}

					if(isset($arrGoogleFonts[$styleValue])){
						$urlGoogleFont = HelperHtmlUC::getGoogleFontUrl($arrGoogleFonts[$styleValue]);

						if(!empty($this->addon)){
							//$urlGoogleFont .= "&amp;fromaddon=".$this->addon->getName();
							$this->addon->addCssInclude($urlGoogleFont);
						}
						else{
							$handle = HelperUC::getUrlHandle($urlGoogleFont);
							HelperUC::addStyleAbsoluteUrl($urlGoogleFont, $handle);
						}

					}
				break;
				case "font-weight":
				case "line-height":
				case "text-decoration":
				case "color":
				case "font-style":
					$arrStyle[$styleName] = $styleValue;
				break;
				case "font-size":
					$arrStyle[$styleName] = UniteFunctionsUC::normalizeSize($styleValue);
				break;
				case "font-size-mobile":
				case "mobile-size":
				case "font-size-tablet":

					$styleValue = UniteFunctionsUC::normalizeSize($styleValue);

					$isTablet = false;
					if($styleName == "font-size-tablet")
						$isTablet = true;

					$cssMobileSize = "{$mobileSizeClass}{font-size:{$styleValue} !important;}";
					$cssMobileSize = HelperHtmlUC::wrapCssMobile($cssMobileSize, $isTablet);

					if($isReturnCss == false)
						$this->addon->addToCSS($cssMobileSize);

				break;

				case "custom":
					$addStyles = $styleValue;
				break;
				case "template":
					$fontTemplate = $styleValue;
				break;
				case "style-selector":
					$spanClass = $styleValue;
					$mobileSizeClass = ".".$spanClass;
				break;

				default:
					UniteFunctionsUC::throwError("Wrong font style: $styleName");
				break;
			}
		}


		if($isReturnCss == true){
			$css = UniteFunctionsUC::arrStyleToStrInlineCss($arrStyle, $addStyles, false);

			if(!empty($css))
				$css = $cssSelector."{".$css."}";

			if(!empty($cssMobileSize))
				$css .= "\n".$cssMobileSize;

			return($css);
		}


		$style = "";
		if(!empty($arrStyle) || !empty($addStyles))
			$style = UniteFunctionsUC::arrStyleToStrInlineCss($arrStyle, $addStyles);

		$htmlAdd = "";
		$arrClasses = array();
		if(!empty($spanClass))
			$arrClasses[] = $spanClass;

		//if linked to font template, eliminate the style, and add template class
		if(!empty($fontTemplate))
			$arrClasses[] = 'uc-page-font-'.$fontTemplate;

		if($this->processType == self::PROCESS_TYPE_OUTPUT_BACK){

			$arrClasses[] = "uc-font-editable-field";
			$htmlAdd .= " data-uc_font_field=\"{$fontsKey}\" ";
			$htmlAdd .= " contenteditable";

			//UniteFunctionsUC::showTrace();exit();
		}

		if(!empty($arrClasses)){
			$strClasses = implode(" ", $arrClasses);
			$htmlAdd .= " class=\"{$strClasses}\"";
		}

		$value = "<span {$htmlAdd} {$style}>$value</span>";
		return($value);
	}


	/**
	 * process fonts, type can be main or items
	 */
	private function processFonts($arrValues, $type, $itemIndex=null){

		$this->validateProcessTypeInited();

		$arrFonts = $this->addon->getArrFonts();

		$arrFontEnabledKeys = $this->getAllParamsNamesForFonts();


		if(empty($arrValues))
			return($arrValues);

		switch($type){
			case "main":
				$prefix = "";
				$prefixForOutput = "";
			break;
			case "items":
				$prefix = self::ITEMS_ATTRIBUTE_PREFIX;
				$prefixForOutput = $prefix;

				if($itemIndex !== null)
					$prefixForOutput = $prefix.$itemIndex."_";

			break;
			default:
				UniteFunctionsUC::throwError("Wrong fonts type: $type");
			break;
		}


		foreach($arrValues as $key=>$value){

			if(empty($value))
				continue;


			//for items like posts
			if(is_array($value)){

				foreach($value as $itemIndex => $item){

					if(!is_array($item))
						continue;

					foreach($item as $itemKey => $itemValue){
						$fontsKey = $prefix.$key.".$itemKey";
						$fontsKeyOutput = $prefixForOutput.$key.".$itemKey";

						$arrFont = UniteFunctionsUC::getVal($arrFonts, $fontsKey);
						$isFontEnabled = isset($arrFontEnabledKeys[$fontsKey]);


						if(!empty($arrFont) || $isFontEnabled)
							$arrValues[$key][$itemIndex][$itemKey] = $this->processFont($itemValue, $arrFont, false, null, $fontsKeyOutput);
					}
				}

				continue;
			}

			$fontsKey = $prefix.$key;
			$fontsKeyOutput = $prefixForOutput.$key;

			$arrFont = UniteFunctionsUC::getVal($arrFonts, $fontsKey);

			$isFontEnabled = isset($arrFontEnabledKeys[$fontsKey]);
			if(!empty($arrFont) || $isFontEnabled)
				$arrValues[$key] = $this->processFont($value, $arrFont, false, null, $fontsKeyOutput);

		}


		return($arrValues);
	}


	/**
	 * return if fonts panel enabled for this addon
	 */
	public function isFontsPanelEnabled(){

		$this->validateInited();

		$arrParams = $this->addon->getParams();

		$hasItems = $this->addon->isHasItems();

		if($hasItems == true){
			$arrParamsItems = $this->addon->getParamsItems();
			$arrParams = array_merge($arrParams, $arrParamsItems);
		}

		$numValidParams = 0;
		foreach($arrParams as $param){
			$type = UniteFunctionsUC::getVal($param, "type");

			switch($type){
				case UniteCreatorDialogParam::PARAM_EDITOR:
				case UniteCreatorDialogParam::PARAM_TEXTAREA:
				case UniteCreatorDialogParam::PARAM_TEXTFIELD:
				case UniteCreatorDialogParam::PARAM_DROPDOWN:
				case UniteCreatorDialogParam::PARAM_FONT_OVERRIDE:
				case UniteCreatorDialogParam::PARAM_POSTS_LIST:
				case UniteCreatorDialogParam::PARAM_SPECIAL:
				case UniteCreatorDialogParam::PARAM_POST_TERMS:
				case UniteCreatorDialogParam::PARAM_WOO_CATS:
				case UniteCreatorDialogParam::PARAM_INSTAGRAM:
					$numValidParams++;
				break;
			}

		}


		if($numValidParams == 0)
			return(false);
		else
			return(true);
	}


	/**
	 * get main params names
	 */
	private function getParamsNamesForFonts($paramsType){

		switch($paramsType){
			case "main":
				$arrParams = $this->addon->getParams();
			break;
			case "items":
				if($this->addon->isHasItems() == false)
					return(array());

				$arrParams = $this->addon->getParamsItems();
			break;
			default:
				UniteFunctionsUC::throwError("Wrong params type: $paramsType");
			break;
		}


		$arrNames = array();
		foreach($arrParams as $param){

			$type = UniteFunctionsUC::getVal($param, "type");

			$name = UniteFunctionsUC::getVal($param, "name");
			$title = UniteFunctionsUC::getVal($param, "title");

			if($paramsType == "items"){

				$name = self::ITEMS_ATTRIBUTE_PREFIX.$name;
				$title = esc_html__("Items", "unlimited-elements-for-elementor")." => ".$title;
			}

			$fontEditable = UniteFunctionsUC::getVal($param, "font_editable");
			$fontEditable = UniteFunctionsUC::strToBool($fontEditable);

			switch($type){
				case UniteCreatorDialogParam::PARAM_POSTS_LIST:
					if($fontEditable == true){
						$arrNames["{$name}.title"] = $title." => Title";
						$arrNames["{$name}.intro"] = $title." => Intro";
						$arrNames["{$name}.content"] = $title." => Content";
						$arrNames["{$name}.date"] = $title." => Date";
					}
				break;
				case UniteCreatorDialogParam::PARAM_POST_TERMS:

					if($fontEditable == true){
						$arrNames["{$name}.name"] = $title." => Name";
					}

				break;
				case UniteCreatorDialogParam::PARAM_WOO_CATS:

					if($fontEditable == true){
						$arrNames["{$name}.name"] = $title." => Name";
					}

				break;
				case UniteCreatorDialogParam::PARAM_INSTAGRAM:

					if($fontEditable == true){
						$arrNames["{$name}.name"] = $title." => Name";
						$arrNames["{$name}.username"] = $title." => Username";
						$arrNames["{$name}.biography"] = $title." => Biography";
						$arrNames["{$name}.item.caption"] = $title." => Item => Caption";
					}

				break;
				case UniteCreatorDialogParam::PARAM_FONT_OVERRIDE:
					if($paramsType == "items")
						return(false);

					$arrNames["uc_font_override_".$name] = $title;
				break;
				default:

					if($fontEditable == true)
						$arrNames[$name] = $title;
				break;
			}

		}

		return($arrNames);
	}



	/**
	 * get all params names for font panel
	 */
	public function getAllParamsNamesForFonts(){

		$arrParamsNamesMain = $this->getParamsNamesForFonts("main");

		$arrParamsNamesItems = $this->getParamsNamesForFonts("items");
		$arrParamsNames = array_merge($arrParamsNamesMain, $arrParamsNamesItems);

		return($arrParamsNames);
	}





	private function z______________POST_____________(){}


	/**
	 * get post data
	 */
	public function getPostData($postID, $arrPostAdditions = null){
		dmp("getPostData: function for override");exit();
	}


	/**
	 * process image param value, add to data
	 */
	private function getProcessedParamsValue_post($data, $value, $param, $processType){

		self::validateProcessType($processType);

		$postID = $value;
		if(empty($postID))
			return($data);

		$name = UniteFunctionsUC::getVal($param, "name");
		$arrPostAdditions = UniteFunctionsUC::getVal($param, "post_additions");


		switch($processType){
			case self::PROCESS_TYPE_CONFIG:		//get additional post title

				/*
				$postTitle = UniteProviderFunctionsUC::getPostTitleByID($postID);
				$data[$name] = $postID;

				if(!empty($postTitle))
					$data[$name."_post_title"] = $postTitle;
				*/

			break;
			case self::PROCESS_TYPE_SAVE:
				$data[$name] = $postID;
				unset($data[$name."_post_title"]);
			break;
			case self::PROCESS_TYPE_OUTPUT:
			case self::PROCESS_TYPE_OUTPUT_BACK:

				$data[$name] = $this->getPostData($postID, $arrPostAdditions);
			break;
		}

		return($data);
	}


	/**
	 * process image param value, add to data
	 */
	private function getProcessedParamsValue_content($data, $value, $param, $processType){

		self::validateProcessType($processType);


		return($data);
	}


	private function z_______IMAGE______(){}


	/**
	 * add other image thumbs based of the platform
	 */
	protected function addOtherImageThumbs($data, $name, $value, $filterSizes = null){

		return($data);
	}

	/**
	 * get all image related fields to data, but value
	 * create param with full fields
	 */
	protected function getImageFields($data, $name, $value){

		if(empty($data))
			$data = array();

		//get by param
		$param = array();
		$param["name"] = $name;
		$param["value"] = $value;

		$data[$name] = $value;
		$data = $this->getProcessedParamsValue_image($data, $value, $param);


		return($data);
	}

	/**
	 * get image key
	 */
	private function addImageAttributes_getImageKey($paramName, $name, $param, $data){

		$imageSize = null;

		$chosenImageSize = UniteFunctionsUC::getVal($param, $paramName);
		if(!empty($chosenImageSize))
			$imageSize = $chosenImageSize;

		if($imageSize == "full")
			$imageSize = null;

		$imageKey = $name;
		switch($imageSize){
			case "medium":
				$imageKey = "{$name}_thumb";
			break;
			case "large":
				$imageKey = "{$name}_thumb_large";
			break;
			default:
				$imageKey = "{$name}_thumb_{$imageSize}";
			break;
		}

		if(isset($data[$imageKey]) == false)
			$imageKey = $name;

		return($imageKey);
	}

	/**
	 * add image attributes
	 */
	private function addImageAttributes($data, $name, $param){

		$addImageSizes = UniteFunctionsUC::getVal($param, "add_image_sizes");
		$addImageSizes = UniteFunctionsUC::strToBool($addImageSizes);

		$imageKey = $name;

		if($addImageSizes == true){
			$imageKey = $this->addImageAttributes_getImageKey("value_size", $name, $param, $data);
		}

		$url = UniteFunctionsUC::getVal($data, $imageKey);
		$width = UniteFunctionsUC::getVal($data, $imageKey."_width");
		$height = UniteFunctionsUC::getVal($data, $imageKey."_height");

		$attributes = "";

		$attributes .= " src=\"{$url}\"";

		//add alt

		$alt = UniteFunctionsUC::getVal($data, "{$name}_alt");

		if(!empty($alt)){

			$alt = esc_attr($alt);
			$attributes .= " alt=\"{$alt}\"";
		}

		$data[$name."_attributes_nosize"] = $attributes;

		//add width and height

		if(!empty($width)){
			$attributes .= " width=\"$width\"";
			$attributes .= " height=\"$height\"";
		}

		$data[$name."_attributes"] = $attributes;

		//change the "image" to the given url
		if($addImageSizes == true && !empty($url)){
			$data[$name] = $url;
			if(!empty($width)){
				$data[$name."_width"] = $width;
				$data[$name."_height"] = $height;
			}
		}

		if($addImageSizes == true){

			$imageSize = UniteFunctionsUC::getVal($param, "value_size","full");

			$data[$name."_size"] = $imageSize;
		}


		return($data);
	}

	/**
	 * get default url of json image
	 */
	private function getImageJsonDefaultUrl($param){

		//no value at all - return nothing

		$defaultValue = UniteFunctionsUC::getVal($param, "default_value_json");
		if(empty($defaultValue)){
			return("");
		}

		//only default:

		$urlAssets = $this->addon->getUrlAssets();

		if(empty($urlAssets))
			return("");

		$urlDefault = $urlAssets.$defaultValue;

		return($urlDefault);
	}

	/**
	 * get image as json processed data
	 */
	private function getProcessedParamsValue_imageJson($data, $value, $param){



		//if the value is emtpy
		if(empty($value)){

			$urlDefault = $this->getImageJsonDefaultUrl($param);
			return($urlDefault);
		}

		//if the value is string, must be a url, return it

		if(is_numeric($value) == false)
			return($value);

		//if the value is number, get the url

		$postThumb = get_post($value);

		//if no thumb found by id - return default
		if(empty($postThumb)){

			$urlDefault = $this->getImageJsonDefaultUrl($param);
			return($urlDefault);
		}

		$urlJson = $postThumb->guid;


		return($urlJson);
	}


	/**
	 * process image param value, add to data
	 */
	protected function getProcessedParamsValue_image($data, $value, $param){

		$name = UniteFunctionsUC::getVal($param, "name");
		$mediaType = UniteFunctionsUC::getVal($param, "media_type");

		if($mediaType === "json"){
			$data[$name] = $this->getProcessedParamsValue_imageJson($data, $value, $param);

			return $data;
		}

		$imageId = null;
		$imageUrl = null;
		$imageSize = "full";

		if(is_array($value) === true){
			$imageId = UniteFunctionsUC::getVal($value, "id");
			$imageUrl = UniteFunctionsUC::getVal($value, "url");
			$imageSize = UniteFunctionsUC::getVal($value, "size", "full");
		}else{
			if(is_numeric($value) === true)
				$imageId = $value;
			else
				$imageUrl = $value;
		}

		if(empty($imageId) === true && empty($imageUrl) === true) {
			$data[$name] = "";

			return $data;
		}

		if(empty($imageId) === false)
			$imageUrl = UniteProviderFunctionsUC::getImageUrlFromImageID($imageId, $imageSize);
		else
			$imageUrl = HelperUC::URLtoFull($imageUrl);
		
		//sanitize the url
		if(!empty($imageUrl))
			$imageUrl = UniteFunctionsUC::sanitize($imageUrl, UniteFunctionsUC::SANITIZE_URL);
					
		$data[$name] = $imageUrl;

		$sizeFilters = UniteFunctionsUC::getVal($param, "size_filters");
		$data = $this->addOtherImageThumbs($data, $name, $imageId, $sizeFilters);

		$isNoImageData = UniteFunctionsUC::getVal($param, "no_image_data");
		$isNoImageData = UniteFunctionsUC::strToBool($isNoImageData);

		if($isNoImageData !== true)
			$data = $this->addOtherImageData($data, $name, $imageId);

		$isNoAttributes = UniteFunctionsUC::getVal($param, "no_attributes");
		$isNoAttributes = UniteFunctionsUC::strToBool($isNoAttributes);

		if($isNoAttributes !== true)
			$data = $this->addImageAttributes($data, $name, $param);

		$keyThumb = $name . "_thumb";
		$urlThumb = UniteFunctionsUC::getVal($data, $keyThumb);
		
		if(empty($urlThumb) === true)
			$data[$keyThumb] = $imageUrl;
		
		return $data;
	}


	private function z___________ICON_____________(){}


	/**
	 * process image param value, add to data
	 * @param  $param
	 */
	protected function getProcessedParamsValue_icon($data, $value, $param, $processType){


		//get array item from simple array like value[0] = value
		if(is_array($value) && count($value) == 1 && isset($value[0]))
			$value = $value[0];


		$isSVG = false;
		$svgContent = null;

		if(is_array($value) == true){

			$library = UniteFunctionsUC::getVal($value, "library");

			if(isset($value["value"]))
				$value = UniteFunctionsUC::getVal($value, "value");

			if($library == "svg"){

				$value = UniteFunctionsUC::getVal($value, "url");	//in case of svg
				$isSVG = true;

				//value is "url" here

				if(!empty($value))
					$value = HelperUC::URLtoFull($value);


				//try to get the content
				$putAs = UniteFunctionsUC::getVal($param, "put_svg_as");

				if($putAs == "svg")
					$svgContent = HelperUC::getFileContentByUrl($value, "svg");
			}

		}

		$name = $param["name"];

		$iconsType = UniteFunctionsUC::getVal($param, "icons_type");
		if(empty($iconsType) || $iconsType == "fa"){
			$value = UniteFontManagerUC::fa_convertIcon($value);
			$data[$name] = $value;
		}

		//value is the icon name
		$html = "<i class='{$value}'></i>";
		if($isSVG == true){

			if(!empty($svgContent))
				$html = $svgContent;
			else
				$html ="<img src='$value' class='uc-svg-image'>";
		}

		$data[$name."_html"] = $html;

		return($data);
	}



	private function z_________INSTAGRAM_________(){}


	/**
	 * get instagram data
	 */
	public function getInstagramData($value, $name, $param){

		try{

			$valueMaxItems = null;
			if(is_array($value)){

				$name = UniteFunctionsUC::getVal($param, "name");

				$valueMaxItems = UniteFunctionsUC::getVal($value, $name."_num_items");

				if(empty($valueMaxItems) && is_numeric($valueMaxItems) == false)
					$valueMaxItems = null;

				$value = UniteFunctionsUC::getVal($param, $name);
			}

			if(empty($value))
				$value = UniteCreatorSettingsWork::INSTAGRAM_DEFAULT_VALUE;

			$maxItems = UniteFunctionsUC::getVal($param, "max_items");

			if(!empty($valueMaxItems))
				$maxItems = $valueMaxItems;

			$services = new UniteServicesUC();
			$data = $services->getInstagramData($value, $maxItems);

			return($data);

		}catch(Exception $e){

			$message = $e->getMessage();

			$data["error"] = __("Instagram Gallery Error: ","unlimited-elements-for-elementor").$message;

			return($data);
		}

	}

	/**
	 * get google map output
	 */
	private function getGoogleMapOutput($value, $name, $param){

		$filepathPickerObject = GlobalsUC::$pathViewsObjects."mappicker_view.class.php";
		require_once $filepathPickerObject;
		$objView = new UniteCreatorMappickerView();

		if(!empty($value))
			$objView->setData($value);

		$html = $objView->getHtmlClientSide($value);

		return($html);
	}

	private function z_______________VARIABLES____________(){}


	/**
	 * process items variables, based on variable type and item content
	 */
	private function getItemsVariablesProcessed($arrItem, $index, $numItems){

		$arrVars = $this->addon->getVariablesItem();
		$arrVarData = array();

		//get variables output object
		if(!empty($this->arrMainParamsValuesCache))
			$this->arrMainParamsValuesCache = $this->getProcessedMainParamsValues($this->processType);

		$objVarOutput = new UniteCreatorVariablesOutput();
		$objVarOutput->init($this->arrMainParamsValuesCache);

		foreach($arrVars as $var){
			$name = UniteFunctionsUC::getVal($var, "name");
			UniteFunctionsUC::validateNotEmpty($name, "variable name");

			$content = $objVarOutput->getItemVarContent($var, $arrItem, $index, $numItems);

			$arrVarData[$name] = $content;
		}

		return($arrVarData);
	}


	/**
	 * get main processed variables
	 */
	private function getMainVariablesProcessed($arrParams){

		//get variables
		$objVariablesOutput = new UniteCreatorVariablesOutput();
		$objVariablesOutput->init($arrParams);

		$arrVars = $this->addon->getVariablesMain();

		$arrOutput = array();

		foreach($arrVars as $var){

			$name = UniteFunctionsUC::getVal($var, "name");
			$content = $objVariablesOutput->getMainVarContent($var);
			$arrOutput[$name] = $content;
		}

		return($arrOutput);
	}

	private function z___________PARAMS_OUTPUT____________(){}

	/**
	 * process params - add params by type (like image base)
	 */
	public function initProcessParams($arrParams){

		$this->validateInited();

		if(empty($arrParams))
			return(array());

		$arrParamsNew = array();
		foreach($arrParams as $param){

			$type = UniteFunctionsUC::getVal($param, "type");
			switch($type){
				case "uc_imagebase":
					$settings = new UniteCreatorSettings();
					$settings->addImageBaseSettings();
					$arrParamsAdd = $settings->getSettingsCreatorFormat();
					foreach($arrParamsAdd as $addParam)
						$arrParamsNew[] = $addParam;
					break;
				default:
					$arrParamsNew[] = $param;
				break;
			}

		}

		return($arrParamsNew);
	}


	/**
	 * process params for output it to settings html
	 * update params items for output
	 */
	public function processParamsForOutput($arrParams){

		$this->validateInited();

		if(is_array($arrParams) == false)
			UniteFunctionsUC::throwError("objParams should be array");

		foreach($arrParams as $key=>$param){

			$type = UniteFunctionsUC::getVal($param, "type");

			$param = apply_filters("unite_creator_process_param_for_output", $param);

			if(isset($param["value"]))
				$param["value"] = $this->convertValueByType($param["value"], $type, $param);

			if(isset($param["default_value"]))
				$param["default_value"] = $this->convertValueByType($param["default_value"], $type, $param);

			//check modify options
			$param = $this->checkModifyParamOptions($param);


			//make sure that the value is part of the options
			if(isset($param["value"]) &&
			   isset($param["default_value"]) &&
			   isset($param["options"]) &&
			   !empty($param["options"]) ){

				$param["value"] = $this->convertValueFromOptions($param["value"], $param["options"], $param["default_value"]);
			}


			$arrParams[$key] = $param;
		}


		return($arrParams);
	}


	private function a_______________MENU______________(){}


	/**
	 * get html of menu item
	 */
	private function getHtmlMenuItem($item, $showSubmenu = true, $htmlBase="ul", $param=array()){

		$link = UniteFunctionsUC::getVal($item, "link");
		$title = UniteFunctionsUC::getVal($item, "title");
		$alias = UniteFunctionsUC::getVal($item, "alias");
		$isActive = UniteFunctionsUC::getVal($item, "active");
		$isCurrent = UniteFunctionsUC::getVal($item, "current");

		$arrSubmenu = UniteFunctionsUC::getVal($item, "submenu");

		$itemClass = UniteFunctionsUC::getVal($param, "menu_item_class");
		$itemClass = trim($itemClass);

		//get active class
		$activeClass = UniteFunctionsUC::getVal($param, "menu_item_active_class");
		$activeClass = trim($activeClass);
		if(empty($activeClass))
			$activeClass = "uc-menuitem-active";

		//get current class
		$currentClass = UniteFunctionsUC::getVal($param, "menu_item_current_class");
		$currentClass = trim($currentClass);

		if(empty($currentClass))
			$currentClass = "uc-menuitem-current";


		$wrapSubmenuItem =  UniteFunctionsUC::getVal($param, "menu_wrap_submenu_item");

		$isWrapSubmenu = false;
		if($wrapSubmenuItem == "wrap"){
			$isWrapSubmenu = true;
			$submenuWrapperClass = UniteFunctionsUC::getVal($param, "menu_submenu_wrapper_class");
			if(empty($submenuWrapperClass))
				$submenuWrapperClass = "uc-submenu-wrapper";
		}


		$alias = htmlspecialchars($alias);

		$arrClasses = array();

		if(!empty($itemClass))
			$arrClasses[] = $itemClass;

		$arrClasses[] = "uc-menu-page-$alias";


		$class = "";
		if($isActive == true)
			$arrClasses[] = $activeClass;

		if($isCurrent == true)
			$arrClasses[] = $currentClass;


		$class = "";
		if(!empty($arrClasses)){
			$class = implode(" ", $arrClasses);
			$class = "class='$class'";
		}

		$html = "";

		$htmlSubmenu = "";

		if($showSubmenu == true && !empty($arrSubmenu)){

			$submenuClass = UniteFunctionsUC::getVal($param, "menu_submenu_class");
			$submenuClass = trim($submenuClass);
			if(!empty($submenuClass))
				$submenuClass = " ".$submenuClass;

			$tag = "ul";
			if($htmlBase != "ul")
				$tag = "div";		//even if menu is nav, submenu is div

			$htmlSubmenu .= "<{$tag} class='uc-menu-submenu{$submenuClass}'>"."\n";
			foreach($arrSubmenu as $indexSub => $itemSub){

				$htmlSubmenu .= $this->getHtmlMenuItem($itemSub, false, $htmlBase, $param);

			}

			$htmlSubmenu .= "</{$tag}>";
		}

		$classLink = "";
		if($htmlBase != "ul")
			$classLink = $class;

		if($htmlBase == "ul")
			$html .= "	<li {$class}>";

		$toAddSubmenuWrapper = ($isWrapSubmenu == true && $htmlSubmenu);

		//wrap submenu item
		if($toAddSubmenuWrapper == true){
			$submenuWrapperClass = esc_attr($submenuWrapperClass);
			$html .= "<div class=\"$submenuWrapperClass\">";
		}

		$html .= "<a href='{$link}' {$classLink}>{$title}</a>".$htmlSubmenu;

		if($toAddSubmenuWrapper == true)
			$html .= "</div>";


		if($htmlBase == "ul")
			$html .= "</li>"."\n";

		return($html);
	}

	/**
	 * get menu output
	 */
	private function getDatasetData($value, $name, $param, $processType){

		dmp("get dataset data");


	}

	/**
	 * get menu output
	 */
	private function getMenuData($value, $name, $param, $processType){

		//UniteFunctionsUC::showTrace();

		$messageEmpty = esc_html__("No menu selected", "unlimited-elements-for-elementor");

		if($this->isOutputProcessType($processType) == false)
			return(null);

		if(is_array($value) == false)
			return($messageEmpty);

		$filters = array();

		$htmlBase = UniteFunctionsUC::getVal($param, "menu_html_base","ul");
		$menuClass = UniteFunctionsUC::getVal($param,"menu_class");

		$menuType = UniteFunctionsUC::getVal($value, "{$name}_menutype");
		$showSubmenu = UniteFunctionsUC::getVal($value, "{$name}_show_submenu");
		$showSubmenu = UniteFunctionsUC::strToBool($showSubmenu);

		$arrItems = UniteProviderFunctionsUC::getMenuItems($menuType, $showSubmenu);

		if(empty($arrItems)){
			$message = esc_html__("No items in ","unlimited-elements-for-elementor").$menuType.esc_html__(" menu","unlimited-elements-for-elementor");
			return($message);
		}

		$tag = "ul";

		switch($htmlBase){
			case "div":
				$tag = "div";
			break;
			case "nav":
				$tag = "nav";
			break;
		}

		if(!empty($menuClass))
			$menuClass = " ".$menuClass;

		$html = "<{$tag} class='uc-menu{$menuClass}'>"."\n";

		foreach($arrItems as $index => $item){

			$html .= $this->getHtmlMenuItem($item, $showSubmenu, $htmlBase, $param);

		}

		$html .= "</{$tag}>";

		return($html);
	}


	/**
	  * get link param data
	 */
	private function getLinkData($data, $value, $name, $param, $processType){
		
		if(is_string($value) === true)
			$value = array("url" => $value);
		
		$url = UniteFunctionsUC::getVal($value, "url");
		
		if(is_array($url))
			$url = "";
		
		$url = UniteFunctionsUC::sanitize($url, UniteFunctionsUC::SANITIZE_URL);
		
		$isExternal = UniteFunctionsUC::getVal($value, "is_external");
		$noFollow = UniteFunctionsUC::getVal($value, "nofollow");

		$customAttributes = UniteFunctionsUC::getVal($value, "custom_attributes");
		$customAttributes = $this->getLinkData_prepareAttributes($customAttributes);

		$urlFull = $url;
		$scheme = parse_url($url, PHP_URL_SCHEME);

		if(empty($scheme) === true){
			$urlFull = "https://{$url}";
			$urlNoPrefix = $url;
		}else{
			$urlNoPrefix = str_replace($scheme . "://", "", $url);
		}

		$addHtml = "";

		if($isExternal === "on")
			$addHtml .= " target='_blank'";

		if($noFollow === "on")
			$addHtml .= " rel='nofollow'";

		if(empty($customAttributes) === false)
			$addHtml .= $customAttributes;

		$data[$name] = $url;
		$data[$name . "_html_attributes"] = $addHtml;
		$data[$name . "_full"] = $urlFull;
		$data[$name . "_noprefix"] = $urlNoPrefix;

		
		return $data;
	}

	/**
	 * get link param data - prepare attributes
	 */
	private function getLinkData_prepareAttributes($attributes){

		if(empty($attributes) === true)
			return $attributes;

		$pairs = explode(",", $attributes);

		if(empty($pairs) === true)
			return $attributes;

		$html = "";

		foreach($pairs as $pair){
			$pair = explode("|", $pair, 2);

			$key = isset($pair[0]) === true ? trim($pair[0]) : "";
			$value = isset($pair[1]) === true ? trim($pair[1]) : "";

			$key = mb_strtolower($key);

			// skip empty key
			if(empty($key) === true)
				continue;

			// skip key with forbidden characters
			if(preg_match("/[^\da-z_-]+/", $key) === 1)
				continue;
		
			// skip href attribute and javascript events
			if($key === "href" || strpos($key, "on") === 0)
				continue;

			$html .= " $key=\"" . esc_attr($value) . "\"";
		}

		return $html;
	}


	/**
	 * get menu data
	 */
	public function getWPMenuData($data, $value, $name, $param, $processType){
		dmp("function for override");
		exit();
	}


	/**
	 * get the actual data
	 */
	protected function getSliderData_work($data, $value, $name, $valueOnly = false){

		if(is_array($value) == false){

			$data[$name."_unit"] = "px";
			$data[$name."_nounit"] = $value;
			return($data);
		}

		$size = UniteFunctionsUC::getVal($value, "size");
		$unit = UniteFunctionsUC::getVal($value, "unit");

		if(empty($unit))
			$unit = "px";

		if($size === ""){
			$data[$name] = "";
		}else
			$data[$name] = $size.$unit;

		if($valueOnly == false){
			$data[$name."_unit"] = $unit;
			$data[$name."_nounit"] = $size;
		}

		return($data);
	}

	/**
	 * get slider data
	 */
	protected function getSliderData($data, $value, $name, $param, $processType){

		$data = $this->getSliderData_work($data, $value, $name);

		$isResponsive = UniteFunctionsUC::getVal($param, "is_responsive");
		$isResponsive = UniteFunctionsUC::strToBool($isResponsive);

		if($isResponsive == true){

			$defaultValueTablet = UniteFunctionsUC::getVal($param, "default_value_tablet");
			$defaultValueMobile = UniteFunctionsUC::getVal($param, "default_value_mobile");

			$valueTablet = UniteFunctionsUC::getVal($param, "value_tablet", $defaultValueTablet);
			$valueMobile = UniteFunctionsUC::getVal($param, "value_mobile", $defaultValueMobile);

			$data = $this->getSliderData_work($data, $valueTablet, $name."_tablet");
			$data = $this->getSliderData_work($data, $valueMobile, $name."_mobile");
		}

		return($data);
	}

	/**
	 * get date time data
	 */
	protected function getDateTimeData($data, $value, $name, $param, $processType){
		
		$isDebug = false;
		
		//not given or wrong type - return current date
		
		$formatFullDate = "d-M-Y, H:i";

		if(empty($value) || is_array($value)){
			
			$stamp = time();
			
			//$data[$name."_stamp"] = $stamp;
			//$data[$name] = date($formatFullDate, $stamp);

			//if empty - return emtpy

			$data[$name."_stamp"] = "";
			$data[$name] = "";

			if($isDebug == true){
				dmp("get time1");
				dmp($name);
				dmp($stamp);
				dmp($data);
			}

			return($data);
		}

		//numeric - date is stamp

		if(is_numeric($value) && UniteFunctionsUC::detectDateFormat($value) == ""){
			
			$stamp = $value;
			
			$data[$name."_stamp"] = $value;
			$data[$name] = uelm_date($formatFullDate, $stamp);
	
			if($isDebug == true){
				dmp("get time2");
				dmp($data);
			}

			return($data);
		}
		
		//date is string
		
		$stamp = UniteFunctionsUC::date2Timestamp($value);
		
		$data[$name."_stamp"] = $stamp;

		if($isDebug == true){
			dmp("get time3");
			dmp($value);
			dmp($stamp);
		}

		return($data);
	}

	

	/**
	 * put hover animation style if needed
	 */
	protected function outputHoverAnimationsStyles($value, $name, $param, $processType){
				
		if(empty($value) === true)
			return;
		
		if($processType !== self::PROCESS_TYPE_OUTPUT
			&& $processType !== self::PROCESS_TYPE_OUTPUT_BACK)
			return;

		if(strpos($value, GlobalsUnlimitedElements::PREFIX_ANIMATION_CLASS) === 0)
			HelperUC::includeUEAnimationStyles();
		else
			HelperProviderCoreUC_EL::includeHoverAnimationsStyles($value);
	}

	private function z__________SPECIAL_PARAMS_DATA__________(){}


	/**
	 * special params data
	 */
	private function getSpecialParamsData($data, $value, $name, $param, $processType){

		$type = UniteFunctionsUC::getVal($param, "attribute_type");

		switch($type){
			case "dynamic_popup":

				//set dynamic popup class and save it for the items

				$name = UniteFunctionsUC::getVal($param, "name");

				$arrValues = UniteFunctionsUC::getVal($data, $name);

				$linkType = UniteFunctionsUC::getVal($arrValues, $name."_link_type");

				$isEnabled = false;

				if($linkType == "popup"){	//is enabled
					$isEnabled = true;

					$this->dynamicPopupEnabled = true;
				}


				//if many popups, every one should enable the class

				if(isset($data["uc_dynamic_popup_class"]) == false){
					$data["uc_dynamic_popup_class"] = "";
				}

				if($this->dynamicPopupEnabled == true)
					$data["uc_dynamic_popup_class"] = " uc-dynamic-popup-grid";


				//use in post items

				$param["dynamic_popup_enabled"] = $isEnabled;
				$param["dynamic_popup_linktype"] = $linkType;

				if($linkType == "meta"){

					$linkType = UniteFunctionsUC::getVal($arrValues, $name."_link_type");

					$linkTypeMetaField = UniteFunctionsUC::getVal($arrValues, $name."_meta_field");

					$param["dynamic_popup_link_metafield"] = $linkTypeMetaField;
				}

				$this->dynamicPopupParams[] = $param;

			break;
			case "ucform_conditions":

				$objForm = new UniteCreatorForm();

				$data = $objForm->getVisibilityConditionsParamsData($data, $param);

			break;
			case "currency_api":
			case "weather_api":
				$data = UniteCreatorAPIIntegrations::getInstance()->addDataToParams($data, $name);
            break;
            case "rss_feed":
                
            	$arrValues = UniteFunctionsUC::getVal($param, "value");
            	            	
            	$objRss = new UniteCreatorRSS();
            	
            	$addonValues = $this->addon->getOriginalValues();
				
            	$showDebug = UniteFunctionsUC::getVal($addonValues,"show_debug");
            	$showDebug = UniteFunctionsUC::strToBool($showDebug);
            	
               	$data = $objRss->getRssFeedData($data, $arrValues, $name, $showDebug);
                
			break;
            case "repeater":
            	
            	$arrValues = UniteFunctionsUC::getVal($param, "value");
				
            	$debugData = UniteFunctionsUC::getVal($arrValues, "{$name}_repeater_debug_data");
            	$debugData = UniteFunctionsUC::strToBool($debugData);
            	            	
            	$debugMeta = UniteFunctionsUC::getVal($arrValues, "{$name}_repeater_debug_meta");
            	$debugMeta = UniteFunctionsUC::strToBool($debugMeta);
            	
            	$arrRepeaterItems = HelperProviderUC::getRepeaterItems($arrValues, $name, $debugData, $debugMeta);
				
            	$data[$name] = $arrRepeaterItems;
            	$data[$name."_settings"] = $arrValues;
            	
            break;
		}
		return($data);
	}

	private function z__________VALUES_OUTPUT__________(){}


	/**
	 * get processe param data, function with override
	 */
	protected function getProcessedParamData($data, $value, $param, $processType){

		
		$type = UniteFunctionsUC::getVal($param, "type");
		$name = UniteFunctionsUC::getVal($param, "name");

		$isOutputProcessType = $this->isOutputProcessType($processType);

		//special params - all types
		switch($type){
			case UniteCreatorDialogParam::PARAM_DROPDOWN:
			case UniteCreatorDialogParam::PARAM_NUMBER:
				$data = $this->getProcessedParamsValue_responsive($data, $param);
			break;
			case UniteCreatorDialogParam::PARAM_RADIOBOOLEAN:
				$data = $this->getProcessedParamsValue_radioBoolean($data, $param, $value);
			break;
			case UniteCreatorDialogParam::PARAM_IMAGE:
				$data = $this->getProcessedParamsValue_image($data, $value, $param);
			break;
			case UniteCreatorDialogParam::PARAM_POST:
				$data = $this->getProcessedParamsValue_post($data, $value, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_CONTENT:
				$data = $this->getProcessedParamsValue_content($data, $value, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_ICON_LIBRARY:
				$data = $this->getProcessedParamsValue_icon($data, $value, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_MENU:
			    $data = $this->getWPMenuData($data,$value, $name, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_SLIDER:
			    $data = $this->getSliderData($data, $value, $name, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_DATETIME:
			    $data = $this->getDateTimeData($data, $value, $name, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_DATASET:
			    $data[$name] = $this->getDatasetData($value, $name, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_HOVER_ANIMATIONS:
				$this->outputHoverAnimationsStyles($value, $name, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_SPECIAL:
				$data = $this->getSpecialParamsData($data, $value, $name, $param, $processType);
			break;
		}

		//process output type only
		if($isOutputProcessType === false)
			return($data);

		switch($type){
			case UniteCreatorDialogParam::PARAM_LINK:
				$data = $this->getLinkData($data, $value, $name, $param, $processType);
			break;
			case UniteCreatorDialogParam::PARAM_INSTAGRAM:
				$data[$name] = $this->getInstagramData($value, $name, $param);
			break;
			case UniteCreatorDialogParam::PARAM_MAP:
				$data[$name] = $this->getGoogleMapOutput($value, $name, $param);
			break;
		}

		return($data);
	}


	/**
	 * sort params. special attributes first, for dynamic popup processing for example
	 */
	public function sortParamsBeforeProcess($param1, $param2){

		$type1 = UniteFunctionsUC::getVal($param1, "type");
		$type2 = UniteFunctionsUC::getVal($param2, "type");

		if($type1 == UniteCreatorDialogParam::PARAM_SPECIAL)
			return(-1);

		if($type2 == UniteCreatorDialogParam::PARAM_SPECIAL)
			return(1);

		return(0);
	}


	/**
	 * get processed params
	 */
	public function getProcessedParamsValues($arrParams, $processType, $filterType = null){

		self::validateProcessType($processType);

		$arrParams = $this->processParamsForOutput($arrParams);

		//sort by param type - special first
		if(!empty($arrParams))
			usort($arrParams, array($this, "sortParamsBeforeProcess"));

		$data = array();

		foreach($arrParams as $param){
			$type = UniteFunctionsUC::getVal($param, "type");

			if ($filterType !== null && $filterType !== $type)
				continue;

			$name = UniteFunctionsUC::getVal($param, "name");

			if(empty($name))
				continue;

			if(isset($data[$name]))
				continue;

			$defaultValue = UniteFunctionsUC::getVal($param, "default_value");
			$value = UniteFunctionsUC::getVal($param, "value", $defaultValue);
			$value = $this->convertValueByType($value, $type, $param);

			if($type !== "imagebase_fields")
				$data[$name] = $value;

			$data = $this->getProcessedParamData($data, $value, $param, $processType);
		}

		$data = $this->modifyDataBySpecialAddonBehaviour($data);

		return $data;
	}

	/**
	 * sort the params for main output
	 * put the posts param to bottom
	 */
	private function sortMainParamsForOutput($objParams){

		if(empty($objParams))
			return($objParams);

		$objParamsNew = array();
		$arrPostsParams = array();

		foreach($objParams as $param){

			$type = UniteFunctionsUC::getVal($param, "type");
			if($type == UniteCreatorDialogParam::PARAM_POSTS_LIST)
				$arrPostsParams[] = $param;
			else
				$objParamsNew[] = $param;
		}

		if(empty($arrPostsParams))
			return($objParamsNew);

		$objParamsNew = array_merge($objParamsNew, $arrPostsParams);

		return($objParamsNew);
	}


	/**
	 * get main params processed, for output
	 */
	public function getProcessedMainParamsValues($processType){

		$this->validateInited();

		self::validateProcessType($processType);

		$this->setProcessType($processType);	//save it for fonts

		$objParams = $this->addon->getParams();

		//put posts list to bottom of processing
		$objParams = $this->sortMainParamsForOutput($objParams);
		$arrParams = $this->getProcessedParamsValues($objParams, $processType);
		$arrVars = $this->getMainVariablesProcessed($arrParams);

		if($this->isOutputProcessType($processType) === true){
			$arrParams = UniteProviderFunctionsUC::applyFilters(UniteCreatorFilters::FILTER_MODIFY_ADDON_OUTPUT_PARAMS, $arrParams, $this->addon);
			$arrParams = $this->processFonts($arrParams, "main");
		}

		$arrParams = array_merge($arrParams, $arrVars);

		return($arrParams);
	}

	/**
	 * modify items data, add "item" to array
	 */
	protected function normalizeItemsData($arrItems){

		if(empty($arrItems))
			return(array());

		foreach($arrItems as $key=>$item){
				$arrItems[$key] = array("item"=>$item);
		}

		return($arrItems);
	}


	/**
	 * get items image size accordion special attribute
	 */
	public function getProcessedItemsData_getImageSize($processType = null){

		
		if($processType == self::PROCESS_TYPE_CONFIG)
			return(null);
				
		$paramsSpecial = $this->addon->getParams(UniteCreatorDialogParam::PARAM_SPECIAL);

		
		if(empty($paramsSpecial))
			return(null);

		$arrValues = array();

		foreach($paramsSpecial as $param){

			$attributeType = UniteFunctionsUC::getVal($param, "attribute_type");
			if($attributeType != "items_image_size")
				continue;

			$value = UniteFunctionsUC::getVal($param, "value");
			
			$name = UniteFunctionsUC::getVal($param, "name");

			if(is_array($value)){
				$value = UniteFunctionsUC::getVal($value, $name."_size");
			}

			$destParamName = UniteFunctionsUC::getVal($param, "image_size_param_name");

			if(empty($destParamName))
				$destParamName = "_default_";

			$arrValues[$destParamName] = $value;
		}
		
		
		return($arrValues);
	}

	/**
	 * modify image param
	 */
	public function getProcessedItemsData_modifyImageItem($arrItemParams, $arrImageSizes){

		$defaultSize = UniteFunctionsUC::getVal($arrImageSizes, "_default_");

		foreach($arrItemParams as $index => $param){

			$type = UniteFunctionsUC::getVal($param, "type");

			if($type != UniteCreatorDialogParam::PARAM_IMAGE)
				continue;

			$name = UniteFunctionsUC::getVal($param, "name");

			$size = UniteFunctionsUC::getVal($arrImageSizes, $name);

			if(empty($size))
				$size = $defaultSize;

			if(empty($size))
				continue;


			$param["add_image_sizes"] = true;
			$param["value_size"] = $size;

			$arrItemParams[$index] = $param;

		}


		return($arrItemParams);
	}


	/**
	 * get item data
	 */
	public function getProcessedItemsData($arrItems, $processType, $forTemplate = true, $filterType = null){
		
		$this->validateInited();
		self::validateProcessType($processType);

		//in case of gallery grouped settings, don't process at all
		$specialType = $this->addon->getSpecialType();

		if($specialType === UniteCreatorAddon::ITEMS_TYPE_IMAGE)
			return $arrItems;

		$this->setProcessType($processType);

		if(empty($arrItems))
			return array();

		//check for special params
		$arrItemsImageSizes = $this->getProcessedItemsData_getImageSize($processType);

		$arrItemsNew = array();
		$arrItemParams = $this->addon->getParamsItems();

		if(!empty($arrItemsImageSizes))
			$arrItemParams = $this->getProcessedItemsData_modifyImageItem($arrItemParams, $arrItemsImageSizes);

		$arrItemParams = $this->initProcessParams($arrItemParams);
		$numItems = count($arrItems);

		foreach($arrItems as $index => $arrItemValues){
			// get elementor row id
			$elementorID = UniteFunctionsUC::getVal($arrItemValues, "_id");

			// get gutenberg item id
			if(empty($elementorID))
				$elementorID = UniteFunctionsUC::getVal($arrItemValues, "_generated_id");

			//if not found - generate one
			if(empty($elementorID))
				$elementorID = UniteFunctionsUC::getRandomString(5);

			$arrParamsNew = $this->addon->setParamsValuesItems($arrItemValues, $arrItemParams);
			$item = $this->getProcessedParamsValues($arrParamsNew, $processType, $filterType);

			if($this->isOutputProcessType($processType) === true)
				$item = $this->processFonts($item, "items", $index);

			//in case of filter - it's enough
			if(!empty($filterType)){
				$arrItemsNew[] = $item;
				continue;
			}

			//add values by items type
			$itemsType = $this->addon->getItemsType();

			switch($itemsType){
				case UniteCreatorAddon::ITEMS_TYPE_IMAGE:
					//add thumb
					$urlImage = UniteFunctionsUC::getVal($item, "image");
					$urlThumb = UniteFunctionsUC::getVal($item, "image_thumb_large");

					if(empty($urlThumb))
						$urlThumb = $urlImage;

					$item["thumb"] = $urlThumb;
					$item["image_id"] = UniteFunctionsUC::getVal($arrItemValues, "image_id");
					$item["raw_caption"] = UniteFunctionsUC::getVal($arrItemValues, "raw_caption");
					$item["raw_title"] = UniteFunctionsUC::getVal($arrItemValues, "raw_title");
				break;
			}

			//add item variables
			$arrVarsData = $this->getItemsVariablesProcessed($item, $index, $numItems);
			$item = array_merge($item, $arrVarsData);

			//add elementor id
			$item["_generated_id"] = $elementorID;

			if($itemsType != UniteCreatorAddon::ITEMS_TYPE_IMAGE)
				$item["item_repeater_class"] = "elementor-repeater-item-" . $elementorID;

			if($forTemplate === true)
				$arrItemsNew[] = array("item" => $item);
			else
				$arrItemsNew[] = $item;
		}

		return $arrItemsNew;
	}


	/**
	 * get array param values, for special params
	 */
	private function getArrayParamValue($arrValues, $paramName, $value){

            $paramArrValues = array();
            $paramArrValues[$paramName] = $value;

            if(empty($arrValues))
            	$arrValues = array();

            foreach($arrValues as $key=>$value){
                if(strpos($key, $paramName."_") === 0)
                    $paramArrValues[$key] = $value;
            }

            $value = $paramArrValues;

           return($value);
	}



	/**
	 * get param value, function for override, by type
	 */
	public function getSpecialParamValue($paramType, $paramName, $value, $arrValues){


	    return($value);
	}




}
