<?php
namespace App\Models\Builtin;

class RolePermissionModel extends \App\Models\BaseModel
{
	
	public function deleteAllPermission() {
		$delete = $this->db->table('role_module_permission')->delete(['id_role' => $_POST['id']]);
		return $delete;
	}
	
	public function deletePermission($id) {
		$delete = $this->db->table('role_module_permission')->delete(['id_module_permission' => $id]);
		return $delete;
	}
	
	public function deleteRolePermissionByModule($id_module) {
		$sql = 'DELETE FROM role_module_permission 
					WHERE id_module_permission 
					IN (SELECT id_module_permission FROM module_permission WHERE id_module = ?)';
		$delete = $this->db->query($sql, $id_module);
		return $delete;
	}
	
	public function getRolePermissionByIdRole($id) 
	{
		$sql = 'SELECT * FROM role_module_permission WHERE id_role = ?';
		$query = $this->db->query($sql, $id)->getResultArray();
		
		$result = [];
		foreach ($query as $val) {
			$result[$val['id_module_permission']] = $val;
		}

		return $result;
	}
	
	public function getAllPermissionByModule() 
	{
		$sql = 'SELECT * FROM module_permission LEFT JOIN module USING(id_module) ORDER BY judul_module';
		$module_permission = $this->db->query($sql)->getResultArray();
				
		foreach ($module_permission as $val) {
			$result[$val['id_module']][$val['id_module_permission']] = $val;
		}

		return $result;
	}
	
	public function getAllModules() {
		
		$sql = 'SELECT * FROM module ORDER BY judul_module';
		
		$query = $this->db->query($sql)->getResultArray();
		foreach ($query as $val) {
			$result[$val['id_module']] = $val;
		}
		return $result;
	}
	
	public function getAllModulesById($id_module = '') {

		if ($id_module) {
			$id_module = ' WHERE id_module = ' . $_GET['id_module'];
		}
		$sql = 'SELECT * FROM module ' . $id_module . ' ORDER BY judul_module';
		
		$query = $this->db->query($sql)->getResultArray();
		foreach ($query as $val) {
			$result[$val['id_module']] = $val;
		}
		return $result;
	}
	
	public function getRoleById($id) {
		$sql = 'SELECT * FROM role WHERE id_role = ?';
		$result = $this->db->query($sql, $id)->getRowArray();
		return $result;
	}
	
	public function getAllRole() {
		$sql = 'SELECT * FROM role';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllRolePermission() {
		$sql = 'SELECT * FROM role_module_permission 
					LEFT JOIN module_permission USING(id_module_permission) 
					LEFT JOIN module USING(id_module)';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function saveData() 
	{
		$this->db->transStart();
		
		$table = $this->db->table('role_module_permission');
		// Via ajax
		if (!empty($_POST['id_module']) && $_POST['id_module'] != 'semua_module') {
			// echo '<pre>'; print_r($_POST); die;
			$sql = 'DELETE FROM role_module_permission 
						WHERE id_role = ? AND id_module_permission 
								IN (SELECT id_module_permission FROM module_permission WHERE id_module = ?)';
								
			$this->db->query($sql, [$_POST['id'], $_POST['id_module']]);
		} else {
			$table->delete(['id_role' => $_POST['id']]);
		}
		
		if (key_exists('permission', $_POST)) {
			foreach ($_POST['permission'] as $val) {
				$data_db[] = ['id_role' => $_POST['id'], 'id_module_permission' => $val];
			}
		}
		$table->insertBatch($data_db);
		
		$this->db->transComplete();
		if ($this->db->transStatus() == false) {
			return false;
		}
		
		return true;
	}
}
?>