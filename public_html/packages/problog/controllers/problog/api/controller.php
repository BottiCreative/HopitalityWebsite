<?php     
defined('C5_EXECUTE') or die(_("Access Denied.")); 

class ProblogApiController extends Controller {

	private $request_vars;
	private $data;
	private $http_accept;
	private $method;
	
	public function on_page_view(){

	}
	
	public function view($method=null,$id = null){
		
		$request_method = strtolower($_SERVER['REQUEST_METHOD']);
		
		if($request_method == 'put' || $request_method == 'delete'){
			// Make a blank array called $_PUT
			$_REQUEST = array();
			// Read contents from the standard input buffer
			//covert to $_PUT
			parse_str(file_get_contents("php://input"),$_REQUEST);
		}
	

		$by = ($id) ? 'ByID' : '';
		
		$this->data = $_REQUEST;
		$this->method = $request_method;
		
		$this->loadRequiredModels();

		switch($request_method){
			case 'get':
				if($this->allowedMethods($method)){			
					if(substr_count($method,'Custom') > 0){
	
						//Custom->model,Custom->method,Custom->package
						$auth = pbApiAuthenticate::checkToken($_REQUEST['token']);
						if($auth['id']) {
							$model = $_REQUEST['model'];
							$package = $_REQUEST['package'];
							$class = $_REQUEST['class'];
							$func = $_REQUEST['funct'];
							
							Loader::model($model,$package);
							
							$call_object = new $class();
							
							if(is_array($_REQUEST['filters'])){
								foreach($_REQUEST['filters'] as $filter){
									$column = $filter['column'];
									$modifier = $filter['modifier'];
									$value = $filter['value'];
									$string = "$column $modifier '$value'";
									$call_object->filter(false,"$string");
								}
							}
							
							if($func){
								$call_response = $call_object->$func($_REQUEST['value'],$auth);
							}else{
								$call_response = $call_object;
							}
						}else{
							$this->getResponse('401',$auth['error']);
							exit;
						}
						
					}elseif(substr_count($method,'Authenticate') > 0){
					
						$call_response = pbApiAuthenticate::generateToken($_REQUEST['user'],$_REQUEST['pass'],$_REQUEST['group']);
						
					}
					
					$this->getResponse('200',$call_response);
					exit;
				}else{
					$this->getResponse('405','ERROR: this method is not allowed');
					exit;
				}
				break;
				
			case 'put':

				if($this->allowedMethods($method)){	
					$auth = pbApiAuthenticate::checkToken($_REQUEST['token']);
					if($auth['id']) {
						if(substr_count($method,'Custom') > 0){
				
							$model = $_REQUEST['model'];
							$package = $_REQUEST['package'];
							$class = $_REQUEST['class'];
							$func = $_REQUEST['funct'];
							
							Loader::model($model,$package);
							
							$call_object = new $class();
							
							if($func){
								$call_response = $call_object->$func($_REQUEST['value']);
							}else{
								$call_response = $call_object;
							}

						}
 						
 						$this->getResponse('200',$call_response);

					}else{
						$this->getResponse('401',$auth['error']);
						exit;
					}
					

				}else{
					$this->getResponse('405','ERROR: this method is not allowed');
					exit;
				}
				
				break;
				
			case 'delete':
				if(substr_count($method,'Custom') > 0){
	
					//Custom->model,Custom->method,Custom->package
					$auth = pbApiAuthenticate::checkToken($_REQUEST['token']);
					if($auth['id']) {
						$model = $_REQUEST['model'];
						$package = $_REQUEST['package'];
						$class = $_REQUEST['class'];
						$func = $_REQUEST['funct'];
						
						Loader::model($model,$package);
						
						$call_object = new $class();
						
						if($func){
							$call_response = $call_object->$func($_REQUEST['value']);
						}else{
							$call_response = $call_object;
						}
						
						$this->getResponse('200',$call_response);
					}else{
						$this->getResponse('401',$auth['error']);
						exit;
					}
					
				}
				
				break;
			
			case 'post':
				if($this->allowedMethods($method)){	
					if(substr_count($method,'Custom') > 0){
						//Custom->model,Custom->method,Custom->package
						$auth = pbApiAuthenticate::checkToken($_REQUEST['token']);
						if($auth['id']) {
							$model = $_REQUEST['model'];
							$package = $_REQUEST['package'];
							$class = $_REQUEST['class'];
							$func = $_REQUEST['funct'];
							
							Loader::model($model,$package);
							
							$call_object = new $class();
							
							if($func){
								$call_response = $call_object->$func($_REQUEST['value'],$auth);
							}else{
								$call_response = $call_object;
							}
							
							$this->getResponse('200',$call_response);
							
						}else{
							$this->getResponse('401',$auth['error']);
							exit;
						}
						
					}
				}else{
					$this->getResponse('405','ERROR: this method is not allowed');
					exit;
				}
				
				break;
			}
			
		exit;
	}
	
	private function getResponse($code=null,$response=null){
	
		switch($code){
			case '405':
				header('HTTP/1.1 405 Method Not Allowed'); 
				break;
			case '401':
				header('HTTP/1.1 401 Unauthorized'); 
				break;
			case '400':
				header('HTTP/1.1 400 Bad Request'); 
				break;
			case '230':
				header('HTTP/1.1 230 Authentication Successful'); 
				break;
			case '202':
				header('HTTP/1.1 202 Accepted'); 
				break;
			case '201':
				header('HTTP/1.1 201 Created'); 
				break;
			case '200':
				header('HTTP/1.1 200 OK'); 
				break;
		}
		
		if($_REQUEST['return'] == 'html'){
			print $response;
		}else{
			print @json_encode($response);
		}
		
	}
	
	
	private function allowedMethods($method){
		
		$method_list = array(
			'Authenticate',
			'Custom',
			'User',
			'UserInfo',
			'Page',
			'File',
			'UserList',
			'PageList',
			'FileList',
			'Group'
		);
		
		if(in_array($method,$method_list)){
			return true;
		}else{
			return false;
		}
		
	}

	
	private function requestConnect(){
		
		
	}
	
	private function loadRequiredModels(){
	    Loader::model('single_page');
	    Loader::model('collection');
	    Loader::model('page');
	    loader::model('block');
	    Loader::model('collection_types');
	    Loader::model('/attribute/categories/collection');
	    Loader::model('/attribute/categories/user');
	    Loader::model('page_list');
	    Loader::model('user');
	    Loader::model('user_list');
	    Loader::model('userinfo');
	    Loader::model('groups');
	    Loader::model('api/problog_api','problog');
	}

}

?>