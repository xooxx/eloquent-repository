<?php

namespace Xooxx\Foundation\Infrastructure\Model\Repository\Eloquent;

use Xooxx\Foundation\Domain\Model\Repository\Contracts\Page;
use Xooxx\Foundation\Domain\Model\Repository\Contracts\Pageable;
use Xooxx\Foundation\Domain\Model\Repository\Contracts\PageRepository;
use Xooxx\Foundation\Domain\Model\Repository\Page as ResultPage;
class EloquentPageRepository extends BaseEloquentRepository implements PageRepository
{
    /**
     * Returns a Page of entities meeting the paging restriction provided in the Pageable object.
     *
     * @param Pageable $pageable
     *
     * @return Page
     * @throws \ReflectionException
     */
    public function findAll(Pageable $pageable = null)
    {
        $model = self::$instance;
        /**@var \Illuminate\Database\Query\Builder | \Illuminate\Database\Eloquent\Builder  $query */
        $query = $model->query();
        if ($pageable) {
            $fields = $pageable->fields();
            $columns = !$fields->isNull() ? $fields->get() : ['*'];
            if (count($distinctFields = $pageable->distinctFields()->get()) > 0) {
                $query->distinct();
                $columns = $distinctFields;
            }
            /**@var \Illuminate\Database\Eloquent\Builder $query */
            $filter = $pageable->filters();
            if (!$filter->isNull()) {
                EloquentFilter::filter($query, $filter);
            }
            $sort = $pageable->sortings();
            if (!$sort->isNull()) {
                EloquentSorter::sort($query, $sort);
            }
            $pageSize = $pageable->pageSize();
            $pageSize = $pageSize > 0 ? $pageSize : 1;

            \DB::getPaginator()->setCurrentPage($pageable->pageNumber());
            return new ResultPage($query->paginate($pageable->pageSize(), $columns)->getItems(), $query->paginate()->getTotal(), $pageable->pageNumber(), ceil($query->paginate()->getTotal() / $pageSize));
        }
        \DB::getPaginator()->setCurrentPage(1);
        return new ResultPage($query->paginate($query->paginate()->getTotal(), ['*'])->getItems(), $query->paginate()->getTotal(), 1, 1);
    }
}