<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Item;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class OrderImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if (!isset($row['customer_name']) || empty($row['customer_name']) || !isset($row['item_name']) || empty($row['item_name'])) {
            return null;
        }

        $customer = Customer::firstOrCreate(
            ['customer_type' => 'purchase'],
            ['customer_name' => $row['customer_name']],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $item = Item::firstOrCreate(
            ['item_name' => $row['item_name']]
        );

        $timestamp = strtotime(date('Y-m-d H:i:s'));
        $six_digit_random_number = substr($timestamp, strlen($timestamp) - 6, strlen($timestamp));
        $order_no = 'ORD-' . $six_digit_random_number;

        return new Order([
            'order_no'      => $order_no,
            'customer_id'   => $customer->id,
            'item_id'       => $item->id,
            'address'       => $row['address'] ?? null,
            'order_type'    => $row['order_type'] ?? null,
            'category_1'    => $row['category_1'] ?? null,
            'category_2'    => $row['category_2'] ?? null,
            'category_3'    => $row['category_3'] ?? null,
            'quantity'      => $row['quantity'] ?? null,
            'unit'          => $row['unit'] ?? null,
            'order_date'    => $this->formatDate($row['orderdate'] ?? null),
            'delivery_date' => $this->formatDate($row['deliverydate'] ?? null),
            'close_date'    => $this->formatDate($row['closedate'] ?? null),
            'location'      => $row['location'] ?? null,
            'remarks'       => $row['remarks'] ?? null,
            'bill_no'       => $row['billno'] ?? null,
            'vehicle_no'    => $row['vehicleno'] ?? null,
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
