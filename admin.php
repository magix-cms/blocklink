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
 * @category   blocklink
 * @package    plugins
 * @copyright  MAGIX CMS Copyright (c) 2008 - 2015 Gerits Aurelien,
 * http://www.magix-cms.com,  http://www.magix-cjquery.com
 * @license    Dual licensed under the MIT or GPL Version 3 licenses.
 * @version    2.0
 * Author: Salvatore Di Salvo
 * Date: 13-01-16
 * Time: 15:00
 * @name blocklink
 * Le plugin blocklink
 */
class plugins_blocklink_admin extends DBblocklink{
    /**
	 * 
	 * @var idadmin
	 */
	protected $template;
	public $idadmin;
	/**
	 * 
	 * @var idlang
	 */
	public $idlang;
	/**
	 * Les variables globales
	 */
	public $action,$tab,$getlang,$edit,$message;
	public $title, $blank, $ltype, $content, $url, $idlink, $order, $q, $type;
	public static $notify = array('plugin'=>'true','template'=>'message-blocklink.tpl','method'=>'display','assignFetch'=>'notifier');

    /**
	 * Construct class
	 */
	public function __construct(){
        if(class_exists('backend_model_message')){
            $this->message = new backend_model_message();
        }
        
        if(magixcjquery_filter_request::isGet('action')){
            $this->action = magixcjquery_form_helpersforms::inputClean($_GET['action']);
        }
        if(magixcjquery_filter_request::isGet('tab')){
            $this->tab = magixcjquery_form_helpersforms::inputClean($_GET['tab']);
        }
        if(magixcjquery_filter_request::isGet('getlang')){
            $this->getlang = magixcjquery_form_helpersforms::inputNumeric($_GET['getlang']);
        }
		if(magixcjquery_filter_request::isGet('edit')){
            $this->edit = magixcjquery_form_helpersforms::inputNumeric($_GET['edit']);
        }

		# ADD PAGE
		if(magixcjquery_filter_request::isPost('title')){
			$this->title = magixcjquery_form_helpersforms::inputClean($_POST['title']);
		}
		if(magixcjquery_filter_request::isPost('type')){
			$this->ltype = magixcjquery_form_helpersforms::inputClean($_POST['type']);
		}
		if(magixcjquery_filter_request::isPost('content')){
			$this->content = magixcjquery_form_helpersforms::inputClean($_POST['content']);
		}
		if(magixcjquery_filter_request::isPost('url')){
			$this->url = magixcjquery_form_helpersforms::inputClean($_POST['url']);
		}
		if(magixcjquery_filter_request::isPost('blank')){
			$this->blank = magixcjquery_form_helpersforms::inputClean($_POST['blank']);
		}

		# EDIT LINK
		if(magixcjquery_filter_request::isPOST('idlink')){
			$this->idlink = magixcjquery_form_helpersforms::inputNumeric($_POST['idlink']);
		}

		# DELETE LINK
		if(magixcjquery_filter_request::isPOST('delete')){
			$this->delete = magixcjquery_form_helpersforms::inputNumeric($_POST['delete']);
		}

		# ORDER LINK
		if(magixcjquery_filter_request::isPost('order')){
			$this->order = magixcjquery_form_helpersforms::arrayClean($_POST['order']);
		}

		// Ajax search
		if(magixcjquery_filter_request::isGet('search_type')){
			$this->type = magixcjquery_form_helpersforms::inputClean($_GET['search_type']);
		}
		if(magixcjquery_filter_request::isGet('q')){
			$this->q = magixcjquery_form_helpersforms::inputClean($_GET['q']);
		}

		$this->template = new backend_controller_plugins();
	}

	/**
	 * Retourne le message de notification
	 * @param $type
	 */
	private function notify($type){
		$this->message->getNotify($type,self::$notify);
	}

	/**
	 * @access private
	 * Installation des tables mysql du plugin
	 */
	private function install_table(){
		if(parent::c_show_table() == 0){
			$this->template->db_install_table('db.sql', 'request/install.tpl');
		}else{
			return true;
		}
	}

	/**
	 *
	 */
	public function save($type)
	{
		if( !empty($this->title) && !empty($this->url) ){
			$page = array(
				'idlang'	=> $this->getlang,
				'title' 	=> $this->title,
				'content' 	=> ( (isset($this->content) && !empty($this->content))?$this->content:NULL ),
				'url' 		=> $this->url,
				'blank' 	=> ( (isset($this->blank) && !empty($this->blank))?1:0 ),
				'ltype' 	=> $this->ltype
			);

			switch ($type) {
				case 'add':
					$c = parent::c_link($this->getlang);
					if ($c != null)
						$page['lorder'] = $c['nb'];
					else
						$page['lorder'] = 0;
							parent::i_link($page);
					break;
				case 'update':
					$page['id'] = $this->idlink;
					parent::u_link($page);
					break;
			}

			$this->notify('save');
		}
	}

