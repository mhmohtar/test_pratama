<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use Codeigniter\API\ResponseTrait;
use App\Models\UserModel;
use Firebase\JWT\JWT;

class Login extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    protected $format = 'json';
    public function index()
    {
        helper(['form']);
        $rules = [
            'username' => 'required|min_length[2]',
            'password' => 'required|min_length[5]'
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $model = new UserModel();
        $user = $model->where('username', $this->request->getVar('username'))->first();
        if(!$user) return $this->failNotFound('Username Not found')->setStatusCode(404);
        
        $verify = password_verify($this->request->getVar('password'), $user['password']);
        if(!$verify) return $this->fail('Wrong Passoword');

        $key = getenv('TOKEN_SECRET');
        $payload = array(
            'iat' => 1356999524,
            'nbf' => 1357000000,
            'uid' => $user['id'],
            'username' => $user['username'],
        );
        $token = JWT::encode($payload, $key, 'HS256');
        $output = [
            'token' => $token,
            'message' => 'Successful login'
        ];
        return $this->respond($output)->setStatusCode(200);
        
    }

    public function userlist()
    {
        $key = getenv('TOKEN_SECRET');
        $header = $this->request->getServer('HTTP_AUTHORIZATION');
        if (!$header) {
            return $this->failUnauthorized('Token Required');
        }
        $token = explode(' ', $header)[1];
        try {
            $decoded = JWT::decode($token, $key, array('HS256'));
            $userId = $decoded->uid;
            $username = $decoded->username;
            $response = [
                'id' => $userId,
                'username' => $username
            ];

            return $this->respond($response)->setStatusCode(200);
        } catch (\Exception $e) {
            return $this->failUnauthorized('Invalid Token');
        }
    }

    /**
     * Return the properties of a resource object
     *
     * @return mixed
     */
    public function show($id = null)
    {
        //
    }

    /**
     * Return a new resource object, with default properties
     *
     * @return mixed
     */
    public function new()
    {
        //
    }

    /**
     * Create a new resource object, from "posted" parameters
     *
     * @return mixed
     */
    public function create()
    {
        //
    }

    /**
     * Return the editable properties of a resource object
     *
     * @return mixed
     */
    public function edit($id = null)
    {
        //
    }

    /**
     * Add or update a model resource, from "posted" properties
     *
     * @return mixed
     */
    public function update($id = null)
    {
        //
    }

    /**
     * Delete the designated resource object from the model
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        //
    }
}