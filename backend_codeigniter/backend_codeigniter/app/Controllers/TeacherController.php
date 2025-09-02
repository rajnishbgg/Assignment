<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\TeacherModel;

class TeacherController extends ResourceController {
    protected $format = 'json';

    public function index(){
        $teacherModel = new TeacherModel();
        $db = \Config\Database::connect();

        $sql = $db->table('teachers t')
            ->select('t.*, u.email, u.first_name, u.last_name')
            ->join('auth_user u','u.id = t.user_id');

        $data = $sql->get()->getResultArray();
        return $this->respond($data);
    }

    public function show($id = null){
        $teacherModel = new TeacherModel();
        $t = $teacherModel->where('id',$id)->first();
        if(!$t) return $this->failNotFound('Teacher not found');
        return $this->respond($t);
    }
}
