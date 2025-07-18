<?php
/**
 * @package Unlimited Elements
 * @author unlimited-elements.com
 * @copyright (C) 2021 Unlimited Elements, All Rights Reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
if ( ! defined( 'ABSPATH' ) ) exit;

class UniteCreatorSettingsOutput extends UniteSettingsOutputUC{

	private static $counter = 1;

	private function a_______COLS_LAYOUT_________(){
	}

	/**
	 * draw columns layout output
	 */
	protected function drawColsLayoutInput($setting){

		$value = UniteFunctionsUC::getVal($setting, "value");
		$id = UniteFunctionsUC::getVal($setting, "id");
		$name = UniteFunctionsUC::getVal($setting, "name");

		?>

		<div id="<?php echo esc_attr($id) ?>"
			data-name="<?php echo esc_attr($name) ?>"
			data-settingtype="col_layout"
			class="uc-setting-cols-layout unite-setting-input-object">

			<div class='uc-layout-row unite-clear' data-layout-type="1_1" title="100%">
				<div class="uc-layout-col uc-colsize-1_1 unite-clear"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_2-1_2" title="50% 50%">
				<div class="uc-layout-col uc-colsize-1_2"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_2"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_4-1_4-1_4-1_4" title="25% 25% 25% 25%">
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_3-1_3-1_3" title="33% 33% 33%">
				<div class="uc-layout-col uc-colsize-1_3"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_3"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_3"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_4-3_4" title="25% 75%">
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-3_4"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_4-1_4-1_2" title="25% 25% 50%">
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_2"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="2_3-1_3" title="66% 33%">
				<div class="uc-layout-col uc-colsize-2_3"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_3"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_3-2_3" title="33% 66%">
				<div class="uc-layout-col uc-colsize-1_3"><span></span></div>
				<div class="uc-layout-col uc-colsize-2_3"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="3_4-1_4" title="75% 25%">
				<div class="uc-layout-col uc-colsize-3_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_4-1_2-1_4" title="25% 50% 25%">
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_2"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_2-1_4-1_4" title="50% 25% 25%">
				<div class="uc-layout-col uc-colsize-1_2"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_4"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="2_5-1_5-1_5-1_5" title="40% 20% 20% 20%">
				<div class="uc-layout-col uc-colsize-2_5"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_5"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_5"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_5"><span></span></div>
			</div>

			<div class='uc-layout-row unite-clear' data-layout-type="1_5-1_5-1_5-2_5" title="20% 20% 20% 40%">
				<div class="uc-layout-col uc-colsize-1_5"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_5"><span></span></div>
				<div class="uc-layout-col uc-colsize-1_5"><span></span></div>
				<div class="uc-layout-col uc-colsize-2_5"><span></span></div>
			</div>

		</div>

		<?php
	}

	private function a________SAVE_GRID_PANEL________(){
	}

	/**
	 * draw save grid panel
	 */
	private function drawSaveGridPanelButton($setting){

		$id = UniteFunctionsUC::getVal($setting, "id");
		$name = UniteFunctionsUC::getVal($setting, "name");

		$prefix = $id;

		?>
		<div id="<?php echo esc_attr($id) ?>"
			data-name="<?php echo esc_attr($name) ?>"
			data-settingtype="save_section_tolibrary"
			class="uc-setting-save-panel-wrapper unite-setting-input-object">

			<?php
			$buttonTitle = esc_html__("Save Section", "unlimited-elements-for-elementor");
			$loaderTitle = esc_html__("Saving...", "unlimited-elements-for-elementor");
			$successTitle = esc_html__("Section Saved", "unlimited-elements-for-elementor");
			HelperHtmlUC::putDialogActions($prefix, $buttonTitle, $loaderTitle, $successTitle);
			?>

		</div>
		<?php
	}

	private function a_______GRID_PANEL_BUTTON_____(){
	}

	/**
	 * draw save grid panel
	 */
	private function drawGridPanelButton($setting){

		$id = UniteFunctionsUC::getVal($setting, "id");
		$name = UniteFunctionsUC::getVal($setting, "name");
		$class = UniteFunctionsUC::getVal($setting, "class");
		if(empty($class))
			$class = "unite-button-secondary";

		$prefix = $id;

		$label = UniteFunctionsUC::getVal($setting, "button_text");
		if(empty($label))
			$label = esc_html__("Click Me", "unlimited-elements-for-elementor");

		$label = UniteFunctionsUC::sanitizeAttr($label); 

		$action = UniteFunctionsUC::getVal($setting, "action", "no_action");
		$action = UniteFunctionsUC::sanitizeAttr($action);

		$actionParam = UniteFunctionsUC::getVal($setting, "action_param");

		$addHtml = "";
		if(!empty($actionParam)){
			$actionParam = UniteFunctionsUC::sanitizeAttr($actionParam);
			$addHtml = "data-actionparam=\"$actionParam\"";
		}

		?>
		<div id="<?php echo esc_attr($id) ?>"
			data-settingtype="grid_panel_button"
			class="unite-setting-input-object uc-grid-panel-button-wrapper">

			<a id="<?php echo esc_attr($id) ?>_button"
				data-action="<?php echo esc_attr($action) ?>" <?php 
				uelm_echo($addHtml) ?>
				href="javascript:void(0)"
				class="uc-grid-panel-button <?php echo esc_attr($class) ?>"><?php echo esc_html($label) ?></a>

		</div>
		<?php
	}

	private function a_______SIZE_RELATED_LAYOUT_____(){
	}

	/**
	 * draw size input label
	 */
	protected function drawSizeInput_label($setting, $size){

		$keyLabel = "label_" . $size;
		$label = UniteFunctionsUC::getVal($setting, $keyLabel);
		$label = htmlspecialchars($label);

		$keyDesc = "description_" . $size;
		$description = UniteFunctionsUC::getVal($setting, $keyDesc);
		$description = htmlspecialchars($description);

		$addClass = "uc-showin-" . $size;

		if(empty($label))
			return (false);

		?>

		<div class="unite-setting-text uc-tip <?php echo esc_attr($addClass) ?>"
			title="<?php echo esc_attr($description) ?>">
			<?php echo esc_html($label) ?>
		</div>

		<?php
	}

	/**
	 * draw the four input for perticular size
	 */
	protected function drawFourInputsInput_size($setting, $baseName, $size, $arrSuffix, $arrTitles){

		$arrObjSettings = array();
		foreach($arrSuffix as $suffix){
			$settingName = $baseName . "_" . $suffix;

			if(!empty($size) && $size != "desktop")
				$settingName .= "_" . $size;

			$objSettings = $this->settings->getSettingByName($settingName);
			$objSettings["type_number"] = true;
			unset($objSettings["unit"]);
			$objSettings["class"] = "nothing";

			$arrObjSettings[$settingName] = $objSettings;
		}

		$index = 0;

		$this->drawSizeInput_label($setting, $size);

		$addClass = "uc-showin-" . $size;

		?>

		<div class="unite-setting-paddingline unite-clear <?php echo esc_attr($addClass) ?>">
			<?php
			foreach($arrObjSettings as $setting):

				$title = $arrTitles[$index];

				?>
				<div class="unite-setting-paddingline-item">
					<?php $this->drawTextInput($setting); ?>
					<label><?php echo esc_html($title) ?></label>
				</div>
				<?php
				$index++;
			endforeach;

			?>
		</div>
		<?php
	}

	/**
	 * get the sizes array from size related draw setting
	 */
	protected function getSizesFromCustomSetting($setting){

		$arrSizes = array("desktop");
		$sizes = UniteFunctionsUC::getVal($setting, "sizes");

		if($sizes == "all")
			$arrSizes = array_merge($arrSizes, GlobalsUC::$arrSizes);

		return ($arrSizes);
	}

	/**
	 * draw four inputs input, for padding and margin
	 * check that the settings are there
	 */
	protected function drawFourInputsInput($setting){

		$baseName = UniteFunctionsUC::getVal($setting, "name");
		$prefix = UniteFunctionsUC::getVal($setting, "prefix");
		$prefixMobile = UniteFunctionsUC::getVal($setting, "prefixmobile");
		$onlyTopBottom = UniteFunctionsUC::getVal($setting, "onlytopbottom");
		$onlyTopBottom = UniteFunctionsUC::strToBool($onlyTopBottom);

		if(!empty($prefix))
			$baseName = $prefix;

		$arrSizes = $this->getSizesFromCustomSetting($setting);

		$arrSuffix = array("top", "right", "bottom", "left");
		$arrTitles = array(
			esc_html__("Top", "unlimited-elements-for-elementor"),
			esc_html__("Right", "unlimited-elements-for-elementor"),
			esc_html__("Bottom", "unlimited-elements-for-elementor"),
			esc_html__("Left", "unlimited-elements-for-elementor"),
		);

		//put only top and bottom
		if($onlyTopBottom == true){
			$arrSuffix = array("top", "bottom");
			$arrTitles = array(
				esc_html__("Top", "unlimited-elements-for-elementor"),
				esc_html__("Bottom", "unlimited-elements-for-elementor"),
			);
		}

		foreach($arrSizes as $size){
			if(!empty($prefixMobile) && $size != "desktop")
				$baseName = $prefixMobile;

			$this->drawFourInputsInput_size($setting, $baseName, $size, $arrSuffix, $arrTitles);
		}
	}

	/**
	 * draw input with sizes
	 */
	protected function drawInputWithSizes($setting){

		$baseName = UniteFunctionsUC::getVal($setting, "prefix");
		$arrSizes = $this->getSizesFromCustomSetting($setting);

		foreach($arrSizes as $size){
			$settingName = $baseName;

			if(!empty($size) && $size != "desktop")
				$settingName .= "_" . $size;

			$objSettings = $this->settings->getSettingByName($settingName);

			$this->drawSizeInput_label($setting, $size);

			$type = UniteFunctionsUC::getVal($objSettings, "type");

			if($type == "custom")
				UniteFunctionsUC::throwError("the input should not be custom here!");

			$showinClass = "uc-showin-" . $size;

			$unit = UniteFunctionsUC::getVal($objSettings, "unit");
			?>

			<div class="<?php echo esc_attr($showinClass) ?>">

				<?php $this->drawInputs($objSettings); ?>
				<?php if(!empty($unit)): ?>
					<span class="setting_unit"><?php echo esc_html($unit) ?></span>
				<?php endif ?>

			</div>

			<?php
		}
	}

	/**
	 * draw connect with instagram button
	 */
	private function drawConnectWithInstagramButton($setting){

		$objServices = new UniteServicesUC();
		$objServices->includeInstagramAPI();

		HelperInstaUC::putConnectWithInstagramButton();
	}

	/**
	 * draw connect with google button
	 */
	private function drawConnectWithGoogleButton($setting){

		$objServices = new UniteServicesUC();
		$objServices->includeGoogleAPI();

		$error = "";
		$textConnected = "";

		try{
			$accessToken = UEGoogleAPIHelper::getFreshAccessToken();
		}catch(Exception $exception){
			if(UEGoogleAPIHelper::getAccessToken())
				// translators: %s is a string
				$error = sprintf(__("Unable to refresh the access token. Please connect to Google again. (Reason: \"%s\")", "unlimited-elements-for-elementor"), $exception->getMessage());
		}

		$error = UniteFunctionsUC::getGetVar("google_connect_error", $error, UniteFunctionsUC::SANITIZE_NOTHING);

		$isAccessTokenExpired = UEGoogleAPIHelper::isAccessTokenExpired();
        $credentials = UEGoogleAPIHelper::isCredentials();

		if($isAccessTokenExpired == false){
			$email = UEGoogleAPIHelper::getUserEmail();
			$isValid = UniteFunctionsUC::isEmailValid($email);

			if($isValid == true)
				$textConnected = sprintf(__("Connected to: <b>%s</b>", "unlimited-elements-for-elementor"), $email);

            $expirationTime = UEGoogleAPIHelper::getExpirationDate();
			$textExpirationTime = sprintf(__("Expires in <b>%s</b>, the time will auto extend.", "unlimited-elements-for-elementor"), $expirationTime);
			?>

			<div class="uc-google-connect-message">
                <div><?php echo wp_kses($textConnected, HelperUC::getKsesAllowedHTML()); ?></div>
                <div><?php echo wp_kses($textExpirationTime, HelperUC::getKsesAllowedHTML()); ?></div>
			</div>

			<a class="button" href="<?php echo esc_url(UEGoogleAPIHelper::getRevokeUrl()); ?>">
				<?php esc_html_e("Disconnect from Google Sheets", "unlimited-elements-for-elementor"); ?>
			</a>
		<?php
		}else{
		?>
			<a class="button" href="<?php echo esc_url(UEGoogleAPIHelper::getAuthUrl()); ?>">
				<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="16" height="16" style="margin-bottom: -0.2em">
					<path fill="#19b870" d="m21 6-6-6H5a2 2 0 0 0-2 2v20a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6z" />
					<path fill="#80D8B0" d="M15 0v4a2 2 0 0 0 2 2h4l-6-6z" />
					<path fill="#ffffff" d="M7 9v10h10V9H7zm9 3h-3.5v-2H16v2zm-3.5 1H16v2h-3.5v-2zm-1 2H8v-2h3.5v2zm0-5v2H8v-2h3.5zM8 16h3.5v2H8v-2zm4.5 2v-2H16v2h-3.5z" />
				</svg>
				<?php esc_html_e("Connect to Google Sheets", "unlimited-elements-for-elementor"); ?>
			</a>

			<?php if($isAccessTokenExpired == true && $credentials == true): ?>
                <div class="uc-google-connect-error">
                    <div><?php esc_html_e("The token has expired. Please connect again.", "unlimited-elements-for-elementor"); ?></div>
                </div>
			<?php endif; ?>
		<?php
		}

		if(!empty($error)){
		?>
			<div class="uc-google-connect-error">
				<div><?php  echo esc_html(sprintf(__("Error: %s", "unlimited-elements-for-elementor"), $error)); //Security Update 1 ?></div>
			</div>
		<?php


		}
	}

	/**
	 * draw openweather check button
	 */
	private function drawOpenWeatherCheckButton($setting){

		$objServices = new UniteServicesUC();
		$objServices->includeOpenWeatherAPI();

		$key = HelperProviderCoreUC_EL::getGeneralSetting("openweather_api_key");
		$weatherService = new UEOpenWeatherAPIClient($key);

		if(empty($key) === false){
			?>
			<a class="button" href="<?php echo esc_url($weatherService->getApiKeyTestUrl()); ?>" target="_blank">
				<?php esc_html_e("Check API", "unlimited-elements-for-elementor"); ?>
			</a>
			<?php
		}
	}

	/**
	 * draw widget svg text
	 */
	private function drawWidgetSvg($setting){

		?>
		<div id="uc_widget_svg_holder" class="uc-wiget-svg-holder" style="display:none"></div>

		<span class="description">
				<?php esc_attr_e("For the preview svg icon put preview_icon.svg file in the assets folder", "unlimited-elements-for-elementor") ?>
			</span>

		<?php
	}

	/**
	 * draw custom inputs
	 */
	protected function drawCustomInputs($setting){

		$customType = UniteFunctionsUC::getVal($setting, "custom_type");

		switch($customType){
			case "cols-layout":
				$this->drawColsLayoutInput($setting);
			break;
			case "fourinputs":
				$this->drawFourInputsInput($setting);
			break;
			case "inputwithsize":
				$this->drawInputWithSizes($setting);
			break;
			case "save_settings_tolibrary":
				$this->drawSaveGridPanelButton($setting);
			break;
			case "grid_panel_button":
				$this->drawGridPanelButton($setting);
			break;
			case "widget_svg_icon":
				$this->drawWidgetSvg($setting);
			break;
			case "instagram_connect":
				$this->drawConnectWithInstagramButton($setting);
			break;
			case "google_connect":
				$this->drawConnectWithGoogleButton($setting);
			break;
			case "openweather_api_test":
				$this->drawOpenWeatherCheckButton($setting);
			break;
		}
	}


	private function a_______MP3______(){}

	/**
	 * draw mp3 input
	 */
	protected function drawMp3AddonInput($setting){

		$previewStyle = "display:none";

		$setting = $this->modifyImageSetting($setting);

		$value = UniteFunctionsUC::getVal($setting, "value");

		$urlBase = UniteFunctionsUC::getVal($setting, "url_base");

		$isError = false;

		if(empty($urlBase)){
			$isError = true;
			$value = "";
			$setting["value"] = "";
		}

		$class = $this->getInputClassAttr($setting, "", "unite-setting-mp3-input unite-input-image");

		//add source param
		$source = UniteFunctionsUC::getVal($setting, "source");

		$buttonAddClass = "";
		$errorStyle = "style='display:none'";
		if($isError == true){
			$buttonAddClass = " button-disabled";
			$errorStyle = "'";
		}

		?>
		<div class="unite-setting-mp3">
			<input type="text"
				id="<?php echo esc_attr($setting["id"]) ?>"
				name="<?php echo esc_attr($setting["name"]) ?>" <?php 
				uelm_echo($class) ?>
				value="<?php echo esc_attr($value) ?>" 
				<?php 
				$this->getDefaultAddHtml($setting);
				if(!empty($source)) {
					echo ' data-source="' . esc_attr($source) . '"';
				}
				?> />
			<a href="javascript:void(0)"
				class="unite-button-secondary unite-button-choose <?php echo esc_attr($buttonAddClass) ?>"><?php esc_html_e("Choose", "unlimited-elements-for-elementor") ?></a>
			<div class='unite-setting-mp3-error unite-setting-error' <?php 
				uelm_echo($errorStyle) ?>><?php esc_html_e("Please select assets path", "unlimited-elements-for-elementor") ?></div>
		</div>
		<?php
	}

	/**
	 * draw image input
	 */
	protected function drawImageInput($setting){

		$source = UniteFunctionsUC::getVal($setting, "source");

		if($source === "addon"){
			$urlBase = UniteFunctionsUC::getVal($setting, "url_base");

			if(empty($urlBase) === true)
				$setting["error"] = __("Please select assets path.", "unlimited-elements-for-elementor");
		}

		parent::drawImageInput($setting);
	}

	/**
	 * draw mp3 input
	 */
	protected function drawMp3Input($setting){

		//add source param
		$source = UniteFunctionsUC::getVal($setting, "source");
		if($source == "addon")
			$this->drawMp3AddonInput($setting);
		else
			parent::drawMp3Input($setting);
	}

	/**
	 * draw switcher setting
	 */
	protected function drawSwitcherSetting($setting){

		$id = UniteFunctionsUC::getVal($setting, "id");
		$name = UniteFunctionsUC::getVal($setting, "name");
		$items = UniteFunctionsUC::getVal($setting, "items");
		$value = UniteFunctionsUC::getVal($setting, "value");

		if(count($items) !== 2)
			UniteFunctionsUC::throwError("Switcher requires 2 items.");

		$uncheckValue = reset($items); // first item
		$checkValue = end($items); // second item

		?>
		<div
			id="<?php echo esc_attr($id); ?>"
			class="unite-setting-switcher unite-setting-input-object"
			data-settingtype="switcher"
			data-name="<?php echo esc_attr($name); ?>"
			data-value="<?php echo esc_attr($value); ?>"
			data-checkedvalue="<?php echo esc_attr($checkValue); ?>"
			data-uncheckedvalue="<?php echo esc_attr($uncheckValue); ?>"
			<?php $this->getDefaultAddHtml($setting); ?>
		>
			<div class="unite-setting-switcher-toggle"></div>
		</div>
		<?php

	}

	/**
	 * draw dimentions setting
	 */
	protected function drawDimentionsSetting($setting){

		$id = UniteFunctionsUC::getVal($setting, "id");
		$name = UniteFunctionsUC::getVal($setting, "name");
		$defaultValue = UniteFunctionsUC::getVal($setting, "default_value");
		$value = UniteFunctionsUC::getVal($setting, "value");
		$units = UniteFunctionsUC::getVal($setting, "units");
		$withNames = UniteFunctionsUC::getVal($setting, "output_names");
		$withNames = UniteFunctionsUC::strToBool($withNames);

		$defaultValue = $this->drawDimentionsSetting_prepareValues($defaultValue);
		$value = $this->drawDimentionsSetting_prepareValues($value);

		$dimentions = array(
			"top" => __("Top", "unlimited-elements-for-elementor"),
			"right" => __("Right", "unlimited-elements-for-elementor"),
			"bottom" => __("Bottom", "unlimited-elements-for-elementor"),
			"left" => __("Left", "unlimited-elements-for-elementor"),
		);

		$setting["default_value"] = $defaultValue;
		$setting["value"] = $value;

		?>
		<div
			class="unite-dimentions unite-setting-input-object unite-settings-exclude"
			data-settingtype="dimentions"
			data-name="<?php echo esc_attr($name); ?>"
			<?php $this->getDefaultAddHtml($setting); ?>
		>

			<?php foreach($dimentions as $dimentionValue => $dimentionTitle): ?>

				<?php

				$fieldId = "$id-$dimentionValue";
				$fieldValue = UniteFunctionsUC::getVal($value, $dimentionValue);
				$fieldName = $withNames === true ? $name . "_" . $dimentionValue : "";

				?>

				<div class="unite-dimentions-field">
					<input
						class="unite-dimentions-field-input"
						id="<?php echo esc_attr($fieldId); ?>"
						type="number"
						name="<?php echo esc_attr($fieldName); ?>"
						value="<?php echo esc_attr($fieldValue); ?>"
						data-key="<?php echo esc_attr($dimentionValue); ?>"
					/>
					<label
						class="unite-dimentions-field-label"
						for="<?php echo esc_attr($fieldId); ?>"
					>
						<?php echo esc_html($dimentionTitle); ?>
					</label>
				</div>

			<?php endforeach; ?>

			<?php

			$fieldName = "is_linked";
			$isLinked = UniteFunctionsUC::getVal($value, $fieldName, true);
			$isLinked = UniteFunctionsUC::strToBool($isLinked);

			?>

			<?php if(empty($units) === false): ?>
				<div class="unite-dimentions-units">
					<?php $this->drawUnitsPicker($units); ?>
				</div>
			<?php endif; ?>

			<div
				class="unite-dimentions-link unite-setting-button uc-tip <?php if($isLinked) { echo "unite-active"; } ?>"
				data-key="<?php echo esc_attr($fieldName); ?>"
				data-title-link="<?php esc_attr_e("Link Values", "unlimited-elements-for-elementor"); ?>"
				data-title-unlink="<?php esc_attr_e("Unlink Values", "unlimited-elements-for-elementor"); ?>"
			>
				<svg class="unite-dimentions-icon-link" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
					<path d="m3.5 8.5 5-5M5 3l1.672-1.672a2.829 2.829 0 0 1 4 4L9 7M3 5 1.328 6.672a2.829 2.829 0 0 0 4 4L7 9" />
				</svg>
				<svg class="unite-dimentions-icon-unlink" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 12 12">
					<path d="m5.5 2.5 1.172-1.172a2.829 2.829 0 0 1 4 4L9.5 6.5M2.5 5.5 1.328 6.672a2.829 2.829 0 0 0 4 4L6.5 9.5M3.5 8.5l1-1M7.5 4.5l1-1M.5.5l11 11" />
				</svg>
			</div>

		</div>
		<?php
	}

	/**
	 * draw dimentions setting - prepare values
	 */
	function drawDimentionsSetting_prepareValues($values){

		$keys = array("top", "bottom", "left", "right", "unit", "is_linked");

		foreach($keys as $key){
			if(isset($values[$key]) === false)
				continue;

			$value = $values[$key];
			$value = trim($value);
			$value = htmlspecialchars($value);

			if($key === "unit")
				$value = empty($value) === false ? $value : "px";
			elseif($key === "is_linked")
				$value = UniteFunctionsUC::strToBool($value);

			$values[$key] = $value;
		}

		return $values;
	}


	private function a________DRAW_FONTS_PANEL_______(){
	}

	/**
	 * get mobile placeholders
	 */
	protected function getMobilePlaceholders($valDesktop, $valTablet, $valMobile){

		$arrSizeValues = array();
		$arrSizeValues["tablet"] = $valTablet;
		$arrSizeValues["mobile"] = $valMobile;

		$parentValue = $valDesktop;

		foreach(GlobalsUC::$arrSizes as $size){
			$sizeValue = UniteFunctionsUC::getVal($arrSizeValues, $size);
			if($sizeValue === "")
				$sizeValue = $parentValue;

			$parentValue = $sizeValue;

			$arrSizeValues[$size] = $sizeValue;
		}

		return ($arrSizeValues);
	}

	/**
	 * get slider font panel html
	 */
	private function getFontsPanelHtmlFields_slider($name, $text, $value, $placeholder = "", $inputID = null, $arrPlaceholderGroup = null, $addClass = ""){

		$classSection = "uc-fontspanel-details";
		$classInput = "uc-fontspanel-field";
		$br = "\n";

		$valueSlider = $value;
		if($value === "" && !empty($placeholder))
			$valueSlider = $placeholder;

		$addParams = "";
		if(!empty($arrPlaceholderGroup)){
			$jsonChildren = UniteFunctionsUC::jsonEncodeForHtmlData($arrPlaceholderGroup);
			$addParams = " data-placeholder_group='$jsonChildren'";
		}

		if(!empty($placeholder)){
			$placeholder = htmlspecialchars($placeholder);
			$addParams .= " placeholder=\"{$placeholder}\"";
		}

		if(!empty($inputID))
			$addParams .= " id=\"{$inputID}\"";

		$html = "";
		$html .= "<span class=\"{$classSection} uc-details-font-size {$addClass}\">" . $br;
		$html .= "			" . $text . "<br>" . $br;
		$html .= "<div class=\"unite-setting-range-wrapper\">" . $br;
		$html .= "		<input type=\"range\" min=\"8\" max=\"76\" step=\"1\" value=\"{$valueSlider}\">" . $br;
		$html .= "	<input type=\"text\" data-fieldname='{$name}' {$addParams} value=\"{$value}\" class=\"unite-setting-range {$classInput}\">	" . $br;
		$html .= "</div>" . $br;
		$html .= "</span>" . $br;

		return ($html);
	}

	/**
	 * get fonts panel html fields
	 */
	private function getFontsPanelHtmlFields($arrParams, $arrFontsData, $addTemplate = false){

		$arrData = HelperUC::getFontPanelData();

		if($addTemplate == true)
			$arrFontsTemplate = UniteCreatorPageBuilder::getPageFontNames(true);

		//get last param name
		end($arrParams);
		$lastName = key($arrParams);

		$html = "<div class='uc-fontspanel'>";

		$counter = 0;
		$random = UniteFunctionsUC::getRandomString(5);

		$br = "\n";
		foreach($arrParams as $name => $title):

			$counter++;
			$IDSuffix = "{$random}_{$counter}";
			$sectionID = "uc_fontspanel_section_{$IDSuffix}";

			$fontData = UniteFunctionsUC::getVal($arrFontsData, $name);
			$isDataExists = !empty($fontData);

			if($addTemplate == true)
				$fontTemplate = UniteFunctionsUC::getVal($fontData, "template");

			$fontFamily = UniteFunctionsUC::getVal($fontData, "font-family");
			$fontWeight = UniteFunctionsUC::getVal($fontData, "font-weight");

			//get size related fields

			$fontSize = UniteFunctionsUC::getVal($fontData, "font-size");
			$fontSize = UniteFunctionsUC::getNumberFromString($fontSize);

			$fontSizeTablet = UniteFunctionsUC::getVal($fontData, "font-size-tablet");
			$fontSizeTablet = UniteFunctionsUC::getNumberFromString($fontSizeTablet);

			$fontSizeMobile = UniteFunctionsUC::getVal($fontData, "font-size-mobile");
			if(empty($fontSizeMobile))
				$fontSizeMobile = UniteFunctionsUC::getVal($fontData, "mobile-size");  //old way

			$fontSizeMobile = UniteFunctionsUC::getNumberFromString($fontSizeMobile);

			$arrPlaceholders = $this->getMobilePlaceholders($fontSize, $fontSizeTablet, $fontSizeMobile);

			$placeholderSizeTablet = UniteFunctionsUC::getVal($arrPlaceholders, "tablet");
			$placeholderSizeMobile = UniteFunctionsUC::getVal($arrPlaceholders, "mobile");

			//---------

			$lineHeight = UniteFunctionsUC::getVal($fontData, "line-height");
			$textDecoration = UniteFunctionsUC::getVal($fontData, "text-decoration");
			$fontStyle = UniteFunctionsUC::getVal($fontData, "font-style");

			$color = UniteFunctionsUC::getVal($fontData, "color");
			$color = htmlspecialchars($color);

			$customStyles = UniteFunctionsUC::getVal($fontData, "custom");
			$customStyles = htmlspecialchars($customStyles);

			$classInput = "uc-fontspanel-field";

			if($addTemplate == true)
				$selectFontTemplate = HelperHtmlUC::getHTMLSelect($arrFontsTemplate, $fontTemplate, "data-fieldname='template' class='{$classInput}'", true, "not_chosen", esc_html__("---- Select Page Font----", "unlimited-elements-for-elementor"));

			$selectFontFamily = HelperHtmlUC::getHTMLSelect($arrData["arrFontFamily"], $fontFamily, "data-fieldname='font-family' class='{$classInput}'", true, "not_chosen", esc_html__("Select Font Family", "unlimited-elements-for-elementor"));
			$selectFontWeight = HelperHtmlUC::getHTMLSelect($arrData["arrFontWeight"], $fontWeight, "data-fieldname='font-weight' class='{$classInput}'", false, "not_chosen", esc_html__("Select", "unlimited-elements-for-elementor"));
			$selectLineHeight = HelperHtmlUC::getHTMLSelect($arrData["arrLineHeight"], $lineHeight, "data-fieldname='line-height' class='{$classInput}'", false, "not_chosen", esc_html__("Select", "unlimited-elements-for-elementor"));
			$selectTextDecoration = HelperHtmlUC::getHTMLSelect($arrData["arrTextDecoration"], $textDecoration, "data-fieldname='text-decoration' class='{$classInput}'", false, "not_chosen", esc_html__("Select Text Decoration", "unlimited-elements-for-elementor"));
			$selectFontStyle = HelperHtmlUC::getHTMLSelect($arrData["arrFontStyle"], $fontStyle, "data-fieldname='font-style' class='{$classInput}'", false, "not_chosen", esc_html__("Select", "unlimited-elements-for-elementor"));

			$classSection = "uc-fontspanel-details";

			$htmlChecked = "";
			$contentAddHtml = "style='display:none'";

			if($isDataExists == true){
				$htmlChecked = "checked ";
				$contentAddHtml = "";
			}

			$html .= "<label class=\"uc-fontspanel-title\">" . $br;
			$html .= "<input data-target=\"{$sectionID}\" {$htmlChecked}data-sectionname=\"{$name}\" type=\"checkbox\" onfocus='this.blur()' class='uc-fontspanel-toggle uc-fontspanel-toggle-{$name}' /> {$title}" . $br;
			$html .= " </label>";

			$html .= "<div id='{$sectionID}' class='uc-fontspanel-section' {$contentAddHtml}>	" . $br;

			$html .= "<div class=\"uc-fontspanel-line\">" . $br;

			if($addTemplate == true){
				$html .= "<span class=\"{$classSection} uc-details-font-select\">" . $br;
				$html .= " 			" . esc_html__("From Page Font", "unlimited-elements-for-elementor") . "<br>" . $br;
				$html .= "		" . $selectFontTemplate . $br;
				$html .= "</span>" . $br;
			}

			$html .= "<span class=\"{$classSection} uc-details-font-family\">" . $br;
			$html .= " 			" . esc_html__("Font Family", "unlimited-elements-for-elementor") . "<br>" . $br;
			$html .= "		" . $selectFontFamily . $br;
			$html .= "</span>" . $br;

			$html .= "<span class=\"{$classSection} uc-details-font-weight\">" . $br;
			$html .= "			" . esc_html__("Font Weight", "unlimited-elements-for-elementor") . "<br>" . $br;
			$html .= "		" . $selectFontWeight . $br;
			$html .= "</span>" . $br;

			//put size related
			$idFontSize = "fontfield_font_size_" . $IDSuffix;
			$idFontSizeTablet = "fontfield_font_size_tablet_" . $IDSuffix;
			$idFontSizeMobile = "fontfield_font_size_mobile_" . $IDSuffix;

			$arrPlaceholdersGroup = array($idFontSize, $idFontSizeTablet, $idFontSizeMobile);

			$text = esc_html__("Font Size (px)", "unlimited-elements-for-elementor");
			$html .= $this->getFontsPanelHtmlFields_slider("font-size", $text, $fontSize, "", $idFontSize, $arrPlaceholdersGroup, "uc-showin-desktop");

			$text = esc_html__("Font Size - Tablet (px)", "unlimited-elements-for-elementor");
			$html .= $this->getFontsPanelHtmlFields_slider("font-size-tablet", $text, $fontSizeTablet, $placeholderSizeTablet, $idFontSizeTablet, $arrPlaceholdersGroup, "uc-showin-tablet");

			$text = esc_html__("Font Size - Mobile (px)", "unlimited-elements-for-elementor");
			$html .= $this->getFontsPanelHtmlFields_slider("font-size-mobile", $text, $fontSizeMobile, $placeholderSizeMobile, $idFontSizeMobile, null, "uc-showin-mobile");

			// ---------

			$html .= "<span class=\"{$classSection} uc-details-line-height\">" . $br;
			$html .= "		" . esc_html__("Line Height", "unlimited-elements-for-elementor") . "<br>" . $br;
			$html .= "		" . $selectLineHeight . $br;
			$html .= "</span>" . $br;

			$html .= "</div>" . $br;  //line

			$html .= "<div class=\"uc-fontspanel-line\">" . $br;

			$html .= "<span class=\"{$classSection} uc-details-text-decoration\">" . $br;
			$html .= "	" . esc_html__("Text Decoration", "unlimited-elements-for-elementor") . "<br>" . $br;
			$html .= $selectTextDecoration;
			$html .= "</span>" . $br;

			$html .= "<span class=\"{$classSection} uc-details-color\">" . $br;
			$html .= "	" . esc_html__("Color", "unlimited-elements-for-elementor") . "<br>" . $br;
			$html .= "<div class='unite-color-picker-wrapper'>" . $br;
			$html .= "	<input type=\"text\" data-fieldname='color' value=\"{$color}\" class=\"unite-color-picker {$classInput}\">	" . $br;
			$html .= "</div>" . $br;
			$html .= "</span>" . $br;

			/*
			$html .= "<span class=\"{$classSection} uc-details-mobile-size\">".$br;
			$html .= "	".esc_html__("Mobile Font Size", "unlimited-elements-for-elementor")."<br>".$br;
			$html .= "	".$selectMobileSize.$br;
			$html .= "</span>".$br;
			*/

			$html .= "<span class=\"{$classSection} uc-details-font-style\">" . $br;
			$html .= "	" . esc_html__("Font Style", "unlimited-elements-for-elementor") . "<br>" . $br;
			$html .= $selectFontStyle;
			$html .= "</span>" . $br;

			$html .= "<span class=\"{$classSection} uc-details-custom-styles\">" . $br;
			$html .= "	" . esc_html__("Custom Styles", "unlimited-elements-for-elementor") . "<br>" . $br;
			$html .= "	<input type=\"text\" data-fieldname='custom' value=\"{$customStyles}\" class=\"{$classInput}\">	" . $br;
			$html .= "</span>" . $br;

			$html .= "	</div>" . $br;
			$html .= "</div>" . $br;

			if($name != $lastName)
				$html .= "<div class='uc-fontspanel-sap'></div>";

			$html .= "<div class='unite-clear'></div>" . $br;

		endforeach;

		$html .= "</div>" . $br;

		$html .= "<div class='unite-clear'></div>" . $br;

		return ($html);
	}

	/**
	 * get param array
	 */
	private function getFontsParams_getArrParam($type, $fieldName, $name, $title, $value, $options = null, $addParams = null){

		$paramName = "ucfont_{$name}__" . $fieldName;

		$param = array();
		$param["name"] = $paramName;
		$param["type"] = $type;
		$param["title"] = $title;
		$param["value"] = $value;

		if(!empty($options)){
			$options = array_flip($options);
			$param["options"] = $options;
		}

		if(!empty($addParams))
			$param = array_merge($param, $addParams);

		return ($param);
	}

	/**
	 * get fonts params
	 */
	public function getFontsParams($arrFontNames, $arrFontsData, $addonType = null, $addonName = null){

		$isElementor = false;
		if($addonType == "elementor")
			$isElementor = true;

		$arrData = HelperUC::getFontPanelData();
		$valueNotChosen = "not_chosen";

		if($isElementor == true){
			$arrFontStyle = array();
			$arrFontWeight = array();
			$arrFontSize = array();
			$arrMobileSize = array();
			$arrLineHeight = array();
			$arrTextDecoration = array();
			$arrFontFamily = array();
			$arrTabletSize = array();
		}else{
			$arrFontStyle = $arrData["arrFontStyle"];
			$arrFontWeight = $arrData["arrFontWeight"];
			$arrFontSize = UniteFunctionsUC::arrayToAssoc($arrData["arrFontSize"]);
			$arrMobileSize = UniteFunctionsUC::arrayToAssoc($arrData["arrMobileSize"]);
			$arrLineHeight = UniteFunctionsUC::arrayToAssoc($arrData["arrLineHeight"]);
			$arrTextDecoration = $arrData["arrTextDecoration"];

			$arrFontFamily = UniteFunctionsUC::addArrFirstValue($arrData["arrFontFamily"], "[Select Font Family]", $valueNotChosen);
			$arrFontStyle = UniteFunctionsUC::addArrFirstValue($arrFontStyle, "[Select Style]", $valueNotChosen);
			$arrFontWeight = UniteFunctionsUC::addArrFirstValue($arrFontWeight, "[Select Font Weight]", $valueNotChosen);
			$arrFontSize = UniteFunctionsUC::addArrFirstValue($arrFontSize, "[Select Font Size]", $valueNotChosen);
			$arrMobileSize = UniteFunctionsUC::addArrFirstValue($arrMobileSize, "[Select Mobile Size]", $valueNotChosen);
			$arrTabletSize = UniteFunctionsUC::addArrFirstValue($arrMobileSize, "[Select Tablet Size]", $valueNotChosen);
			$arrLineHeight = UniteFunctionsUC::addArrFirstValue($arrLineHeight, "[Select Line Height]", $valueNotChosen);
			$arrTextDecoration = UniteFunctionsUC::addArrFirstValue($arrTextDecoration, "[Select Text Decoration]", $valueNotChosen);
		}

		$arrParams = array();

		foreach($arrFontNames as $name => $title){
			$fontData = UniteFunctionsUC::getVal($arrFontsData, $name);
			$isDataExists = !empty($fontData);

			$fontFamily = UniteFunctionsUC::getVal($fontData, "font-family", $valueNotChosen);
			$fontWeight = UniteFunctionsUC::getVal($fontData, "font-weight", $valueNotChosen);
			$fontSize = UniteFunctionsUC::getVal($fontData, "font-size", $valueNotChosen);
			$lineHeight = UniteFunctionsUC::getVal($fontData, "line-height", $valueNotChosen);
			$textDecoration = UniteFunctionsUC::getVal($fontData, "text-decoration", $valueNotChosen);
			$mobileSize = UniteFunctionsUC::getVal($fontData, "mobile-size", $valueNotChosen);
			$fontStyle = UniteFunctionsUC::getVal($fontData, "font-style", $valueNotChosen);
			$color = UniteFunctionsUC::getVal($fontData, "color");
			$customStyles = UniteFunctionsUC::getVal($fontData, "custom");

			$paramType = UniteCreatorDialogParam::PARAM_CHECKBOX;
			if($isElementor == true)
				$paramType = UniteCreatorDialogParam::PARAM_HIDDEN;

			$arrFields = array();

			if($isElementor == true){
				$styleSelector = "uc-style-{$addonName}-{$name}";

				$styleSelector = HelperUC::convertTitleToHandle($styleSelector);

				$arrFields[] = $this->getFontsParams_getArrParam(UniteCreatorDialogParam::PARAM_HIDDEN, "style-selector", $name, "Style Selector", $styleSelector);
			}

			$fieldEnable = $this->getFontsParams_getArrParam(UniteCreatorDialogParam::PARAM_CHECKBOX, "fonts-enabled", $name, __("Enable Styles", "unlimited-elements-for-elementor"), null, null, array("is_checked" => $isDataExists));

			$arrFields[] = $fieldEnable;

			//add typography field
			if($isElementor == true){
				$arrTypography = array();
				$arrTypography["selector1"] = "." . $styleSelector;

				$arrFields[] = $this->getFontsParams_getArrParam(UniteCreatorDialogParam::PARAM_TYPOGRAPHY, "typography", $name, "Typography", "", null, $arrTypography);
			}

			$nameEnabled = $fieldEnable["name"];

			$addParams = array();

			// 		conditions

			/*
				$condition = array();
				$condition[$nameEnabled] = "no";

				$addParams["elementor_condition"] = $condition;
			*/

			$arrFields[] = $this->getFontsParams_getArrParam($paramType, "font-family", $name, "Font Family", $fontFamily, $arrFontFamily);
			$arrFields[] = $this->getFontsParams_getArrParam(UniteCreatorDialogParam::PARAM_COLORPICKER, "color", $name, "Color", $color, null, $addParams);
			$arrFields[] = $this->getFontsParams_getArrParam($paramType, "font-style", $name, "Font Style", $fontStyle, $arrFontStyle);
			$arrFields[] = $this->getFontsParams_getArrParam($paramType, "font-weight", $name, "Font Weight", $fontWeight, $arrFontWeight);
			$arrFields[] = $this->getFontsParams_getArrParam($paramType, "font-size", $name, "Font Size", $fontSize, $arrFontSize);
			$arrFields[] = $this->getFontsParams_getArrParam($paramType, "mobile-size", $name, "Mobile Size", $mobileSize, $arrMobileSize);
			$arrFields[] = $this->getFontsParams_getArrParam($paramType, "font-size-tablet", $name, "Tablet Size", $mobileSize, $arrTabletSize);
			$arrFields[] = $this->getFontsParams_getArrParam($paramType, "line-height", $name, "Line Height", $lineHeight, $arrLineHeight);
			$arrFields[] = $this->getFontsParams_getArrParam($paramType, "text-decoration", $name, "Text Decoraiton", $textDecoration, $arrTextDecoration);
			$arrFields[] = $this->getFontsParams_getArrParam(UniteCreatorDialogParam::PARAM_TEXTAREA, "custom", $name, __("Custom Styles", "unlimited-elements-for-elementor"), $customStyles);

			$arrParams[$name] = $arrFields;
		}

		return ($arrParams);
	}

	/**
	 * draw fonts panel - function for override
	 */
	protected function drawFontsPanel($setting){

		$name = $setting["name"];
		$id = $setting["id"];

		$arrParamsNames = $setting["font_param_names"];
		$arrFontsData = $setting["value"];

		$html = "<div id='{$id}' class='uc-setting-fonts-panel' data-name='{$name}'>";

		if(empty($arrParamsNames)){
			$html .= "<div class='uc-fontspanel-message'>";
			$html .= "Font overrides are disabled for this addon. If you would like to enable them please contact our support at <a href='https://unitecms.ticksy.com' target='_blank'>unitecms.ticksy.com</a>";
			$html .= "</div>";
		}else{
			$html .= self::TAB3 . "<div class='uc-addon-config-fonts'>" . self::BR;
			$html .= "<h2>" . esc_html__("Edit Fonts", "unlimited-elements-for-elementor") . "</h2>";

			$isInsideGrid = UniteFunctionsUC::getVal($setting, "inside_grid");
			$addGridTemplate = UniteFunctionsUC::strToBool($isInsideGrid);

			$html .= $this->getFontsPanelHtmlFields($arrParamsNames, $arrFontsData, $addGridTemplate);

			$html .= self::TAB3 . "</div>";
		}

		$html .= "</div>";

		uelm_echo($html);
	}

	private function a_______DRAW_ITEMS_PANEL_______(){
	}

	/**
	 * draw fonts panel - function for override
	 */
	protected function drawItemsPanel($setting){

		$name = $setting["name"];
		$id = $setting["id"];
		$value = UniteFunctionsUC::getVal($setting, "value");
		$idDialog = $id . "_dialog";

		$objManager = $setting["items_manager"];

		$source = UniteFunctionsUC::getVal($setting, "source");

		if(!empty($source))
			$objManager->setSource($source);

		?>
		<div id="<?php echo esc_attr($id) ?>" class='uc-setting-items-panel' data-name='<?php echo esc_attr($name) ?>'>
			<?php

			if($this->isSidebar == true): ?>
			<a href="javascript:void(0)"
				class="unite-button-secondary uc-setting-items-panel-button"><?php esc_html_e("Edit Widget Items", "unlimited-elements-for-elementor") ?></a>

			<div id='<?php echo esc_attr($idDialog) ?>'
				class='uc-settings-items-panel-dialog'
				title="<?php esc_html_e("Edit Addon Items", "unlimited-elements-for-elementor") ?>"
				style='display:none'>
				<?php endif;

				$objManager->outputHtml();

				if($this->isSidebar == true): ?>
			</div>
		<?php endif;

		?>
		</div>
		<?php
	}

}
