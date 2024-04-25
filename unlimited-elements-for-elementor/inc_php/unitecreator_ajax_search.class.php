<?php 
/**
 * @package Unlimited Elements
 * @author unlimited-elements.com
 * @copyright (C) 2021 Unlimited Elements, All Rights Reserved.
 * @license GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 * */
defined('UNLIMITED_ELEMENTS_INC') or die('Restricted access');

class UniteCreatorAjaxSeach{
	
	public static $arrCurrentParams;
	public static $customSearchEnabled = false;
	
	private $searchMetaKey = "";
	
	
	/**
	 * on posts response
	 */
	public function onPostsResponse($arrPosts, $value, $filters){
		
		if(GlobalsProviderUC::$isUnderAjaxSearch == false)
			return($arrPosts);
		
		$name = UniteFunctionsUC::getVal($value, "uc_posts_name");
		
		$args = GlobalsProviderUC::$lastQueryArgs;
		
		$maxItems = UniteFunctionsUC::getVal($args, "posts_per_page", 9);
		
		$numPosts = count($arrPosts);
		
		//if maximum reached - return the original
		
		if($numPosts >= $maxItems)
			return($arrPosts);
		
		$search = $args["s"];
			
		unset($args["s"]);
		
		//search in meta
		
		if(!empty($this->searchMetaKey)){
			
			$arrMetaItem = array(
			        'key'     => $this->searchMetaKey,
			        'value'   => $search,
			        'compare' => "LIKE"
			);
			
			$arrMetaQuery = array("relation"=>"OR",$arrMetaItem);
			
			$arrExistingMeta = UniteFunctionsUC::getVal($args, "meta_query",array());
						
			$args["meta_query"] = array_merge($arrExistingMeta, $arrMetaQuery);
		}
				
		$query = new WP_Query();
		$query->query($args);
		
		$arrNewPosts = $query->posts;
		
		
		$arrPosts = array_merge($arrPosts, $arrNewPosts);
				
		return($arrPosts);
	}
	
	/**
	 * supress third party filters except of this class ones
	 */
	public static function supressThirdPartyFilters(){
			
		global $wp_filter;
		
		if(self::$customSearchEnabled == false){
			
			$wp_filter = array();
			return(false);
		}

		$arrKeys = array("uc_filter_posts_list");
		
		$newFilters = array();
		
		foreach($arrKeys as $key){
			
			$filter = UniteFunctionsUC::getVal($wp_filter, $key);
			
			if(!empty($filter))
				$newFilters[$key] = $filter;
		}
		
		$wp_filter = $newFilters;
		
	}
	
	
	/**
	 * init the ajax search - before the get posts accure, from ajax request
	 */
	public function initCustomAjaxSeach(UniteCreatorAddon $addon){
		
		$arrParams = $addon->getProcessedMainParamsValues(UniteCreatorParamsProcessor::PROCESS_TYPE_CONFIG);
		
		self::$arrCurrentParams = $arrParams;
		
		$searchInMeta = UniteFunctionsUC::getVal($arrParams, "search_in_meta");
		$searchInMeta = UniteFunctionsUC::strToBool($searchInMeta);
		
		if($searchInMeta == true){

			self::$customSearchEnabled = true;
			
			$this->searchMetaKey = "country";
			
			UniteProviderFunctionsUC::addFilter("uc_filter_posts_list", array($this,"onPostsResponse"),10,3);
				
		}
		
	}

}