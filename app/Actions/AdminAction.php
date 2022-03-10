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

        return $this->store($data);
    }
}
