<?php

namespace App\Exports;

use App\Customer;
use App\Repository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;

class CustomersExport implements FromCollection , WithHeadings , WithStrictNullComparison
{
    private $repository_id;

    public function __construct($repo_id){
         $this->repository_id = $repo_id;
    }
    

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {   
        $repository = Repository::find($this->repository_id);
        $customers = $repository->customers->makeHidden(['id','created_at','updated_at']);

        return $customers;
    }

    public function headings(): array
    {
        return ["Name", "Phone","Points"];
    }
}
