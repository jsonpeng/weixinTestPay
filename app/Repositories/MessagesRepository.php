<?php

namespace App\Repositories;

use App\Models\Messages;
use InfyOm\Generator\Common\BaseRepository;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

/**
 * Class MessagesRepository
 * @package App\Repositories
 * @version August 7, 2018, 2:16 pm CST
 *
 * @method Messages findWithoutFail($id, $columns = ['*'])
 * @method Messages find($id, $columns = ['*'])
 * @method Messages first($columns = ['*'])
*/
class MessagesRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'content'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Messages::class;
    }

    public function getCacheMessages($skip,$take){
        return Cache::remember('zcjy_messages_'.$skip.'_'.$take, Config::get('web.shrottimecache'), function() use ($skip,$take) {
            return Messages::orderBy('created_at', 'desc')->skip($skip)->take($take)->get();
        });
    }
}
