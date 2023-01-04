<?php
namespace App\Models\Builtin;

class PermissionModel extends \App\Models\BaseModel
{
	public function getAllModules() {
		
		$sql = 'SELECT * FROM module ORDER BY judul_module';
		$modules =  $this->db->query($sql)->getResultArray();
		foreach ($modules as $val) {
			$result[$val['id_module']] = $val['judul_module'];
		}
		
		return $result;
	}
	
	public function getModuleById($id_module) {
		
		$sql = 'SELECT * FROM module WHERE id_module = ?';
		$result =  $this->db->query($sql, $id_module)->getRowArray();
		return $result;
	}

	public function getPermissionById(int $id = null) 
	{
		$sql = 'SELECT * FROM module_permission LEFT JOIN module USING(id_module) WHERE id_module_permission = ?';
		$module_permission = $this->db->query($sql, $id )->getRowArray();
		
		return $module_permission;
	}
	
	// For controller "module"
	public function getRolePermission($id_role) {
		
		$sql = 'SELECT id_module_permission FROM role_module_permission WHERE id_role = ?';
		$result =  $this->db->query($sql, $id_role)->getResultArray();
		return $result;
	}
	// --
	
	public function getPermission(int $id = null) 
	{
		$result = [];
		if ($id) {
			$sql = 'SELECT * FROM module_permission LEFT JOIN module USING(id_module) WHERE id_module = ?';
			$module_permission = $this->db->query($sql, $id )->getResultArray();
		}
		
		else {
			$sql = 'SELECT * FROM module LEFT JOIN module_permission USING(id_module) ORDER BY nama_permission, judul_module';
			$module_permission = $this->db->query($sql)->getResultArray();
		}
		
		foreach ($module_permission as $val) {
			$result[$val['id_module']][$val['id_module_permission']] = $val;
		}

		return $result;
	}
	
	public function checkDuplicate() {
		$sql = 'SELECT * FROM module_permission WHERE nama_permission = ? AND id_module = ?';
		$result  = $this->db->query($sql, [$_POST['nama_permission'], $_POST['id_module']] )->getRowArray();
		return $result;
	}
	
	/*
		Method for save data
	*/
	private function checkPermissionExists($permission) 
	{
		$sql = 'SELECT * FROM module_permission 
					WHERE id_module = ? 
					AND nama_permission IN ("' . join('","', $permission) . '")';
					
		// echo $sql; die;
					
		$query = $this->db->query($sql, (int) $_POST['id_module'])->getResultArray();
		$permission_exists = [];
		foreach ($query as $val) {
			$permission_exists[$val['nama_permission']] = $val['nama_permission'];
		}
		return $permission_exists;
	}
	
	private function saveCrud() 
	{
		$keterangan = ['membuat', 'membaca', 'mengupdate', 'menghapus'];
		
		// Cek exists
		$list_permission = ["create", "read_all", "update_all", "delete_all"];
		$permission_exists = $this->checkPermissionExists($list_permission);
		
		foreach ($list_permission as $key => $nama_permission) 
		{
			if (in_array($nama_permission, $permission_exists))
				continue;
			
			$data_db = [];
			$data_db['id_module'] = (int) $_POST['id_module'];
			$data_db['nama_permission'] = $nama_permission;
			$data_db['judul_permission'] = ucwords( str_replace('_', ' ', $nama_permission) ) . ' Data';
			$ket_data = $nama_permission == 'create' ? ' data' : ' semua data';
			$data_db['keterangan'] = 'Hak akses untuk ' . $keterangan[$key] . $ket_data;
			$query = $this->db->table('module_permission')->insert($data_db);
		}
	}
	
	private function saveCrudOwn() 
	{
		$keterangan = ['membuat', 'membaca', 'mengupdate', 'menghapus'];
		
		// Cek exists
		$list_permission = ["create", "read_own", "update_own", "delete_own"];
		$permission_exists = $this->checkPermissionExists($list_permission);
		
		// print_r($permission_exists); die;
		foreach ($list_permission as $key => $nama_permission) 
		{
			if (in_array($nama_permission, $permission_exists))
				continue;
			
			$data_db = [];
			$data_db['id_module'] = (int) $_POST['id_module'];
			$data_db['nama_permission'] = $nama_permission;
			$data_db['judul_permission'] = ucwords( str_replace('_', ' ', $nama_permission) ) . ' Data';
			$ket_data = $nama_permission == 'create' ? ' data' : ' data miliknya sendiri';
			$data_db['keterangan'] = 'Hak akses untuk ' . $keterangan[$key] . $ket_data;
			$query = $this->db->table('module_permission')->insert($data_db);
		}
	}
	
	public function saveData() 
	{
		$this->db->transStart();
		
		$id_new = '';
		if ($_POST['generate_permission']) {
		
			if ($_POST['generate_permission'] == 'otomatis') {
				$this->saveCrud();
			} else if (  $_POST['generate_permission'] == 'otomatis_own' ) {
				$this->saveCrudOwn();
			} else if (  $_POST['generate_permission'] == 'otomatis_all_own' ) {
				$this->saveCrud();
				$this->saveCrudOwn();
			} else {
				
				$data_db['id_module'] = (int) $_POST['id_module'];
				$data_db['nama_permission'] = $_POST['nama_permission'];
				$data_db['judul_permission'] = $_POST['judul_permission'];
				$data_db['keterangan'] =  $_POST['keterangan'];
				if (empty($_POST['id'])) {
					$query = $this->db->table('module_permission')->insert($data_db);
					$id_new = $this->db->insertID();
				} else {
					$query = $this->db->table('module_permission')->update($data_db, ['id_module_permission' => (int) $_POST['id']] );
				}
			}
			
			if (!empty($_POST['id_role'])) 
			{
				$id_module = (int) $_POST['id_module'];
				$sql = 'SELECT * FROM module_permission WHERE id_module = ?';
				$module_permission = $this->db->query($sql, $id_module)->getResultArray();
				$values = [];
				foreach ($module_permission as $val) {
					$values[] = ['id_role' => $_POST['id_role'],  'id_module_permission' => $val['id_module_permission']];
				}
				
				if ($values){
					$this->db->table('role_module_permission')->insertBatch($values);
				}
			}
		}
				
		$this->db->transComplete();
		if ($this->db->transStatus() == false) {
			$result['status'] = 'error';
			$result['message'] = 'Data gagal disimpan';
		} else {
			$result['status'] = 'ok';
			$result['message'] = 'Data berhasil disimpan';
		}
		$result['id'] = $id_new;
		return $result;
	}
	
	/*
		-- Method for save data
	*/
	
	public function deletePermissionByModule($id) {
		
		$delete = $this->db->table('module_permission')->delete(['id_module' => (int) trim($id) ]);
		return $delete;
	}
	
	public function deleteData($id) {
		
		$delete = $this->db->table('module_permission')->delete(['id_module_permission' => (int) trim($id) ]);
		return $delete;
	}
}
?>