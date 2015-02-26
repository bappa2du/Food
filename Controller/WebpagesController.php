<?php

App::uses('AppController', 'Controller');

class WebpagesController extends AppController
{

    /**
     * Components
     *
     * @var array
     */
    public $components = array('Paginator');

    /**
     * index method
     *
     * @return void
     */
    public function index()
    {

        $this->Webpage->recursive = 0;
        $this->set('webpages', $this->Paginator->paginate());
    }

    /**
     * view method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function view($id = null)
    {
        if (!$this->Webpage->exists($id)) {
            throw new NotFoundException(__('Invalid webpage'));
        }
        die('dd');
        $options = array('conditions' => array('Webpage.' . $this->Webpage->primaryKey => $id));
        $this->set('webpage', $this->Webpage->find('first', $options));
    }

    /**
     * add method
     *
     * @return void
     */
    public function add()
    {
        if ($this->request->is('post')) {
            $this->Webpage->create();
            if ($this->Webpage->save($this->request->data)) {
                $this->Session->setFlash(__('The webpage has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The webpage could not be saved. Please, try again.'));
            }
        }
        $categories = $this->Webpage->Category->find('list');
        $restaurants = $this->Webpage->Restaurant->find('list');
        $this->set(compact('categories', 'restaurants'));
    }

    /**
     * edit method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function edit($id = null)
    {
        if (!$this->Webpage->exists($id)) {
            throw new NotFoundException(__('Invalid webpage'));
        }
        if ($this->request->is(array('post', 'put'))) {
            if ($this->Webpage->save($this->request->data)) {
                $this->Session->setFlash(__('The webpage has been saved.'));
                return $this->redirect(array('action' => 'index'));
            } else {
                $this->Session->setFlash(__('The webpage could not be saved. Please, try again.'));
            }
        } else {
            $options = array('conditions' => array('Webpage.' . $this->Webpage->primaryKey => $id));
            $this->request->data = $this->Webpage->find('first', $options);
        }
        $categories = $this->Webpage->Category->find('list');
        $restaurants = $this->Webpage->Restaurant->find('list');
        $this->set(compact('categories', 'restaurants'));
    }

    /**
     * delete method
     *
     * @throws NotFoundException
     * @param string $id
     * @return void
     */
    public function delete($id = null)
    {
        $this->Webpage->id = $id;
        if (!$this->Webpage->exists()) {
            throw new NotFoundException(__('Invalid webpage'));
        }
        //$this->request->allowMethod('post', 'delete');

        if ($this->request->isPost()) {

            if ($this->Webpage->delete()) {
                $this->Session->setFlash(__('The webpage has been deleted.'));
            } else {
                $this->Session->setFlash(__('The webpage could not be deleted. Please, try again.'));
            }
        }
        return $this->redirect(array('action' => 'index'));

    }

    public function home()
    {

        $this->theme = 'Takeaway';
//        $this->loadModel('restaurant');
//        $restaurants = $this->restaurant->find('all', array(
//            'order' => array('ratting' => 'desc'),
//            'limit' => 4,
//        ));
        $this->loadModel('Restaurant');

        $query = "SELECT restaurants.id FROM restaurants LIMIT 8";

        $restaurants = $this->Restaurant->query($query);

        $list_of_search_restaurants = array();

        foreach ($restaurants as $restaurant) {
            $list_of_search_restaurants[] = $restaurant['restaurants']['id'];
        }
        $this->Paginator->settings['conditions'][]['Restaurant.id'] = $list_of_search_restaurants;
        $restaurants = $this->Paginator->paginate('Restaurant');

//        debug($restaurants);die();

        $this->loadModel('cusine');
        $this->loadModel('Order');
        $this->loadModel('Offer');

        $query = "SELECT offers.restaurant_id,offers.title,offers.discount_amount,offers.discount_type,restaurants.name,foods.name
                        FROM offers
                        JOIN restaurants
                        ON offers.restaurant_id = restaurants.id
                        JOIN foods
                        ON offers.food_id = foods.id";

        $offers = $this->Offer->query($query);

        //$query = "SELECT count(orders.id) as ordercount, orders.restaurant_id, restaurants.name from orders join restaurants on orders.restaurant_id = restaurants.id group by orders.restaurant_id order by ordercount desc ";
        /*$query = "SELECT
                        count(orders.id) as ordercount, orders.restaurant_id, restaurants.name, cusines_restaurants.cusine_id,cusines.name,cusines.image,cusines.image_dir
                        from orders 
                        join restaurants 
                        on orders.restaurant_id = restaurants.id 
                        join cusines_restaurants
                        on orders.restaurant_id = cusines_restaurants.restaurant_id
                        join cusines
                        on cusines_restaurants.cusine_id = cusines.id
                        group by orders.restaurant_id 
                        order by ordercount desc";*/
        $query = "SELECT DISTINCT cusines.name,cusines.id ,cusines.image,cusines.image_dir,cusines_restaurants.cusine_id
                FROM cusines JOIN cusines_restaurants ON cusines_restaurants.cusine_id = cusines.id ORDER BY rand() LIMIT 6";

        $order = $this->Order->query($query);
        $cusines = $this->cusine->find('all', array(
            'limit' => 6,
        ));

        $this->set(compact('restaurants', 'cusines', 'order','offers'));

    }


