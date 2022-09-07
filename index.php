<?php
// Require config.php file
require_once('config.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interveiw Task</title>
    <link rel="stylesheet" href="style.css?<?php echo time(); ?>">
    
    <link rel="stylesheet" href="fontawesome/all.min.css">
    <link rel="stylesheet" href="fontawesome/fontawesome.min.css">
</head>
<body>
    <form class="container">
        <section class="product-container">
            <h3 class="product-title">Select the our and see the details on productr detail section.</h3>
            <div class="message">Message box</div>
            <div class="form">
                <div class="div-col each-input d-flex flex-column">
                    <label for="productName" class="form-label">Product Name</label>
                    <select id="productName" class="reg-select" name="productName" required>
                        <?php
                        $sel_pro_name = $db->read("SELECT p_name FROM tbl_product");
                            foreach ($sel_pro_name as $row1) {
                                ?>
                                
                                <option value="<?php echo $row1->p_name; ?>"><?php echo $row1->p_name; ?></option>
                                <?php
                            }
                        ?>
                    </select>
                </div>
                <div class="div-col each-input quantity">
                    <label for="productQuantity" class="form-label">Product Quantity</label>
                    <div class="input-group">
                        <div class="button minus">
                            <button type="button" class="btn btn-number" data-type="minus" data-id="pro1">
                            <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <input type="text" data-id="pro1" class="input-number" value="1" name="productQty" id="productQty">
                        <div class="button plus">
                            <button type="button" class="btn btn-number" data-type="plus" data-id="pro1">
                            <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="div-col each-input">
                    <label for="customerName" class="form-label">Customer Name</label>
                    <input type="text" class="form-control" id="customerName" name="customerName" required>
                </div>
                <div class="div-col each-input">
                    <label for="customerPhone" class="form-label">Customer Phone</label>
                    <input type="text" class="form-control" id="customerPhone" name="customerPhone" required>
                </div>
                <div>
                    <button type="submit" id="submit" name="submit" class="submit">Submit</button>
                </div>
            </div>
        </section>
        <section class="product-details">
            <table>
                <caption>The details of product and customer</caption>
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Product Name</td>
                        <th>Product Price</td>
                        <th>Product Quantity</td>
                        <th>Product Unit</td>
                        <th>Customer Name</td>
                        <th>Customer Phone</td>
                    </tr>
                </thead>
                <tbody class="product-append">

                    
                    <tr>
                    </tr>
                </tbody>
            </table>
        </section>
        <section class="product-sales">
            <div class="format-date">
                <label for="stopDate" class="form-label">Customer Name</label>
                <input type="date" name="startDate" id="startDate">
                <label for="stopDate" class="form-label">Customer Name</label>
                <input type="date" name="stopDate" id="stopDate">
            </div>
            <table>
                <caption>Sales Report</caption>
                <thead>
                    <tr>
                        <th>S/N</th>
                        <th>Date</td>
                        <th>Sales</td>
                    </tr>
                </thead>
                <tbody class="sales-append">
                    <tr>
                    </tr>
                </tbody>
                <tfoot style="text-align: center;" class="sales-append-footer">
                
                </tfoot>
            </table>
        </section>

   
    </form>
    <script src="jquery.js"></script>
    <script src="ajax.js?<?php echo time(); ?>"></script>
</body>
</html>