<?php
// require utils.php file
require_once('../config.php');

if(isset($_POST['productName']) && isset($_POST['productQty']) && isset($_POST['customerName']) && isset($_POST['customerPhone'])) {
    $table_bought_details = '';
    $table_bought_details_sales = '';
    $final_total = 0;
    if(!empty($_POST['productName']) && !empty($_POST['productQty']) && !empty($_POST['customerName']) && !empty($_POST['customerPhone'])) {

        // getting product form database using the name of the product

        $arr = false;
        $arr['product_name'] = $_POST['productName'];
        $result = $db->read("SELECT * FROM tbl_product WHERE p_name = :product_name", $arr);

        if (is_array($result) || is_object($result)) {						
            foreach ($result as $row) {
                $current_product_cust_id = $row->p_id;
                $current_product_cust_name = $row->p_name;
                $current_product_cust_qty = $row->p_qty;
                $current_product_cust_price = $row->p_price;
            }
            // checking if the customer product quatity is greater than quatity in the database
            if($_POST['productQty'] <= $current_product_cust_qty){
                // calculating customer amount, i did not include it in the input fields because
                // customer don't have to select the price since every products have it's price
                $cust_amount = $current_product_cust_price * $_POST['productQty'];
                //Saving data into the table tbl_customer
                $arr = false;
                $arr['cust_name'] = $_POST['customerName'];
                $arr['cust_phone'] = $_POST['customerPhone'];
                $arr['cust_amount'] = $cust_amount;
                $write_result = $db->write("INSERT INTO tbl_customer (cust_name, cust_phone, cust_amount) VALUES (:cust_name, :cust_phone, :cust_amount)", $arr);
                if ($write_result) {
                    // to get the time customer buy product
                    $cust_datetime = date('Y-m-d');
                    // fetch the customer id to join with product table
                    $arr = false;
                    $arr['cust_name'] = $_POST['customerName'];
                    $select_cust_id = $db->read("SELECT cust_id FROM tbl_customer WHERE cust_name = :cust_name", $arr);

                    if (is_array($select_cust_id) || is_object($select_cust_id)) {						
                        foreach ($select_cust_id as $row1) {
                            $cust_id = $row1->cust_id;
                        }
                        // insert into tbl_sale table
                        
                        $arr = false;
                        $arr['sale_cust_id'] = $cust_id;
                        $arr['sale_p_id'] = $current_product_cust_id;
                        $arr['sale_qty'] = $_POST['productQty'];
                        $arr['sale_date'] = $cust_datetime;

                        $write_sales = $db->write("INSERT INTO tbl_sales (sale_cust_id, sale_p_id, sale_qty, sale_date) VALUES (:sale_cust_id, :sale_p_id, :sale_qty, :sale_date)", $arr);
                        if ($write_sales) {
                            // select all customer product bought details

                            $sql_sales = "SELECT * 
                            FROM tbl_sales t1
                            JOIN tbl_customer t2
                            ON t1.sale_cust_id = t2.cust_id
                            JOIN tbl_product t3
                            ON t1.sale_p_id = t3.p_id";
                            $sql_sales_result = $db->read($sql_sales);
                            $i = 0;
                            $table_bought_details = '';
                            foreach ($sql_sales_result as $row2) {
                                $sales_date_in = $row2->sale_date;
                                $i++;
                                $table_bought_details .= "<tr>
                                    <td>$i</td>
                                    <td>$row2->p_name</td>
                                    <td>$row2->p_price</td>
                                    <td>$row2->sale_qty</td>
                                    <td>$row2->p_unit</td>
                                    <td>$row2->cust_name</td>
                                    <td>$row2->cust_phone</td>
                                </tr>";
                            }

                            // making sales report
                            if (!empty($_POST['startDate']) && !empty($_POST['stopDate'])) {
                                $startDate = $_POST['startDate'];
                                $stopDate = $_POST['stopDate'];
                                $month1 = strtotime($startDate);
                                $month2 = strtotime($stopDate);
                                $arr = false;
                                $arr['startDate'] = $startDate;
                                $arr['stopDate'] = $stopDate;
                                // $sql_sales3 = ;
                                $sql_sales_result3 = $db->read("SELECT month(sale_date) as fmonth, year(sale_date) as fyear,
                                t1.sale_qty, t2.p_price
                                FROM tbl_sales t1
                                JOIN tbl_product t2
                                ON t1.sale_p_id = t2.p_id
                                WHERE date(t1.sale_date) BETWEEN :startDate AND :stopDate
                                ", $arr);
                                $ii = 0;
                                $final_total = 0;
                                $$table_bought_details_sales = '';
                                foreach ($sql_sales_result3 as $row3) {
                                    $i++;
                                    $total = $row3->p_price * $row3->sale_qty;
                                    $table_bought_details_sales .= "<tr>
                                        <td>$i</td>
                                        <td>$row3->fmonth / $row3->fyear</td>
                                        <td>$total</td>
                                    </tr>";
                                    $final_total +=$total;
                                }
                            }
                        }
                    }
                }
            }else{
                $error_message .= 'Availble product quantity is '. $current_product_cust_qty;
            }
            
        }

    }else{
        $error_message .= 'All inputs are required';
    }
    echo json_encode(array('Error'=>$error_message, 'Success'=>$success_message, 'TableBought'=>$table_bought_details, 'TableBoughtSales'=>$table_bought_details_sales, 'Total'=>$final_total));
}
