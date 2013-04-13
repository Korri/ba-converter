<?php



/**

 * Smarty plugin

 */



/**

 * Smarty {l} compiler plugin

 *

 * Type:     compiler

 * Name:     lang

 * @author:  Trimo, Korri

 * @mail:     trimo.1992[at]gmail[dot]com

 */

class smarty_compiler_l {
    public function compile($params, &$smarty) {
	$key = $params[0];

        return "<?php echo lang($key); ?>";
    }
}



?>