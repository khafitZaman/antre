<?php
namespace App\Models\Builtin;

class RoleModel extends \App\Models\BaseModel
{
	public function getAllModules() {
		
		$sql = 'SELECT * FROM module';
		return $this->db->query($sql)->getResultArray();
	}
	
	public function getModuleStatus() {
		$sql = 'SELECT * FROM module_status';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function listModuleRole() {
		$sql = 'SELECT * FROM module_role LEFT JOIN module USING(id_module)';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function listModulePermission() {
		$sql = 'SELECT * FROM role_module_permission 
				LEFT JOIN module_permission USING(id_module_permission)
				LEFT JOIN module USING(id_module)
				WHERE nama_permission LIKE "read%"
				';
				
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	public function getAllRole() {
		$sql = 'SELECT role.*, module.*, id_module_permission FROM role LEFT JOIN module USING(id_module)
				LEFT JOIN (
					SELECT id_role, id_module, id_module AS id_module_permission, judul_permission
					FROM module_permission 
					LEFT JOIN role_module_permission USING(id_module_permission)
					WHERE nama_permission LIKE "read%"
					GROUP BY id_role, id_module
				) AS mp ON role.id_module = mp.id_module AND role.id_role = mp.id_role';
		$result = $this->db->query($sql)->getResultArray();
		return $result;
	}
	
	// EDIT
	public function getRole($id_role) {
		$sql = 'SELECT * FROM role WHERE id_role = ?';
		$result = $this->db->query($sql, [$id_role])->getRowArray();
		if (!$result)
			$result = [];
		return $result;
	}
	
	public function saveData() 
	{
		$fields = ['nama_role', 'judul_role', 'keterangan', 'id_module'];

		foreach ($fields as $field) {
			$data_db[$field] = $this->request->getPost($field);
		}
		$fields['id_module'] = $this->request->getPost('id_module') ?: 0;
		
		// echo '<pre>'; print_r($data_db); die;
		// Save database
		if ($this->request->getPost('id')) {
			$id_role = $this->request->getPost('id');
			$save = $this->db->table('role')->update($data_db, ['id_role' => $id_role]);
		} else {
			$save = $this->db->table('role')->insert($data_db);
			$id_role = $this->db->insertID();
		}
		
		if ($save) {
			$result['status'] = 'ok';
			$result['message'] = 'Data berhasil disimpan';
			$result['id_role'] = $id_role;
		} else {
			$result['status'] = 'error';
			$result['message'] = 'Data gagal disimpan';
		}
								
		return $result;
	}
	
	public function deleteData() {
		$this->db->table('role')->delete(['id_role' => $this->request->getPost('id')]);
		return $this->db->affectedRows();
	}
}
?>