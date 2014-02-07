<?php
namespace assertions;


$assert = new assert;
$assert->this("10")->is->a("string")->report; 
//$assert->this($var)->is->equleto($var2)->and()->lessthen("300")->report(); 
//$assert->this($object)->has->a("get_var")->method()->and->has->a("setting")->property()->and->method("get_var".)->returns->a("string")->report();
//$assert->this($object)->method("get_var")->returns->a("value")->of(10)->report();




class Error{
	private static $Errors = array();
	
	public static function register($e){
		$self::$Errorsp[] = $e->getMessage()."\n";
	}
	public static function get_errors(){
		echo $self::$Errors;
	}
}

class assert{
	private $error;
	public function __construct(){

	}

	public function this($item){
		return new this($item);
	}
}

class this{
	private $item;

	public $is,$isnot,$has,$hasnot;
	

	public function __construct($item){
		$this->item = $item;
		$this->is = new is($item);
		$this->isnot = new isnot($item);
		$this->has = new has($item);
		$this->hasnot= new doesNotHave($item);
	}
	
	public function method($function){
		$args = func_get_args();
				unset($args[1]);
		$args = array_values($args);
		return new method($this->item,$function,$args);
	}

}

class method{
	public $returns;

	public function __construct($item,$function,$args){
		
		$this->returns = new returns($item,$function,$args);

	}

}

class returns{
	private $returns;

	public function __construct($item,$value){
		

		$this->returns =call_user_func_array(array($item,$value),$args);
		
	}

	public function a($type){
		return new a($this->returns, $type, "returns");
	}

}

class is{
	private $item;

	function __construct($item){$this->item = $item;}


	public function a($type){
		return new a($this->item, $type, "is");
	}

	public function equleto($value){
		try{
			if($this->item !== $value){
				throw new Exception("this is not equle to ".$value);
			}
			else{
				return new istrue($this->item,"is");
			}
		}
		catch(Exception $e){
			return new isfalse($this->item,$E,"is");
		}
	}

	public function Greaterthen($value){
		try{
			if ($this->item <= $value){
				throw new  Exception("this is not greater then".$value);
			}
			else{
				return new istrue($this->item,"is");
			}
		}
		catch(Exception $e){return new isfalse($this->item,$E,"is");}
	}

	public function lessthen($value){
		try{
			if ($this->item >= $value){
				throw new  Exception("this is less then".$value);
			}
			else{
				return new istrue($this->item,"is");
			}
		}
		catch(Exception $e){return new isfalse($this->item,$E,"is");}
	}
}

class isnot{
	private $item;

	function __construct($item){$this->item = $item;}

	public function a($type){
		return new a($this->item, $type, "isnot");
	}

	public function equleto($value){
		try{
			if($this->item == $value){
				throw new Exception("this is equle to ".$value);
			}
			else{
				return new istrue($this->item,"isnot");
			}
		}
		catch(Exception $e){return new isfalse($this->item,$E,"isnot");}
	}

	public function Greaterthen($value){
		try{
			if ($this->item > $value){
				throw new  Exception("this is greater then".$value);
			}
			else{
				return new istrue($this->item,"isnot");
			}
		}
		catch(Exception $e){return new isfalse($this->item,$E,"isnot");}
	}

	public function lessthen($value){
		try{
			if ($this->item < $value){
				throw new  Exception("this is less then".$value);
			}
			else{
				return new istrue($this->item,"isnot");
			}
		}
		catch(Exception $e){return new isfalse($this->item,$E,"isnot");}
	}
}

class has{
	private $item;

	public function __construct($item){	$this->item = $item;}

	public function a($value){	return new a($this->item, $value, "has");}
}

class doesNotHave{
	private $item;

	public function __construct($item){$this->item = $item;}

	public function a($value){
		return new a($this->item, $value, "doesNotHave");
	}
}

class a{
	private $item,$value,$operator;
	public $report;

	public function __construct($item,$value,$operator){
		$this->item = $item;
		$this->value = $value;
		$this->operator = $operator;

		if($operator == "is"){
			$this->is($value,$operator);
		}

		if($operator == "returns"){
			$this->returns($value);
		}

		if($operator == "isnot"){
			$this->isnot($value);
		}


	}

	public function property(){
		try{
			switch ($this->operator) {
				case 'has':
					if(!property_exists($this->item,$value)){
						throw Exception("property does not exist");
					}
					else{
						return new istrue($this->item,"has");
					}
					break;

				case 'doesNotHave':
					if(property_exists($this->item,$value)){
						throw Exception("property does exist");
					}
					else{
						return new istrue($this->item,"doesNotHave");
					}
					break;
				
				default:
					throw Exception("invalid operator");
					break;
			}
			}
		
		catch(Exception $e){return new isfalse($this->item,$E,$this->operator);}
	}

	public function method(){
		try{
			switch ($this->operator) {
				case 'has':
					if(!method_exists($this->item,$value)){
						throw Exception("Method does not exist");
					}
					else{
						return new istrue($this->item,"has");
					}
					break;

				case 'doesNotHave':
					if(method_exists($this->item,$value)){
						throw Exception("Method does exist");
					}
					else{
						return new istrue($this->item,"doesNotHave");
					}
					break;
				
				default:
					throw Exception("invalid operator");
					break;
			}	
		}
		catch(Exception $e){return new isfalse($this->item,$E,$this->operator);}
	}

