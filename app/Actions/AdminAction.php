<?php

namespace App\Actions;

use App\Exceptions\CustomException;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminAction extends \App\Services\Action
{
    protected array $validation_roles = [
        'store' => [
            'name' => 'required|string|unique:App\Models\Admin|max:200',
            'password' => 'required|string|min:6'
        ],
        'login' => [
            'name' => 'required|string|max:200',
            'password' => 'required|string|min:6'
        ]
    ];

    public function __construct()
    {
        $this->model = Admin::class;
    }

    public function store_by_request(Request $request, $validation_role = 'store')
    {
        $data = $this->get_data_from_request($request,$validation_role);
        $data['password'] = Hash::make($data['password']);

        return parent::store($data);
    }

    public function login(array $data)
    {
        $admin_object = $this->model::where('name', $data['name'])->first();

        if(!empty($admin_object))
        {
            if(Hash::check($data['password'], $admin_object->password))
            {
                return $admin_object->createToken('Admin-Token')->plainTextToken;
            }
        }

        throw new CustomException('Name or Password is Wrong!',0,400);
    }

    public function login_by_request(Request $request,$validation_rule = 'login')
    {
        return $this->login($this->get_data_from_request($request,$validation_rule));
    }
}
