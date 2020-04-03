<?php
namespace Illuminate\Pipeline;


class Pipeline{
	
	protected $passable;

	protected $pipes = [];

	protected $method = 'handle';

	//定义通过管道的对象
	public function send($passable){
		$this->passable = $passable;
		
		return $this;
	}
	//定义所需的管道
	public function through($pipes){
		$this->pipes = $pipes;
		return $this;
	}
	//具体执行管道
	public function then(){
		//闭包的顺序是按照管道顺序从内到外，执行顺序相当于管道顺序的倒序，故要转换管道顺序，执行的顺序与定义的管道顺序一致
		$pipes = array_reverse($this->pipes);
		$call_back = array_reduce($pipes,$this->getSlice(),function(){});
		if(!is_null($call_back)){
				return call_user_func(
				$call_back,$this->passable
			);
		}

	}
	//返回中间件闭包
	public function getSlice(){
		return function($stack,$pipe){
			return function($passable) use ($stack,$pipe){
				$pipe::handle($passable,$stack);
			};
		}; 
	}

	
}