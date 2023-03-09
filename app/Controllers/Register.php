<?php

namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;
use App\Models\UserModel;
use Codeigniter\API\ResponseTrait;

class Register extends ResourceController
{
    /**
     * Return an array of resource objects, themselves in array format
     *
     * @return mixed
     */
    use ResponseTrait;
    public function index()
    {
        helper(['form']);
        $rules = [
            'username' => 'required|min_length[2]',
            'fullname' => 'required',
            'password' => 'required|min_length[5]',
        ];
        if(!$this->validate($rules)) return $this->fail($this->validator->getErrors());
        $data = [
            'username' => $this->request->getVar('username'),
            'fullname' => $this->request->getVar('fullname'),
            'password' => password_hash($this->request->getVar('password'), PASSWORD_BCRYPT),
        ];
        $model = new UserModel();
        $registered = $model->save($data);
        $this->respondCreated($registered);
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