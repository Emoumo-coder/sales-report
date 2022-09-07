<?php

// class Customer
// {
//     public $db = null;
//     public function __construct(DBController $db)
//     {
//         if (!isset($db)) return null;
//         $this->db = $db;
//     }

//     public function getUser ($value = null, $column = "cust_name", $table = "tbl_customer"){
//         if ($this->db != null){
//             if ($value != null){
//                 $sql1 = sprintf("SELECT * FROM %s WHERE %s =?", $table, $column);
//                 $stmt = $this->db->con->prepare($sql1);
//                 $stmt->execute(array($value));
//                 return $stmt;
//             }
//         }
//     }
// }