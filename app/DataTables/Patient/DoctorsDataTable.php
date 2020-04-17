<?php

namespace App\DataTables\Patient;

use App\User;
use Carbon\Carbon;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class DoctorsDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('category', function (User $user) {
                return $user->profile->doctorCategory->name;
            })
            ->addColumn('joined', function (User $user) {
                return $user->created_at->diffForHumans();
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where('name', 'LIKE', "%{$keyword}%")->orWhereHas('profile', function ($dpq) use ($keyword) {
                    $dpq->whereHas('doctorCategory', function ($dcq) use ($keyword) {
                        $dcq->where('name', 'LIKE', "%{$keyword}%");
                    });
                });
            })
            ->addColumn('action', '<button class="btn btn-sm btn-info">Show</button>');
    }

    /**
     * Get query source of dataTable.
     *
     * @param App\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(User $model)
    {
        return $model->role('doctor')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('patient-doctors-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('name'),
            Column::make('category'),
            Column::make('joined'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Patient_Doctors_' . date('YmdHis');
    }
}