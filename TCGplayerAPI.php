<?php
/*
#############################################################################################################################

	Title:		TCGpplayerAPI

	Dependencies:
  HTTP request package https://github.com/rmccue/Requests/blob/master/docs/README.md
  Dotenv Package

#############################################################################################################################
*/
	namespace PFF;
	use rmccue\requests;
	use Dotenv;

	class TCGplayerAPI {


		const API_BASE_URL_1_6 	= "https://api.tcgplayer.com/v1.6.0/";
		public $access_token, $userName, $store_token;


		# -------------------------------------------------------------------------------------------------
		#	Construct
		#		authorize the user, or creates the user
		# -------------------------------------------------------------------------------------------------

		public function __construct($store_token=false, $api_base_url="https://api.tcgplayer.com/v1.3.0/"){
			$this->store_token = $store_token;
			$this->API_BASE_URL = $api_base_url;
			$dotenv = Dotenv\Dotenv::create(__DIR__);
			$dotenv->load();
		}


		public function auth($access_token){

			$endpoint = $this->API_BASE_URL."token";

			if(!$access_token){
				$headers = array(
					'Accept' => 'application/json' ,
					'Content-Type' => 'application/x-www-form-urlencoded'
				);
			} else {
				$headers = array(
					'Accept' => 'application/json' ,
					'X-Tcg-Access-Token' => $access_token,
					'Content-Type' => 'application/x-www-form-urlencoded'
				);
			}

			$post_data = array(
				'grant_type' => 'client_credentials',
				'client_id' => $_ENV['TCG_CLIENT_ID'],
				'client_secret' => $_ENV['TCG_CLIENT_SECRET'],
			);

			$request = \Requests::post($endpoint, $headers, $post_data);

			if($request->status_code == 200){
				$return_request = json_decode($request->body);
				$this->access_token = $return_request->access_token;
				$this->store_token = $this->access_token;
				$this->userName 	= $return_request->userName;
				return array('access_token' => $this->access_token, 'user_name' => $this->userName);

			} else {

				throw new Exception('Error Retrieving Token from TCGplayer: '.$request->status_code);
			}


		}

		public function setAccessToken($token){
			$this->access_token = $token;
		}

		// This get the Game Types, their name, and IDs
		// catalog/categories

		public function getAllCategories(){
			$endpoint = $this->API_BASE_URL."catalog/categories";

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			$return_request = json_decode($request->body);
			print_r($return_request );


		}

		// this gets all the language of a game type, and hte IDs of a language
		// product/category/manifest/

		public function getSingleCategoryManifest($category_id=1){
			$endpoint = $this->API_BASE_URL."product/category/manifest/".$category_id;

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			$return_request = json_decode($request->body);

			return $return_request;


		}


		public function getGroups($offset=0,$limit=100){
			// function gets listing of groups
			$endpoint = SELF::API_BASE_URL_1_6."catalog/groups?limit={$limit}&offset={$offset}";

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			return json_decode($request->body);

		}

		public function getGroupSkuPrices($group_id){

			// function gets listing of groups
			// $endpoint = $this->API_BASE_URL."/product/group/marketprices/{$group_id}";
			$endpoint = $this->API_BASE_URL."/pricing/group/{$group_id}";

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			return json_decode($request->body);

		}

		public function getWholeSet($set_id=1){
			// get individual group info (cards)
			$endpoint = $this->API_BASE_URL."product/manifest/".$set_id;

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			return json_decode($request->body);

		}

		public function getSingleItem($set_id=1, $item_id=1){
			// get individual group info (cards)
			$endpoint = $this->API_BASE_URL."product/manifest/".$set_id."/".$item_id;

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			return json_decode($request->body);

		}

		public function getBuylistDataByExpansion($group_id=1){
			// get individual group info (cards)
			$endpoint = $this->API_BASE_URL."product/group/buylist/".$group_id;

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			$return_request = json_decode($request->body);

			return $return_request;


		}

		public function getGroupBuylistData($group_id=1){
			// get individual group info (cards)
			$endpoint = $this->API_BASE_URL."product/group/buylist/".$group_id;

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			$return_request = json_decode($request->body);

			return $return_request;


		}

		public function getMarketPriceDataByExpansion($group_id=1){
			// get individual group info (cards)
			$endpoint = $this->API_BASE_URL."product/group/marketprices/".$group_id;

			$headers = array(
				'Authorization' => 'bearer '.$this->access_token,
			);
			$options = array();

			$request = \Requests::get($endpoint, $headers, $options);

			$return_request = json_decode($request->body);

			return $return_request;

		}

		// gets back a key for the store you are authorizing to use your app
		// use that key to run the auth command, and store the result into your database
		// then there out make calls to the
		// user needs to navigate to https://store.tcgplayer.com/admin/Apps/3

		/**
		 * @param $hash
		 * @return mixed
		 */

		public function authStore($hash){

			// get individual group info (cards)

			$endpoint = $this->API_BASE_URL."app/authorize/".$hash;

			$headers = array();
			$data = array();

			$request = \Requests::post($endpoint, $headers, $data);

			$return_request = json_decode($request->body);

			return $return_request->Results[0]->AuthorizationKey;

		}

		private function getBaseHeaderArrayForStoreRequest(){
			return array(
				'Accept' => 'application/json' ,
				'Authorization' => 'bearer '.$this->store_token,
				'Content-Type' => 'application/x-www-form-urlencoded'
			);
		}

		public function getStoreInfo(){

			// get individual group info (cards)
			$endpoint = $this->API_BASE_URL."store/identity";

			$headers = $this->getBaseHeaderArrayForStoreRequest();
			$data = array();

			$request = \Requests::get($endpoint, $headers, $data);

			return json_decode($request->body);

		}

		/**
		 * @param int $groupId
		 * @return object
		 */

		public function getProductsByGroupId(int $groupId,int $offset, int $limit){

			$endpoint = $this->API_BASE_URL."catalog/products?limit={$limit}&offset={$offset}&getExtendedFields=true&groupId={$groupId}";

			$headers = $this->getBaseHeaderArrayForStoreRequest();

			$data = array(
				'offset' => (int) $offset,
				'limit' => (int) $limit
			);

			$request = \Requests::get($endpoint, $headers, $data);

			return json_decode($request->body);
		}

		/**
		 * @param int $offset
		 * @param int $limit
		 * @param bool|array $options (categoryName, groupName, productName, getExtendedFields)
		 * @return mixed
		 */

		public function getProducts($offset=0,$limit=100,$options=false){

			$endpoint = $this->API_BASE_URL."catalog/products?limit={$limit}&offset={$offset}&getExtendedFields=true";

			$headers = $this->getBaseHeaderArrayForStoreRequest();

			$data = array(
				'offset' => (int) $offset,
				'limit' => (int) $limit
			);

			// append options if exist
			if($options){
				$data = array_merge( $data, $options );
			}


			$request = \Requests::get($endpoint, $headers, $data);

			return json_decode($request->body);
		}


		public function getStoreCategories(){

			// get individual group info (cards)
			$endpoint = $this->API_BASE_URL."store/inventory/categories";

			$headers = $this->getBaseHeaderArrayForStoreRequest();
			$data = array();

			$request = \Requests::get($endpoint, $headers, $data);

			return json_decode($request->body);

		}


		/**
		 * Updates a Product Price Realtime
		 *
		 * @param $skuID
		 * @param $price
		 */
		public function updateSKUPrice( $skuID , $price ){
			//PUT /store/inventory/skus

			$endpoint = $this->API_BASE_URL."store/inventory/skus";
			$headers = $this->getBaseHeaderArrayForStoreRequest();
			$data = array(
				'SkuId' => (int) $skuID,
				'Price' => (float) $price
			);


			try{

				$request = \Requests::put($endpoint, $headers, $data);
				return json_decode($request->body);

			} catch (\Requests_Exception $e){
				//$this->emailAdmin( 'updateSKUPrice: '.$endpoint.' '.json_encode($e) . json_encode($headers) );
				return false;

			}

		}

		/**
		 * Returns a store inventory (list of product skus and quantities)
		 * @param int $categoryId
		 * @param int $offset
		 * @param int $limit
		 * @return mixed
		 */
		public function getStoreInventory( $categoryId=1, $offset=0, $limit=10 ){
			// /store/inventory/products?categoryId=1
			// get individual group info (cards)
			$endpoint = $this->API_BASE_URL."store/inventory/products?categoryId=" . ( (int) $categoryId)."&limit=" . ( (int) $limit)."&offset=" . ( (int) $offset);

			$headers = $this->getBaseHeaderArrayForStoreRequest();
			$data = array();

			try{

				$request = \Requests::get($endpoint, $headers, $data);
				return json_decode($request->body);

			} catch (\Requests_Exception $e){
				$this->emailAdmin( 'Inventory Sync: '.$endpoint.' '.json_encode($e) . json_encode($headers) );
				return false;

			}



		}

		/**
		 * @param STRING $error
		 */
		private function emailAdmin($error){

			//$email = new \PFF\Email($error,"Error with TCGplayer API: ".date('r'),$_ENV['SUPPORT_EMAIL']);

		}



 }
