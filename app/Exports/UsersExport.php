<?php

namespace App\Exports;

use App\Http\structure\Repositories\UserRepository;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        return UserRepository::getUsersByBirthDate($this->startDate, $this->endDate);
    }

    public function headings(): array 
    {
        return [
            'ID', 
            'Nombres y Apellidos',
            'Fecha de Nacimiento'
        ];
    }
}
