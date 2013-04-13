<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// set spark version
define('SMARTYVIEW_VERSION', '0.0.1');

// get smarty lib
require_once __DIR__ . '/../vendor/Smarty.class.php';
// main class
class SmartyParser
{

	/**
	 * Smarty instance
	 * @var Smarty
	 */
	public $smarty;

	/**
	 * Contruct
	 * @param $config
	 */
	public function __construct($config)
	{
		// setup the object
		$this->smarty = new Smarty();

		$this->smarty->template_dir = $config['smarty_template_dir'];
		$this->smarty->compile_dir = $config['smarty_compile_dir'];
		$this->smarty->cache_dir = $config['smarty_cache_dir'];
		$this->smarty->cache_lifetime = $config['smarty_cache_lifetime'];
		$this->smarty->caching = $config['smarty_cache_status'];
		$this->smarty->force_compile = $config['smarty_force_compile'];

		//Add a plugin dir
		if (isset($config['smarty_plugin_dir'])) {
			$this->smarty->addPluginsDir($config['smarty_plugin_dir']);
		}
	}

	/**
	 * @param string $template Template url to parse
	 * @param array $data Data that will be assigned to the template
	 * @param boolean $data Return content (true) or append it to Codeigniter content (false)
	 */
	public function parse($template, $data = array(), $return=false)
	{
		// get codeigniter object
		$CI =& get_instance();

		// assign template variables
		$this->smarty->assign($data);
		$this->smarty->assign('CI', $CI);

		// output the template
		$output = $this->smarty->fetch($template);
		if($return) {
			return $output;
		}
		$CI->output->append_output($output);

		//Clear all assigns, just in case there was another call to parse
		$this->smarty->clearAllAssign();
	}

}