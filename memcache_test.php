<?php

/**
* Memcache Test örneği
*/
class MemcacheTest
{
	protected $memcache;

	private $host;
	private $port;

	public $status = NULL;

	protected $messages = array();
	
	public function __construct()
	{
		$this->messages = array(
			'connection' => array(
				'error' => 'Bağlantı yapılamıyor.',
				'success' => 'Bağlantı başarılı.' 
			),
			'not_found' => 'Sayfa yok!'
		);

		$this->host = '127.0.0.1';
		$this->port = '11211';

		$this->memcache = new Memcache();
	}

	private function memcacheConnect()
	{
		if (!$this->memcache->connect($this->host, $this->port)) 
		{
			$this->status = FALSE;
			throw new Exception($this->messages['connection']['error']);
		}
		$this->status = TRUE;
	}

	public function parseURL()
	{
		$server = $_SERVER;

		$url = preg_replace('/'.str_replace('/', '\/', $server['SCRIPT_NAME']).'\/?/', '', $server['REQUEST_URI']);

		$method = str_replace(' ', '', ucwords(str_replace('-', ' ', $url)));
		
		$prefix = 'get';

		if ($method == null) { $method = 'Index'; }

		$method = $prefix.$method;

		if (!method_exists($this, $method)) 
		{
			throw new Exception($this->messages['not_found']);
		}

		call_user_func_array(array($this,$method),array());
	}

	public function run()
	{
		$this->memcacheConnect();
		$this->parseURL();
	}

	public function getIndex()
	{
		$test = $this->memcache->get('test');

		if ($test) { $test = unserialize($test); }

		var_dump($test);
	}

	public function getSetTest()
	{
		$last = $this->memcache->get('test');
		
		if ($last) { $last = unserialize($last); }
		else { $last = array(); }

		srand(time());

		$last[] = rand(0,100);

		var_dump(end($last)); 
		
		$this->memcache->set('test', serialize($last));
	}
}


try 
{
	$app = new MemcacheTest();
	$app->run();
} 
catch (Exception $e) 
{
	echo '<center><h2>HATA MESAJI</h2><hr>'.$e->getMessage().'</center>';
}
