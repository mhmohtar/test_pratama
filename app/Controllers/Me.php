<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Codeigniter\API\ResponseTrait;

//use Config\Services;
//use Config\JWT\JWT;
use Firebase\JWT\JWT;

class Me extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    
    use ResponseTrait;
    public function index()
    {
        // $key = getenv('TOKEN_SECRET');
        // $header = $this->request->getServer('HTTP_AUTHORIZATION');
        // if(!$header) return $this->failUnauthorized('Token Required');
        // $token = explode(' ', $header)[1];
         
        // try {
        //     $decoded = JWT::decode($token, $key, ['HS256']);
        //     $response = [
        //         'id' => $decoded->uid,
        //         'username' => $decoded->username
        //     ];
        //     return $this->respond($response);
            
        // } catch (\Throwable $th){
        //     return $this->fail('Invalid Token');
        // }

        $authHeader = $this->request->getServer('HTTP_AUTHORIZATION');
        $arr = explode(" ", $authHeader);
        $jwt = $arr[1];
        $secret_key = "YOUR_SECRET_KEY";

        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, $secret_key, array('HS256'));
                $user = (array) $decoded->data;
                $model = new UserModel();
                $data = $model->findAll();
                return $this->respond($data);
            } catch (\Exception $e) {
                return $this->failUnauthorized($e->getMessage());
            }
        }

        return $this->failUnauthorized('No token provided');
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