<?php
/**
 * Created by PhpStorm.
 * User: zeenomlabs
 * Date: 7/24/2015
 * Time: 11:14 PM
 */


class Sort {

    /*----- Install Your View Drivers Here ----------*/
    public static $viewDrivers = [
        'customer_ledgers'=>[
            'table'=>'tankers_status_view',
            'default'=>[
                'sort_by'=>'id',
                'order_by'=>'desc'
            ],
            'columns'=>[
                [
                    'column_name'=>'id',
                    'slug'=>'id',
                    'type'=>'num',
                ],
                [
                    'column_name'=>'tanker',
                    'slug'=>'truck_number',
                    'type'=>'string',
                ],
                [
                    'column_name'=>'customer',
                    'slug'=>'customer',
                    'type'=>'string',
                ],
                [
                    'column_name'=>'engine number',
                    'slug'=>'engine_number',
                    'type'=>'string',
                ],
                [
                    'column_name'=>'chase number',
                    'slug'=>'chase_number',
                    'type'=>'string',
                ],
                [
                    'column_name'=>'fitness certificate',
                    'slug'=>'fitness_certificate',
                    'type'=>'string',
                ],
                [
                    'column_name'=>'capacity',
                    'slug'=>'capacity',
                    'type'=>'string',
                ],
                [
                    'column_name'=>'product',
                    'slug'=>'product',
                    'type'=>'string',
                ],
                [
                    'column_name'=>'status',
                    'slug'=>'status',
                    'type'=>'num',
                ],
                [
                    'column_name'=>'route',
                    'slug'=>'source',
                    'type'=>'string',
                ],
            ],
        ],
    ];
    /*-----------------------------------------------*/




    public static function columns($module)
    {
        $ci = &get_instance();
        $sorting_info = [];
        if(isset($_GET['sort_by'])){
            $requested_column = $_GET['sort_by'];
            $fields = $ci->db->list_fields(self::$viewDrivers[$module]['table']);
            if(in_array($requested_column, $fields)){
                $column_data['sort_by'] = $requested_column;
                $column_data['order_by'] = 'asc';
                if(isset($_GET['order'])){
                    if($_GET['order'] == 'desc')
                        $column_data['order_by'] = 'desc';
                }
                $sorting_info[] = $column_data;
                return $sorting_info;
            }
        }

        $db = $ci->db;
        $db->select('*');
        $db->where('view',$module);
        $db->order_by('priority','asc');
        $result = $db->get('sort')->result();

        foreach($result as $record)
        {
            $column_data['sort_by'] = $record->sort_by;
            $column_data['order_by'] = $record->order_by;
            $sorting_info[] = $column_data;
        }

        if(sizeof($sorting_info) > 0){
            return $sorting_info;
        }else{
            $column_data['sort_by'] = self::$viewDrivers[$module]['default']['sort_by'];
            $column_data['order_by'] = self::$viewDrivers[$module]['default']['order_by'];
            $sorting_info[] = $column_data;

            return $sorting_info;
        }
    }

    public static function createSortableHeader($module)
    {
        $columns = self::$viewDrivers[$module]['columns'];
        $markup = "";
        foreach($columns as $column)
        {
            $markup.= sortable_header($column['slug'], $column['type'],ucwords($column['column_name']));
        }
        return $markup;
    }

    public static function createCheckBoxes($module)
    {
        //<th><div><input id="" type="checkbox" name="column[]" style="" value="id" checked></div></th>
        $columns = self::$viewDrivers[$module]['columns'];
        $markup = "";
        foreach($columns as $column)
        {
            $markup.= '<th><div><input id="" type="checkbox" name="column[]" style="" value="'.$column['slug'].'" checked></div></th>';
        }
        return $markup;
    }

    public static function createPrintableHeaders($module, $selected_columns)
    {
        $columns = self::$viewDrivers[$module]['columns'];
        $markup = "";
        foreach($columns as $column)
        {
            $markup.= ((in_array($column['slug'], $selected_columns) == true)?"<th>".ucwords($column['column_name'])."</th>":"");
        }
        return $markup;
    }

    public static function createPrintableBody($module, $selected_columns, $object)
    {
        $columns = self::$viewDrivers[$module]['columns'];
        $markup = "";
        foreach($columns as $column)
        {
            $markup.=printable_column($column['slug'], $selected_columns, $object->$column['slug']);
        }
        return $markup;
    }
} 