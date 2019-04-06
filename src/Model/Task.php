<?php


namespace App\Model;


use ActiveRecord\Model;
use App\Model\Task as TaskModel;

/**
 * Class Review
 * @package App\Model
 * @method static Task find_by_id(integer $id)
 * @method static []Task find()
 */
class Task extends Model
{
    const PER_PAGE = 3;
    const DEFAULT_SORT = 'created';
    const DEFAULT_DIR = [
        'name' => 'asc',
        'email'  => 'asc',
        'created' => 'desc',
        'status'  => 'asc'
    ];
    const ALLOWED_DIR = ['asc','desc'];

    public static function findListRequestParams(array $requestParams)
    {
        return static::find('all',static::makeFindParamsFromRequestParams($requestParams));
    }

    public static function makeFindParamsFromRequestParams($requestParams) : array
    {
        // dump($requestParams);
        $findParams = ['limit'=>3];
        // check sort
        if(!array_key_exists($requestParams['sort'],static::DEFAULT_DIR)){
            $requestParams['sort'] = static::DEFAULT_SORT;
        }
        // check dir
        if(
            !in_array($requestParams['dir'], static::ALLOWED_DIR)
        ){
            $requestParams['dir'] = static::DEFAULT_DIR[$requestParams['sort']];
        }
        // check page
        if($requestParams['page'] && $requestParams['page'] > 1){
            $findParams['offset'] = ($requestParams['page'] -1 ) * static::PER_PAGE;
        }
        //
        $findParams['order'] = $requestParams['sort'].' '.$requestParams['dir'];
        //
        // dump($findParams);
        // exit();
        return $findParams;
    }
}
