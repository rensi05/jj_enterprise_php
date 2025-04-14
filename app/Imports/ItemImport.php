<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Item;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['customer_name']) || empty($row['customer_name'])) {
            return null;
        }

        $customer = Customer::where('customer_name', $row['customer_name'])->first();
        
        if(empty($customer)) {
            $customer = new Customer();
            $customer->customer_type = 'purchase';
            $customer->customer_name = $row['customer_name'];
            $customer->save();
        }

        return new Item([
            'customer_id'   => $customer->id,
            'item_name'     => $row['item_name'] ?? null,
            'category_1'    => $row['category_1'] ?? null,
            'category_2'    => $row['category_2'] ?? null,
            'category_3'    => $row['category_3'] ?? null,
            'quantity'      => $row['quantity'] ?? null,
            'unit'          => $row['unit'] ?? null,
            'quantity_1'    => $row['quantity_1'] ?? null,
            'unit_1'        => $row['unit_1'] ?? null,
            'remarks'       => $row['remarks'] ?? null,
            'location'      => $row['location'] ?? null,
        ]);
    }

    private function formatDate($value)
    {
        if (!$value) {
            return null;
        }

        try {
            return \PhpOffice\PhpSpreadsheet\Shared\Date::isDateTimeFormatCode($value)
                ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d')
                : Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
