<?php
App::uses ( 'AppController', 'Controller' );

/**
 * Foods Controller
 *
 * @property Food $Food
 * @property PaginatorComponent $Paginator
 */
class FoodsController extends AppController {
	
	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array (
			'Paginator' 
	);
	
	/**
	 * index method
	 *
	 * @return void
	 */
	public function index() {
		$this->Food->recursive = 0;
		
		$this->set ( 'foods', $this->Paginator->paginate () );
	}
	public function sownersfoods() {
		$this->Food->recursive = 0;
		$_user = $this->UserAuth->getUser ();
		$this->paginate = array (
				'conditions' => array (
						'Food.restaurant_id' => $_user ['User'] ['restaurantid'] 
				) 
		);
		
		$this->set ( 'foods', $this->Paginator->paginate () );
	}
	
	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function view($id = null) {
		if (! $this->Food->exists ( $id )) {
			
			throw new NotFoundException ( __ ( 'Invalid food' ) );
		}
		
		$options = array (
				'conditions' => array (
						'Food.' . $this->Food->primaryKey => $id 
				) 
		);
		
		$this->set ( 'food', $this->Food->find ( 'first', $options ) );
	}
	
	/**
	 * add method
	 *
	 * @return void
	 */
	public function add() {
		
		if ($this->request->is ( 'post' )) {
			
			$data = array ();
			
			if (empty ( $this->request->data ['Food'] ['restaurant_id'] )) {
				$this->Session->setFlash ( __ ( 'Please select a restaurant before save.' ) );
				return;
			}
			
			if (empty ( $this->request->data ['Food'] ['menu_id'] )) {
				$this->Session->setFlash ( __ ( 'Please select a menu before save.' ) );
				return;
			}
			
			$this->Food->create ();
			
			$check_data = $this->checkDuplicateFoodFromController($id, $this->request->data ['Food'] ['restaurant_id'], $this->request->data ['Food'] ['menu_id'], $this->request->data['Food']['name']);
            	
            if($check_data[0][0]['count'] > 0)
            {
            	$this->Session->setFlash ( __ ( 'Duplicate Food for restaurant.' ) );
            	
            	return $this->redirect ( array (
								'action' => 'add?city='.$this->request->data ['Food']['city'].'&&postal='.$this->request->data ['Food']['postal'].'&&res='.$this->request->data ['Food'] ['restaurant_id'].'&&menu='.$this->request->data ['Food'] ['menu_id'] 
						));
            }
			
			if ($this->Food->save ( $this->request->data ['Food'] )) {
				if (! empty ( $this->request->data ['FoodItem'] )) {
					$food_id = $this->Food->getLastInsertID ();
					$food_item = array ();
					
					foreach ( $this->request->data ['FoodItem'] as $item ) {
						$data = array ();
						$data = $item;
						$data ['food_id'] = $food_id;
						$data ['restaurant_id'] = $this->request->data ['Food'] ['restaurant_id'];
						$data ['menu_id'] = $this->request->data ['Food'] ['menu_id'];
						$food_item [] = $data;
					}
					$this->loadModel ( 'Additional' );
					if ($this->Additional->saveAll ( $food_item )) {
						$this->Session->setFlash ( __ ( 'The food has been saved.' ) );
						
						return $this->redirect ( array (
								'action' => 'add?city='.$this->request->data ['Food']['city'].'&&postal='.$this->request->data ['Food']['postal'].'&&res='.$this->request->data ['Food'] ['restaurant_id'].'&&menu='.$this->request->data ['Food'] ['menu_id'] 
						));
					} else {
						$this->Food->id = $food_id;
						$this->Food->delete ();
						$this->Session->setFlash ( __ ( 'The food could not be saved. Please, try again.' ) );
					}
				} else {
					$this->Session->setFlash ( __ ( 'The food has been saved.' ) );
					
					return $this->redirect ( array (
								'action' => 'add?city='.$this->request->data ['Food']['city'].'&&postal='.$this->request->data ['Food']['postal'].'&&res='.$this->request->data ['Food'] ['restaurant_id'].'&&menu='.$this->request->data ['Food'] ['menu_id'] 
						));
				}
			}
		} else {
			if(isset($this->request->query['res'])){
				$this->set('restaurant', $this->request->query['res']);
			}
			if(isset($this->request->query['menu'])){
				$this->set('menu', $this->request->query['menu']);
			}
			if(isset($this->request->query['city'])){
				$this->set('city', $this->request->query['city']);
			}
			if(isset($this->request->query['postal'])){
				$this->set('postal', $this->request->query['postal']);
			}
		}
		
		$restaurants = $this->Food->Restaurant->find ( 'list' );


        $existing_foods = $this->Food->query('SELECT DISTINCT name FROM foods');
        $foods = Set::extract('/foods/name', $existing_foods);

        $this->loadModel('Additional');
        $existing_additional_foods = $this->Additional->query('SELECT DISTINCT name FROM additionals');
        $additional_foods = Set::extract('/additionals/name', $existing_additional_foods);

		$this->set ( compact ( 'restaurants' ,'foods', 'additional_foods' ) );
	}
	
	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function edit($id = null) {
		if (! $this->Food->exists ( $id )) {
			
			throw new NotFoundException ( __ ( 'Invalid food' ) );
		}
		
		if ($this->request->is ( array (
				'post',
				'put' 
		) )) {
			
			if ($this->Food->save ( $this->request->data )) {
				
				$this->Session->setFlash ( __ ( 'The food has been saved.' ) );
				
				return $this->redirect ( array (
						'action' => 'index' 
				) );
			} else {
				
				$this->Session->setFlash ( __ ( 'The food could not be saved. Please, try again.' ) );
			}
		} else {
			
			$options = array (
					'conditions' => array (
							'Food.' . $this->Food->primaryKey => $id 
					) 
			);
			
			$this->request->data = $this->Food->find ( 'first', $options );
		}
		
		$restaurants = $this->Food->Restaurant->find ( 'list' );
		
		$menus = $this->Food->Menu->find ( 'list' );
		
		$additionals = $this->Food->Additional->find ( 'list' );

        $existing_foods = $this->Food->query('SELECT DISTINCT name FROM foods');
        $foods = Set::extract('/foods/name', $existing_foods);

        $this->loadModel('Additional');
        $existing_additional_foods = $this->Additional->query('SELECT DISTINCT name FROM additionals');
        $additional_foods = Set::extract('/additionals/name', $existing_additional_foods);
		
		$this->set ( compact ( 'restaurants', 'menus', 'additionals', 'foods', 'additional_foods' ) );
	}
	public function priceedit($id = null) {
		if (! $this->Food->exists ( $id )) {
			
			throw new NotFoundException ( __ ( 'Invalid food' ) );
		}
		
		if ($this->request->is ( array (
				'post',
				'put' 
		) )) {
			
			if ($this->Food->save ( $this->request->data )) {
				
				$this->Session->setFlash ( __ ( 'The food has been saved.' ) );
				
				return $this->redirect ( array (
						'action' => 'sownersfoods' 
				) );
			} else {
				
				$this->Session->setFlash ( __ ( 'The food could not be saved. Please, try again.' ) );
			}
		} else {
			
			$options = array (
					'conditions' => array (
							'Food.' . $this->Food->primaryKey => $id 
					) 
			);
			
			$this->request->data = $this->Food->find ( 'first', $options );
		}
		
		$restaurants = $this->Food->Restaurant->find ( 'list' );
		
		$menus = $this->Food->Menu->find ( 'list' );
		
		$additionals = $this->Food->Additional->find ( 'list' );
		
		$this->set ( compact ( 'restaurants', 'menus', 'additionals' ) );
	}
	
	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id        	
	 * @return void
	 */
	public function delete($id = null) {
		$this->Food->id = $id;
		
		if (! $this->Food->exists ()) {
			
			throw new NotFoundException ( __ ( 'Invalid food' ) );
		}
		
		// $this->request->allowMethod('post', 'delete');
		
		if ($this->request->isPost ()) {
			
			if ($this->Food->delete ()) {
				
				$this->Session->setFlash ( __ ( 'The food has been deleted.' ) );
			} else {
				
				$this->Session->setFlash ( __ ( 'The food could not be deleted. Please, try again.' ) );
			}
		}
		
		return $this->redirect ( array (
				'action' => 'index' 
		) );
	}
	public function guestview($id = null) {
		if (! $this->Food->exists ( $id )) {
			
			throw new NotFoundException ( __ ( 'Invalid food' ) );
		}
		
		$options = array (
				'conditions' => array (
						'Food.' . $this->Food->primaryKey => $id 
				) 
		);
		
		$this->set ( 'food', $this->Food->find ( 'first', $options ) );
	}
	public function getMenuItems() {
		$this->loadModel ( 'Menu' );
		$restaurent_id = $this->request->data ['restaurent_id'];
		$data = $this->Menu->getMenuItemsByRestaurent ( $restaurent_id );
		$output = array ();
		if ($data) {
			foreach ( $data as $d ) {
				$df = array ();
				$df ['name'] = $d ['menus'] ['name'];
				$df ['id'] = $d ['menus'] ['id'];
				$output [] = $df;
			}
		} else {
			$output = 0;
		}
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $output ) 
		) );
	}
	public function getFoodItemsForMenu() {
		$this->loadModel ( 'Menu' );
		$menu_id = $this->request->data ['menu_id'];
		$data = $this->Food->getFoodItemsForMenu ( $menu_id );
		$output = array ();
		if ($data) {
			foreach ( $data as $d ) {
				$df = array ();
				$df ['name'] = $d ['foods'] ['name'];
				$df ['id'] = $d ['foods'] ['id'];
				$output [] = $df;
			}
		} else {
			$output = 0;
		}
		return new CakeResponse ( array (
				'type' => 'application/json',
				'body' => json_encode ( $output ) 
		) );
	}

	/**
	 * Check Duplicate Name
	 */
	public function checkDuplicateFood()
	{
		$paramsArray = $this->request->data;
			
		$modelName = $paramsArray['0'];
			
		$modelId = $paramsArray['1'];
			
		$this->loadModel($modelName);
			
		$tableName = $this->$modelName->table;
			
		$where = "1 and $tableName.id != '$modelId'";
			
		foreach($paramsArray as $param => $value)
		{
			if(is_array($value))
			{
				$key = $value['0'];
					
				$keyVal = str_replace("'","\'",$value['1']);
					
				$where .= " and $key = '$keyVal'";
			}
		}
			
		$query = "SELECT count(*) as count from $tableName where $where";
			
		$queryResult = $this->$modelName->query($query);
			
		if($queryResult['0']['0']['count'] > 0)
		{
			return new CakeResponse(array('type'=>'application/json', 'body'=>json_encode(1)));
		}
		else
		{
			return new CakeResponse(array('type'=>'application/json', 'body'=>json_encode(0)));
		}
	}
	/*
	 * Code from zadid vai public function getFoodsByMenuId($menu_id = NULL ){ Configure::write('debug',0); $this->layout = 'ajax'; if(is_null($menu_id)){ return NULL; } $this->loadModel('Food'); $foods = $this->Food->find('list', array('conditions'=>array('menu_id = '=>$menu_id))); header("Content-type: application/json"); // not necessary echo json_encode($foods); $this->render = false; exit; }
	 */
	
	/*
	|--------------------------------------------------------------------------
	| function for escape for single quates
	|--------------------------------------------------------------------------
	*/

	public function checkDuplicateFoodFromController($id = 0, $res_id, $menu_id, $name)
	{
		$this->loadModel('Food');

		$name=str_replace("'","\'",$name);
		 
		$query = "SELECT count(*) as count from foods where name = '$name' and id != '$id' and restaurant_id = '$res_id' and menu_id = '$menu_id'";
	
		return $queryResult = $this->Food->query($query);
	}
	
	public function checkDuplicateFoodVariationFromController($id = 0, $food_id, $name)
	{
		$this->loadModel('Additional');
	
		$query = "SELECT count(*) as count from additionals where name = '$name' and id != '$id' and food_id = '$food_id'";
	
		return $queryResult = $this->Additional->query($query);
	}
}



