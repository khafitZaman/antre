<?php
/**
*	App Name	: Admin Template Dashboard Codeigniter 4	
*	Developed by: Agus Prawoto Hadi
*	Website		: https://jagowebdev.com
*	Year		: 2020
*/

namespace App\Models;
use App\Libraries\Auth;

class BaseModel extends \CodeIgniter\Model 
{
	protected $request;
	protected $session;
	private $auth;
	protected $user;
	
	public function __construct() {
		parent::__construct();
		// echo '<pre>'; print_r($_SESSION); die;
		$this->request = \Config\Services::request();
		$this->session = \Config\Services::session();
		$user = $this->session->get('user');
		if ($user)
			$this->user = $this->getUserById($user['id_user']);
		
		$this->auth = new \App\Libraries\Auth;
	}
	
	public function checkRememberme() 
	{
		if ($this->session->get('logged_in')) 
		{
			return true; 
		}
		
		helper('cookie');
		$cookie_login = get_cookie('remember');
	
		if ($cookie_login) 
		{
			list($selector, $cookie_token) = explode(':', $cookie_login);

			$sql = 'SELECT * FROM user_token WHERE selector = ?';		
			$data = $this->db->query($sql, $selector)->getRowArray();
			
			if ($this->auth->validateToken($cookie_token, @$data['token'])) {
				
				if ($data['expires'] > date('Y-m-d H:i:s')) 
				{
					$user_detail = $this->getUserById($data['id_user']);
					$this->session->set('user', $user_detail);
					$this->session->set('logged_in', true);
				}
			}
		}
		
		return false;
	}
	
	public function getUserById($id_user = null, $array = false) {
		
		if (!$id_user) {
			if (!$this->user) {
				return false;
			}
			$id_user = $this->user['id_user'];
		}
		
		$query = $this->db->query('SELECT * FROM user 
									LEFT JOIN (SELECT id_role,id_user FROM user_role WHERE id_user = user_role.id_user) AS user_role USING(id_user)
									WHERE user.id_user = ?', [$id_user]);
		$user = $query->getRowArray();
		
		$query = $this->db->query('SELECT * FROM user_role LEFT JOIN role USING(id_role) WHERE id_user = ?', [$id_user]);
		$result = $query->getResultArray();
		foreach ($result as $val) {
			$user['role'][$val['id_role']] = $val;
		}
		// echo '<pre>'; print_r($user); die;
		return $user;
	}
	
	public function getUserSetting() {
		
		$result = $this->db->query('SELECT * FROM setting_app_user WHERE id_user = ?', [$this->session->get('user')['id_user']])
						->getRow();
		
		if (!$result) {
			$query = $this->db->query('SELECT * FROM setting_app_tampilan')
						->getResultArray();
			
			foreach ($query as $val) {
				$data[$val['param']] = $val['value'];
			}
			$result = new \StdClass;
			$result->param = json_encode($data);
		}
		return $result;
	}
	
	public function getAppLayoutSetting() {
		$result = $this->db->query('SELECT * FROM setting_app_tampilan')->getResultArray();
		return $result;
	}
	
	public function getDefaultUserModule() {
		
		$query = $this->db->query('SELECT * 
							FROM role 
							LEFT JOIN module USING(id_module)
							WHERE id_role IN (' . join(',', array_keys($this->session->get('user')['role'])) . ')'
							)
						->getRow();
		return $query;
	}
	
	public function getModule($nama_module) {
		$result = $this->db->query('SELECT * FROM module WHERE nama_module = ?', [$nama_module])
						->getRowArray();
		return $result;
	}
	
	public function getMenu($aktif = 'all', $showAll = false, $current_module = '') {
		

		$result = [];
		$where = ' ';
		$where_aktif = '';
		if ($aktif != 'all') {
			$where_aktif = ' AND aktif = '.$aktif;
		}
		
		$role = '';
		if (!$showAll) {
			$role = ' AND ( id_role IN ( ' . join(',', array_keys($_SESSION['user']['role'])) . ') )';
		}
		
		$sql = 'SELECT * FROM menu 
					LEFT JOIN menu_role USING (id_menu)
					LEFT JOIN module USING (id_module)
				WHERE 1 = 1 ' . $role
					. $where_aktif.' 
				ORDER BY urut';
		// echo $sql; die;
		$menu_array = $this->db->query($sql)->getResultArray();
		
		$current_id = '';
		foreach ($menu_array as $val) 
		{
			
			$result[$val['id_menu']] = $val;
			$result[$val['id_menu']]['highlight'] = 0;
			$result[$val['id_menu']]['depth'] = 0;

			if ($current_module == $val['nama_module']) {
				
				$current_id = $val['id_menu'];
				$result[$val['id_menu']]['highlight'] = 1;
			}
			
		}
		
		if ($current_id) {
			$this->menuCurrent($result, $current_id);
		}
		return $result;
	}
	
	private function menuCurrent( &$result, $current_id) 
	{
		$parent = $result[$current_id]['id_parent'];

		$result[$parent]['highlight'] = 1; // Highlight menu parent
		if (@$result[$parent]['id_parent']) {
			$this->menuCurrent($result, $parent);
		}
	}
	
	public function getModulePermission($id_module) {
		$sql = 'SELECT * FROM module_permission LEFT JOIN role_module_permission USING (id_module_permission) WHERE id_module = ?';
		
		$result = $this->db->query($sql, [$id_module])->getResultArray();
		return $result;
	}

	public function validateFormToken($session_name = null, $post_name = 'form_token') {				

		$form_token = explode (':', $this->request->getPost($post_name));
		
		$form_selector = $form_token[0];
		$sess_token = $this->session->get('token');
		if ($session_name)
			$sess_token = $sess_token[$session_name];
	
		if (!key_exists($form_selector, $sess_token))
				return false;
		
		try {
			$equal = $this->auth->validateToken($sess_token[$form_selector], $form_token[1]);

			return $equal;
		} catch (\Exception $e) {
			return false;
		}
		
		return false;
	}
	
	// For role check BaseController->hasPermissionPrefix
	public function getDataById($table, $column, $id) {
		$sql = 'SELECT * FROM ' . $table . ' WHERE ' . $column . ' = ?';
		return $this->db->query($sql, $id)->getResultArray();
	}
	
	public function checkUser($username) 
	{
		$query = $this->db->query('SELECT * FROM user WHERE username = ?', [$username]);
		$user = $query->getRowArray();
		
		if (!$user)
			return;
		
		$user = $this->getUserById($user['id_user']);
		return $user;
	}
	
	public function getSettingWeb() {
		$sql = 'SELECT * FROM setting_web';
		$query = $this->db->query($sql)->getResultArray();
		
		$settingWeb = new \stdClass();
		foreach($query as $val) {
			$settingWeb->{$val['param']} = $val['value'];
		}
		return $settingWeb;
	}
	
	public function getSettingRegistrasi() {
		$sql = 'SELECT * FROM setting_register';
		$query = $this->db->query($sql)->getResultArray();
		foreach($query as $val) {
			$setting_register[$val['param']] = $val['value'];
		}
		return $setting_register;
	}
}