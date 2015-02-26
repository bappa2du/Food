<?php
App::uses ( 'AppController', 'Controller' );

/**
 * Restaurants Controller
 *
 * @property Restaurant $Restaurant
 * @property PaginatorComponent $Paginator
 */
class RestaurantsController extends AppController {
	public $name = 'Restaurants';
	public $paginate = array (
			'order' => array (
					'Restaurant.modified' => 'desc' 
			) 
	);
	
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array (
			'Paginator' 
	);
	
	/*
	 * search page
	 */
	public function adminSearch() {
		$this->loadModel ( 'Cusine' );
		$restaurant_postal = 'M27 4A';
		$restaurant_name = 'Taste Of India';
		
		$conditions = array (
				'Restaurant.name' => $restaurant_name,
				'Restaurant.postal' => $restaurant_postal 
		);
		
		$options = array (
				'conditions' => $conditions 
		);
		$restaurant = $this->Restaurant->find ( 'all', $options );
	}
	
	/**
	 * index method
	 *
	 * @return void
	 */
	public function adminIndex() {
		$this->Restaurant->recursive = 0;
		$this->Paginator->settings ['limit'] = 1000000;
		$user = $this->UserAuth->getUser ();
		if ($user ['User'] ['user_group_id'] == 1) {
			$this->set ( 'restaurants', $this->Paginator->paginate () );
		} else {
			$conditions = array (
					'Restaurant.created_by' => $user ['User'] ['email'] 
			);
			$this->set ( 'restaurants', $this->Paginator->paginate ( $conditions ) );
		}
	}
	
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function view($id = null) {
		if (! $this->Restaurant->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid restaurant' ) );
		}
		$options = array (
				'conditions' => array (
						'Restaurant.' . $this->Restaurant->primaryKey => $id 
				) 
		);
		$this->Restaurant->unbindModel ( array (
				'hasMany' => array (
						'Food' 
				) 
		) );
		$restaurant = $this->Restaurant->find ( 'first', $options );
		
		$this->set ( 'restaurant', $restaurant );
		$this->loadModel ( 'Food' );
		$query = "select menu.name as menu_name, menu.id as menu_id,'' as adf_id, f.id, f.name, f.description, f.price, '1' as type, '' as variation_name, f.restaurant_id, f.menu_id from foods as f
					join menus as menu on menu.id = f.menu_id
					where f.restaurant_id = '$id' and f.id not in (select af.food_id from additionals as af where af.restaurant_id='$id')
					union
					select menu.name as menu_name, menu.id as menu_id, adf.id as adf_id, foods.id, foods.name, foods.description, adf.price, '2' as type, adf.name, foods.restaurant_id, foods.menu_id as variation_name from additionals as adf
					join foods on adf.food_id = foods.id
					join menus as menu on menu.id = adf.menu_id
					where adf.restaurant_id = '$id' order by menu_name";
		$foods = $this->Food->query ( $query );
		$this->set ( 'foods', $foods );
		
		$this->loadModel ( 'Menu' );
		$this->set ( 'menus', $this->Menu->find ( 'list', array (
				'conditions' => array (
						'restaurant_id' => $id 
				),
				'order' => array (
						'name' 
				) 
		) ) );
	}
	
	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		if ($this->request->is ( 'post' )) {
			/*
			 * |-------------------------------------------------------------------------- | For Restaurant |--------------------------------------------------------------------------
			 */
			$this->Restaurant->create ();
			if ($this->Restaurant->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The restaurant has been saved.' ) );
			} else {
				$this->Session->setFlash ( __ ( 'The restaurant could not be saved. Please, try again.' ) );
			}
			
			/*
			 * |-------------------------------------------------------------------------- | For Restaurant opening hour |--------------------------------------------------------------------------
			 */
			
			$shopOperation = array ();
			$final = array ();
			$i = 0;
			$j = 0;
			foreach ( $this->request->data ['store_operation_day'] as $key => $day ) {
				$day ['operation_day'] = $key;
				$day ['restaurant_id'] = $this->Restaurant->getLastInsertId ();
				if ($day ['operation_type'] == 'close') {
					$day ['open_hour'] = '';
					$day ['close_hour'] = '';
					$day ['delivery_hour'] = '';
				}
				
				$shopOperation [$i] = $day;
				$i ++;
			}
			$this->loadModel ( 'RestaurentOpeningHours' );
			$this->RestaurentOpeningHours->create ();
			foreach ( $shopOperation as $data ) {
				$final [$j] = $data;
				$j ++;
			}
			$this->RestaurentOpeningHours->saveAll ( $final );
			return $this->redirect ( array (
					'action' => 'add' 
			) );
		}
		$countries = $this->Restaurant->Country->find ( 'list' );
		$cities = $this->Restaurant->City->find ( 'list' );
		$cusines = $this->Restaurant->Cusine->find ( 'list', array (
				'order' => array (
						'name' 
				) 
		) );
		$this->set ( compact ( 'countries', 'cities', 'cusines' ) );
	}
	
	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function edit($id = null) {
		$this->loadModel ( 'RestaurentOpeningHours' );
		$query = "SELECT operation_day,operation_type,open_hour,close_hour FROM restaurent_opening_hours WHERE restaurant_id='$id'";
		$restaurentOpeningHours = $this->RestaurentOpeningHours->query ( $query );
		$this->set ( compact ( 'restaurentOpeningHours' ) );
		
		$shopOperation = array ();
		$final = array ();
		$i = 0;
		$j = 0;
		
		if (! $this->Restaurant->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid restaurant' ) );
		}
		if ($this->request->is ( array (
				'post',
				'put' 
		) )) {
			if ($this->Restaurant->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The restaurant has been saved.' ) );
				$query = "DELETE FROM restaurent_opening_hours WHERE restaurant_id = '$id'";
				$this->RestaurentOpeningHours->query ( $query );
				
				foreach ( $this->request->data ['store_operation_day'] as $key => $day ) {
					$day ['operation_day'] = $key;
					$day ['restaurant_id'] = $id;
					if ($day ['operation_type'] == 'close') {
						$day ['open_hour'] = '';
						$day ['close_hour'] = '';
						$day ['delivery_hour'] = '';
					} else {
						/*
						 * $st_time = strtotime ( $day ['open_hour'] ); $end_time = strtotime ( $day ['close_hour'] ); $delivery_time = strtotime ( $day ['delivery_hour'] ); if ($end_time <= $st_time) { $msg = "Invalid store operation day for " . $day ['operation_day']; $this->Session->setFlash ( __ ( $msg ) ); $countries = $this->Restaurant->Country->find ( 'list' ); $cities = $this->Restaurant->City->find ( 'list' ); $cusines = $this->Restaurant->Cusine->find ( 'list', array ( 'order' => array ( 'name' ) ) ); $this->set ( compact ( 'countries', 'cities', 'cusines' ) ); return; } if ($delivery_time > $end_time || $delivery_time < $st_time) { $msg_delivery = "Invalid delivery time for " . $day ['operation_day']; $this->Session->setFlash ( __ ( $msg_delivery ) ); $countries = $this->Restaurant->Country->find ( 'list' ); $cities = $this->Restaurant->City->find ( 'list' ); $cusines = $this->Restaurant->Cusine->find ( 'list', array ( 'order' => array ( 'name' ) ) ); $this->set ( compact ( 'countries', 'cities', 'cusines' ) ); return; }
						 */
					}
					$shopOperation [$i] = $day;
					$i ++;
				}
				
				$this->RestaurentOpeningHours->create ();
				foreach ( $shopOperation as $data ) {
					$final [$j] = $data;
					$j ++;
				}
				$this->RestaurentOpeningHours->saveAll ( $final );
				return $this->redirect ( array (
						'action' => 'adminIndex' 
				) );
			} else {
				$this->Session->setFlash ( __ ( 'The restaurant could not be saved. Please, try again.' ) );
			}
		} else {
			$options = array (
					'conditions' => array (
							'Restaurant.' . $this->Restaurant->primaryKey => $id 
					) 
			);
			$this->request->data = $this->Restaurant->find ( 'first', $options );
		}
		$countries = $this->Restaurant->Country->find ( 'list' );
		$cities = $this->Restaurant->City->find ( 'list' );
		$cusines = $this->Restaurant->Cusine->find ( 'list', array (
				'order' => array (
						'name' 
				) 
		) );
		$this->set ( compact ( 'countries', 'cities', 'cusines' ) );
	}
	
	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function delete($id = null) {
		$this->Restaurant->id = $id;
		if (! $this->Restaurant->exists ()) {
			throw new NotFoundException ( __ ( 'Invalid restaurant' ) );
		}
		// $this->request->allowMethod('post', 'delete');
		
		if ($this->request->isPost ()) {
			
			if ($this->Restaurant->delete ()) {
				$this->Session->setFlash ( __ ( 'The restaurant has been deleted.' ) );
			} else {
				$this->Session->setFlash ( __ ( 'The restaurant could not be deleted. Please, try again.' ) );
			}
		}
		
		return $this->redirect ( array (
				'action' => 'adminIndex' 
		) );
	}
	
	/*
	 * |-------------------------------------------------------------------------- | Take away by City |--------------------------------------------------------------------------
	 */
	public function takeawaysCity() {
		$cusines = array ();
		
		$restaurants = array ();
		
		$cityText = "";
		
		$cusineId = 0;
		
		$cusine_name = "";
		
		if (isset ( $this->request->query ['city'] )) {
			$cityText = $this->request->query ['city'];
		} else {
			$this->redirect ( '/' );
		}
		
		if ($this->request->is ( 'post' )) {
			
			$cusineId = $this->request->data ['Search'] ['cuisine'];
		}
		
		$this->loadModel ( 'City' );
		
		$this->loadModel ( 'CusineRestaurant' );
		
		$this->loadModel ( 'Cusine' );
		
		$city = $this->City->find ( 'first', array (
				'conditions' => array (
						'City.name' => $cityText 
				),
				'recursive' => - 1 
		) );
		
		$r_restaurants = $this->Restaurant->find ( 'all', array (
				'conditions' => array (
						'city_id' => $city ['City'] ['id'] 
				),
				'recursive' => - 1 
		) );
		
		$c_array = array ();
		
		$cuisines = $c_array;
		
		foreach ( $r_restaurants as $cr ) {
			$cusineTakeaways = $this->CusineRestaurant->find ( 'all', array (
					'field' => array (
							'cusine_id' 
					),
					'conditions' => array (
							'restaurant_id' => $cr ['Restaurant'] ['id'] 
					),
					'recursive' => - 1 
			) );
			
			$r_cusines = "";
			
			$is_cusine_takeaway = false;
			
			foreach ( $cusineTakeaways as $ct ) {
				$id = $ct ['CusineRestaurant'] ['cusine_id'];
				
				if (! array_key_exists ( $id, $c_array )) {
					$cusine = $this->Cusine->read ( null, $id );
					
					$r_cusines .= $cusine ['Cusine'] ['name'] . ",";
					
					$c_array [$id] = $cusine ['Cusine'] ['name'];
				} else {
					$r_cusines .= $c_array [$id] . ",";
				}
				
				if ($id == $cusineId) {
					$is_cusine_takeaway = true;
					
					$cusine_name = $c_array [$id];
				}
			}
			
			if ($is_cusine_takeaway) {
				$cr ['Restaurant'] ['cusines'] = rtrim ( $r_cusines, ',' );
				
				$restaurants [] = $cr;
			} else {
				if ($cusineId == 0) {
					$cr ['Restaurant'] ['cusines'] = rtrim ( $r_cusines, ',' );
					
					$restaurants [] = $cr;
				}
			}
		}
		$cusines = $c_array;
		
		$this->set ( compact ( 'restaurants', 'cusines' ) );
		
		$this->set ( 'search_cusine', $cusineId );
		$this->set ( 'search_city', $cityText );
		$this->set ( 'search_cusine_name', $cusine_name );
	}
	
	/*
	 * |-------------------------------------------------------------------------- | Take away by Cuisine |--------------------------------------------------------------------------
	 */
	public function takeawaysCuisine() {
		$cities = array ();
		
		$restaurants = array ();
		
		$cityId = 0;
		
		$cuisine = "";
		
		$city_name = "";
		
		if (isset ( $this->request->query ['cuisines'] )) {
			$cuisine = $this->request->query ['cuisines'];
		} else {
			$this->redirect ( '/' );
		}
		
		if ($this->request->is ( 'post' )) {
			
			$cityId = $this->request->data ['Search'] ['city'];
		}
		
		$this->loadModel ( 'CusineRestaurant' );
		
		$this->loadModel ( 'Cusine' );
		
		$this->loadModel ( 'City' );
		
		$cusines = $this->Cusine->find ( 'first', array (
				'conditions' => array (
						'name' => $cuisine 
				),
				'recursive' => - 1 
		) );
		
		$restaurant_ids = $this->CusineRestaurant->find ( 'all', array (
				'field' => array (
						'restaurant_id' 
				),
				'conditions' => array (
						'cusine_id' => $cusines ['Cusine'] ['id'] 
				),
				'recursive' => - 1 
		) );
		
		$list_of_search_restaurants = array ();
		
		foreach ( $restaurant_ids as $restaurant ) {
			$list_of_search_restaurants [] = $restaurant ['CusineRestaurant'] ['restaurant_id'];
		}
		
		$restaurants_city = $this->Restaurant->find ( 'all', array (
				'fields' => array (
						'city_id' 
				),
				'conditions' => array (
						'id' => $list_of_search_restaurants 
				),
				'group' => array (
						'city_id' 
				),
				'recursive' => - 1 
		) );
		
		/* First City make selected if city is not found */
		
		if (isset ( $this->request->query ['cuisines'] ) && ! $this->request->is ( 'post' )) {
			$cityId = $restaurants_city ['0'] ['Restaurant'] ['city_id'];
		}
		
		foreach ( $restaurants_city as $city_res ) {
			$city = $this->City->find ( 'first', array (
					'conditions' => array (
							'id' => $city_res ['Restaurant'] ['city_id'] 
					),
					'recursive' => - 1 
			) );
			
			$key = $city ['City'] ['id'];
			
			$cities [$key] = $city ['City'] ['name'];
			
			if ($key == $cityId) {
				$city_name = $city ['City'] ['name'];
			}
		}
		
		$restaurants_full = $this->Restaurant->find ( 'all', array (
				'conditions' => array (
						'city_id' => $cityId,
						'Restaurant.id' => $list_of_search_restaurants 
				) 
		) );
		
		foreach ( $restaurants_full as $cr ) {
			$cusineTakeaways = $this->CusineRestaurant->find ( 'all', array (
					'field' => array (
							'cusine_id' 
					),
					'conditions' => array (
							'restaurant_id' => $cr ['Restaurant'] ['id'] 
					),
					'recursive' => - 1 
			) );
			
			$r_cusines = "";
			
			foreach ( $cusineTakeaways as $ct ) {
				$id = $ct ['CusineRestaurant'] ['cusine_id'];
				
				$cusine = $this->Cusine->read ( null, $id );
				
				$r_cusines .= $cusine ['Cusine'] ['name'] . ",";
			}
			
			$cr ['Restaurant'] ['cusines'] = rtrim ( $r_cusines, ',' );
			
			$restaurants [] = $cr;
		}
		
		$this->set ( compact ( 'cities', 'restaurants' ) );
		$this->set ( 'search_cusine', $cuisine );
		$this->set ( 'search_city', $cityId );
		
		$this->set ( 'search_city_name', $city_name );
	}
	
	/*
	 * |-------------------------------------------------------------------------- | Search Page |--------------------------------------------------------------------------
	 */
	public function search() {
		$url ['action'] = 'index';
		
		if (isset ( $this->request->query ['lattitude'] )) {
			
			$this->redirect ( array (
					"controller" => "restaurants",
					"action" => "index",
					"?" => array (
							"lattitude" => $this->request->query ['lattitude'],
							"longitude" => $this->request->query ['longitude'] 
					) 
			), null, true );
		}
		foreach ( $this->data as $k => $v ) {
			foreach ( $v as $kk => $vv ) {
				if (! empty ( $vv )) {
					$url [$k . '_' . $kk] = $vv;
				}
			}
		}
		
		$this->redirect ( $url, null, true );
	}
	
	/*
	 * |-------------------------------------------------------------------------- | Default Index Page for Restaurants |--------------------------------------------------------------------------
	 */
	public function index() 
	{
		$restaurants = array ();
		
		$cusines = array ();
		
		if (isset ( $this->passedArgs ['Search_cuisines'] ) && $this->passedArgs ['Search_cuisines'] != NULL) 
		{
			$lat = $this->Session->read ( 'lat' );
			
			$lng = $this->Session->read ( 'lng' );
			
			$this->loadModel ( 'Postcode' );
			
			$postcode = array ();
			
			if (! empty ( $lat ) && ! empty ( $lng )) {
				$postcode = $this->Postcode->find ( 'first', array (
						'conditions' => array (
								'lattitude' => $lat,
								'longitude' => $lng 
						) 
				) );
				
				if (empty ( $postcode )) {
					$postcode = $this->Postcode->find ( 'first', array (
							'conditions' => array (
									'postcode' => "HD6 1EA" 
							) 
					) );
				}
			} else {
				$postcode = $this->Postcode->find ( 'first', array (
						'conditions' => array (
								'postcode' => "HD6 1EA" 
						) 
				) );
			}
			
			$this->set('postcode', $postcode['Postcode']['postcode']);
			
			$cusineID = $this->passedArgs ['Search_cuisines'];
			
			$this->set('search_cusine_id', $cusineID);
			
			$this->loadModel('Cusine');
			
			$cusine = $this->Cusine->read(null, $this->passedArgs ['Search_cuisines']);
			
			$this->set('search_cusine', $cusine['Cusine']['name']);
			
			$restaurants_data = $this->prepareRestaurantData($postcode, $cusineID);
			
			$restaurants = $restaurants_data['restaurants'];
			
			$cusines = $restaurants_data['cusines'];

		}
		
		else if (isset ( $this->passedArgs ['Search_postcode'] ))
		{
			$this->loadModel ( 'Postcode' );
			
			$this->loadModel ( 'Restaurants' );
			
			$postcode = $this->passedArgs ['Search_postcode'];
			
			$postcode = $this->prepareValidPostCode ( $postcode );
			
			if (empty ( $postcode )) 
			{
				$this->redirect ( '/' );
			}
			
			$this->set('postcode', $postcode['Postcode']['postcode']);
				
			$restaurants_data = $this->prepareRestaurantData($postcode, "");
				
			$restaurants = $restaurants_data['restaurants'];
				
			$cusines = $restaurants_data['cusines'];
		}

        else if($this->request->is('post') && $this->request->data['Search']['postcode'])
        {
            $this->loadModel ( 'Postcode' );

            $this->loadModel ( 'Restaurants' );

            $search_postcode = $this->request->data['Search']['postcode'];

            $postcode = $this->Postcode->find ( 'first', array (
                'conditions' => array (
                    'postcode' => $search_postcode
                )
            ) );

            $this->set('postcode', $postcode['Postcode']['postcode']);

            $restaurants_data = $this->prepareRestaurantData($postcode, "");

            $restaurants = $restaurants_data['restaurants'];

            $cusines = $restaurants_data['cusines'];

        }
		
		else if($this->request->is('post') && $this->request->data['Search']['cusine'])
		{
			$search_cusine = $this->request->data['Search']['cusine'];
			
			$search_postcode = $this->request->data['Search']['postcode'];
			
			if(empty($search_cusine) && empty($search_postcode))
			{
				die();
			}
			
			$this->loadModel('Postcode');
			
			$postcode = $this->Postcode->find ( 'first', array (
					'conditions' => array (
							'postcode' => $search_postcode
					)
			) );
			
			$this->set('postcode', $postcode['Postcode']['postcode']);
			
			$this->loadModel('Cusine');
			
			$cusine = $this->Cusine->read(null, $search_cusine);
				
			$this->set('search_cusine_id', $search_cusine);
				
			$this->set('search_cusine', $cusine['Cusine']['name']);
			
			$restaurants_data = $this->prepareRestaurantData($postcode, $search_cusine);
			
			$restaurants = $restaurants_data['restaurants'];
			
			$cusines = $restaurants_data['cusines'];
		}
		else
		{
			$this->redirect('/');
		}
		
		
		$this->set ( compact ( 'restaurants', 'cusines' ) );
	}
	
	/* Postcode object */
	function prepareRestaurantData($postcode, $cusineId = "") 
	{
		$this->loadModel ( 'SearchingDistance' );
		
		$distance = $this->SearchingDistance->find ( 'first' );
		
		$distance = $distance ['SearchingDistance'] ['value'];
		
		$restaurants_all = $this->getRestaurantDataByWithinRange ( $postcode, $distance );
		
		$cusines = $restaurants_all ['TakeawaysCusine'];
		
		$data_array = array();
		
		$data_array['cusines'] = $cusines;
		
		$search_cusine = "";
		
		if (isset ( $restaurants_all ['TakeawaysCusine'] )) 
		{
			unset ( $restaurants_all ['TakeawaysCusine'] );
		}
		
		$this->Session->write ( 'postcode', $postcode );
		
		$restaurants = array();
		
		if (! empty ( $cusineId )) 
		{
			foreach ( $restaurants_all as $ra ) {
				$cusineTakeaways = $this->CusineRestaurant->find ( 'all', array (
						'field' => array (
								'cusine_id' 
						),
						'conditions' => array (
								'restaurant_id' => $ra ['Restaurant'] ['id'] 
						),
						'recursive' => - 1 
				) );
				
				foreach ( $cusineTakeaways as $ct ) {
					$id = $ct ['CusineRestaurant'] ['cusine_id'];
					
					if ($id == $cusineId) {
						$cusine = $this->Cusine->read ( null, $id );
						
						$search_cusine = $cusine ['Cusine'] ['name'];
						
						$restaurants [] = $ra;
						
						break;
					}
				}
			}
		} else {
			$restaurants = $restaurants_all;
		}
		
		$data_array['restaurants'] = $restaurants;

		return $data_array;
	}
	
	public function nearByTakeaways() {
		$lat = $this->Session->read ( 'lat' );
		
		$lng = $this->Session->read ( 'lng' );
		
		$this->loadModel ( 'Postcode' );
		
		$postcode = array ();
		
		if (! empty ( $lat ) && ! empty ( $lng )) {
			$postcode = $this->Postcode->find ( 'first', array (
					'conditions' => array (
							'lattitude' => $lat,
							'longitude' => $lng 
					) 
			) );
			
			if (empty ( $postcode )) {
				$postcode = $this->Postcode->find ( 'first', array (
						'conditions' => array (
								'postcode' => "HD6 1EA" 
						) 
				) );
			}
		} else {
			$postcode = $this->Postcode->find ( 'first', array (
					'conditions' => array (
							'postcode' => "HD6 1EA" 
					) 
			) );
		}
		
		$this->set ( 'postcode', $postcode ['Postcode'] ['postcode'] );
		
		$this->loadModel ( 'SearchingDistance' );
		
		$distance = $this->SearchingDistance->find ( 'first' );
		
		$distance = $distance ['SearchingDistance'] ['value'];
		
		$restaurants_all = $this->getRestaurantDataByWithinRange ( $postcode, $distance );
		
		$cusines = $restaurants_all ['TakeawaysCusine'];
		
		$cusineId = 0;
		
		$restaurants = array ();
		
		$search_cusine = "";
		
		if (isset ( $restaurants_all ['TakeawaysCusine'] )) {
			unset ( $restaurants_all ['TakeawaysCusine'] );
		}
		
		if ($this->request->is ( 'post' )) {
			$cusineId = $this->request->data ['Search'] ['cusine'];
			
			if (! empty ( $cusineId )) {
				$this->set ( 'search_cusine_id', $cusineId );
				
				foreach ( $restaurants_all as $ra ) {
					$cusineTakeaways = $this->CusineRestaurant->find ( 'all', array (
							'field' => array (
									'cusine_id' 
							),
							'conditions' => array (
									'restaurant_id' => $ra ['Restaurant'] ['id'] 
							),
							'recursive' => - 1 
					) );
					
					foreach ( $cusineTakeaways as $ct ) {
						$id = $ct ['CusineRestaurant'] ['cusine_id'];
						
						if ($id == $cusineId) {
							$cusine = $this->Cusine->read ( null, $id );
							
							$search_cusine = $cusine ['Cusine'] ['name'];
							
							$restaurants [] = $ra;
							
							break;
						}
					}
				}
			} else {
				$restaurants = $restaurants_all;
			}
		} else {
			$restaurants = $restaurants_all;
		}
		
		$this->set ( compact ( 'restaurants', 'cusines' ) );
		
		$this->set ( 'search_cusine', $search_cusine );
	}
	public function index_old() {
		/*
		 * |-------------------------------------------------------------------------- | Get distance from database |--------------------------------------------------------------------------
		 */
		$this->loadModel ( 'SearchingDistance' );
		$distance = $this->SearchingDistance->find ( 'first' );
		$distance = $distance ['SearchingDistance'] ['value'];
		
		$title = array ();
		$this->Paginator->settings ['limit'] = 10000;
		$restaurants = $this->Paginator->paginate ( 'Restaurant' );
		
		/*
		 * |-------------------------------------------------------------------------- | Search Restaurant form current user position |--------------------------------------------------------------------------
		 */
		
		if (isset ( $this->request->query ['lattitude'] )) {
			
			$current_position ['Postcode'] ['lattitude'] = $this->request->query ['lattitude'];
			$current_position ['Postcode'] ['longitude'] = $this->request->query ['longitude'];
			
			if (! empty ( $current_position )) {
				$restaurants = $this->getRestaurantDataByWithinRange ( $current_position, $distance );
			} else {
				$this->Session->setFlash ( "There is some error, Please try again." );
				$this->layout = 'error404_1';
			}
		}
		
		/*
		 * |-------------------------------------------------------------------------- | filter by name |--------------------------------------------------------------------------
		 */
		
		if (isset ( $this->passedArgs ['Search_name'] )) {
			$this->Paginator->settings ['conditions'] [] ['Restaurant.name LIKE'] = '%' . $this->passedArgs ['Search.name'] . '%';
			$this->request->data ['Search'] ['name'] = $this->passedArgs ['Search.name'];
			$title [] = __ ( 'Name', true ) . ': ' . $this->passedArgs ['Search.name'];
			$restaurants = $this->Paginator->paginate ( 'Restaurant' );
		}
		
		/*
		 * |-------------------------------------------------------------------------- | filter by postcode |--------------------------------------------------------------------------
		 */
		
		if (isset ( $this->passedArgs ['Search_postcode'] )) {
			
			// $this->Paginator->settings['conditions'][]['Restaurant.postal LIKE'] = '%' . $this->passedArgs['Search.postcode'] . '%';
			$this->loadModel ( 'Postcode' );
			$this->loadModel ( 'Restaurants' );
			
			$postcode = $this->passedArgs ['Search_postcode'];
			$postcode = str_replace ( ' ', '', $postcode );
			
			$this->Session->write ( 'postcode', $postcode );
			
			$postcode = $this->Postcode->find ( 'first', array (
					'conditions' => array (
							'postcode' => $this->passedArgs ['Search_postcode'] 
					) 
			) );
			
			if (! empty ( $postcode )) {
				
				$this->request->data ['Search'] ['postcode'] = $this->passedArgs ['Search_postcode'];
				$title [] = __ ( 'Postcode', true ) . ': ' . $this->passedArgs ['Search_postcode'];
				
				$restaurants = $this->getRestaurantDataByWithinRange ( $postcode, $distance );
			} else {
				return $this->redirect ( array (
						'action' => 'index' 
				) );
			}
		}
		
		/*
		 * |-------------------------------------------------------------------------- | read Session Data |--------------------------------------------------------------------------
		 */
		
		$postal = $this->Session->read ( 'postcode' );
		
		/*
		 * |-------------------------------------------------------------------------- | search by cusine |--------------------------------------------------------------------------
		 */
		if (isset ( $this->passedArgs ['Search_cuisines'] ) && $this->passedArgs ['Search_cuisines'] != NULL) {
			$this->loadModel ( 'CusineRestaurant' );
			
			$cuisine = $this->passedArgs ['Search_cuisines'];
			
			$restaurant_ids = $this->CusineRestaurant->find ( 'all', array (
					'fields' => array (
							'restaurant_id' 
					),
					'conditions' => array (
							'cusine_id' => $cuisine 
					),
					'recursive' => - 1 
			) );
			
			$list_of_search_restaurants = array ();
			
			foreach ( $restaurant_ids as $restaurant ) {
				$list_of_search_restaurants [] = $restaurant ['CusineRestaurant'] ['restaurant_id'];
			}
			
			$restaurants = $this->Restaurant->find ( 'all', array (
					'conditions' => array (
							'id' => $list_of_search_restaurants 
					),
					'recursive' => - 1 
			) );
			// $this->Paginator->settings['conditions'][]['Restaurant.id'] = $list_of_search_restaurants;
			
			// $restaurants = $this->Paginator->paginate('Restaurant');
		}
		/*
		 * |-------------------------------------------------------------------------- | For All Restaurant Near to current Position |--------------------------------------------------------------------------
		 */
		if (empty ( $this->passedArgs )) {
			$this->loadModel ( 'Restaurant' );
			$this->loadModel ( 'Postcode' );
			$query = "SELECT * FROM postcodes WHERE replace(postcodes.postcode,' ','') = '$postal'";
			$postcode = $this->Postcode->query ( $query );
			if (empty ( $postcode )) {
				$postcode ['Postcode'] ['lattitude'] = $this->Session->read ( 'lat' );
				$postcode ['Postcode'] ['longitude'] = $this->Session->read ( 'lng' );
			} else {
				$postcode ['Postcode'] = $postcode [0] ['postcodes'];
			}
			
			$restaurants = $this->getRestaurantDataByWithinRange ( $postcode, $distance );
		}
		/*
		 * |-------------------------------------------------------------------------- | Search Restaurant By City |--------------------------------------------------------------------------
		 */
		
		if (isset ( $this->request->query ['city'] )) {
			$city = $this->request->query ['city'];
			
			$query = "SELECT * FROM restaurants Restaurant
						JOIN cities City 
						ON Restaurant.city_id = City.id 
						WHERE City.name = '$city'";
			$this->loadModel ( 'City' );
			$results = $this->City->query ( $query );
			$r_array = array ();
			foreach ( $results as $r ) {
				$res_id = $r ['Restaurant'] ['id'];
				$restaurant = $this->Restaurant->read ( null, $res_id );
				$r_array [] = $restaurant;
			}
			$restaurants = $r_array;
		}
		
		/*
		 * |-------------------------------------------------------------------------- | Search Restaurant By Cuisine Name |--------------------------------------------------------------------------
		 */
		if (isset ( $this->request->query ['cuisines'] )) {
			$cuisines = $this->request->query ['cuisines'];
			$query = "SELECT * FROM restaurants Restaurant
						JOIN cusines_restaurants
						ON Restaurant.id = cusines_restaurants.restaurant_id
						JOIN cusines
						ON cusines.id = cusines_restaurants.cusine_id
						WHERE cusines.name = '$cuisines'";
			$this->loadModel ( 'City' );
			$results = $this->City->query ( $query );
			$r_array = array ();
			foreach ( $results as $r ) {
				$res_id = $r ['Restaurant'] ['id'];
				$restaurant = $this->Restaurant->read ( null, $res_id );
				$r_array [] = $restaurant;
			}
			$restaurants = $r_array;
		}
		
		$this->loadModel ( 'Cusines' );
		$cuisines = $this->Cusines->find ( 'list', array (
				'order' => 'name ASC' 
		) );
		
		$this->set ( compact ( 'restaurants', 'cuisines' ) );
	}
	
	/*
	 * |-------------------------------------------------------------------------- | Overridden paginate method - group by week, away_team_id and home_team_id |--------------------------------------------------------------------------
	 */
	public function getRestaurantDataByWithinRange($postcode, $distance) {
		$recursive = - 1;
		$lat = $postcode ['Postcode'] ['lattitude'];
		$lng = $postcode ['Postcode'] ['longitude'];
		
		$this->loadModel ( 'CusineRestaurant' );
		
		$this->loadModel ( 'Cusine' );
		
		$query = "SELECT Restaurant.id , 3956 *2 * ASIN( SQRT( POWER( SIN( ($lat - abs( Restaurant.lattitude ) ) * pi( ) /180 /2 ) , 2 ) + COS( $lat * pi( ) /180 ) * COS( abs( Restaurant.lattitude ) * pi( ) /180 ) * POWER( SIN( (
    	$lng - Restaurant.longitude
    	) * pi( ) /180 /2 ) , 2 ) ) ) AS approx_distance
    	FROM restaurants AS Restaurant
    	HAVING approx_distance <=$distance
    	ORDER BY approx_distance";
		$results = $this->Restaurant->query ( $query );
		$r_array = array ();
		
		$cusine_arr = array ();
		
		foreach ( $results as $r ) {
			$dist = $r ['0'] ['approx_distance'];
			
			$res_id = $r ['Restaurant'] ['id'];
			
			$restaurant = $this->Restaurant->find ( 'first', array (
					'conditions' => array (
							'id' => $res_id 
					),
					'recursive' => - 1 
			) );
			
			$restaurant ['Restaurant'] ['approx_distance'] = $dist;
			
			$cusineTakeaways = $this->CusineRestaurant->find ( 'all', array (
					'field' => array (
							'cusine_id' 
					),
					'conditions' => array (
							'restaurant_id' => $res_id 
					),
					'recursive' => - 1 
			) );
			
			$r_cusines = "";
			
			foreach ( $cusineTakeaways as $ct ) {
				$id = $ct ['CusineRestaurant'] ['cusine_id'];
				
				$cusine = $this->Cusine->read ( null, $id );
				
				$r_cusines .= $cusine ['Cusine'] ['name'] . ",";
				
				$cusine_arr [$id] = $cusine ['Cusine'] ['name'];
			}
			
			$restaurant ['Restaurant'] ['cusines'] = rtrim ( $r_cusines, ',' );
			
			$r_array [] = $restaurant;
		}
		
		$r_array ['TakeawaysCusine'] = array_unique ( $cusine_arr, SORT_REGULAR );
		
		return $r_array;
	}
	
	/*
	 * public function details($id = null) { if (! $this->Restaurant->exists ( $id )) { throw new NotFoundException ( __ ( 'Invalid restaurant' ) ); } $this->Restaurant->recursive = 2; $options = array ( 'conditions' => array ( 'Restaurant.' . $this->Restaurant->primaryKey => $id ) ); $restaurant = $this->Restaurant->find ( 'first', $options ); $this->loadModel ( 'Menu' ); $this->Menu->recursive = 0; $menus = $this->Menu->find ( 'all', array ( 'fields' => array ( 'Menu.id', 'Menu.name', 'Menu.photo', 'Menu.photo_dir' ), 'conditions' => array ( 'restaurant_id' => $id ) ) ); // debug($menus); // die(); $this->loadModel ( 'Food' ); $this->loadModel ( 'FoodAccessories' ); $this->Food->recursive = 0; $this->FoodAccessories->recursive = 0; if (! empty ( $menus )) { foreach ( $menus as $key => $menu ) { $foods = $this->Food->find ( 'all', array ( 'fields' => array ( 'Food.id', 'Food.name', 'Food.description', 'Food.price', 'Food.photo', 'Food.photo_dir' ), 'conditions' => array ( 'Food.restaurant_id' => $id, 'Food.menu_id' => $menu ['Menu'] ['id'] ) ) ); $menus [$key] ['Food'] = $foods; } } // debug($menus); // die(); $foods = $this->Food->find ( 'all' ); // debug($foods); foreach ( $foods as $food ) { $food_accessories = $this->FoodAccessories->find ( 'all', array () // 'fields' => array('FoodAccessories.id','FoodAccessories.name','FoodAccessories.price','FoodAccessories.food_id'), // 'conditions' => array('food_id' => $food['Food']['id']) ); $food_acc = $food_accessories; } $new_array = array(); foreach ( $food_acc as $foo ) { // debug($foo); // die(); $i = 0; if ($foo ['FoodAccessories'] ['food_id'] == $foo ['Food'] ['id']) { $new_array [$i] ['FoodAccessories'] = $foo ['FoodAccessories']; } $i ++; } // $this->loadModel('FoodAccessories'); // $this->FoodAccessories->recursive = 0; // $food_accessories = $this->FoodAccessories->find('all'); // $this->loadModel('Food'); // $this->Food->recursive = 0; // $food_accessories = $this->Food->find('all'); // $options = array ( // 'joins' => array ( // array ('table' => 'cusines_restaurants', // // 'alias' => 'Channel', // the alias is 'included' in the 'table' field // 'type' => 'LEFT', // 'conditions' => array ( // 'Restaurant.id = cusines_restaurants.restaurant_id', // ) // ) // ), // 'conditions' => array ('Restaurant.' . $this->Restaurant->primaryKey => $id) // ); // $restaurant = $this->Restaurant->find('first', $options); // $this->loadModel('Menu'); // if(!empty($restaurant['Cusine'])){ // foreach($restaurant['Cusine'] as $key => $cusine){ // $menu = $this->Menu->find('all', array( // 'conditions' => array ( // 'Menu.cusine_id' => $cusine['id'], // 'Menu.restaurant_id' => $id, // ) // )); // $restaurant['Cusine'][$key]['Menu'] = $menu; // } // } $this->set ( compact ( 'restaurant', 'menus', 'food_acc' ) ); }
	 */
	public function details($id = null) {
		if (! $this->Restaurant->exists ( $id )) {
			throw new NotFoundException ( __ ( 'Invalid restaurant' ) );
		}
		$this->Restaurant->recursive = 2;
		$options = array (
				'conditions' => array (
						'Restaurant.' . $this->Restaurant->primaryKey => $id 
				) 
		);
		$restaurant = $this->Restaurant->find ( 'first', $options );
		$this->loadModel ( 'Menu' );
		$this->Menu->recursive = 0;
		$menus = $this->Menu->find ( 'all', array (
				'fields' => array (
						'Menu.id',
						'Menu.name',
						'Menu.description',
						'Menu.photo',
						'Menu.photo_dir' 
				),
				'conditions' => array (
						'restaurant_id' => $id 
				) 
		) );
		
		$this->loadModel ( 'Food' );
		$this->Food->recursive = 1;
		$this->loadModel ( 'Additional' );
		if (! empty ( $menus )) {
			foreach ( $menus as $key => $menu ) {
				$foods = $this->Food->find ( 'all', array (
						'conditions' => array (
								'Food.restaurant_id' => $id,
								'Food.menu_id' => $menu ['Menu'] ['id'] 
						) 
				) );
				for($i = 0; $i < count ( $foods ); $i ++) {
					$additionals = $this->Additional->find ( 'all', array (
							'conditions' => array (
									'Additional.restaurant_id' => $id,
									'Additional.menu_id' => $menu ['Menu'] ['id'],
									'Additional.food_id' => $foods [$i] ['Food'] ['id'] 
							) 
					) );
					if (count ( $additionals ) > 0) {
						foreach ( $additionals as $add ) {
							$foods [$i] ['Additional'] [] = $add ['Additional'];
						}
					}
				}
				
				$menus [$key] ['Food'] = $foods;
			}
		}
		$this->set ( compact ( 'restaurant', 'menus' ) );
	}
	public function findLatlngForPostCode() {
		$this->loadModel ( 'Postcode' );
		$postcode = $this->request->data ['postcode'];
		if (! empty ( $postcode )) {
			$data = $this->Postcode->findLatlngForPostCode ( $postcode );
			$output = array ();
			if ($data) {
				$output ['lat'] = $data ['Postcode'] ['lattitude'];
				$output ['lng'] = $data ['Postcode'] ['longitude'];
			} else {
				$output = 0;
			}
		} else {
			$output = 0;
		}
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $output ) 
		) );
	}
	public function getPostCodeListAutoComplete() {
		$postcode = $this->request->query ['query'];
		$postcode = str_replace ( ' ', '', $postcode );
		/*
		 * $p_length = strlen ( $postcode ); if ($p_length > 3) { $split_1 = substr ( $postcode, 0, 3 ); $split_2 = " " . substr ( $postcode, 3 ); $postcode = $split_1 . "" . $split_2; }
		 */
		$query = "select * from postcodes where replace(`postcode`,' ','') like '$postcode%'";
		$this->loadModel ( 'Postcode' );
		$data = $this->Postcode->query ( $query );
		$output ['suggestions'] = array ();
		if (count ( $data ) > 0) {
			foreach ( $data as $row ) {
				$nRow = array ();
				$nRow ['data'] = $row ['postcodes'] ['id'];
				$nRow ['value'] = $row ['postcodes'] ['postcode'];
				$output ['suggestions'] [] = $nRow;
			}
		} else {
			$output ['suggestions'] = 0;
		}
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $output ) 
		) );
	}
	public function getCityListAutoComplete() {
		$city = $this->request->query ['query'];
		$city = str_replace ( ' ', '', $city );
		$query = "select * from cities where name like '$city%'";
		$this->loadModel ( 'City' );
		$data = $this->City->query ( $query );
		$output ['suggestions'] = array ();
		if (count ( $data ) > 0) {
			foreach ( $data as $row ) {
				$nRow = array ();
				$nRow ['data'] = $row ['cities'] ['id'];
				$nRow ['value'] = $row ['cities'] ['name'];
				$output ['suggestions'] [] = $nRow;
			}
		} else {
			$output ['suggestions'] = 0;
		}
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $output ) 
		) );
	}
	
	/**
	 * ====================================
	 * New Action for Modal update/Delete |
	 * ====================================
	 */
	public function updateRestaurantFoodItem($id = null, $add_food_id = null) {
		$this->loadModel ( 'Food' );
		
		$this->loadModel ( 'Additional' );
		
		$this->Food->id = $id;
		
		if ($this->request->isPost ()) {
			
			$check_data = $this->checkDuplicateFoodFromController ( $id, $this->request->data ['restaurant_id'], $this->request->data ['menu_id'], $this->request->data ['name'] );
			
			if ($check_data [0] [0] ['count'] > 0) {
				$this->Session->setFlash ( __ ( 'Duplicate Food for restaurant.' ) );
				
				return $this->redirect ( array (
						'controller' => 'restaurants',
						'action' => 'view/' . $this->request->data ['restaurant_id'] 
				) );
			}
			
			if ($add_food_id) {
				$check_variation = $this->checkDuplicateFoodVariationFromController ( $add_food_id, $id, $this->request->data ['variation'] );
				
				if ($check_variation [0] [0] ['count'] > 0) {
					$this->Session->setFlash ( __ ( 'Duplicate Food Variation for restaurant.' ) );
					
					return $this->redirect ( array (
							'controller' => 'restaurants',
							'action' => 'view/' . $this->request->data ['restaurant_id'] 
					) );
				}
				
				$this->Additional->id = $add_food_id;
				
				$this->Additional->set ( 'name', $this->request->data ['variation'] );
				
				$this->Additional->set ( 'price', $this->request->data ['price'] );
				
				$this->Additional->save ();
				
				$this->Food->id = $id;
				
				$this->Food->set ( 'name', $this->request->data ['name'] );
				
				$this->Food->set ( 'description', $this->request->data ['description'] );
				
				$this->Food->save ();
				
				if ($this->Additional->save () && $this->Food->save ()) {
					$this->Session->setFlash ( __ ( 'The food has been updated.' ) );
				}
			} else {
				$this->Food->id = $id;
				
				$this->Food->set ( 'name', $this->request->data ['name'] );
				
				$this->Food->set ( 'description', $this->request->data ['description'] );
				
				$this->Food->set ( 'price', $this->request->data ['price'] );
				
				if ($this->Food->save ()) {
					$this->Session->setFlash ( __ ( 'The food has been updated.' ) );
				}
			}
		}
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $this->request->data ['restaurant_id'] 
		) );
	}
	public function deleteRestaurantFoodItem($id = null, $restaurantId = null, $add_id = null) {
		$this->loadModel ( 'Additional' );
		$this->loadModel ( 'Food' );
		if ($this->request->isPost ()) {
			if ($add_id) {
				$this->Additional->id = $add_id;
				if ($this->Additional->delete ()) {
					$this->Session->setFlash ( __ ( 'The food has been deleted.' ) );
				} else {
					$this->Session->setFlash ( __ ( 'The food could not be deleted. Please, try again.' ) );
				}
			} else {
				$this->Food->id = $id;
				if ($this->Food->delete ()) {
					$this->Session->setFlash ( __ ( 'The food has been deleted.' ) );
				} else {
					$this->Session->setFlash ( __ ( 'The food could not be deleted. Please, try again.' ) );
				}
			}
		}
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $restaurantId 
		) );
	}
	public function updateRestaurantMenuItem($id = null) {
		$this->loadModel ( 'Menu' );
		
		$this->Menu->id = $id;
		
		if ($this->request->isPost ()) {
			$check_data = $this->checkDuplicateFromMenuController ( $id, $this->request->data ['restaurant_id'], $this->request->data ['name'] );
			
			if ($check_data [0] [0] ['count'] > 0) {
				$this->Session->setFlash ( __ ( 'Duplicate Menu for restaurant.' ) );
				
				return $this->redirect ( array (
						'controller' => 'restaurants',
						'action' => 'view/' . $this->request->data ['restaurant_id'] 
				) );
			}
			
			if ($this->Menu->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The Menu has been updated.' ) );
			}
		}
		
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $this->request->data ['restaurant_id'] 
		) );
	}
	public function deleteRestaurantMenuItem($id = null, $restaurantId = null) {
		$this->loadModel ( 'Menu' );
		$this->Menu->id = $id;
		if ($this->request->isPost ()) {
			if ($this->Menu->delete ()) {
				$this->Session->setFlash ( __ ( 'The Menu has been deleted.' ) );
			} else {
				$this->Session->setFlash ( __ ( 'The Menu could not be deleted. Please, try again.' ) );
			}
		}
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $restaurantId 
		) );
	}
	public function updateRestaurantAdditionalItem($id = null) {
		$this->loadModel ( 'Additional' );
		$this->Additional->id = $id;
		if ($this->request->isPost ()) {
			if ($this->Additional->save ( $this->request->data )) {
				$this->Session->setFlash ( __ ( 'The Additional has been updated.' ) );
			}
		}
		
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $this->request->data ['restaurant_id'] 
		) );
	}
	public function deleteRestaurantAdditionalItem($id = null, $restaurantId = null) {
		$this->loadModel ( 'Additional' );
		$this->Additional->id = $id;
		if ($this->request->isPost ()) {
			if ($this->Additional->delete ()) {
				$this->Session->setFlash ( __ ( 'The Additional has been deleted.' ) );
			} else {
				$this->Session->setFlash ( __ ( 'The Additional could not be deleted. Please, try again.' ) );
			}
		}
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $restaurantId 
		) );
	}
	public function add_menu($res_id = null) {
		if ($this->request->isPost ()) {
			$this->loadModel ( 'Menu' );

            $menu_array = array();
            foreach($this->request->data['menu'] as $menu)
            {
                $data = array();
                $data['name'] = $menu['name'];
                $data['description'] = $menu['description'];
                $data['restaurant_id'] = $this->request->data['restaurant_id'];
                $check_data = $this->checkDuplicateFromMenuController ( 0, $res_id, $menu['name'] );
                $menu_array[] = $data;
            }

			if ($check_data [0] [0] ['count'] > 0) {
				$this->Session->setFlash ( __ ( 'Duplicate Menu for restaurant.' ) );
				return $this->redirect ( array (
						'controller' => 'restaurants',
						'action' => 'view/' . $res_id 
				) );
			}
			
			$this->Menu->create ();
			
			if ($this->Menu->saveAll ( $menu_array )) {
				$this->Session->setFlash ( __ ( 'The Menu has been added.' ) );
			} else {
				$this->Session->setFlash ( __ ( 'The Menu could not be deleted. Please, try again.' ) );
			}
		}
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $res_id 
		) );
	}
	public function add_food($res_id = null) {
		if ($this->request->isPost ()) {
			//debug($this->request->data);die();
			$this->loadModel ( 'Food' );
			$food_array = array();
			foreach($this->request->data['food'] as $food)
			{
				$data = array();
				$data['restaurant_id'] = $this->request->data['restaurant_id'];
				$data['menu_id'] = $food['menu_id'];
				$data['name'] = $food['name'];
				$data['description'] = $food['description'];
				$data['price'] = $food['price'];
				$check_data = $this->checkDuplicateFoodFromController ( 0, $this->request->data['restaurant_id'], $food['menu_id'], $food['name'] );
				$food_array[] = $data;
			}


			/*if (empty ( $this->request->data ['food']['menu_id'] )) {
				$this->Session->setFlash ( __ ( 'Please select a menu before save.' ) );
				
				return $this->redirect ( array (
						'controller' => 'restaurants',
						'action' => 'view/' . $res_id 
				) );
				;
			}*/
			

			
			if ($check_data [0] [0] ['count'] > 0) {
				$this->Session->setFlash ( __ ( 'Duplicate Food for restaurant.' ) );
				
				return $this->redirect ( array (
						'controller' => 'restaurants',
						'action' => 'view/' . $res_id 
				) );
			}
			
			$this->Food->create ();
			
			if ($this->Food->saveAll ( $food_array )) {
				$this->Session->setFlash ( __ ( 'The Food has been added.' ) );
			} else {
				$this->Session->setFlash ( __ ( 'The Food could not be deleted. Please, try again.' ) );
			}
		}
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $res_id 
		) );
	}
	public function add_food_variation($res_id = null) {
		if ($this->request->isPost ()) {

			$this->loadModel ( 'Additional' );

			$food_variation_array = array();
			foreach($this->request->data['foodVariation'] as $foodVariation)
			{
				$data = array();
				$data['restaurant_id'] = $this->request->data['variation']['restaurant_id'];
				$data['menu_id'] = $this->request->data['variation']['menu_id'];
				$data['food_id'] = $this->request->data['variation']['food_id'];
				$data['name'] = $foodVariation['name'];
				$data['price'] = $foodVariation['price'];
				$check_variation = $this->checkDuplicateFoodVariationFromController ( 0, $data['food_id'], $data['name'] );
				$food_variation_array[] = $data;
			}

			if ($check_variation [0] [0] ['count'] > 0) {
				$this->Session->setFlash ( __ ( 'Duplicate Food Variation for restaurant.' ) );
				
				return $this->redirect ( array (
						'controller' => 'restaurants',
						'action' => 'view/' . $this->request->data ['restaurant_id'] 
				) );
			}
			
			$this->Additional->create ();
			if ($this->Additional->saveAll ( $food_variation_array )) {
				$this->Session->setFlash ( __ ( 'Food Variation has been added.' ) );
			} else {
				$this->Session->setFlash ( __ ( 'Food Variation could not be deleted. Please, try again.' ) );
			}
		}
		return $this->redirect ( array (
				'controller' => 'restaurants',
				'action' => 'view/' . $res_id 
		) );
	}
	public function checkDuplicateFromMenuController($id = 0, $res_id, $name) {
		$query = "SELECT count(*) as count from menus where name = '$name' and id != '$id' and restaurant_id = '$res_id'";
		
		$this->loadModel ( 'Menu' );
		
		return $queryResult = $this->Menu->query ( $query );
	}
	public function checkDuplicateFoodFromController($id = 0, $res_id, $menu_id, $name) {
		$this->loadModel ( 'Food' );
		
		$query = "SELECT count(*) as count from foods where name = '$name' and id != '$id' and restaurant_id = '$res_id' and menu_id = '$menu_id'";
		
		return $queryResult = $this->Food->query ( $query );
	}
	public function checkDuplicateFoodVariationFromController($id = 0, $food_id, $name) {
		$this->loadModel ( 'Additional' );
		
		$query = "SELECT count(*) as count from additionals where name = '$name' and id != '$id' and food_id = '$food_id'";
		
		return $queryResult = $this->Additional->query ( $query );
	}
	public function suggestRestaurant() {
	}
	public function suggestTakeaways() {
		$this->loadModel ( 'Order' );
		$query = "SELECT
                        count(orders.id) as ordercount, orders.restaurant_id, restaurants.name, cusines_restaurants.cusine_id,cusines.name,cusines.image,cusines.image_dir
                        from orders
                        join restaurants
                        on orders.restaurant_id = restaurants.id
                        join cusines_restaurants
                        on orders.restaurant_id = cusines_restaurants.restaurant_id
                        join cusines
                        on cusines_restaurants.cusine_id = cusines.id
                        group by orders.restaurant_id
                        order by ordercount desc";
		
		$orders = $this->Order->query ( $query );
		
		$this->loadModel ( 'Restaurant' );
		$query = "SELECT count(orders.id) AS ordercount,restaurants.city_id,cities.name
                  FROM orders
                  JOIN restaurants
                  ON orders.restaurant_id = restaurants.id
                  JOIN cities
                  ON restaurants.city_id = cities.id
                  ORDER BY ordercount DESC";
		$cities = $this->Order->query ( $query );
		$this->set ( compact ( 'orders', 'cities' ) );
	}
	public function newTakeaways() {
		$query = "SELECT restaurants.id
                    FROM restaurants
                    ORDER BY created DESC LIMIT 6";
		$this->loadModel ( 'Restaurant' );
		$restaurants = $this->Restaurant->query ( $query );
		
		$list_of_search_restaurants = array ();
		
		foreach ( $restaurants as $restaurant ) {
			$list_of_search_restaurants [] = $restaurant ['restaurants'] ['id'];
		}
		$this->Paginator->settings ['conditions'] [] ['Restaurant.id'] = $list_of_search_restaurants;
		$restaurants = $this->Paginator->paginate ( 'Restaurant' );
		
		$this->set ( compact ( 'restaurants' ) );
	}
	public function pizzaDelivery() {
	}
	public function takeaways() {
		/*
		 * |-------------------------------------------------------------------------- | Pizza Takeaways by city Footer |--------------------------------------------------------------------------
		 */
		if (isset ( $this->passedArgs ['pizzaCity'] ) && $this->passedArgs ['pizzaCity'] != NULL) {
			$this->loadModel ( 'Restaurant' );
			$city = $this->passedArgs ['pizzaCity'];
			
			$query = "SELECT restaurants.id
						FROM restaurants
						JOIN cities
						ON restaurants.city_id = cities.id
						JOIN cusines_restaurants
						ON cusines_restaurants.restaurant_id = restaurants.id
						JOIN cusines
						ON cusines_restaurants.cusine_id = cusines.id
						WHERE cities.name = '$city'
						AND cusines.name = 'pizza'";
			
			$restaurants = $this->Restaurant->query ( $query );
			
			$list_of_search_restaurants = array ();
			
			foreach ( $restaurants as $restaurant ) {
				$list_of_search_restaurants [] = $restaurant ['restaurants'] ['id'];
			}
			$this->Paginator->settings ['conditions'] [] ['Restaurant.id'] = $list_of_search_restaurants;
			$restaurants = $this->Paginator->paginate ( 'Restaurant' );
			$title = 'Pizza Delivery in ' . $city;
		}
		
		/*
		 * |-------------------------------------------------------------------------- | New Restaurants / Takeaways Footer |--------------------------------------------------------------------------
		 */
		if (isset ( $this->passedArgs ['newRestaurants'] )) {
			$query = "SELECT restaurants.id
                    FROM restaurants
                    ORDER BY created DESC LIMIT 6";
			$this->loadModel ( 'Restaurant' );
			$restaurants = $this->Restaurant->query ( $query );
			
			$list_of_search_restaurants = array ();
			
			foreach ( $restaurants as $restaurant ) {
				$list_of_search_restaurants [] = $restaurant ['restaurants'] ['id'];
			}
			$this->Paginator->settings ['conditions'] [] ['Restaurant.id'] = $list_of_search_restaurants;
			$restaurants = $this->Paginator->paginate ( 'Restaurant' );
			$title = 'New Takeaways';
		}
		/*
		 * |-------------------------------------------------------------------------- | Append restaurant List from cuisineList |--------------------------------------------------------------------------
		 */
		if (isset ( $this->request->data ['cuisine'] ) && isset ( $this->request->data ['city'] )) {
			$this->loadModel ( 'Restaurant' );
			$cuisine = $this->request->data ['cuisine'];
			$city = $this->request->data ['city'];
			
			$query = "SELECT cusines_restaurants.restaurant_id
						FROM cusines_restaurants
						JOIN restaurants
						ON cusines_restaurants.restaurant_id = restaurants.id
						JOIN cities
						ON cities.id = restaurants.city_id
						WHERE cusines_restaurants.cusine_id='$cuisine'
						AND cities.name = '$city'";
			
			$restaurants = $this->Restaurant->query ( $query );
			
			$list_of_search_restaurants = array ();
			
			foreach ( $restaurants as $restaurant ) {
				$list_of_search_restaurants [] = $restaurant ['cusines_restaurants'] ['restaurant_id'];
			}
			$this->Paginator->settings ['conditions'] [] ['Restaurant.id'] = $list_of_search_restaurants;
			$restaurants = $this->Paginator->paginate ( 'Restaurant' );
			if (empty ( $restaurants )) {
				$restaurants = 0;
			}
			
			return new CakeResponse ( array (
					'type' => 'application/json',
					'body' => json_encode ( $restaurants ) 
			) );
		}
		/*
		 * |-------------------------------------------------------------------------- | Append restaurant List from cityList |--------------------------------------------------------------------------
		 */
		if (isset ( $this->request->data ['cuisineName'] ) && isset ( $this->request->data ['cityId'] )) {
			$this->loadModel ( 'Restaurant' );
			$cuisine = $this->request->data ['cuisineName'];
			$city = $this->request->data ['cityId'];
			
			$query = "SELECT restaurants.id
						FROM restaurants
						JOIN cities
						ON restaurants.city_id = cities.id
						JOIN cusines_restaurants
						ON cusines_restaurants.restaurant_id = restaurants.id
						JOIN cusines
						ON cusines.id = cusines_restaurants.cusine_id
						WHERE cities.id='$city'
						AND cusines.name = '$cuisine'";
			
			$restaurants = $this->Restaurant->query ( $query );
			
			$list_of_search_restaurants = array ();
			
			foreach ( $restaurants as $restaurant ) {
				$list_of_search_restaurants [] = $restaurant ['restaurants'] ['id'];
			}
			$this->Paginator->settings ['conditions'] [] ['Restaurant.id'] = $list_of_search_restaurants;
			$restaurants = $this->Paginator->paginate ( 'Restaurant' );
			if (empty ( $restaurants )) {
				$restaurants = 0;
			}
			
			return new CakeResponse ( array (
					'type' => 'application/json',
					'body' => json_encode ( $restaurants ) 
			) );
		}
		/*
		 * |-------------------------------------------------------------------------- | Append Restaurant List Popular Cuisines |--------------------------------------------------------------------------
		 */
		if (isset ( $this->request->data ['cuisineId'] )) {
			$this->loadModel ( 'Restaurant' );
			$cuisine = $this->request->data ['cuisineId'];
			
			$query = "SELECT cusines_restaurants.restaurant_id
						FROM cusines_restaurants
						JOIN restaurants
						ON cusines_restaurants.restaurant_id = restaurants.id
						WHERE cusines_restaurants.cusine_id='$cuisine'";
			
			$restaurants = $this->Restaurant->query ( $query );
			
			$list_of_search_restaurants = array ();
			
			foreach ( $restaurants as $restaurant ) {
				$list_of_search_restaurants [] = $restaurant ['cusines_restaurants'] ['restaurant_id'];
			}
			$this->Paginator->settings ['conditions'] [] ['Restaurant.id'] = $list_of_search_restaurants;
			$restaurants = $this->Paginator->paginate ( 'Restaurant' );
			if (empty ( $restaurants )) {
				$restaurants = 0;
			}
			
			return new CakeResponse ( array (
					'type' => 'application/json',
					'body' => json_encode ( $restaurants ) 
			) );
		}
		/*
		 * |-------------------------------------------------------------------------- | Append Restaurant List Popular Cities |--------------------------------------------------------------------------
		 */
		if (isset ( $this->request->data ['cityId'] )) {
			$this->loadModel ( 'Restaurant' );
			$city = $this->request->data ['cityId'];
			
			$query = "SELECT restaurants.id
						FROM restaurants
						JOIN cities
						ON restaurants.city_id = cities.id
						JOIN cusines_restaurants
						ON cusines_restaurants.restaurant_id = restaurants.id
						WHERE cities.id='$city'";
			
			$restaurants = $this->Restaurant->query ( $query );
			
			$list_of_search_restaurants = array ();
			
			foreach ( $restaurants as $restaurant ) {
				$list_of_search_restaurants [] = $restaurant ['restaurants'] ['id'];
			}
			$this->Paginator->settings ['conditions'] [] ['Restaurant.id'] = $list_of_search_restaurants;
			$restaurants = $this->Paginator->paginate ( 'Restaurant' );
			if (empty ( $restaurants )) {
				$restaurants = 0;
			}
			
			return new CakeResponse ( array (
					'type' => 'application/json',
					'body' => json_encode ( $restaurants ) 
			) );
		}
		
		$this->set ( compact ( 'restaurants', 'title' ) );
	}
	public function allCuisineList() {
		$this->loadModel ( 'Cusine' );
		$query = "SELECT id,name FROM cusines";
		$cuisines = $this->Cusine->query ( $query );
		if (empty ( $cuisines )) {
			$cuisines = 0;
		}
		
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $cuisines ) 
		) );
	}
	public function allCityList() {
		$this->loadModel ( 'City' );
		$query = "SELECT id,name FROM cities";
		$cities = $this->City->query ( $query );
		if (empty ( $cities )) {
			$cities = 0;
		}
		
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $cities ) 
		) );
	}
	public function prepareValidPostCode($postcode) 
	{
		$postcode = strtoupper($postcode);
		$p_length = strlen ( $postcode );
		
		if ($p_length > 3) {
			$split_1 = substr ( $postcode, 0, 3 );
			$split_2 = " " . substr ( $postcode, 3 );
			$postcode = $split_1 . "" . $split_2;
		}
		
		$this->loadModel ( 'Postcode' );
		$PostCodeData = $this->Postcode->find ( 'first', array (
				'conditions' => array (
						'postcode LIKE' => $postcode . '%' 
				) 
		) );
		if (! empty ( $PostCodeData )) {
			$this->Session->write ( 'postcode', $PostCodeData ['Postcode'] ['postcode'] );
		}
		return $PostCodeData;
	}
	public function searchTakeaways()
	{

	}

	public function getRestaurantListAutoComplete() {
		$restaurant = $this->request->data ['restaurant'];
		$restaurant = str_replace ( ' ', '', $restaurant );

		$query = "select name,id from restaurants where replace(`name`,' ','') like '%$restaurant%'";
		$this->loadModel ( 'Restaurant' );
		$data = $this->Restaurant->query ( $query );
		$output = array ();
		if (count ( $data ) > 0)
		{
			foreach ( $data as $row ) {
				$nRow = array ();
				$nRow ['name'] = $row ['restaurants'] ['name'];
				$nRow ['id'] = $row ['restaurants'] ['id'];
				$output [] = $nRow;
			}
		} else {
			$output = 0;
		}
		return new CakeResponse ( array (
			'type' => 'application/json',
			'body' => json_encode ( $output )
		) );
	}
}





