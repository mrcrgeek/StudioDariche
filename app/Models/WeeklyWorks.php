<?php

namespace App\Models;

use App\Actions\WorkAction;
use App\Services\KeyObjectConfig;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeeklyWorks extends KeyObjectConfig
{

    protected $key = 'weekly_work';

    protected $fields = [
        'updated_at' => 'date:Y-m-d H:i:s'
    ];

    protected $default_values = [
        'updated_at' => null
    ];

    public function change ()
    {
        $workAction = New WorkAction();
        $work = New $workAction->model();
        $work->where('is_index', true)->update([
            'is_index' => false
        ]);

        $limit_array = $workAction->get_limit_array();

        foreach ($limit_array as $category => $limit)
        {
            $workAction->model::inRandomOrder()
                ->where('work_name', $category)
                ->where('type', 'color')
                ->limit($limit['color'])
                ->update([
                    'is_index' => true
                ]);

            $workAction->model::inRandomOrder()
                ->where('work_name', $category)
                ->where('type', 'img')
                ->limit($limit['img'])
                ->update([
                    'is_index' => true
                ]);
        }

        $this->update((object)[
            'updated_at' => date('Y-m-d H:i:s')
        ]);
    }

    public function change_if_should ()
    {
        $updated_at = $this->get()->updated_at;

        if (!empty($updated_at))
        {
            $updated_at = strtotime($updated_at);
        }
        else
        {
            $updated_at = 0;
        }

        if (time() > ($updated_at + (86400 * 7)))
        {
            $this->change();
        }
    }
}
