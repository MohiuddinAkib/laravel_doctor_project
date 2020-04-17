<?php

namespace App\DataTables\Patient;

use App\Appointment;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class AppointmentsDataTable extends DataTable
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
            ->addColumn('doctor', function (Appointment $appointment) {
                return $appointment->doctor->name;
            })
            ->addColumn('category', function (Appointment $appointment) {
                return $appointment->doctor->profile->doctorCategory->name;
            })
            ->editColumn('sex', function (Appointment $appointment) {
                return $appointment->sex();
            })
            ->editColumn('created_at', function (Appointment $appointment) {
                return $appointment->created_at->diffForHumans();
            })
            ->filterColumn('doctor', function ($query, $keyword) {
                $query->whereHas('doctor', function ($dq) use ($keyword) {
                    $dq->where('name', 'LIKE', "%{$keyword}%")->orWhereHas('profile', function ($dpq) use ($keyword) {
                        $dpq->whereHas('doctorCategory', function ($dcq) use ($keyword) {
                            $dcq->where('name', 'LIKE', "%{$keyword}%");
                        });
                    });
                });
            })

            ->addColumn('action', '
                <div class="btn-group" role="group" >
                    <button class="btn btn-primary btn-sm">Edit</button>
                    <button class="btn btn-info btn-sm">Show</button>
                </div>
            ');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Appointment $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Appointment $model)
    {
        return $model->wherePatientId(auth()->id())->with('doctor')->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
            ->setTableId('patient-appointments-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->dom('Bfrtip')
            ->orderBy(1)
            ->buttons(
                Button::make('create'),
                Button::make('export'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            );
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('id'),
            Column::make('name'),
            Column::make('age'),
            Column::make('sex'),
            Column::make('doctor'),
            Column::make('category'),
            Column::make('created_at'),
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
        return 'Patient_Appointments_' . date('YmdHis');
    }
}