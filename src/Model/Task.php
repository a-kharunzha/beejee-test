<?php declare(strict_types=1);


namespace App\Model;


use ActiveRecord\Model;
use App\Exception\TaskInvalidArrayException;
use JasonGrimes\Paginator;

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
        'email' => 'asc',
        'created' => 'desc',
        'status' => 'asc'
    ];
    const ALLOWED_DIR = ['asc', 'desc'];

    public static function findListByRequestParams(array $requestParams)
    {
        return static::find('all', static::makeFindParamsFromRequestParams($requestParams));
    }

    protected static function normalizeRequestParams(array $requestParams): array
    {
        // check sort
        if (!array_key_exists($requestParams['sort'], static::DEFAULT_DIR)) {
            $requestParams['sort'] = static::DEFAULT_SORT;
        }
        // check dir
        if (
        !in_array($requestParams['dir'], static::ALLOWED_DIR)
        ) {
            $requestParams['dir'] = static::DEFAULT_DIR[$requestParams['sort']];
        }
        // page must be int, default to 1
        $requestParams['page'] = intval($requestParams['page'] ?? 1);
        return $requestParams;
    }

    public static function makeFindParamsFromRequestParams(array $requestParams): array
    {
        $requestParams = static::normalizeRequestParams($requestParams);
        $findParams = ['limit' => self::PER_PAGE];
        // check page
        if ($requestParams['page'] && $requestParams['page'] > 1) {
            $findParams['offset'] = ($requestParams['page'] - 1) * static::PER_PAGE;
        }
        $findParams['order'] = $requestParams['sort'] . ' ' . $requestParams['dir'];
        return $findParams;
    }

    public static function makePaginatorByRequestParams($requestParams) : Paginator
    {
        $requestParams = static::normalizeRequestParams($requestParams);
        // it is not necessary while $findParams does not contain any filters
        // but let be
        $findParams = static::makeFindParamsFromRequestParams($requestParams);
        unset($findParams['offset']); // to count all items
        $itemsPerPage = $findParams['limit'];
        $totalItems = static::count($findParams);
        $currentPage = $requestParams['page'];
        //
        $urlPattern = '/' . $requestParams['sort'] . '/' . $requestParams['dir'] . '/(:num)/';
        $paginator = new Paginator($totalItems, $itemsPerPage, $currentPage, $urlPattern);
        return $paginator;
    }

    public static function initFromArray(array $fieldValues)
    {
        $errors = [];
        $emptyRules = [
            'name' => 'Please enter Name',
            'email' => 'Please enter Email',
            'text' => 'Provide task description',
        ];
        $task = new static();
        foreach($emptyRules as $field => $errorText){
            if(empty($fieldValues[$field])){
                $errors[$field] = $errorText;
            }else{
                $task->{$field} = $fieldValues[$field];
            }
        }
        if($errors){
            throw new TaskInvalidArrayException('Invalid input array',$errors);
        }
        return $task;
    }
}
