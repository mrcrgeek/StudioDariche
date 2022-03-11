<?php

namespace App\Actions;

use App\Exceptions\CustomException;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class WorkAction extends \App\Services\Action
{
    protected array $validation_roles = [
        'store' => [
            'information' => 'required|string',
            'img' => 'required|file|mimes:jpg,png,jpeg|max:10000',
            'work_name' => 'required|in:corporate_identity,poster,typeface_design,printing&packaging,environmental_graphic_design_EGD,illustration',
            'type' => 'required|in:img,color',
            'is_index' => 'boolean|nullable'
        ],
        'store_color' => [
            'img' => 'required|file|mimes:jpg,png,jpeg|max:10000',
            'work_name' => 'required|in:corporate_identity,poster,typeface_design,printing&packaging,environmental_graphic_design_EGD,illustration',
            'type' => 'required|in:img,color',
            'is_index' => 'boolean|nullable'
        ]
    ];

    public function __construct()
    {
        $this->model = Work::class;
    }

    public function store_by_request(Request $request, $validation_role = 'store')
    {
        if($request['type'] == 'color')
        {
            $validation_role = 'store_color';
        }

        $data = $this->get_data_from_request($request, $validation_role);
        $this->store($data);
    }

    public function store(array $data)
    {
        $limit_array = [
            'corporate_identity' => [
                'color' => 3,
                'img' => 4
            ],
            'poster' => [
                'color' => 3,
                'img' => 3
            ],
            'typeface_design' => [
                'color' => 4,
                'img' => 3
            ],
            'printing&packaging' => [
                'color' => 3,
                'img' => 4
            ],
            'environmental_graphic_design_EGD' => [
                'color' => 4,
                'img' => 3
            ],
            'illustration' => [
                'color' => 3,
                'img' => 4
            ]
        ];

        if(isset($data['is_index']) && $data['is_index'])
        {
            $get_limit_validation = $limit_array[$data['work_name']];

            $WorkAction = $this->model::
            where('work_name', $data['work_name'])
                ->where('type', $data['type'])
                ->where('is_index', $data['is_index'])
                ->get();

            if (count($WorkAction) == $get_limit_validation[$data['type']])
            {
                throw new CustomException("is_index {$data['type']} full for {$data['work_name']} WorkName", 0, 400);
            }
        }
            $data['img'] = $this->upload_file($data['img']);

            return $this->model::create($data);
    }
}
