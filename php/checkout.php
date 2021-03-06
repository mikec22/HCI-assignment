<?
session_start();
extract($_POST);
if (isset($_SESSION['cart_details']) && count($_SESSION['cart_details'])>0) {
    if ($action === "show") {
        echo "<h2>Checkout</h2>";
    } else if ($action === "confirm") {
        echo "<h2>Confirmation</h2>
                <h4 class=\"text-xs-center\">Thank you for your payment!</h4>
                <h4 class=\"text-xs-center\">Your goods will be sent within 3 days.</h4><br>";
    }
        echo "<div class=\"table-responsive\">
        <table class=\"table table-striped\">
            <thead class=\"thead-inverse\">
                <tr>
                    <th></th>
                    <th>Name</th>
                    <th class=\"text-xs-center\">Unit Price</th>
                    <th class=\"text-xs-center\">Quantity</th>
                    <th class=\"text-xs-center\">Price</th>
                </tr>
            </thead>
            <tbody>";
    $total = 0;
    $vipTotal = 0;
    foreach ($_SESSION['cart_details'] as $key => $value) {
        $unit = $value['price'];
        $vipUnit = $unit * 0.9;
        $quantity = $value['quantity'];
        $price = $unit * $quantity;
        $vipPrice = $price * 0.9;
        $total += $price;
        $vipTotal += $vipPrice;
        echo "<tr>
                <td class=\"align-middle\"><img src=\"img/{$value['img']}\" style=\"height:70px; width:70px; object-fit: cover; object-position: center;\"></td>
                <td class=\"align-middle\">{$value['name']}</td>";
        if (isset($_COOKIE['user'])) {
            echo "<td class=\"align-middle text-xs-center\"><del>$$unit</del> <strong class=\"text-danger\">$$vipUnit</strong></td>";
        } else {
            echo "<td class=\"align-middle text-xs-center\">$$unit</td>";
        }    
        echo "<td class=\"align-middle text-xs-center\">$quantity";
        if (isset($_COOKIE['user'])) {
            echo "<th class=\"align-middle text-xs-center text-danger\" scope=\"row\">$$vipPrice</th>";
        } else {
            echo "<th class=\"align-middle text-xs-center\" scope=\"row\">$$price</th>";
        }           
        echo "</tr>";
    }
    if (isset($_COOKIE['user'])) {
        setcookie("price", $vipTotal, time() + (86400 * 30), "/");
        echo $_COOKIE['price'].$vipTotal;
        echo "<th colspan=\"5\" scope=\"row\" class=\"align-middle text-xs-right table-info h3\"><small class=\"text-muted\">Saved $".($total-$vipTotal)."</small> Total Price: $$vipTotal</th>
                </tbody>
                </table>
            </div>";
    } else {
        setcookie("price", $total, time() + (86400 * 30), "/");
        echo "<th colspan=\"5\" scope=\"row\" class=\"align-middle text-xs-right table-info h3\">Total Price: $$total</th>
                </tbody>
                </table>
            </div>";
    }
    if ($action === "show") {
        echo "<div class=\"text-xs-right\">
                <button class=\"btn btn-primary\" id=\"next\">Next</button>
              </div>";
    } else if ($action === "confirm") {
        if (isset($_COOKIE['user'])) {
            $point = $vipTotal * 0.1;
            if (isset($_COOKIE['point'])) {
                $point += $_COOKIE['point'];
            }
            setcookie("point", $point, time() + (86400 * 30), "/");
        }        
        unset($_SESSION['cart_details']);
        echo "<div class=\"text-xs-right\">
                <button class=\"btn btn-primary\" id=\"continue\">Continue Shopping</button>
              </div>";
    }
}
?>