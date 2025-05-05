<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;

class Item extends Model {

    protected $fillable = [
        'customer_id',
        'item_name',
        'category_1',
        'category_2',
        'category_3',
        'quantity',
        'unit',
        'quantity_1',
        'unit_1',
        'remarks',
        'location',
    ];

    use HasFactory,
        SoftDeletes;

    protected $table = 'items';

    public function categories() {
        return $this->hasMany(ItemCategory::class);
    }

    public static function ItemModel($table_name, $datatable_fields, $conditions_array, $getfiled, $request, $join_str = array()) {
        DB::enableQueryLog();
        $output = array();
        $data = DB::table($table_name)
                ->select($getfiled);
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id']);
                } else {
                    $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id'], $join['join_type']);
                }
            }
        }
        $data->whereNull('i.deleted_at');

        if ($request['search']['value'] != '') {
            $data->where(function ($query) use ($request, $datatable_fields) {
                for ($i = 0; $i < count($datatable_fields); $i++) {
                    if ($request['columns'][$i]['searchable'] == true) {
                        $search = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request['search']['value']));
                        $query->orWhereRaw("LOWER(REPLACE(REPLACE(REPLACE($datatable_fields[$i], '.', ''), ' ', ''), '-', '')) LIKE ?", ["%$search%"]);
                    }
                }
            });
        }
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $data->orderBy($datatable_fields[$request['order'][$i]['column']], $request['order'][$i]['dir']);
                }
            }
        }
        $count = $data->count();
        $data->skip($request['start'])->take($request['length']);
        $output['recordsTotal'] = $count;
        $output['recordsFiltered'] = $count;
        $output['draw'] = $request['draw'];
        $data_d = $data->get();
        $output['data'] = $data_d;
        return json_encode($output);
    }
    
    public static function FirstItemModel($table_name, $datatable_fields, $conditions_array, $getfiled, $request, $join_str = array()) {
        DB::enableQueryLog();
        $output = array();
        $data = DB::table($table_name)
                ->select($getfiled);
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id']);
                } else {
                    $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id'], $join['join_type']);
                }
            }
        }

        if ($request['search']['value'] != '') {
            $data->where(function ($query) use ($request, $datatable_fields) {
                for ($i = 0; $i < count($datatable_fields); $i++) {
                    if ($request['columns'][$i]['searchable'] == true) {
            $search = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request['search']['value']));
                        $query->orWhereRaw("LOWER(REPLACE(REPLACE(REPLACE($datatable_fields[$i], '.', ''), ' ', ''), '-', '')) LIKE ?", ["%$search%"]);
                    }
                }
            });
        }
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $data->orderBy($datatable_fields[$request['order'][$i]['column']], $request['order'][$i]['dir']);
                }
            }
        }

        if (!empty($request['item_name'])) {
            $data->where('i.item_name', $request['item_name']);
        }
//        $data->where('i.item_name', 'AIR BUBBLE ROLL 1 MTR');
        $data->groupBy('oi.category_1', 'oi.category_2');
        $data->orderByDesc(DB::raw('SUM(oi.quantity)'));

        // Count manually from grouped result
        $countData = clone $data;
        $count = $countData->get()->count();

        // Pagination
        $data->skip($request['start'])->take(10);

        // Final output
        $output['recordsTotal'] = $count;
        $output['recordsFiltered'] = $count;
        $output['draw'] = $request['draw'];
        $output['data'] = $data->get();

        return json_encode($output);
    }

    public static function OtherItemModel($table_name, $datatable_fields, $conditions_array, $getfiled, $request, $join_str = array()) {
        DB::enableQueryLog();
        $output = array();
        $data = DB::table($table_name)
                ->select($getfiled);
        if (!empty($join_str)) {
            foreach ($join_str as $join) {
                if (!isset($join['join_type'])) {
                    $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id']);
                } else {
                    $data->join($join['table'], $join['join_table_id'], '=', $join['from_table_id'], $join['join_type']);
                }
            }
        }

        if ($request['search']['value'] != '') {
            $data->where(function ($query) use ($request, $datatable_fields) {
                for ($i = 0; $i < count($datatable_fields); $i++) {
                    if ($request['columns'][$i]['searchable'] == true) {
                        $search = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $request['search']['value']));
                        $query->orWhereRaw("LOWER(REPLACE(REPLACE(REPLACE($datatable_fields[$i], '.', ''), ' ', ''), '-', '')) LIKE ?", ["%$search%"]);
                    }
                }
            });
        }
        if (isset($request['order']) && count($request['order'])) {
            for ($i = 0; $i < count($request['order']); $i++) {
                if ($request['columns'][$request['order'][$i]['column']]['orderable'] == true) {
                    $data->orderBy($datatable_fields[$request['order'][$i]['column']], $request['order'][$i]['dir']);
                }
            }
        }
        
        $data->whereNotIn('i.item_name', ['AIR BUBBLE ROLL 1 MTR', 'BOPP TAP', 'STRETCH FILM ROLL', 'EPE FOAM ROLL']);

        $data->groupBy('oi.category_1', 'oi.category_2');
        $data->orderByDesc(DB::raw('SUM(oi.quantity)'));

        $count = $data->count();
        $data->skip($request['start'])->take($request['length']);
        $output['recordsTotal'] = $count;
        $output['recordsFiltered'] = $count;
        $output['draw'] = $request['draw'];
        $data_d = $data->get();

//        if (!$data_d->isEmpty()) {
//            foreach ($data_d as $key => $d) {
//                $data_d[$key]->created_at = Common::adminconvertTimezone($d->created_at, 'm-d-Y h:i A');
//            }
//        }
        $output['data'] = $data_d;
        return json_encode($output);
    }

}
