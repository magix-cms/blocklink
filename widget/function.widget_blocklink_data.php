<?php
function smarty_function_widget_blocklink_data($params, $template){
    plugins_Autoloader::register();
    $collection = new plugins_blocklink_public();

    $template->assign('links',$collection->getLinks());;
}
?>