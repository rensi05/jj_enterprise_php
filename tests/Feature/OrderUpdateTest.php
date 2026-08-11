<?php

namespace Tests\Feature;

use App\Http\Controllers\OrderController;
use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\orderItems;
use App\Models\Unit;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\Request;
use Tests\TestCase;

class OrderUpdateTest extends TestCase
{
    use DatabaseTransactions;

    public function test_updating_an_order_does_not_create_a_duplicate_order_number(): void
    {
        $customer = Customer::create([
            'customer_name' => 'Update Test Customer',
            'status' => 'active',
        ]);
        $item = Item::create([
            'customer_id' => $customer->id,
            'item_name' => 'Update Test Item',
            'status' => 'active',
        ]);
        $unit = new Unit();
        $unit->name = 'PCS';
        $unit->status = 'active';
        $unit->save();

        $order = new Order();
        $order->order_no = 'JJ-TEST-UPD-001';
        $order->customer_id = $customer->id;
        $order->order_date = '2026-08-11';
        $order->status = 'pending';
        $order->save();

        orderItems::create([
            'order_id' => $order->id,
            'item_id' => $item->id,
            'quantity' => 10,
            'used_qty' => 2,
            'remaining_qty' => 8,
            'unit_id' => $unit->id,
        ]);

        $request = Request::create('/updateorder', 'POST', [
            'order_id' => base64_encode((string) $order->id),
            'customer_id' => $customer->id,
            'order_date' => '2026-08-11',
            'item_id' => [$item->id],
            'quantity' => [12],
            'used_qty' => [3],
            'remaining_qty' => [9],
            'unit_id' => [$unit->id],
            'category_1' => [null],
            'category_2' => [null],
            'category_3' => [null],
        ]);

        $response = (new OrderController())->UpdateOrder($request);

        $this->assertEquals(route('order'), $response->getTargetUrl());
        $this->assertEquals(1, Order::where('order_no', 'JJ-TEST-UPD-001')->count());
        $this->assertEquals(1, orderItems::where('order_id', $order->id)->count());
        $this->assertEquals(0, orderItems::withTrashed()->where('order_id', $order->id)->whereNotNull('deleted_at')->count());
        $this->assertEquals(12, orderItems::where('order_id', $order->id)->value('quantity'));

        $list = json_decode(Order::OrderModel(
            'orders as o',
            ['o.id', 'o.order_no'],
            [],
            ['o.id', 'o.order_no'],
            [
                'search' => ['value' => ''],
                'order' => [],
                'start' => 0,
                'length' => 50,
                'draw' => 1,
                'columns' => [],
            ],
            [
                [
                    'join_type' => 'left',
                    'table' => 'order_items as oi',
                    'join_table_id' => 'oi.order_id',
                    'from_table_id' => 'o.id',
                ],
            ]
        ), true);

        $matchingRows = array_values(array_filter($list['data'], function ($row) {
            return $row['order_no'] === 'JJ-TEST-UPD-001';
        }));
        $this->assertCount(1, $matchingRows);
    }
}
