<?php

namespace App\Imports;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Item;
use App\Models\orderItems;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\ToCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class OrderImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $groupedOrders = [];

        foreach ($rows as $row) {
            if (empty($row['customer_name']) || empty($row['item_name'])) continue;

            $key = $row['customer_name'] . '|' . $row['orderdate'] . '|' . $row['order_type'];

            $groupedOrders[$key][] = $row;
        }

        foreach ($groupedOrders as $group) {
            $first = $group[0];

            $customer = Customer::firstOrCreate(
                ['customer_type' => 'purchase', 'customer_name' => $first['customer_name']]
            );

            $lastOrder = Order::withTrashed()->latest()->first();
            $newNumber = $lastOrder ? (int) str_replace('JJ-', '', $lastOrder->order_no) + 1 : 1;
            $order_no = 'JJ-' . str_pad($newNumber, 9, '0', STR_PAD_LEFT);

            $order = Order::create([
                'order_no'      => $order_no,
                'customer_id'   => $customer->id,
                'address'       => $first['address'] ?? null,
                'order_type'    => $first['order_type'] ?? null,
                'order_date'    => $this->formatDate($first['orderdate']),
                'delivery_date' => $this->formatDate($first['deliverydate']),
                'close_date'    => $this->formatDate($first['closedate']),
                'location'      => $first['location'] ?? null,
                'remarks'       => $first['remarks'] ?? null,
                'bill_no'       => $first['billno'] ?? null,
                'vehicle_no'    => $first['vehicleno'] ?? null,
                'status'        => (!empty($first['billno']) && !empty($first['deliverydate']) && !empty($first['closedate'])) ? 'completed' : 'pending',
            ]);

            foreach ($group as $itemRow) {
                $item = Item::firstOrCreate(['item_name' => $itemRow['item_name']]);

                OrderItems::create([
                    'order_id'   => $order->id,
                    'item_id'    => $item->id,
                    'quantity'   => $itemRow['quantity'] ?? null,
                    'unit_id'    => $itemRow['unit'] ?? null,
                    'category_1' => $itemRow['category_1'] ?? null,
                    'category_2' => $itemRow['category_2'] ?? null,
                    'category_3' => $itemRow['category_3'] ?? null,
                ]);
            }
        }
    }

    private function formatDate($value)
    {
        try {
            return is_numeric($value)
                ? \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value)->format('Y-m-d')
                : Carbon::parse($value)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }
}