    public function getmenu($menupos = 'footer')
    {
        $this->loadModel('Category');
        if ($this->request->is('requested')) {
            return $this->Category->find('all', array(
                'conditions' => array('Category.placement' => $menupos)
            ));
        }

    }

    public function quickmail()
    {
        $qumail = $this->request->data;
        $Email = new CakeEmail();
        $Email->from(array($qumail['qemail'] => $qumail['qname']));
        $Email->to('admin@lict.com');
        $Email->subject('Query form Mail');
        $Email->send($qumail['qcomment']);

    }

    /*
    |--------------------------------------------------------------------------
    | Homepage restaurant List by Latitude and Longitude
    |--------------------------------------------------------------------------
    */
    public function homePageRestaurant()
    {
        $this->loadModel('SearchingDistance');
        $distance = $this->SearchingDistance->find('first');
        $distance = $distance['SearchingDistance']['value'];



        $current_position ['Postcode'] ['lattitude'] = $this->request->data['lattitude'];
        $current_position ['Postcode'] ['longitude'] = $this->request->data['longitude'];

        if (!empty ($current_position)) {
            $restaurants = $this->getRestaurantDataByWithinRange($current_position, $distance);
        } else {
            $restaurants = 0;
        }
        return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($restaurants)));
    }

    public function getRestaurantDataByWithinRange($postcode, $distance)
    {
        $recursive = -1;
        $lat = $postcode ['Postcode'] ['lattitude'];
        $lng = $postcode ['Postcode'] ['longitude'];

        $query = "SELECT DISTINCT Restaurant.id , 3956 *2 * ASIN( SQRT( POWER( SIN( ($lat - abs( Restaurant.lattitude ) ) * pi( ) /180 /2 ) , 2 ) + COS( $lat * pi( ) /180 ) * COS( abs( Restaurant.lattitude ) * pi( ) /180 ) * POWER( SIN( ($lng - Restaurant.longitude) * pi( ) /180 /2 ) , 2 ) ) ) AS approx_distance,
            COUNT(orders.restaurant_id) AS HIT
            FROM restaurants AS Restaurant
            JOIN orders
            ON orders.restaurant_id = Restaurant.id
            HAVING approx_distance <= $distance
            ORDER BY approx_distance,HIT";
        $this->loadModel('Restaurant');
        $results = $this->Restaurant->query($query);
        $r_array = array();

        foreach ($results as $r) {
            $dist = $r ['0'] ['approx_distance'];
            $res_id = $r ['Restaurant'] ['id'];
            $restaurant = $this->Restaurant->read(null, $res_id);
            $restaurant ['Restaurant'] ['approx_distance'] = $dist;
            $r_array [] = $restaurant;
        }
        return $r_array;
    }
    /*
    |--------------------------------------------------------------------------
    | FAQ
    |--------------------------------------------------------------------------
    */
    public function faq(){}

    /*
    |--------------------------------------------------------------------------
    | Privacy Policy
    |--------------------------------------------------------------------------
    */

    public function privacyPolicy(){}

    /*
    |--------------------------------------------------------------------------
    | Contact Page
    |--------------------------------------------------------------------------
    */

    public function contact(){}

    public function assignLatLngSession()
    {
        $this->Session->write('lat', $this->request->data['latitude']);
        $this->Session->write('lng', $this->request->data['longitude']);
        $result = $this->Session->read('lat');
        return new CakeResponse(array('type' => 'application/json', 'body' => json_encode($result)));
    }
}
