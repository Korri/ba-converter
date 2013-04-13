<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

// config for smarty template library
// more info about these settings at http://www.smarty.net/docs/en/installing.smarty.basic.tpl

//Base folder for all your templates
$config['smarty_template_dir']		= APPPATH.'views';
//Where templates will be compiled to
$config['smarty_compile_dir']		= APPPATH.'cache/smarty/compiled';
//Where templates will be cached to
$config['smarty_cache_dir']			= APPPATH.'cache/smarty/cached';
// Smarty caching, 0 = off, 1 or 2 = on
$config['smarty_cache_status']		= ENVIRONMENT == 'development' ? 0 : 1;
// Cache lifetime. Default value is 3600 seconds (1 hour) Smarty's default value
$config['smarty_cache_lifetime']	= 3600;
// Force compile, default to on for development environment
$config['smarty_force_compile']		= ENVIRONMENT == 'development';
// Check if template changed, in production templates shoud not change
$config['smarty_compile_check']		= ENVIRONMENT != 'production';
// Need custom plugins for you application, default to "application/helpers/"
$config['smarty_plugin_dir'] 		= APPPATH.'helpers';