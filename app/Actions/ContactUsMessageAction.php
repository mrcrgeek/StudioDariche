<?php

namespace App\Actions;
use App\Models\ContactUsMessage;
use Illuminate\Http\Request;
use App\Exceptions\CustomException;
use App\Services\PaginationService;

class ContactUsMessageAction extends \App\Services\Action
{
    public function __construct()
    {
        $this->model = ContactUsMessage::class;
    }

    protected array $validation_roles = [
        'store' => [
            'name' => 'required|string|max:150',
            'email' => 'required|string|email|max:150',
            'phoneNumber' => 'required|string',
            'message' => 'required|max:500'
        ]
    ];

    public function store_by_request(Request $request, $validation_role = 'store')
    {
        return parent::store_by_request($request, $validation_role);
    }

    public function get_all_by_request(Request $request)
    {
        $ContactUsMessage = PaginationService::paginate_with_request(
            $request,
            ContactUsMessage::orderBy('id','DESC')
        );

        if(!empty($ContactUsMessage))
        {
            foreach ($ContactUsMessage->data as $item)
            {
                $this->model::where('id', $item->id)->update([
                    'is_seen' => true
                ]);
            }
        }

        return $ContactUsMessage;
    }

    public function delete_by_id(string $id)
    {
        $Contact_Us = $this->get_by_field('id',$id);

        return $Contact_Us->delete();
    }
}
