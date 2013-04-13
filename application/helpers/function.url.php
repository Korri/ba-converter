<?php

/**
 * Smarty plugin
 */

/**
 * Smarty {url} function plugin
 *
 * Type:     function
 * Name:     url
 * @author:  Trimo, Korri
 * @mail:     trimo.1992[at]gmail[dot]com
 */
function smarty_function_url($params, &$smarty) {
    $CI = &get_instance();
    if (!function_exists('current_url')) {
        if (!function_exists('get_instance')) {
            $smarty->trigger_error("url: Cannot load CodeIgniter");
            return '--Cannot load CodeIgniter--';
        }
        $CI->load->helper('url');
    }
    
    if(isset($params['type']) && $params['type'] == 'urltitle' && !isset($params['title'])) {
        $smarty->trigger_error('Parameter "title" is required for type "urltitle"');
            return '--Parameter "title" is required for type "urltitle"--';
    }else if(!isset($params['url']) && isset($params['type']) && $params['type'] != 'current' && $params['type'] != 'static' && $params['type'] != 'base') {
        $smarty->trigger_error('Parameter "url" is required for type "'.$params['type'].'"');
            return '--Parameter "url" is required for type "'.$params['type'].'"--';
    }
    $params['type'] = isset($params['type']) ? $params['type'] : '';
    switch ($params['type']) {
        case 'string':
            return uri_string();
        case 'anchor':
            return anchor($params['url'], $params['text'], $params['attr']);
        case 'safemail':
            return safe_mailto($params['url'], $params['text'], $params['attr']);
        case 'mail':
            return mailto($params['url'], $params['text'], $params['attr']);
        case 'autolink':
            return auto_link($params['url'], (isset($params['mode'])) ? $params['mode'] : 'both', ($params['new'] == 1) ? TRUE : FALSE);
        case 'urltitle':
            return url_title($params['title'], (isset($params['mode'])) ? $params['mode'] : 'dash', ($params['lower'] == 1) ? TRUE : FALSE);
        case 'prep':
            return prep_url($params['url']);
        case 'current':
            return current_url();
        case 'current_class':
            $current = $CI->uri->segment(1);
            if(!$current) $current = 'index';
            return $current == $params['url'] ? $params['class'] : '';
        case 'assets':
            return base_url().'assets/'.(isset($params['url'])?$params['url'].'/':'');
        case 'base':
            return base_url();
        case 'site':
        default:
            if (isset($params['url'])) {
                return site_url($params['url']);
            } else {
                return site_url('/');
            }
    }
}

?>