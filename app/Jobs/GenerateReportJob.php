<?php

namespace App\Jobs;

use App\Events\ReportGeneratedEvent;
use App\Exports\UsersExport;
use App\Models\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

class GenerateReportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $title;
    protected $startDate;
    protected $endDate;

    /**
     * Create a new job instance.
     */
    public function __construct($title, $startDate, $endDate)
    {
        $this->title = $title;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileName = 'reports/'.date('YmdHis'). '_' . str_replace(' ', '_', $this->title) . '.xlsx';
        Excel::store(new UsersExport($this->startDate, $this->endDate), $fileName, 'public');

        $data = new Report();
        $data->title = $this->title;
        $data->report_link = $fileName;
        $data->save();
        broadcast(new ReportGeneratedEvent($data));
    }
}