	public function del()
	{
		parent::d_link($this->delete);
		$this->notify('delete');
	}

	/**
	 * Execute Update AJAX FOR order
	 * @access private
	 *
	 */
	private function update_order(){
		if(isset($this->order)){
			$p = $this->order;
			for ($i = 0; $i < count($p); $i++) {
				parent::u_order($i,$p[$i]);
			}
		}
	}

	/**
	 * Affiche les pages de l'administration du plugin
	 * @access public
	 */
	public function run(){
		if(self::install_table() == true){
			if (isset($this->tab) && $this->tab == 'about')
			{
				$this->template->display('about.tpl');
			}
			elseif (!isset($this->tab) || (isset($this->tab) && $this->tab == 'index'))
			{
				if(isset($this->action)) {
					if ($this->action == 'edit') {
						if ( isset($this->idlink) && is_numeric($this->idlink) && $this->idlink != '' ) {
							if ( isset($this->title) && isset($this->url) ) {
								$this->save('update');
							}
						} elseif ( isset($this->title) && isset($this->url) ) {
							$this->save('add');
						} elseif ( isset($this->edit) && is_numeric($this->edit) ) {
							$this->template->assign('link',parent::g_link($this->edit));
							$this->template->display('modal/edit.tpl');
						}
					} elseif ($this->action == 'delete') {
						if ( isset($this->delete) && is_numeric($this->delete) ) {
							$this->del();
						}
					} elseif ($this->action == 'order' && isset($this->order)) {
						$this->update_order();
					} elseif ($this->action == 'getlist') {
						$this->template->assign('links',parent::getLastlink($this->getlang));
						$this->template->display('loop/list.tpl');
					} elseif ($this->action == 'list') {
						$this->template->assign('links',parent::getlinks($this->getlang));
						$this->template->display('index.tpl');
					} elseif ($this->action == 'search') {
						if (isset($this->q) && isset($this->type)) {
							$results = parent::search($this->type,$this->q,$this->getlang);
							//var_dump($results);
							$iso = parent::getIso($this->getlang);
							$this->template->assign('iso',$iso['iso']);
							$this->template->assign('type',$this->type);
							$this->template->assign('search_results',$results);
							$this->template->display('loop/results.tpl');
						}
					}
				}
			}
		}
	}

    /**
     * Set Configuration pour le menu
     * @return array
     */
    public function setConfig(){
        return array(
            'url'=> array(
                'lang'=>'list',
                'action'=>'list',
                'name'=>'Bloc Liens'
            )
        );
    }
}
class DBblocklink{
    /**
	 * Vérifie si les tables du plugin sont installé
	 * @access protected
	 * return integer
	 */
	protected function c_show_table(){
		$table = 'mc_plugins_blocklink';
		return magixglobal_model_db::layerDB()->showTable($table);
	}

	/**
	 * @param $lang
	 * @return array
	 */
	protected function getIso($lang)
	{
		$query = "SELECT iso FROM mc_lang WHERE idlang = $lang";
		return magixglobal_model_db::layerDB()->selectOne($query);
	}

	// GET
	/**
	 * @param $idlang
	 * @return array
	 */
	protected function getLinks($idlang)
	{
		$query = "SELECT idlink as id, title, content, url, blank, ltype FROM mc_plugins_blocklink WHERE idlang = :idlang ORDER BY lorder";

		return magixglobal_model_db::layerDB()->select($query, array(
			':idlang' => $idlang
		));
	}

	/**
	 * @return array
	 */
	protected function getLastLink($idlang)
	{
		$query = "SELECT idlink as id, title, content, url, blank, ltype FROM `mc_plugins_blocklink` WHERE idlang = :idlang ORDER BY idlink DESC LIMIT 1";

		return magixglobal_model_db::layerDB()->select($query, array(
				':idlang' => $idlang
		));
	}

	/**
	 * @param $id
	 * @return array
	 */
	protected function g_link($id)
	{
		$query = "SELECT idlink as id, title, content, url, blank, ltype
				FROM mc_plugins_blocklink
				JOIN mc_lang USING(idlang)
				WHERE idlink = :id";

		return magixglobal_model_db::layerDB()->selectOne($query, array(
				':id' => $id
		));
	}

