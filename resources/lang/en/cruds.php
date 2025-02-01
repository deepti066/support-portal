<?php

return [
    'userManagement' => [
        'title'          => 'User management',
        'title_singular' => 'User management',
    ],
    'permission'     => [
        'title'          => 'Permissions',
        'title_singular' => 'Permission',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'title'             => 'Title',
            'title_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'role'           => [
        'title'          => 'Roles',
        'title_singular' => 'Role',
        'fields'         => [
            'id'                 => 'ID',
            'id_helper'          => '',
            'title'              => 'Title',
            'title_helper'       => '',
            'permissions'        => 'Permissions',
            'permissions_helper' => '',
            'created_at'         => 'Created at',
            'created_at_helper'  => '',
            'updated_at'         => 'Updated at',
            'updated_at_helper'  => '',
            'deleted_at'         => 'Deleted at',
            'deleted_at_helper'  => '',
        ],
    ],
    'user'           => [
        'title'          => 'Users',
        'title_singular' => 'User',
        'fields'         => [
            'id'                       => 'ID',
            'id_helper'                => '',
            'name'                     => 'Name',
            'name_helper'              => '',
            'email'                    => 'Email',
            'email_helper'             => '',
            'email_verified_at'        => 'Email verified at',
            'email_verified_at_helper' => '',
            'password'                 => 'Password',
            'password_helper'          => '',
            'roles'                    => 'Roles',
            'roles_helper'             => '',
            'remember_token'           => 'Remember Token',
            'remember_token_helper'    => '',
            'created_at'               => 'Created at',
            'created_at_helper'        => '',
            'updated_at'               => 'Updated at',
            'updated_at_helper'        => '',
            'deleted_at'               => 'Deleted at',
            'deleted_at_helper'        => '',
        ],
    ],
    'status'         => [
        'title'          => 'Statuses',
        'title_singular' => 'Status',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'color'             => 'Color',
            'color_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'priority'       => [
        'title'          => 'Priorities',
        'title_singular' => 'Priority',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'color'             => 'Color',
            'color_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'category'       => [
        'title'          => 'Categories',
        'title_singular' => 'Category',
        'fields'         => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'color'             => 'Color',
            'color_helper'      => '',
            'created_at'        => 'Created at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
    'ticket'         => [
        'title'          => 'Tickets',
        'title_singular' => 'Ticket',
        'fields'         => [
            'id'                      => 'ID',
            'id_helper'               => '',
            'inventory_id'            => 'Inventory_ID',
            'inventory_helper'        => '',
            'title'                   => 'Title',
            'title_helper'            => '',
            'content'                 => 'Content',
            'content_helper'          => '',
            'status'                  => 'Status',
            'status_helper'           => '',
            'priority'                => 'Priority',
            'priority_helper'         => '',
            'category'                => 'Category',
            'category_helper'         => '',
            'author_name'             => 'Name',
            'author_name_helper'      => '',
            'author_email'            => 'Email',
            'author_email_helper'     => '',
            'assigned_to_user'        => 'Assigned To User',
            'assigned_to_user_helper' => '',
            'comments'                => 'Comments',
            'comments_helper'         => '',
            'created_at'              => 'Created at',
            'created_at_helper'       => '',
            'updated_at'              => 'Updated at',
            'updated_at_helper'       => '',
            'deleted_at'              => 'Deleted at',
            'deleted_at_helper'       => '',
            'attachments'             => 'Attachments',
            'attachments_helper'      => '',
            'technical_person'        => 'Technical Person',
            'inventory_items'         => 'Inventory Items',
            'assigned_to_technical_person'=>'Assigned To Technical Person'
        ],
    ],

    'inventory' => [
            'title'          => 'Inventory',
            'title_singular' => 'Inventory',
            'fields' => [
                'id' => 'ID',
                'inv_id'                => 'Inventory_ID',
                'serial_no'             => 'Serial_No',
                'product_name'          => 'Product_Name',
                'invoice_date'          => 'Invoice_Date',
                'invoice_no'            => 'Invoice_No',
                'make'                  => 'Make',
                'model'                 => 'Model',
                'asset_description'     => 'Asset_Description',
                'stock_in_quantity'     => 'Stock_in_quantity',
                'stock_in_date'         => 'Stock_in_Date',
                'stock_out_quantity'    => 'Stock_out_Quantity',
                'stock_out_date'        => 'Stock_out_Date',
                'balance_quantity'      => 'Balance_Quantity',
                'used_in'               => 'Used_In',
                'used_by'               => 'Used_By',
            ],
        ],

        'stock' => [
            'title'             =>'Stock',
            'title_singular'    => 'Stock',
            'fields'    =>[
                'id'            => 'ID',
                'serial_no'     => 'Serial_No',
                'product_name'  => 'Product_Name',
                'invoice_date'  => 'Invoice_Date',
                'invoice_no'    => 'Invoice_No',
                'model'         => 'Model',
                'asset_description' => 'Asset_Description',
                'stock_out_quantity'    => 'Stock_Quantity',
                'stock_out_date'        => 'Stock_Date',
                'balance_quantity'      => 'Stock_Type',
                'used_in'               => 'Used_In',
                'used_by'               => 'Used_By',
            ]
        ],


    'comment'        => [
        'title'          => 'Comments',
        'title_singular' => 'Comment',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => '',
            'ticket'              => 'Ticket',
            'ticket_helper'       => '',
            'author_name'         => 'Author Name',
            'author_name_helper'  => '',
            'author_email'        => 'Author Email',
            'author_email_helper' => '',
            'user'                => 'User',
            'user_helper'         => '',
            'comment_text'        => 'Comment Text',
            'comment_text_helper' => '',
            'created_at'          => 'Created at',
            'created_at_helper'   => '',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => '',
            'deleted_at'          => 'Deleted at',
            'deleted_at_helper'   => '',
        ]
    ],
    'auditLog'       => [
        'title'          => 'Audit Logs',
        'title_singular' => 'Audit Log',
        'fields'         => [
            'id'                  => 'ID',
            'id_helper'           => '',
            'description'         => 'Description',
            'description_helper'  => '',
            'subject_id'          => 'Subject ID',
            'subject_id_helper'   => '',
            'subject_type'        => 'Subject Type',
            'subject_type_helper' => '',
            'user_id'             => 'User ID',
            'user_id_helper'      => '',
            'properties'          => 'Properties',
            'properties_helper'   => '',
            'host'                => 'Host',
            'host_helper'         => '',
            'created_at'          => 'Created at',
            'created_at_helper'   => '',
            'updated_at'          => 'Updated at',
            'updated_at_helper'   => '',
        ],
    ],
    'model'        =>[
        'title'      => 'Model',
        'title_singular'    => 'Model',
        'fields'     => [
            'id'                => 'ID',
            'id_helper'         => '',
            'name'              => 'Name',
            'name_helper'       => '',
            'color'             => 'Color',
            'color_helper'      => '',
            'created_at'        => 'Create at',
            'created_at_helper' => '',
            'updated_at'        => 'Updated at',
            'updated_at_helper' => '',
            'deleted_at'        => 'Deleted at',
            'deleted_at_helper' => '',
        ],
    ],
];