	private function isnot($value){
		$value = (string)$value;
		try{
		switch ($value) {
			case 'string': 
				if(gettype($this->item) == 'string'){
					throw new Exception('This is a string');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;


   			case "boolean": 
				if(gettype($this->item) == "boolean"){
					throw new Exception('This is a boolean');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;

   			case "integer": 
				if(gettype($this->item) == "integer"){
					throw new Exception('This is a integer');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;

   			case "double" : 
				if(gettype($this->item) == "double"){
					throw new Exception('This is a double');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;

   			case "float": 
				if(gettype($this->item) == "double"){
					throw new Exception('This is a float');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;
   			case "string": 
				if(gettype($this->item) == "string"){
					throw new Exception('This is a string');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;

   			case "array": 
				if(gettype($this->item) == "array"){
					throw new Exception('This is a array');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;

   			case "object": 
				if(gettype($this->item) == "object"){
					throw new Exception('This is a object');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;

   			case "resource": 
				if(gettype($this->item) == "resource"){
					throw new Exception('This is a resource');
				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;
   
			
			default:
				if(!($this->item instanceof $type)){
					throw new Exception('This is a inctance of '.$type);

				}
				else{
					return new istrue($this->item,"isnot");
				}
				break;
		}}
		catch(Exception $e){return new isfalse($this->item,$E,"isnot");}
	}

	private function is($value){
		$value = (string)$value;
		try{
		switch ($value) {
			case 'string': 
				if(gettype($this->item) != 'string'){
					throw new Exception('This is not a string');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;


   			case "boolean": 
				if(gettype($this->item) != "boolean"){
					throw new Exception('This is not a boolean');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;

   			case "integer": 
				if(gettype($this->item) != "integer"){
					throw new Exception('This is not a integer');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;

   			case "double" : 
				if(gettype($this->item) != "double"){
					throw new Exception('This is not a double');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;

   			case "float": 
				if(gettype($this->item) != "double"){
					throw new Exception('This is not a float');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;
   			case "string": 
				if(gettype($this->item) != "string"){
					throw new Exception('This is not a string');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;

   			case "array": 
				if(gettype($this->item) != "array"){
					throw new Exception('This is not a array');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;

   			case "object": 
				if(gettype($this->item) != "object"){
					throw new Exception('This is not a object');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;

   			case "resource": 
				if(gettype($this->item) != "resource"){
					throw new Exception('This is not a resource');
				}
				else{
					return new istrue($this->item,"is");
				}
				break;
   
			
			default:
				if(!($this->item instanceof $type)){
					throw new Exception('This is not a inctance of '.$type);

				}
				else{
					return new istrue($this->item,"is");
				}
				break;
		}}
		catch(Exception $e){return new isfalse($this->item,$E,"is");}
	}

	private function returns($value){
		$value = (string)$value;
		try{
		switch ($value) {
			case 'string': 
				if(gettype($this->item) != 'string'){
					throw new Exception('This doesn\'t return a string');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;


   			case "boolean": 
				if(gettype($this->item) != "boolean"){
					throw new Exception('This doesn\'t return a boolean');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;

   			case "integer": 
				if(gettype($this->item) != "integer"){
					throw new Exception('This doesn\'t return a integer');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;

   			case "double" : 
				if(gettype($this->item) != "double"){
					throw new Exception('This doesn\'t return a double');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;

   			case "float": 
				if(gettype($this->item) != "double"){
					throw new Exception('This doesn\'t return a float');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;
   			case "string": 
				if(gettype($this->item) != "string"){
					throw new Exception('This doesn\'t return a string');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;

   			case "array": 
				if(gettype($this->item) != "array"){
					throw new Exception('This doesn\'t return a array');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;

   			case "object": 
				if(gettype($this->item) != "object"){
					throw new Exception('This doesn\'t return a object');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;

   			case "resource": 
				if(gettype($this->item) != "resource"){
					throw new Exception('This doesn\'t return a resource');
				}
				else{
					return new istrue($this->item,"returns");
				}
				break;
			case "value":
				return new value($this->item);
				break;
   
			
			default:
				if(!($this->item instanceof $type)){
					throw new Exception('This doesn\'t return a inctance of '.$type);

				}
				else{
					return new istrue($this->item,"returns");
				}
				break;
		}}
		catch(Exception $e){return new isfalse($this->item,$E,"returns");}
	}
}

class value{
	private $item;
	public function __construct($item){
		$this->item = $item;
	}

	public function of($value){
		try{
			if($this->item != $value){
				throw new Exception("This doesn't return ".$value);
			}
		}
		catch(Exception $e){return new isfalse($this->item,$E,$this->operator);}
	}
}

class isfalse{
	private $item, $class, $e;
	public  $which;

	public function __construct($item,$e,$class){
		$this->item = $item;
		$this->class = $class;
		$this->$e = $e;
		echo "isfalse \n";
	}

	public function _or(){
		return new $this->class($this->item);
	}

	public function _and(){
		return new $this->item;
	}

	public function report(){
		Error:: register($this->e);
	}

}

class istrue{

	private $item, $class, $function;
	public  $which, $report;

	public function __construct($item,$class,$function=null){
		$this->item = $item;
		$this->class = $class;
		$this->function = $function;
		$this->which = new this($item);
		$this->report = new report(true);
		
	}

	public function _or(){
		return $this->item;
	}

	public function _and(){
		return new $this->class($this->item);
	}
			

}

class report{

	public function __construct($valid,$e=null){
		if (!$valid){
			Error:: register($this->e);
		}
		else{
			echo "passed";
		}
	}
}



?>