	/**
	 * @param $idlang
	 * @return array
	 */
	protected function c_link($idlang)
	{
		$query = "SELECT COUNT(idlink) as nb FROM mc_plugins_blocklink WHERE idlang = :idlang";

		return magixglobal_model_db::layerDB()->selectOne($query, array(
			':idlang' => $idlang
		));
	}

	// INSERT
	/**
	 * @param $page
	 */
	protected function i_link($page)
	{
		$query = "INSERT INTO mc_plugins_blocklink (idlang,title,content,url,blank,ltype,lorder) VALUES (:idlang,:title,:content,:url,:blank,:ltype,:lorder)";

		magixglobal_model_db::layerDB()->insert($query,array(
			':idlang'	=> $page['idlang'],
			':title'	=> $page['title'],
			':content'	=> $page['content'],
			':url'		=> $page['url'],
			':blank'	=> $page['blank'],
			':ltype'	=> $page['ltype'],
			':lorder'	=> $page['lorder']
		));
	}

	// UPDATE
	/**
	 * @param $page
	 */
	protected function u_link($page)
	{
		$query = "UPDATE mc_plugins_blocklink
				  SET
					idlang = :idlang,
					title = :title,
					content = :content,
					url = :url,
					blank = :blank,
					ltype = :ltype
				  WHERE idlink = :id";

		magixglobal_model_db::layerDB()->insert($query,array(
				':id'		=> $page['id'],
				':idlang'	=> $page['idlang'],
				':title'	=> $page['title'],
				':content'	=> $page['content'],
				':url'		=> $page['url'],
				':blank'	=> $page['blank'],
				':ltype'	=> $page['ltype']
		));
	}

	/**
	 * Met à jour l'ordre d'affichage des pages
	 * @param $i
	 * @param $id
	 */
	protected function u_order($i,$id){
		$sql = 'UPDATE mc_plugins_blocklink SET lorder = :i WHERE idlink = :id';
		magixglobal_model_db::layerDB()->update($sql,
			array(
				':i'=>$i,
				':id'=>$id
			)
		);
	}

	// DELETE
	/**
	 * @param $id
	 */
	protected function d_link($id)
	{
		$query = "DELETE FROM mc_plugins_blocklink WHERE idlink = :id";

		magixglobal_model_db::layerDB()->delete($query,array(':id'=>$id));
	}

	// AJAX SEARCH
	/**
	 * @param $type
	 * @param $str
	 * @param $idlang
	 * @return array
	 */
	protected function search($type, $str, $idlang)
	{
		$limit = 10;

		if ($type == 'cat')
		{
			$query = "SELECT
						`c`.`idclc` as parent,
						`c`.`pathclibelle` as uriparent,
						`c`.`clibelle` as nameparent,
						`s`.`idcls` as id,
						`s`.`slibelle` as name,
						`s`.`pathslibelle` as uri
					FROM `mc_catalog_c` as `c`
					LEFT JOIN `mc_catalog_s` as `s`
					ON `c`.`idclc` = `s`.`idclc`
					WHERE
						`c`.`idlang` = :idlang
					AND
						`s`.`slibelle` LIKE '%".addslashes($str)."%'
					ORDER BY `s`.`idcls`";
			$query .= ($limit?" LIMIT ".$limit:"");

			$data1 = magixglobal_model_db::layerDB()->select($query,array(':idlang' => $idlang));

			$query = "SELECT
						`c`.`idclc` as id,
						`c`.`clibelle` as name,
						`c`.`pathclibelle` as uri
					FROM `mc_catalog_c` as `c`
					WHERE
						`c`.`idlang` = :idlang
					AND
						`c`.`clibelle` LIKE '%".addslashes($str)."%'
					ORDER BY `c`.`idclc`";
			$query .= ($limit?" LIMIT ".$limit:"");

			$data2 = magixglobal_model_db::layerDB()->select($query,array(':idlang' => $idlang));

			return array_merge($data1,$data2);
		}
		elseif ($type == 'cms')
		{
			$query = "SELECT
							`p`.`idpage` as id,
							`p`.`title_page` as name,
							`p`.`uri_page` as uri,
							`p`.`idcat_p` as parent,
							`parent`.`uri_page` as `uriparent`,
							`parent`.`title_page` as `nameparent`
						FROM `mc_cms_pages` as `p`
						LEFT JOIN `mc_cms_pages` as `parent`
						ON `p`.`idcat_p` = `parent`.`idpage`
						WHERE
							`p`.`idlang` = :idlang
						AND
							`p`.`title_page` LIKE '%".addslashes($str)."%'
						ORDER BY `p`.`idpage`";
			$query .= ($limit?" LIMIT ".$limit:"");

			return magixglobal_model_db::layerDB()->select($query,array(':idlang' => $idlang));
		}
	}
}
?>