<?php
namespace BPCUT\Admin;

/**
 * Class UsersDatasource
 * @package BPCUT\Admin
 */
class UsersDatasource {

    /**
     * The name for the 'role' datatable field. Used for matching it on filtering.
     */
    const ROLE_COLUMN_NAME = 'role';

    /**
     * A Json encoded object user for datatable datasource
     * Used via AJAX.
     */
    public function getUsers()
    {
        header("Content-Type: application/json");
        $draw = $_POST['draw'];
        $columns = $_POST['columns'];

        $order_column_idx = $_POST['order'][0]['column'];
        $order_direction = $_POST['order'][0]['dir'];
        $order_column = $columns[$order_column_idx]['name'];
        $length = $_POST['length'];
        $start = $_POST['start'];

        $args = [
            'orderby' => $order_column,
            'order' => strtoupper($order_direction),
            'count_total' => true,
            'fields' => [
                'ID',
                'display_name',
                'user_login',
                'user_email'
            ],
            'number' => $length,
            'offset' => $start
        ];

        if(!empty($_POST['search']['value'])) {
            $args['search'] = $_POST['search']['value'];
        }

        foreach($columns as $idx => $column) {
            if ($column['name'] === self::ROLE_COLUMN_NAME && !empty($column['search']['value'])) {
                $args['role'] = $column['search']['value'];
            }
        }

        $user_query = new \WP_User_Query( $args );

        $results = $user_query->get_results();
        $data = [];
        foreach($results as $user) {
            $user_meta=get_userdata($user->ID);
            $roles = implode(',', $user_meta->roles);
            $data[] = [
                $user->display_name,
                $user->user_login,
                $user->user_email,
                $roles
            ];
        }   

        $mockUp = [
            'draw' => $draw,
            'recordsTotal' => $user_query->get_total(),
            'recordsFiltered' => $user_query->get_total(),
            'data' => $data
        ];

        echo json_encode($mockUp);

        wp_die();
    }
}