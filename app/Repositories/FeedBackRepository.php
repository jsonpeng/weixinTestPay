<?php

namespace App\Repositories;

use App\Models\FeedBack;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class FeedBackRepository
 * @package App\Repositories
 * @version January 18, 2019, 9:20 am CST
 *
 * @method FeedBack findWithoutFail($id, $columns = ['*'])
 * @method FeedBack find($id, $columns = ['*'])
 * @method FeedBack first($columns = ['*'])
*/
class FeedBackRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'content',
        'questtion_img',
        'commit',
        'grade',
        'user_id'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return FeedBack::class;
    }
}
