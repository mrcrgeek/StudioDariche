<?php

namespace App\Actions;

use App\Exceptions\CustomException;
use App\Models\Work;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

class WorkAction extends \App\Services\Action
{
    protected array $validation_roles = [
        'store_img' => [
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
        ],
        'update_img' => [
            'information' => 'string',
            'img' => 'file|mimes:jpg,png,jpeg|max:10000',
            'is_index' => 'boolean|nullable'
        ],
        'update_color' => [
            'img' => 'file|mimes:jpg,png,jpeg|max:10000',
            'is_index' => 'boolean|nullable'
        ]
    ];

    protected array $limit_array = [
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

    public function __construct()
    {
        $this->model = Work::class;
    }

    public function store_by_request(Request $request, $validation_role = 'store_img')
    {
        if($request['type'] == 'color')
        {
            $validation_role = 'store_color';
        }

        return parent::store_by_request($request, $validation_role);
    }

    public function store(array $data)
    {
        $this->check_is_index($data);

        $data['img'] = $this->upload_file($data['img']);

        return parent::store($data);
    }

    public function check_is_index(array $data)
    {
        if(isset($data['is_index']))
        {
            $get_limit_validation = $this->limit_array[$data['work_name']];

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
    }

    public function update_entity_by_request_and_id(Request $request, string $id, $validation_role = 'update_img')
    {
        $get_type = $this->get_by_id($id);

        if($get_type->type == 'color')
        {
            $validation_role = 'update_color';
        }

        return $this->update_by_id(
            $this->get_data_from_request($request,$validation_role),
            $id
        );
    }

    public function update_by_id(array $update_data,string $id)
    {
        $work_data = $this->model::where('id',$id)->first()->toArray();

        if(isset($update_data['is_index']) && $update_data['is_index'] != $work_data['is_index'])
        {
            if($update_data['is_index'])
            {
                $work_data['is_index'] = true;
                $this->check_is_index($work_data);
            }
        }

        if(isset($update_data['img']))
        {
            $update_data['img'] = $this->upload_file($update_data['img']);
        }

        return $this->model::where('id',$id)->update($update_data);
    }

    public function delete_by_id(string $id)
    {
        $Work = $this->get_by_field('id',$id);

        return $Work->delete();
    }
}
