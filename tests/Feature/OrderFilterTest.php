<?php

namespace Tests\Feature;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\orderItems;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class OrderFilterTest extends TestCase
{
    use DatabaseTransactions;

    public function test_pending_order_list_filters_by_item_and_category(): void
    {
        $customer = Customer::create([
            'customer_name' => 'Filter Test Customer',
            'status' => 'active',
        ]);
        $matchItem = Item::create([
            'customer_id' => $customer->id,
            'item_name' => 'FILTER TEST A4 PAPER',
        ]);
        $otherItem = Item::create([
            'customer_id' => $customer->id,
            'item_name' => 'FILTER TEST OTHER',
        ]);

        $matchingOrder = new Order();
        $matchingOrder->order_no = 'JJ-TEST-FLT-001';
        $matchingOrder->customer_id = $customer->id;
        $matchingOrder->order_date = '2026-08-11';
        $matchingOrder->status = 'pending';
        $matchingOrder->save();

        orderItems::create([
            'order_id' => $matchingOrder->id,
            'item_id' => $matchItem->id,
            'category_1' => '70 GSM',
            'quantity' => 5,
        ]);

        $otherOrder = new Order();
        $otherOrder->order_no = 'JJ-TEST-FLT-002';
        $otherOrder->customer_id = $customer->id;
        $otherOrder->order_date = '2026-08-11';
        $otherOrder->status = 'pending';
        $otherOrder->save();

        orderItems::create([
            'order_id' => $otherOrder->id,
            'item_id' => $otherItem->id,
            'category_1' => '80 GSM',
            'quantity' => 3,
        ]);

        $list = json_decode(Order::OrderModel(
            'orders as o',
            ['o.id', 'o.order_no', 'i.item_name', 'oi.category_1'],
            [],
            ['o.id', 'o.order_no', 'i.item_name', 'oi.category_1'],
            [
                'search' => ['value' => ''],
                'order' => [],
                'start' => 0,
                'length' => 50,
                'draw' => 1,
                'columns' => [],
                'item_name' => 'FILTER TEST A4 PAPER',
                'category_1' => '70 GSM',
            ],
            [
                [
                    'join_type' => 'left',
                    'table' => 'order_items as oi',
                    'join_table_id' => 'oi.order_id',
                    'from_table_id' => 'o.id',
                ],
                [
                    'join_type' => 'left',
                    'table' => 'items as i',
                    'join_table_id' => 'i.id',
                    'from_table_id' => 'oi.item_id',
                ],
            ]
        ), true);

        $this->assertCount(1, $list['data']);
        $this->assertEquals('JJ-TEST-FLT-001', $list['data'][0]['order_no']);
        $this->assertEquals('70 GSM', $list['data'][0]['category_1']);
    }
}
