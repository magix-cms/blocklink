<?php
/*
 # -- BEGIN LICENSE BLOCK ----------------------------------
 #
 # This file is part of MAGIX CMS.
 # MAGIX CMS, The content management system optimized for users
 # Copyright (C) 2008 - 2013 magix-cms.com <support@magix-cms.com>
 #
 # OFFICIAL TEAM :
 #
 #   * Gerits Aurelien (Author - Developer) <aurelien@magix-cms.com> <contact@aurelien-gerits.be>
 #
 # Redistributions of files must retain the above copyright notice.
 # This program is free software: you can redistribute it and/or modify
 # it under the terms of the GNU General Public License as published by
 # the Free Software Foundation, either version 3 of the License, or
 # (at your option) any later version.
 #
 # This program is distributed in the hope that it will be useful,
 # but WITHOUT ANY WARRANTY; without even the implied warranty of
 # MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 # GNU General Public License for more details.

 # You should have received a copy of the GNU General Public License
 # along with this program.  If not, see <http://www.gnu.org/licenses/>.
 #
 # -- END LICENSE BLOCK -----------------------------------

 # DISCLAIMER

 # Do not edit or add to this file if you wish to upgrade MAGIX CMS to newer
 # versions in the future. If you wish to customize MAGIX CMS for your
 # needs please refer to http://www.magix-cms.com for more information.
 */
 /**
 * MAGIX CMS
 * @category   advantage
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2015 Gerits Aurelien,
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * Author: Salvatore Di Salvo
 * Date: 03-03-16
 * Time: 14:53
 * @name blocklink
 * Le plugin blocklink
 */
class plugins_blocklink_public extends database_plugins_blocklink{
    /**
     * @var frontend_controller_plugins
     */
    protected $template;
    /**
     * Class constructor
     */
    public function __construct(){
        $this->template = new frontend_controller_plugins();
    }

    /**
     * @return array
     */
    public function getLinks(){
        $iso = $this->template->getLanguage();

        if($iso == null) {
            $default = parent::getDefaultLang();
            $iso = $default['iso'];
        }

        $links = parent::g_links($iso);
        if($links != null){
            return $links;
        }

    }
}
class database_plugins_blocklink{
    /**
     * Vérifie si les tables du plugin sont installé
     * @access protected
     * return integer
     */
    protected function c_show_table(){
        $table = 'mc_plugins_blocklink';
        return frontend_db_plugins::layerPlugins()->showTable($table);
    }

    /**
     * Get the default language
     * @return array
     */
    protected function getDefaultLang()
    {
        $query = "SELECT iso FROM mc_lang WHERE default_lang = 1 ";

        return magixglobal_model_db::layerDB()->selectOne($query);
    }

    /**
     * @param $iso
     * @return array
     */
    protected function g_links($iso)
    {
        $query = 'SELECT link.* FROM mc_plugins_blocklink as link
                JOIN mc_lang AS lang ON(link.idlang = lang.idlang)
                WHERE lang.iso = :iso ORDER BY lorder';

        return magixglobal_model_db::layerDB()->select($query,array(
            ':iso'=>$iso
        ));
    }
}
?>