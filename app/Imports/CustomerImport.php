<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomerImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (!isset($row['customertype']) || empty($row['customertype'])) {
            return null;
        }

        return new Customer([
            'customer_type' => $row['customertype'] ?? null,
            'customer_name' => $row['customer_name'] ?? null,
            'location'      => $row['location'] ?? null,
            'state'         => $row['state'] ?? null,
            'country'       => $row['country'] ?? null,
            'type'          => $row['type'] ?? null,
            'gst_no'        => $row['gstno'] ?? null,
        ]);
    }
}
