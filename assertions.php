<?php
namespace assertions;

/*
$assert = new assert;
$assert->this("car")->is->a("car"); 
$assert->this($var)->is->equleto($var2)->and()->lessthen("300"); 
$assert->this($object)->has->a("get_var")->method()->which->has->a("setting")->property()->which->returns->a->report();

*/


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

	public $is = new is($item);
	public $isnot = new isnot($item);
	public $has = new has($item);
	public $hasnot= new hasnot($item);
	

	public function __construct($item){
		$this->item = $item;
	}
	
	public function returns($function){
		return new returns($this->item,$function);
	}

}

class returns{
	private $returns;

	public function __construct($item,$value){
		$args = func_get_args();
		for ($x=0; $x<2; $x++){

			unset($args[$x]);
		}
		$args = array_values($args);

		$returns =call_user_func_array(array($item,$value),$args);
		
		return new this($returns);
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
				return new true($this->item,"is");
			}
		}
		catch(return new false($this->item,$E,"is")}
	}

	public function Greaterthen($value){
		try{
			if ($this->item <= $value){
				throw new  Exception("this is not greater then".$value);
			}
			else{
				return new true($this->item,"is");
			}
		}
		catch(return new false($this->item,$E,"is")}
	}

	public function lessthen($value){
		try{
			if ($this->item >= $value){
				throw new  Exception("this is less then".$value);
			}
			else{
				return new true($this->item,"is");
			}
		}
		catch(return new false($this->item,$E,"is")}
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
				return new true($this->item,"isnot");
			}
		}
		catch(return new false($this->item,$E,"isnot")}
	}

	public function Greaterthen($value){
		try{
			if ($this->item > $value){
				throw new  Exception("this is greater then".$value);
			}
			else{
				return new true($this->item,"isnot");
			}
		}
		catch(return new false($this->item,$E,"isnot")}}
	}

	public function lessthen($value){
		try{
			if ($this->item < $value){
				throw new  Exception("this is less then".$value);
			}
			else{
				return new true($this->item,"isnot");
			}
		}
		catch(return new false($this->item,$E,"isnot")}
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

	public function __construct($item,$value,$operator){
		$this->item = $item;
		$this->value = $value;
		$this->operator = $overator;

		if($operator == "is"){
			$this->is($value);
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
						return new true($this->item,"has");
					}
					break;

				case 'doesNotHave':
					if(property_exists($this->item,$value)){
						throw Exception("property does exist");
					}
					else{
						return new true($this->item,"doesNotHave");
					}
					break;
				
				default:
					throw Exception("invalid operator");
					break;
			}
			}
		}
		catch(return new false($this->item,$E,$this->operator)}
	}

	public function method(){
		try{
			switch ($this->operator) {
				case 'has':
					if(!method_exists($this->item,$value)){
						throw Exception("Method does not exist");
					}
					else{
						return new true($this->item,"has");
					}
					break;

				case 'doesNotHave':
					if(method_exists($this->item,$value)){
						throw Exception("Method does exist");
					}
					else{
						return new true($this->item,"doesNotHave");
					}
					break;
				
				default:
					throw Exception("invalid operator");
					break;
			}	
		}
		catch(return new false($this->item,$E,$this->operator)}
	}

	private function isnot($value){
		$value = string($value);
		try{
		switch ($value) {
			case 'string': 
				if(gettype($this->item) == 'string'){
					throw new Exception('This is a string',1);
				}
				else{
					return new true($this->item,"isnot");
				}
				break;


   			case "boolean": 
				if(gettype($this->item) == "boolean"){
					throw new Exception('This is a boolean',);
				}
				else{
					return new true($this->item,"isnot");
				}
				break;

   			case "integer": 
				if(gettype($this->item) == "integer"){
					throw new Exception('This is a integer');
				}
				else{
					return new true($this->item,"isnot");
				}
				break;

   			case "double" : 
				if(gettype($this->item) == "double"){
					throw new Exception('This is a double');
				}
				else{
					return new true($this->item,"isnot");
				}
				break;

   			case "float": 
				if(gettype($this->item) == "double"){
					throw new Exception('This is a float');
				}
				else{
					return new true($this->item,"isnot");
				}
				break;
   			case "string": 
				if(gettype($this->item) == "string"){
					throw new Exception('This is a string');
				}
				else{
					return new true($this->item,"isnot");
				}
				break;

   			case "array": 
				if(gettype($this->item) == "array"){
					throw new Exception('This is a array');
				}
				else{
					return new true($this->item,"isnot");
				}
				break;

   			case "object": 
				if(gettype($this->item) == "object"){
					throw new Exception('This is a object');
				}
				else{
					return new true($this->item,"isnot");
				}
				break;

   			case "resource": 
				if(gettype($this->item) == "resource"){
					throw new Exception('This is a resource');
				}
				else{
					return new true($this->item,"isnot");
				}
				break;
   
			
			default:
				if(!($this->item instanceof $type)){
					throw new Exception('This is a inctance of '.$type);

				}
				else{
					return new true($this->item,"isnot");
				}
				break;
		}
		catch(return new false($this->item,$E,"isnot")}
	}

	private function is($value){
		$value = string($value);
		try{
		switch ($value) {
			case 'string': 
				if(gettype($this->item) != 'string'){
					throw new Exception('This is not a string');
				}
				else{
					return new true($this->item,"is");
				}
				break;


   			case "boolean": 
				if(gettype($this->item) != "boolean"){
					throw new Exception('This is not a boolean',);
				}
				break;

   			case "integer": 
				if(gettype($this->item) != "integer"){
					throw new Exception('This is not a integer');
				}
				else{
					return new true($this->item,"is");
				}
				break;

   			case "double" : 
				if(gettype($this->item) != "double"){
					throw new Exception('This is not a double');
				}
				else{
					return new true($this->item,"is");
				}
				break;

   			case "float": 
				if(gettype($this->item) != "double"){
					throw new Exception('This is not a float');
				}
				else{
					return new true($this->item,"is");
				}
				break;
   			case "string": 
				if(gettype($this->item) != "string"){
					throw new Exception('This is not a string');
				}
				else{
					return new true($this->item,"is");
				}
				break;

   			case "array": 
				if(gettype($this->item) != "array"){
					throw new Exception('This is not a array');
				}
				else{
					return new true($this->item,"is");
				}
				break;

   			case "object": 
				if(gettype($this->item) != "object"){
					throw new Exception('This is not a object');
				}
				else{
					return new true($this->item,"is");
				}
				break;

   			case "resource": 
				if(gettype($this->item) != "resource"){
					throw new Exception('This is not a resource');
				}
				else{
					return new true($this->item,"is");
				}
				break;
   
			
			default:
				if(!($this->item instanceof $type)){
					throw new Exception('This is not a inctance of '.$type);

				}
				else{
					return new true($this->item,"is");
				}
				break;
		}
		catch(return new false($this->item,$E,"is")}
	}
}

class false{
	private $item, $class, $e;
	public  $which;

	public function __construct($item,$e,$class){
		$this->item = $item;
		$this->class = $class;
		$this->$e = $e;
	}

	public function or(){
		return new $this->class($this->item);
	}

	public function report(){
		Error:: register($this->e);
	}

}

class true{

	private $item, $class, $function;
	public  $which;

	public function __construct($item,$class,$function=null){
		$this->item = $item;
		$this->class = $class;
		$this->function = $function;
		$this->which = new this($item);
	}

	public function and(){
		return new $this->class($this->item);
	}
			
	}
	public function report(){
		
	}

}



?>
