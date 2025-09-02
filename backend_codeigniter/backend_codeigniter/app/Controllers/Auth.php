<?php
namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use App\Models\TeacherModel;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends ResourceController {
    protected $format = 'json';
    private $secretKey;

    public function __construct(){
        $this->secretKey = getenv('JWT_SECRET') ?: 'supersecretkeyyoushouldchange';
    }

    public function register(){
        $db = \Config\Database::connect();
        $userModel = new UserModel();
        $teacherModel = new TeacherModel();

        $json = $this->request->getJSON(true);
        if(!$json) return $this->fail('Invalid JSON', 400);

        $validation = \Config\Services::validation();
        $validation->setRules([
            'email' => 'required|valid_email|is_unique[auth_user.email]',
            'first_name' => 'required',
            'last_name' => 'required',
            'password' => 'required|min_length[6]'
        ]);

        if(!$validation->run($json)){
            return $this->failValidationErrors($validation->getErrors());
        }

        $db->transStart();
        try{
            $userData = [
                'email'=> $json['email'],
                'first_name'=> $json['first_name'],
                'last_name'=> $json['last_name'],
                'password'=> password_hash($json['password'], PASSWORD_DEFAULT)
            ];
            $userModel->insert($userData);
            $userId = $userModel->getInsertID();

            $teacherData = [
                'user_id' => $userId,
                'university_name' => $json['university_name'] ?? '',
                'gender' => $json['gender'] ?? 'other',
                'year_joined' => $json['year_joined'] ?? null
            ];
            $teacherModel->insert($teacherData);

            $db->transComplete();

            if($db->transStatus() === FALSE){
                return $this->fail('Transaction failed', 500);
            }

            return $this->respondCreated(['message'=>'User and Teacher created']);
        } catch(\Exception $e){
            $db->transRollback();
            return $this->failServerError($e->getMessage());
        }
    }

    public function login(){
        $json = $this->request->getJSON(true);
        if(!$json) return $this->fail('Invalid JSON', 400);

        $email = $json['email'] ?? '';
        $password = $json['password'] ?? '';

        $userModel = new UserModel();
        $user = $userModel->where('email', $email)->first();
        if(!$user) return $this->failNotFound('User not found');

        if(!password_verify($password, $user['password'])){
            return $this->failForbidden('Invalid credentials');
        }

        $payload = [
            'iss' => base_url(),
            'iat' => time(),
            'exp' => time() + 60*60*24,
            'sub' => $user['id'],
            'email' => $user['email']
        ];
        $jwt = JWT::encode($payload, $this->secretKey, 'HS256');

        return $this->respond(['token' => $jwt]);
    }
}
