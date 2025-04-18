<?php

namespace App\Imports;

use App\Models\Customer;
use App\Models\Item;
use App\Models\ItemCategory;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Row;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ItemImport implements OnEachRow, WithHeadingRow
{
    public function onRow(Row $row)
    {
        $data = $row->toArray();

        $item = Item::firstOrCreate(
            [
                'item_name'     => $data['item_name'] ?? null,
                'quantity'      => $data['quantity'] ?? null,
                'unit'          => $data['unit'] ?? null,
                'quantity_1'    => $data['quantity_1'] ?? null,
                'unit_1'        => $data['unit_1'] ?? null,
                'remarks'       => $data['remarks'] ?? null,
                'location'      => $data['location'] ?? null,
            ]
        );

        $existingCategory = ItemCategory::where('item_id', $item->id)
            ->where(function ($query) use ($data) {
                $query->where('category_1', $data['category_1'] ?? null)
                      ->where('category_2', $data['category_2'] ?? null)
                      ->where('category_3', $data['category_3'] ?? null);
            })
            ->first();
        
        if (!$existingCategory) {
            ItemCategory::create([
                'item_id' => $item->id,
                'category_1' => $data['category_1'] ?? null,
                'category_2' => $data['category_2'] ?? null,
                'category_3' => $data['category_3'] ?? null,
            ]);
        }
    }
}
