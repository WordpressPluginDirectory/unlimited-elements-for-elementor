<?php
/**
 * @package Unlimited Elements
 * @author unlimited-elements.com
 * @copyright (C) 2021 Unlimited Elements, All Rights Reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
if ( ! defined( 'ABSPATH' ) ) exit;


/**
 *
 * creator helper functions class
 *
 */
	class HelperHtmlUC extends UniteHelperBaseUC{

		private static $isGlobalJSPut = false;
		private static $isPutBrowsersOnce = false;


		protected function z_____GETTERS______(){}


		/**
		 *
		 * get link html
		 */
		public static function getHtmlLink($link,$text,$id="",$class="", $isNewWindow = false){

			if(!empty($class))
				$class = " class='$class'";

			if(!empty($id))
				$id = " id='$id'";

			$htmlAdd = "";
			if($isNewWindow == true)
				$htmlAdd = ' target="_blank"';

			$html = "<a href=\"$link\"".$id.$class.$htmlAdd.">$text</a>";
			return($html);
		}


		/**
		 * get select options
		 */
		public static function getHTMLSelectOptions($arrAssoc){

			if(empty($arrAssoc))
				return("");

			$options = "";
			foreach($arrAssoc as $value=>$text){

				$value = esc_attr($value);
				$text = esc_html($text);

				$options .= "<option value=\"{$value}\">{$text}</option>\n";
			}


			return($options);
		}

		/**
		 *
		 * get select from array
		 */
		public static function getHTMLSelect($arr,$default="",$htmlParams="",$assoc = false, $addData = null, $addDataText = null){

			$html = "<select $htmlParams>";
			//add first item
			if($addData == "not_chosen"){
				$selected = "";
				$default = trim($default);
				if(empty($default))
					$selected = " selected='selected' ";

				$itemText = $addDataText;
				if(empty($itemText))
					$itemText = "[".esc_html__("not chosen", "unlimited-elements-for-elementor")."]";

				$html .= "<option $selected value=''>{$itemText}</option>";
			}

			foreach($arr as $key=>$item){
				$selected = "";

				if($assoc == false){
					if($item == $default)
						$selected = " selected='selected' ";
				}
				else{
					if(trim($key) == trim($default))
						$selected = " selected='selected' ";
				}

				$addHtml = "";
				if(strpos($key, "html_select_sap") !== false)
					$addHtml = " disabled";

				if($assoc == true)
					$html .= "<option $selected value='$key' $addHtml>$item</option>";
				else
					$html .= "<option $selected value='$item' $addHtml>$item</option>";
			}
			$html.= "</select>";
			return($html);
		}


		/**
		 * get row of addons table
		 */
		public static function getTableAddonsRow($addonID, $title){

			$editLink = HelperUC::getViewUrl_EditAddon($addonID);

			$htmlTitle = htmlspecialchars($title);

			$html = "<tr>\n";
			$html.= "<td><a href='{$editLink}'>{$title}</a></td>\n";
			$html.= "	<td>\n";
			$html.= " 	  <a href='{$editLink}' class='unite-button-secondary float_left mleft_15'>". esc_html__("Edit","unlimited-elements-for-elementor") . "</a>\n";
			$html.= "		<a href='javascript:void(0)' data-addonid='{$addonID}' class='uc-button-delete unite-button-secondary float_left mleft_15'>".esc_html__("Delete","unlimited-elements-for-elementor")."</a>";
			$html.= "		<span class='loader_text uc-loader-delete mleft_10' style='display:none'>" . esc_html__("Deleting", "unlimited-elements-for-elementor") . "</span>";
			$html.= "		<a href='javascript:void(0)' data-addonid='{$addonID}' class='uc-button-duplicate unite-button-secondary float_left mleft_15'>" . esc_html__("Duplicate","unlimited-elements-for-elementor")."</a>\n";
			$html.= "		<span class='loader_text uc-loader-duplicate mleft_10' style='display:none'>" . esc_html__("Duplicating", "unlimited-elements-for-elementor") . "</span>";
			$html.= "		<a href='javascript:void(0)' data-addonid='{$addonID}' data-title='{$htmlTitle}' class='uc-button-savelibrary unite-button-secondary float_left mleft_15'>" . esc_html__("Save To Library","unlimited-elements-for-elementor")."</a>\n";
			$html.= "		<span class='loader_text uc-loader-save mleft_10' style='display:none'>" . esc_html__("Saving to library", "unlimited-elements-for-elementor") . "</span>";
			$html.= "	</td>\n";
			$html.= "	</tr>\n";

			return($html);
		}


		/**
		 * get global js output for plugin pages
		 */
		public static function getGlobalJsOutput(){

			//insure that this function run only once
			if(self::$isGlobalJSPut == true)
				return("");


			self::$isGlobalJSPut = true;

			$jsArrayText = UniteFunctionsUC::phpArrayToJsArrayText(GlobalsUC::$arrClientSideText,"				");

			//prepare assets path
			$pathAssets = HelperUC::pathToRelative(GlobalsUC::$pathAssets, false);
			$pathAssets = urlencode($pathAssets);

			//check catalog
			$objWebAPI = new UniteCreatorWebAPI();
			$isNeedCheckCatalog = $objWebAPI->isTimeToCheckCatalog();

			$arrGeneralSettings = array();
			$arrGeneralSettings["color_picker_type"] = GlobalsUC::$colorPickerType;

			$arrGeneralSettings = UniteProviderFunctionsUC::applyFilters(UniteCreatorFilters::FILTER_CLIENTSIDE_GENERAL_SETTINGS, $arrGeneralSettings);

			//dmp($arrGeneralSettings);exit();

			$strGeneralSettings = UniteFunctionsUC::jsonEncodeForClientSide($arrGeneralSettings);

			$js = "";
			$js .= self::TAB2.'var g_pluginNameUC = "'.GlobalsUC::PLUGIN_NAME.'";'.self::BR;
			$js .= self::TAB2.'var g_pathAssetsUC = decodeURIComponent("'.$pathAssets.'");'.self::BR;
			$js .= self::TAB2.'var g_urlAjaxActionsUC = "'.GlobalsUC::$url_ajax.'";'.self::BR;
			$js .= self::TAB2.'var g_urlViewBaseUC = "'.GlobalsUC::$url_component_admin.'";'.self::BR;
			$js .= self::TAB2.'var g_urlViewBaseNowindowUC = "'.GlobalsUC::$url_component_admin_nowindow.'";'.self::BR;
			$js .= self::TAB2.'var g_urlBaseUC = "'.GlobalsUC::$url_base.'";'.self::BR;
			$js .= self::TAB2.'var g_urlAssetsUC = "'.GlobalsUC::$url_assets.'";'.self::BR;
			$js .= self::TAB2.'var g_settingsObjUC = {};'.self::BR;
			$js .= self::TAB2.'var g_ucAdmin;'.self::BR;


			if(GlobalsUC::$is_admin_debug_mode == true)
				$js .= self::TAB2.'var g_ucDebugMode=true;'.self::BR;

			$js .= self::TAB2."var g_ucGeneralSettings = {$strGeneralSettings};".self::BR;

			if(GlobalsUC::$enableWebCatalog == true){
				if($isNeedCheckCatalog)
					$js .= self::TAB2.'var g_ucCheckCatalog = true;'.self::BR;

				$js .= self::TAB2.'var g_ucCatalogAddonType="'.GlobalsUC::$defaultAddonType.'";'.self::BR;
			}

			//output icons
			$jsonFaIcons = UniteFontManagerUC::fa_getJsonIcons();
			$js .= self::TAB2.'var g_ucFaIcons = '.$jsonFaIcons.';'.self::BR;

			//output elementor icons
			$jsonElementorIcons = UniteFontManagerUC::elementor_getJsonIcons();
			$js .= self::TAB2.'var g_ucElIcons = '.$jsonElementorIcons.';'.self::BR;


			//get nonce
			if(method_exists("UniteProviderFunctionsUC", "getNonce"))
				$js .= self::TAB2 . "var g_ucNonce='".UniteProviderFunctionsUC::getNonce()."';";

			$js .= self::TAB2.'var g_uctext = {'.self::BR;
			$js .= self::TAB3.$jsArrayText.self::BR;
			$js .= self::TAB2.'};'.self::BR;

			
			return($js);
		}


		/**
		 * get flobal debug divs
		 */
		public static function getGlobalDebugDivs(){
			$html = "";
			
			$html .= self::TAB2.'<div id="div_debug" class="unite-div-debug"></div>'.self::BR;
			$html .= self::TAB2.'<div id="debug_line" style="display:none"></div>'.self::BR;
			$html .= self::TAB2.'<div id="debug_side" style="display:none"></div>'.self::BR;
			$html .= self::TAB2.'<div class="unite_error_message" id="error_message" style="display:none;"></div>'.self::BR;
			$html .= self::TAB2.'<div class="unite_success_message" id="success_message" style="display:none;"></div>'.self::BR;

			return($html);
		}




		/**
		 * get version text
		 */
		public static function getVersionText(){

			$filepath = GlobalsUC::$pathPlugin . "changelog.txt";
			
			if(file_exists($filepath) == false)
				UniteFunctionsUC::throwError("file: $filepath not exists");
			
			$content = UniteFunctionsUC::fileGetContents($filepath);
			$content = trim($content);
			
			//$content = substr($content, 0, 10000);
			
			return ($content);
		}

		/**
		 * get error message html
		 */
		public static function getErrorMessageHtml($message, $trace = "", $withCSS = false){

			$html = '<div class="unite-error-message">';
			$html .= '<div style="unite-error-message-inner">';
			$html .= $message;

			if($withCSS == true){
				$html .= "<style> .unite-error-message{color:red;}  </style>";
			}

			if(!empty($trace)){
				$html .= '<div class="unite-error-message-trace">';
				$html .= "<pre>{$trace}</pre>";
				$html .= "</div>";
			}

			$html .= '</div></div>';

			return($html);
		}

		/**
		 * get settings html
		 */
		public static function getHtmlSettings($filename, $formID, $arrValues = array()){

			UniteFunctionsUC::obStart();

			$html = self::putHtmlSettings($filename, $formID, $arrValues);
			$html = ob_get_contents();

			ob_clean();
			ob_end_clean();

			return($html);
		}


		/**
		 * get custom scripts from array of scripts
		 */
		public static function getHtmlCustomScripts($arrScripts){

			if(empty($arrScripts))
				return("");
			
			if(is_array($arrScripts) == false){
				UniteFunctionsUC::throwError("arrScripts should be array");
			}
			
			$arrScriptsOutput = array();
			$arrModulesOutput = array();
			
			foreach ($arrScripts as $key=>$script){
				$isModule = (strpos($key, "module_") !== false);

				if($isModule == true)
					$arrModulesOutput[] = $script;
				else
					$arrScriptsOutput[] = $script;
			}

			$html = "";

			//prepare the html regular

			if(!empty($arrScriptsOutput)){

				$html.= "<script type='text/javascript'>\n";

					foreach ($arrScriptsOutput as $script){
						$html.= $script."\n";
					}

				$html.= "</script>\n";
			}

			//prepare the modules html

			if(!empty($arrModulesOutput)){

				foreach($arrModulesOutput as $script){

					$html .= "<script type='module'>\n";
					$html .= $script."\n";
					$html .= "</script>\n";

				}

			}


			return($html);
		}

		/**
		 * get custom html styles
		 */
		public static function getHtmlCustomStyles($arrStyles, $wrapInTag = true){

			if(empty($arrStyles))
				return("");

			$css = "";

			if(is_array($arrStyles) == false)
				$css = $arrStyles;
			else{	//if array
				if(count($arrStyles) == 1 && empty($arrStyles[0]))
					return("");

				foreach($arrStyles as $style)
					$css .= $style.self::BR;

			}

			if($wrapInTag == false)
				return($css);

			$html = "<style type='text/css'>".self::BR;
			$html .= $css;
			$html .= "</style>".self::BR;

			return($html);
		}

		/**
		 * get css include
		 */
		public static function getHtmlCssInclude($url){
			// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedStylesheet
			$html = "<link rel=\"stylesheet\" type=\"text/css\" href=\"{$url}\">";

			return($html);
		}


		/**
		 * get css include
		 */
		public static function getHtmlJsInclude($url){
			// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript
			$html = "<script type=\"text/javascript\" src=\"{$url}\"></script>";

			return($html);
		}


		/**
		 *
		 * get html of some includes
		 */
		private static function getHtmlIncludes($type, $arrIncludes, $tab = null){

			if(empty($arrIncludes))
				return("");

			$html = "";
			foreach($arrIncludes as $urlInclude){
				if($tab !== null)
					$html .= $tab;

				if($type == "css")
					$html .= self::getHtmlCssInclude($urlInclude).self::BR;
				else
					$html .= self::getHtmlJsInclude($urlInclude).self::BR;

			}

			return($html);

		}

		/**
		 * get html includes from array includes
		 */
		public static function getHtmlCssIncludes($arrCssIncludes, $tab = null){

			return self::getHtmlIncludes("css", $arrCssIncludes, $tab);
		}

		/**
		 * get html includes from array includes
		 */
		public static function getHtmlJsIncludes($arrJsIncludes, $tab = null){

			return self::getHtmlIncludes("js", $arrJsIncludes, $tab);
		}

		/**
		 * get array table html
		 */
		public static function getHtmlArrayTable($arr, $emptyText = ""){

			if(empty($arr))
				return($emptyText);

			$html = "";
			foreach($arr as $key=>$value){

				$isArray = is_array($value);

				if($isArray == true){
					$html .= "$key:";
					$html .= "<pre style='padding-left:60px;font-size:12px;'>";
					$html .= print_r($value, true);
					$html .= "</pre>";
				}
				else{

					$firstLetter = $key[0];		//for post meta

					if($firstLetter == "_")
						$html .= "$key: <span style='color:gray'>$value</span> \n";
					else
						$html .= "<b>$key</b>: $value \n";

				}

			}

			return($html);
		}

		protected function z_________PUTTERS_______(){}
		
		/**
		 * put debug box
		 */
		public static function putHtmlDataDebugBox($data){
			
			self::putHtmlDataDebugBox_start();
			
			if(is_array($data))
				$data = UniteFunctionsUC::modifyDataArrayForShow($data);
			
			if(is_string($data))
				$data = htmlspecialchars($data);
			
			dmp($data);
			
			self::putHtmlDataDebugBox_end();
		}

		/**
		 * put debug box - start
		 */
		public static function putHtmlDataDebugBox_start(){
			
			echo "<div style='background-color:#E5F7E1;
				              font-size:12px;padding:5px;
				              max-width:800px;
				              max-height:600px;
				              overflow:scroll;margin-bottom:30px;'>";
		}
		
		/**
		 * put debug box end
		 */
		public static function putHtmlDataDebugBox_end(){
			
			echo "</div>";
		}
		
		/**
		 * put debug wrapper div start
		 */
		public static function getQueryDebugWrapperStyles(){
			
			return("background: lightgrey; padding: 10px; margin-bottom: 10px; font-size: 12px; overflow:auto;");
		}
		
		/**
		 * get debug message html output
		 */
		public static function getDebugWarningMessageHtml($message){
			
			$html = "
				<div style='background-color:#e3af7b;
							border:2px solid #d99857;
							color:#000000;
				              font-size:18px;
				              margin-top:10px;
				              padding:10px;
				              max-width:800px;
				              max-height:600px;
				              overflow:scroll;margin-bottom:30px;'>$message</div>
			";
			
			return($html);
		}
		
		
		/**
		 * put all browser dialogs of all addon types
		 */
		public static function putAddonTypesBrowserDialogs($filterType = null, $objLayoutType = null){

			if(self::$isPutBrowsersOnce == true)
				return(false);

			self::$isPutBrowsersOnce = true;

			$arrMultipleTypesRegular = null;
			if(!empty($objLayoutType) && !empty($objLayoutType->arrLayoutBrowserAddonTypes))
				$arrMultipleTypesRegular = $objLayoutType->arrLayoutBrowserAddonTypes;


			//put other addon type browser

			if(!empty($filterType)){

				if(is_array($arrTypes))
					$arrTypes = $filterType;
				else
					$arrTypes = array($filterType);
			}else
				$arrTypes = array(
					GlobalsUC::ADDON_TYPE_REGULAR_ADDON,
					GlobalsUC::ADDON_TYPE_SHAPE_DEVIDER,
					GlobalsUC::ADDON_TYPE_LAYOUT_SECTION,
					GlobalsUC::ADDON_TYPE_SHAPES,
					GlobalsUC::ADDON_TYPE_BGADDON,
				);


			foreach($arrTypes as $addontype){

				if($addontype == GlobalsUC::ADDON_TYPE_REGULAR_ADDON && !empty($arrMultipleTypesRegular))
						$addontype = $arrMultipleTypesRegular;

				$objBrowser = new UniteCreatorBrowser();
				$objBrowser->initAddonType($addontype);
				$objBrowser->putBrowser();
			}


		}



		/**
		 * put global framework
		 */
		public static function putGlobalsHtmlOutput(){
			
			if(self::$isGlobalJSPut == true)
				return(false);
			
			$script = self::getGlobalJsOutput();

			UniteProviderFunctionsUC::printCustomScript($script, true);
			
			uelm_echo(self::getGlobalDebugDivs());

			if(method_exists("UniteProviderFunctionsUC", "putMasterHTML"))
				UniteProviderFunctionsUC::putMasterHTML()
			?>

			<?php
		}


		/**
		 * put control fields notice to dialogs that use it
		 */
		public static function putDialogControlFieldsNotice(){
			?>
				<div class="unite-inputs-sap"></div>

				<div class="unite-inputs-label unite-italic">
					* <?php esc_html_e("only dropdown and radio boolean field types are used for conditional inputs", "unlimited-elements-for-elementor")?>.
				</div>

			<?php
		}


		/**
		 * put dialog actions
		 */
		public static function putDialogActions($prefix, $buttonTitle, $loaderTitle, $successTitle, $buttonClass="primary"){

			$prefix = esc_attr($prefix);

			?>
				<div id="<?php echo esc_attr($prefix)?>_actions_wrapper" class="unite-dialog-actions">

					<a id="<?php echo esc_attr($prefix)?>_action" href="javascript:void(0)" class="unite-button-<?php echo esc_attr($buttonClass)?>"><?php echo esc_html($buttonTitle)?></a>
					<div id="<?php echo esc_attr($prefix)?>_loader" class="loader_text" style="display:none"><?php echo esc_html($loaderTitle)?></div>
					<div id="<?php echo esc_attr($prefix)?>_error" class="unite-dialog-error"  style="display:none"></div>
					<div id="<?php echo esc_attr($prefix)?>_success" class="unite-dialog-success" style="display:none"><?php echo esc_html($successTitle)?></div>

				</div>
			<?php
		}

		/**
		 * put plugin version html
		 */
		public static function putPluginVersionHtml(){

			$objPlugins = new UniteCreatorPlugins();

			$arrPlugins = $objPlugins->getArrPlugins();

			if(empty($arrPlugins))
				return(false);

			foreach($arrPlugins as $plugin){

				$name = UniteFunctionsUC::getVal($plugin, "name");
				$title = UniteFunctionsUC::getVal($plugin, "title");
				$version = UniteFunctionsUC::getVal($plugin, "version");
				$silentMode = UniteFunctionsUC::getVal($plugin, "silent_mode");
				$silentMode = UniteFunctionsUC::strToBool($silentMode);

				if($silentMode == true)
					continue;

				switch($name){
					case "create_addons":
							$title = "Create addons plugin {$version}";
					break;
					default:
						$title = "$title {$version}";
					break;
				}

				echo ", ";
				uelm_echo($title);
			}

		}

		/**
		 * output exception
		 */
		public static function outputError(Error $e){

			$message = $e->getMessage();
			$trace = $e->getTraceAsString();
			$line = $e->getLine();
			$file = $e->getFile();

			dmp("PHP Error Occured!!!");

			dmp("<b>$message </b>");
			dmp("in file: <b>$file</b> (line: <b>$line</b>)");
			dmp("trace: ");
			dmp($trace);

		}


		/**
		 * output exception
		 */
		public static function outputException($e, $prefix="", $forceTrace = false){

			if(empty($prefix))
				$prefix = GlobalsUnlimitedElements::$pluginTitleCurrent." Error: ";

			$message = $prefix.$e->getMessage();
			$trace = $e->getTraceAsString();

			echo "<div style='color:darkred;'>";

			dmp($message);

			if(GlobalsUC::$SHOW_TRACE == true || $forceTrace === true)
				dmp($trace);
			else
				if($e instanceof Error)
					dmp($trace);

			echo "</div>";
		}

		/**
		 * output error message
		 */
		public static function outputErrorMessage($message){

			echo "<div style='color:darkred;margin:20px;'>";
			echo esc_attr($message);
			echo "</div>";
		}


		/**
		 * output exception in a box
		 */
		public static function outputExceptionBox($e, $prefix=""){

			$message = $e->getMessage();

			if(!empty($prefix))
				$message = $prefix.":  ".$message;

			$trace = "";

			$showTrace = GlobalsUC::$SHOW_TRACE_FRONT;
			if(UniteProviderFunctionsUC::isAdmin() == true)
				$showTrace = GlobalsUC::$SHOW_TRACE;

			if($showTrace)
				$trace = $e->getTraceAsString();

			$html = self::getErrorMessageHtml($message, $trace);
			uelm_echo($html);
		}

		/**
		 * get hidden input field
		 */
		public static function getHiddenInputField($name, $value){
			$value = htmlspecialchars($value);

			$name = esc_attr($name);
			$value = esc_attr($value);

			$html = '<input type="hidden" name="'.$name.'" value="'.$value.'">';

			return($html);
		}


		/**
		 * put settings html from filepath
		 */
		public static function putHtmlSettings($filename, $formID, $arrValues = array(), $pathSettings = null){

			if($pathSettings === null)
				$pathSettings = GlobalsUC::$pathSettings;

			$filepathSettings = $pathSettings."{$filename}.xml";

			UniteFunctionsUC::validateFilepath($filepathSettings, "settings file - {$filename}.xml");

			$settings = new UniteSettingsAdvancedUC();
			$settings->loadXMLFile($filepathSettings);

			if(!empty($arrValues))
				$settings->setStoredValues($arrValues);

			$output = new UniteSettingsOutputWideUC();
			$output->init($settings);
			$output->draw($formID);

		}


		/**
		 * draw settings and get html output
		 */
		public static function drawSettingsGetHtml($settings, $formName){

			$output = new UniteSettingsOutputWideUC();
			$output->init($settings);

			UniteFunctionsUC::obStart();
			$output->draw($formName);

			$htmlSettings = ob_get_contents();

			ob_end_clean();

			return($htmlSettings);
		}



		/**
		 * draw settings
		 */
		public static function drawSettings($settings, $formName = null){

			$output = new UniteSettingsOutputWideUC();

			$drawForm = false;
			if(!empty($formName))
				$drawForm = true;

			$output->init($settings);
			$output->draw($formName, $drawForm);

		}


		/**
		 * output memory log html
		 */
		public static function outputMemoryUsageLog(){
			$arrLog = HelperUC::getLastMemoryUsage();

			if(empty($arrLog)){
				echo "no memory log found";
				return(false);
			}

			$timestamp = $arrLog[0]["time"];
			$date = UniteFunctionsUC::timestamp2DateTime($timestamp);

			$urlPage = UniteFunctionsUC::getVal($arrLog[0], "current_page");

			?>
			<div class="unite-title1">Last log from: <b><?php echo esc_html($date)?></b></div>
			<div>Page: <b><?php echo esc_html($urlPage)?></b></div>
			<br>

			<table class="unite-table">
				<tr>
					<th>
						Operation
					</th>
					<th>
						Usage
					</th>
					<th>
						Diff
					</th>
				</tr>

			<?php

			foreach($arrLog as $item):
				$operation  = $item["oper"];
				$usage = $item["usage"];
				$diff = $item["diff"];

				$usage = number_format($usage);
				$diff = number_format($diff);

				?>
				<tr>
					<td>
						<?php echo esc_html($operation)?>
					</td>
					<td>
						<?php echo esc_html($usage)?>
					</td>
					<td>
						<?php echo esc_html($diff)?>
					</td>
				</tr>
				<?php

			endforeach;
			?>
			</table>
			<?php
		}


		/**
		 * put admin notices html
		 */
		public static function putHtmlAdminNotices(){

			$arrNotices = HelperUC::getAdminNotices();
			if(empty($arrNotices))
				return(false);

			$html = "";
			foreach($arrNotices as $notice){

				$html .= "\n<div class='unite-admin-notice'>{$notice}</div>\n";
			}
			uelm_echo($html);

			//clear admin notices

		}

		/**
		 * put admin notices from footer
		 */
		public static function putFooterAdminNotices(){

			$arrNotices = HelperUC::getAdminNotices();
			if(empty($arrNotices))
				return(false);

			$script = 'jQuery(document).ready(function(){
					var objHeader = jQuery(".unite_header_wrapper");
					if(objHeader){
						<?php foreach($arrNotices as $notice):
							echo "objHeader.append(\"<div class=\'unite-admin-notice\'>" . esc_html($notice) . "</div>\");";
						endforeach;
						?>
					}
				});';
			UniteProviderFunctionsUC::printCustomScript($script, true);
			
		}

		/**
		 * put admin notices
		 */
		public static function putInternalAdminNotices(){

			$masterNotice = null;

			if(strpos(GlobalsUC::URL_API, "http://localhost") !== false)
				$masterNotice = "Dear developer, Please remove local API url in globals";

			if(empty($masterNotice))
				return(false);

			?>

			<div class="unite-admin-notice">
				<?php echo esc_html($masterNotice)?>
			</div>
			<?php
		}

		/**
		 * wrap in media query
		 */
		public static function wrapCssMobile($css, $isTablet = false){

			if(empty($css) === true)
				return $css;

			if(is_string($isTablet) === true)
				$isTablet = ($isTablet === "tablet");

			if($isTablet === true)
				$output = "@media(max-width:1024px){{$css}}";
			else
				$output = "@media(max-width:768px){{$css}}";

			return $output;
		}

		/**
		 * get css selector value by param
		 */
		public static function getCSSSelectorValueByParam($type, $subtype = null){

			switch($type){
				case UniteCreatorDialogParam::PARAM_BACKGROUND:
					switch($subtype){
						case "attachment":
							return "background-attachment:{{value}};";
						case "color":
							return "background-color:{{value}};";
						case "image":
							return "background-image:url('{{value}}');";
						case "position":
							return "background-position:{{value}};";
						case "repeat":
							return "background-repeat:{{value}};";
						case "size":
							return "background-size:{{value}};";
						case "linear-gradient":
							return "background-image:linear-gradient({{angle}},{{color1}} {{stop1}},{{color2}} {{stop2}});";
						case "radial-gradient":
							return "background-image:radial-gradient(at {{position}},{{color1}} {{stop1}},{{color2}} {{stop2}});";
						default:
							UniteFunctionsUC::throwError("Param \"$type\" subtype \"$subtype\" is not implemented.");
					}
				case UniteCreatorDialogParam::PARAM_BORDER:
					switch($subtype){
						case "width":
							return "border-top-width:{{top}};border-right-width:{{right}};border-bottom-width:{{bottom}};border-left-width:{{left}};";
						case "style":
							return "border-style:{{value}};";
						case "color":
							return "border-color:{{value}};";
						default:
							UniteFunctionsUC::throwError("Param \"$type\" subtype \"$subtype\" is not implemented.");
					}
				case UniteCreatorDialogParam::PARAM_TYPOGRAPHY:
					switch($subtype){
						case "family":
							return "font-family:{{value}};";
						case "size":
							return "font-size:{{value}};";
						case "style":
							return "font-style:{{value}};";
						case "weight":
							return "font-weight:{{value}};";
						case "decoration":
							return "text-decoration:{{value}};";
						case "transform":
							return "text-transform:{{value}};";
						case "line-height":
							return "line-height:{{value}};";
						case "letter-spacing":
							return "letter-spacing:{{value}};";
						case "word-spacing":
							return "word-spacing:{{value}};";
						default:
							UniteFunctionsUC::throwError("Param \"$type\" subtype \"$subtype\" is not implemented.");
					}
				case UniteCreatorDialogParam::PARAM_PADDING:
					return "padding-top:{{top}};padding-right:{{right}};padding-bottom:{{bottom}};padding-left:{{left}};";
				case UniteCreatorDialogParam::PARAM_MARGINS:
					return "margin-top:{{top}};margin-right:{{right}};margin-bottom:{{bottom}};margin-left:{{left}};";
				case UniteCreatorDialogParam::PARAM_BORDER_DIMENTIONS:
					return "border-top-left-radius:{{top}};border-top-right-radius:{{right}};border-bottom-right-radius:{{bottom}};border-bottom-left-radius:{{left}};";
				case UniteCreatorDialogParam::PARAM_TEXTSHADOW:
					return "text-shadow:{{x}} {{y}} {{blur}} {{color}};";
				case UniteCreatorDialogParam::PARAM_TEXTSTROKE:
					return "stroke-width:{{width}};stroke:{{color}};-webkit-text-stroke-width:{{width}};-webkit-text-stroke-color:{{color}};";
				case UniteCreatorDialogParam::PARAM_BOXSHADOW:
					return "box-shadow:{{x}} {{y}} {{blur}} {{spread}} {{color}} {{position}};";
				case UniteCreatorDialogParam::PARAM_CSS_FILTERS:
					return "filter:brightness({{brightness}}) contrast({{contrast}}) saturate({{saturate}}) blur({{blur}}) hue-rotate({{hue}});";
				default:
					UniteFunctionsUC::throwError("Param \"$type\" is not implemented.");
			}
		}

		/**
		 * get google font base url
		 */
		public static function getGoogleFontBaseUrl(){

			return "https://fonts.googleapis.com/css";
		}

		/**
		 * get google font url
		 */
		public static function getGoogleFontUrl($family){

			$variations = array("100", "100i", "200", "200i", "300", "300i", "400", "400i", "500", "500i", "600", "600i", "700", "700i", "800", "800i", "900", "900i");
			$variations = implode(",", $variations);

			return self::getGoogleFontBaseUrl() . "?display=swap&family=" . urlencode($family) . ":" . $variations;
		}

		/**
		 * get rating array from rating number. used to help to draw stars
		 */
		public static function getRatingArray($rating){

	    	$arrRating = array();

	    	$empty = array(
	    		"type"=>"empty",
	    		"class"=>"far fa-star",
	    	);
	    	$full = array(
	    		"type"=>"full",
	    		"class"=>"fas fa-star",
	    	);
	    	$half = array(
	    		"type"=>"half",
	    		"class"=>"fas fa-star-half-alt",
	    	);


	    	for($i=1;$i<=5;$i++){

	    		$low = floor($rating);

	    		if($rating == 0){
	    			$arrRating[] = $empty;
	    			continue;
	    		}

	    	    if($rating < $i && $rating > ($i-1)){
	    			$arrRating[] = $half;
	    			continue;
	    	    }


	    		if($i <= $low){
	    			$arrRating[] = $full;
	    			continue;
	    		}

	    		$arrRating[] = $empty;
	    	}


	    	return($arrRating);
		}


		/**
		 * put conditions html
		 */
		public static function putHtmlConditions($type){

			$checkboxID = "uc_dialog_left_condition_".$type;
			$tableID = "uc_dialog_left_condition_table".$type;

			?>

				<div class="unite-inputs-sap"></div>

				<label for="<?php echo esc_attr($checkboxID)?>" class="unite-inputs-label-inline-free">
						<?php esc_html_e("Enable Condition", "unlimited-elements-for-elementor")?>:
				</label>
				<input id="<?php echo esc_attr($checkboxID)?>" type="checkbox" name="enable_condition" class="uc-control" data-controlled-selector=".uc-dialog-conditions-content">

				<div class="uc-dialog-conditions-content">

					<div class="unite-inputs-sap"></div>

					<div class="uc-dialog-conditions-empty">

						<?php esc_attr_e("No parent attribute (dropdown, checkbox or radio) exists in this category", "unlimited-elements-for-elementor")?>
					</div>

					<div class="uc-dialog-conditions-inputs">

						<label class="unite-inputs-label">
							<?php esc_attr_e("Show When", "unlimited-elements-for-elementor")?>:
						</label>

						<table class="uc-table-dialog-conditions">
							<tr>
								<td>
									<select class="uc-dialog-condition-attribute" name="condition_attribute"></select>
								</td>
								<td>
									<select class="uc-dialog-condition-operator" name="condition_operator">
										<option value="equal"><?php esc_attr_e("Equal","unlimited-elements-for-elementor")?></option>
										<option value="not_equal"><?php esc_attr_e("Not Equal","unlimited-elements-for-elementor")?></option>
									</select>
								</td>
								<td>
									<div class="uc-dialog-condition-value-wrapper">
										<select class="uc-dialog-condition-value" name="condition_value" multiple></select>

										<a href="javascript:void(0)" class="uc-dialog-link-addcondition" title="<?php esc_attr_e("Add Condition", "unlimited-elements-for-elementor") ?>">+</a>
									</div>
								</td>
							</tr>
							<tr class="uc-row-condition2" style="display:none">
								<td>
									<select class="uc-dialog-condition-attribute" name="condition_attribute2"></select>
								</td>
								<td>
									<select class="uc-dialog-condition-operator" name="condition_operator2">
										<option value="equal"><?php esc_attr_e("Equal","unlimited-elements-for-elementor")?></option>
										<option value="not_equal"><?php esc_attr_e("Not Equal","unlimited-elements-for-elementor")?></option>
									</select>
								</td>
								<td>
									<select class="uc-dialog-condition-value" name="condition_value2"></select>
								</td>

							</tr>
						</table>

					</div>

				</div>

			<?php

		}

		/**
		 * put remote parent js
		 */
		public static function putRemoteParentJS($arg1, $arg2 = null){


			if($arg2 == "unitegallery"){
				echo esc_attr($arg1) . ".data(\"unitegallery-api\",api);\n";
				$arg2 = null;
			}

			$strOptions = "[" . esc_attr($arg1);

			//maybe put something here

			$strOptions .= "]";

			?>
			<?php if(!empty($arg2)):?>
			<?php echo esc_attr($arg1)?>.data("uc-remote-options", <?php uelm_echo($arg2)?>);
			<?php endif?>

			<?php echo esc_attr($arg1)?>.trigger("uc-object-ready");
			jQuery(document).trigger("uc-remote-parent-init", <?php uelm_echo($strOptions)?>);
			<?php

		}


		/**
		 * put hide id's css
		 * iput id1,id2 - comma separated id's list
		 */
		public static function putHideIdsCss($strIDs){

			$strIDs = trim($strIDs);

			if(empty($strIDs))
				return(false);

			$arrIDs = explode(",", $strIDs);

			$strCSS = "";
			foreach($arrIDs as $id){

				if(!empty($strCSS))
					$strCSS .= ",";

				$strCSS .= "#{$id}";
			}

			$strCSS.= "{display:none}";

			uelm_echo("\n".$strCSS);
		}

		/**
		 * put php info html
		 */
		public static function putPHPInfo(){

			UniteFunctionsUC::obStart();
			HelperHtmlUC::putAddonTypesBrowserDialogs();

			phpinfo();

			$content = ob_get_contents();

			ob_end_clean();

			//clean css
			$content = str_replace("body {background-color:", "xbody {background-color:", $content);
			$content = str_replace("a:link", ".uc-phpino a:link", $content);

			?>

			<br>

			<div class="uc-phpino" style="overflow-x:scroll;width:100%;">

			<?php 
			uelm_echo($content);
			?>

			</div>
<?php
		}

		/**
		 * put function - isElementInViewport
		 */
		public static function putJSFunc_isElementInViewport($checkRunOnce = true){

			if($checkRunOnce == true){

				$isRunOnce = HelperUC::isRunCodeOnce("js_isElementInViewport");

				if($isRunOnce == false)
					return(false);

			}

			?>
	/**
	 * is element in viewport
	 */
    function ueIsElementInViewport(objElement) {
	  
	  if(document.body.scrollHeight <= (window.innerHeight + 30) )
		return(true);	

      var elementTop = objElement.offset().top;
      var elementBottom = elementTop + objElement.outerHeight();

      var viewportTop = jQuery(window).scrollTop();
      var viewportBottom = viewportTop + jQuery(window).height();

      return (elementBottom > viewportTop && elementTop < viewportBottom);
	}

			<?php
		}


		/**
		 * put document ready start js
		 */
		public static function putDocReadyStartJS($widgetID){
			
			if(GlobalsProviderUC::$isGutenbergOutput == true):
			?>
jQuery(document).ready(function(){
			<?php 
			return(false);
			endif;
			
			
			?>
jQuery(document).ready(function(){
function <?php echo esc_attr($widgetID)?>_start(){
			<?php

		}

		/**
		 * put document ready end js
		 */
		public static function putDocReadyEndJS($widgetID){
			
			if(GlobalsProviderUC::$isGutenbergOutput == true):
			?>
});
			<?php 
			return(false);
			endif;
			
			?>
}if(jQuery("#<?php echo esc_attr($widgetID)?>").length) <?php echo esc_attr($widgetID)?>_start();
	jQuery( document ).on( 'elementor/popup/show', (event, id, objPopup) => {
	if(objPopup.$element.has(jQuery("#<?php echo esc_attr($widgetID)?>")).length) <?php echo esc_attr($widgetID)?>_start();});
});

			<?php

		}


	} //end class
