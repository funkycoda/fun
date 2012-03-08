<?php
/**
 * IndexController 
 * 
 * Essentially the only controller for this demo. 
 * - Displays the initial index page
 * - Sends of a search query to Flickr and returns the data as JSON
 * - Displays a page view of the selected photo
 * 
 * TODO: Should really make the common variables global rather
 *       rather than referencing them in the functions 
 */

class IndexController extends AppController {
		
	// API to call the Flickr service
	// instead of the regular cURL service
	public $components = array('RequestHandler');

	/**
	 * Index page
	 */
	public function index() {
		$this -> set('message', 'Welcome to Flearch');
	}

	/**
	 * Search flickr and return the response as JSON
	 * 
	 * $query text user entered search terms. mandatory.
	 * $page integer starting page. optional. defaults to 1
	 */
	public function search($query, $page = 1) {
		
		$API_KEY = 'FLICKR_API_CODE';

		$BASE_URL = 'http://api.flickr.com/services/rest/?';
		$SEARCH_METHOD = 'flickr.photos.search';
		$RESPONSE_FORMAT = 'php_serial';
		$PER_PAGE = 5;

		$defquery = "hello world";
		if (!$query) {
			$query = $defquery;
		}
		$query = urlencode(urldecode($query));

		$params = array('api_key' => $API_KEY, 'method' => $SEARCH_METHOD, 'format' => $RESPONSE_FORMAT, 'per_page' => $PER_PAGE, 'page' => $page, 'text' => $query);

		App::uses('HttpSocket', 'Network/Http');
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket -> get($BASE_URL, $params);

		$res = unserialize($response -> body);

		$this -> autoRender = false;
		echo json_encode($res);
	}
	
	/**
	 * View the selected image. Add a pointer to the photo's page on Flickr
	 * 
	 * $id integer photo id. mandatory.
	 */
	public function view($id) {
		$API_KEY = 'FLICKR_API_CODE';

		$BASE_URL = 'http://api.flickr.com/services/rest/?';
		$VIEW_METHOD = 'flickr.photos.getInfo';
		$RESPONSE_FORMAT = 'php_serial';
		
		$params = array('api_key' => $API_KEY, 'method' => $VIEW_METHOD, 'format' => $RESPONSE_FORMAT, 'photo_id' => $id);

		App::uses('HttpSocket', 'Network/Http');
		$HttpSocket = new HttpSocket();
		$response = $HttpSocket -> get($BASE_URL, $params);

		$res = unserialize($response -> body);
		
		$photourl = 'http://farm' . $res['photo']['farm'] . '.staticflickr.com/' . $res['photo']['server'] . '/' . $id . '_' . $res['photo']['secret'] . '_z.jpg';
		
		if ($res['stat'] == 'ok'){
			$this -> set('phototitle', $res['photo']['title']['_content']);
			$this -> set('photourl', $photourl);
			$this -> set('photodesc', $res['photo']['description']['_content']);
			$this -> set('photopage', 'http://www.flickr.com/photos/'.$res['photo']['owner']['nsid'].'/'.$id);
		} else {
			$this -> set('message', 'fail'); 
		}
	}

}
