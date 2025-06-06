<?php
/**
 * @package Unlimited Elements
 * @author unlimited-elements.com
 * @copyright (C) 2021 Unlimited Elements, All Rights Reserved. 
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
if ( ! defined( 'ABSPATH' ) ) exit;

class UniteCreatorAddonType_Shape_Divider extends UniteCreatorAddonType{
	
	
	/**
	 * init the addon type
	 */
	protected function initChild(){

		$this->typeName = GlobalsUC::ADDON_TYPE_SHAPE_DEVIDER;
		$this->textSingle = __("Divider", "unlimited-elements-for-elementor");
		$this->textPlural = __("Dividers", "unlimited-elements-for-elementor");
		$this->isSVG = true;
		$this->textShowType = $this->textSingle;
		$this->titlePrefix = $this->textSingle." - ";
		$this->isBasicType = false;
		$this->allowWebCatalog = true;
		$this->allowManagerWebCatalog = true;
		$this->catalogKey = $this->typeName;
		$this->browser_addEmptyItem = true;
	}
	
	
}
