<?php

if(!empty($_POST)){


/**
 * PHP library version: v1.7
 */
require_once('lib/worldpay.php');

// Initialise Worldpay class with your SERVICE KEY
$worldpay = new Worldpay("T_S_fa426195-ff1c-4ac1-8015-8bbb0de550fa");

// Sometimes your SSL doesnt validate locally
// DONT USE IN PRODUCTION
$worldpay->disableSSLCheck(true);

$token = $_POST['token'];
$name = $_POST['name'];
$amount = $_POST['amount'];
$_3ds = (isset($_POST['3ds'])) ? $_POST['3ds'] : false;
$authoriseOnly = (isset($_POST['authoriseOnly'])) ? $_POST['authoriseOnly'] : false;
$customerIdentifiers = (!empty($_POST['customer-identifiers'])) ? json_decode($_POST['customer-identifiers']) : array();

// Try catch
try {
    // Customers billing address
    $billing_address = array(
        "address1"=> $_POST['address1'],
       "address2"=> $_POST['address2'],
        //"address3"=> $_POST['address3'],
        "postalCode"=> $_POST['postcode'],
        "city"=> $_POST['city'],
        "state"=> '',
        "countryCode"=> $_POST['countryCode']
    );

    // Customers delivery address
    $delivery_address = array(
        "firstName" => $_POST['delivery-firstName'],
        "lastName" => $_POST['delivery-lastName'],
        "address1"=> $_POST['delivery-address1'],
       "address2"=> $_POST['delivery-address2'],
       // "address3"=> $_POST['delivery-address3'],
        "postalCode"=> $_POST['delivery-postcode'],
        "city"=> $_POST['delivery-city'],
        "state"=> '',
        "countryCode"=> $_POST['delivery-countryCode']
    );
    $response = $worldpay->createOrder(array(
        'token' => $token, // The token from WorldpayJS
        'orderDescription' => $_POST['description'], // Order description of your choice
        'amount' => $amount*100, // Amount in pence
        'is3DSOrder' => $_3ds, // 3DS
        'authoriseOnly' => $authoriseOnly,
        'orderType' =>'ECOM', //Order Type: ECOM/MOTO/RECURRING
        'currencyCode' => $_POST['currency'], // Currency code
        'settlementCurrency' => $_POST['settlement-currency'], // Settlement currency code
        'name' => ($_3ds) ? '3D' : $name, // Customer name
        'billingAddress' => $billing_address, // Billing address array
        'deliveryAddress' => $delivery_address, // Delivery address array
        'customerIdentifiers' => (!is_null($customerIdentifiers)) ? $customerIdentifiers : array(), // Custom indentifiers
        'statementNarrative' => $_POST['statement-narrative'],
        'customerOrderCode' => 'A123' // Order code of your choice
    ));

    if ($response['paymentStatus'] === 'SUCCESS' ||  $response['paymentStatus'] === 'AUTHORIZED') {
        // Create order was successful!
        $worldpayOrderCode = $response['orderCode'];
        echo '<p>Order Code: <span id="order-code">' . $worldpayOrderCode . '</span></p>';
        echo '<p>Token: <span id="token">' . $response['token'] . '</span></p>';
        echo '<p>Payment Status: <span id="payment-status">' . $response['paymentStatus'] . '</span></p>';
        echo '<pre>' . print_r($response, true). '</pre>';
        // TODO: Store the order code somewhere..
    } elseif ($response['is3DSOrder']) {
        // Redirect to URL
        // STORE order code in session
        $_SESSION['orderCode'] = $response['orderCode'];
        ?>
        <form id="submitForm" method="post" action="<?php echo $response['redirectURL'] ?>">
            <input type="hidden" name="PaReq" value="<?php echo $response['oneTime3DsToken']; ?>"/>
            <input type="hidden" id="termUrl" name="TermUrl" value="http://localhost/3ds_redirect.php"/>
            <script>
                document.getElementById('termUrl').value = window.location.href.replace('create_order.php', '3ds_redirect.php');
                document.getElementById('submitForm').submit();
            </script>
        </form>
        <?php
    } else {
        // Something went wrong
        echo '<p id="payment-status">' . $response['paymentStatus'] . '</p>';
        throw new WorldpayException(print_r($response, true));
    }
} catch (WorldpayException $e) { // PHP 5.3+
    // Worldpay has thrown an exception
    echo 'Error code: ' . $e->getCustomCode() . '<br/>
    HTTP status code:' . $e->getHttpStatusCode() . '<br/>
    Error description: ' . $e->getDescription()  . ' <br/>
    Error message: ' . $e->getMessage();
} catch (Exception $e) {  // PHP 5.2
    echo 'Error message: '. $e->getMessage();
}
}
?>
<?php
session_start();
error_reporting(0);
//add product to session or create new one
if(isset($_POST["type"]) && $_POST["type"]=='add' && $_POST["product_qty"]>0)
{
	foreach($_POST as $key => $value){ //add all post vars to new_product array
		$new_product[$key] = filter_var($value, FILTER_SANITIZE_STRING);
    }
	//  unset($_SESSION["cart_products"]);
	//print_r($new_product);die;
    $new_product["package_name"]  ;
    $new_product["price"]  ;
	$new_product["package_id"]  ;
	$new_product["product_qty"]  ;
	
	  if(isset($_SESSION["cart_products"])){  //if session var already exist
            if(isset($_SESSION["cart_products"][$new_product['package_id']])) //check item exist in products array
            {
				echo "<script>alert('This is already added to cart');
				</script>";
                //unset($_SESSION["cart_products"][$new_product['country_id']]); //unset old array item
            }else{
 				echo "<script>alert('1 Item(s) added to your cart.');
				</script>";
 				header('Location:shoppingcart.php');
			}           
        }
		
        $_SESSION["cart_products"][$new_product['package_id']] = $new_product; //update or create product session with new item 
      
}

  include('header.php'); ?>
 
 
<!----------Slider-------------->
<div id="myCarousel" class="carousel slide" data-ride="carousel">
    <!-- Indicators -->
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
      <li data-target="#myCarousel" data-slide-to="3"></li>
    </ol>

    <!-- Wrapper for slides -->
    <div class="carousel-inner" role="listbox" >
      <div class="item active">
        <img src="img/slider3.jpg" alt="Chania" width="460" height="345">
		<div class="slide-text col-sm-7">
	  <h2>Shop securely, transfer money for free, access your funds instantly</h2>
      <p>Trusted by millions</p>
      <p class="button-container">
	  <a href="prices_packages.php" class="button large">View Prices</a> 
	  <a href="prices_packages.php" class="button secondary large">Start</a></p>
	  </div>
	  <div class="down-arrow">
	  <a href="#indicators" class="smoothScroll">
	  <i class="fa fa-angle-down"></i>
	  </a>
	  </div>
      </div>

    



      <div class="item">
        <img src="img/slider1.png" alt="Chania" width="460" height="345">
		
		<div class="slide-text2 col-sm-5">
	  <h2>Shop securely, transfer money for free, access your funds instantly</h2>
      <p>Trusted by millions</p>
      <p class="button-container">
	  <a href="prices_packages.php" class="button large">View Prices</a> 
	  <a href="prices_packages.php" class="button secondary large">Start</a></p>
	  </div>
	  <div class="down-arrow">
	  <a href="#indicators" class="smoothScroll">
	  <i class="fa fa-angle-down"></i>
	  </a>
	  </div>
      </div>
    
      <div class="item">
        <img src="img/slider4.png" alt="Flower" width="460" height="345">
		<div class="slide-text col-sm-7 slide3">
	  <h2>Shop securely, transfer money for free, access your funds instantly</h2>
      <p>Trusted by millions</p>
      <p class="button-container">
	  <a href="prices_packages.php" class="button large">View Prices</a> 
	  <a href="prices_packages.php" class="button secondary large">Start</a></p>
	  </div>
	  <div class="down-arrow arrow3" >
	  <a href="#indicators" class="smoothScroll">
	  <i class="fa fa-angle-down"></i>
	  </a>
	  </div>
      </div>

      <div class="item">
        <img src="img/slider5.jpg" alt="Flower" width="460" height="345">
		<div class="slide-text col-sm-6 slide3">
	  <h2>Shop securely, transfer money for free, access your funds instantly</h2>
      <p>Trusted by millions</p>
      <p class="button-container">
	  <a href="prices_packages.php" class="button large">View Prices</a> 
	  <a href="prices_packages.php" class="button secondary large">Start</a></p>
	  </div>
	  <div class="down-arrow">
	  <a href="#indicators" class="smoothScroll">
	  <i class="fa fa-angle-down"></i>
	  </a>
	  </div>
      </div>
    </div>
    <!-- Left and right controls -->
    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
      <span aria-hidden="true"><i class="fa fa-chevron-circle-left" id="indicators"></i>
</span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
      <span aria-hidden="true">
	  <i class="fa fa-chevron-circle-right"></i>
</span>
      <span class="sr-only">Next</span>
    </a>
  </div>
</div>



<!-----------icons section------------->

<section id="icons">
<section id="pricePlans">
<div class="container">
		<div id="plans">
		<div class="col-sm-3 col-xs-6 plan">
			<div class="icon">
<h2>Registered Office</h2>
<img src="img/merchant-services.png" class="img-responsive" />
</div>
				<ul class="planContainer">
					  <form method="post" action="<?php $_SERVER['php_self']; ?>" >
					<li class="price"><p>£29/per year</p></li>
					<li>
						<ul class="options">
							<li>2% <span>Credit Card Transaction fee</span></li>
                            <li>2% <span>Debit Card Transaction fee</span></li>
							<!--<li>Setup fee <span>&pound;99.00</span></li>-->
							<li>£0.25 <span>Authorisation Request Fee</span></li>
							<li>Free <span>Virtual Terminal</span></li>
                            <li>Free <span>e-Invoicing</span></li>
							<li>3D secure <span>Hosted Payment Page</span></li>
						</ul>
					</li>
                  
                    <input type="hidden" name="package_id" value="1" />
                    <input type="hidden" name="package_name" value="Registered Office" />
                    <input type="hidden" name="price" value="29" />
                    <input type="hidden" size="2" maxlength="2" name="product_qty" value="1" />
                    <input type="hidden" name="type" value="add" />
                    <input type="hidden" name="return_url" value="<?php $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    echo $current_url; ?>" />
                                        
                   <a href="shoppingcart.php"> <li class="button"> <input type="submit" value="START TODAY" name="AddToCart_Submit" class="btn2"></li></a>
                    <li class="more"><a href="javascript:slideonlyone('pricingpanes1');">Full Information ▼ </a></li>
                      </form>
				</ul>
			</div>
			<div class="col-sm-3 col-xs-6 plan">
			<div class="icon">
<h2>Business Address</h2>
<img src="img/reseller.png" class="img-responsive" />
</div>
				<ul class="planContainer">
					  <form method="post" action="<?php $_SERVER['php_self']; ?>" >
					<li class="price"><p>£99/per year</p></li>
					<li>
						<ul class="options">
							<li>1.79% <span>Credit Card Transaction fee</span></li>
                            <li>1% <span>Debit Card Transaction fee</span></li>
							<!--<li>Setup fee <span>&pound;99.00</span></li>-->
							<li>£0.20 <span>Authorisation Request Fee</span></li>
							<li>Free <span>Virtual Terminal</span></li>
							<li>3D secure <span>Hosted Payment Page</span></li>
                            <li>PCI DSS Approved <span>Remote API</span></li>
						</ul>
					</li>
                     <input type="hidden" name="package_id" value="2" />
                    <input type="hidden" name="package_name" value="Business Address" />
                    <input type="hidden" name="price" value="99" />
                    <input type="hidden" size="2" maxlength="2" name="product_qty" value="1" />
                    <input type="hidden" name="type" value="add" />
                    <input type="hidden" name="return_url" value="<?php $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    echo $current_url; ?>" />
                    
				 <li class="button"> <input type="submit" value="START TODAY" name="AddToCart_Submit" class="btn2"></li>
                    <li class="more"><a href="javascript:slideonlyone('pricingpanes2');">Full Information ▼</a></li>
                    </form>
				</ul>
			</div>

			<div class="col-sm-3 col-xs-6 plan">
			<div class="icon">
<h2>Telephone Service</h2>
<img src="img/merchant-services.png" class="img-responsive" />
</div>
				<ul class="planContainer">
					 <form method="post" action="<?php $_SERVER['php_self']; ?>" >
					<li class="price"><p>£99/per year</p></li>
					<li>
						<ul class="options">
							<li>1.29% <span>Credit Card Transaction fee</span></li>
                            <li>1% <span>Debit Card Transaction fee</span></li>
							<!--<li>Setup fee <span>&pound;99.00</span></li>-->
							<li>£0.15 <span>Authorisation Request Fee</span></li>
                            <li>Free <span>Virtual Terminal</span></li>
							<li>3D secure <span>Hosted Payment Page</span></li>
                            <li>PCI DSS Approved <span>Remote API</span></li>
						</ul>
					<input type="hidden" name="package_id" value="3" />
                    <input type="hidden" name="package_name" value="Telephone Service" />
                    <input type="hidden" name="price" value="99" />
                    <input type="hidden" size="2" maxlength="2" name="product_qty" value="1" />
                    <input type="hidden" name="type" value="add" />
                    <input type="hidden" name="return_url" value="<?php $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    echo $current_url; ?>" />
 					</li>
				 <li class="button"> <input type="submit" value="START TODAY" name="AddToCart_Submit" class="btn2"></li>
                    <li class="more"><a href="javascript:slideonlyone('pricingpanes3');">Full Information ▼</a></li>
                    </form>
				</ul>
			</div>
			
			<div class="col-sm-3 col-xs-6 plan">
			<div class="icon">
<h2>Complete Package</h2>
<img src="img/card.png" class="img-responsive" />
</div>
				<ul class="planContainer">
					 <form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" >
					<li class="price"><p>£199/per year</li>
					<li>
						<ul class="options">
							<li>1.29% <span>Credit Card Transaction fee</span></li>
                            <li>1% <span>Debit Card Transaction fee</span></li>
							
							<li>£0.15 <span>Authorisation Request Fee</span></li>
                            <li>Free <span>Virtual Terminal</span></li>
							<li>3D secure <span>Hosted Payment Page</span></li>
                            <li>PCI DSS Approved <span>Remote API</span></li>
						</ul>
                                       
 					</li>
                          <input type="hidden" name="package_id" value="4" />
                    <input type="hidden" name="package_name" value="Complete Package" />
                    <input type="hidden" name="price" value="199" />
                    <input type="hidden" size="2" maxlength="2" name="product_qty" value="1" />
                    <input type="hidden" name="type" value="add" />
                    <input type="hidden" name="return_url" value="<?php $current_url = urlencode($url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
                    echo $current_url; ?>" />
					 <li class="button"> <input type="submit" value="START TODAY" name="AddToCart_Submit" class="btn2"></li>
                    <li class="more"><a href="javascript:slideonlyone('pricingpanes3');">Full Information ▼</a></li>
                    </form>
				</ul>
			</div>
		</div ><!-- End ul#plans -->
</div>
</section>
<section id="pricedetails">
	 <div class="container">
   					 <div class="panes1" id="pricingpanes1">
								<div>
                                <a name="startup"></a><h1 class="info-title">Registered Office</h1>
    							<table>
                                     <tbody>
                                            <tr>
                                                <th colspan="2">Included in the pricing plan:</th>
                                            </tr>
                                        <tr>
                                          <td><a href="merchant-account.php">Merchant Account</a> for accepting credit and debit card payments</td>
                                          <td width="15%"><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="payment-gateway.php">Online Payment Gateway</a> for processing credit and debit card payments</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="e-invoicing.php">e-Invoicing</a></td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="mail-and-telephone-order.php">Virtual Terminal</a> for processing Mail and Telephone Orders</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td>Hosted Payment Page with 3D secure enabled</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    
                                    <table>
                                     <tbody>
                                            <tr>
                                                <th colspan="2">What you pay</th>
                                            </tr>
                                        
                                        <tr>
                                          <td>Monthly Fee</td>
                                          <td width="15%">&pound;10.00</td>
                                        </tr>
                                        
                                      </tbody>
                                    </table>
                                    <table>				
                                       <tbody>
                                       	<tr>
                                              <th>Transaction Charges*</th>
                                              <th width="15%">Cost Per Transaction</th>
                                            </tr>
                                            <tr>
                                              <td>Credit/Debit Cards</td>
                                              <td width="15%">2%</td>
                                            </tr>
                                            <tr>
                                              <td>Amex Cards</td>
                                              <td>4.00%</td>
                                            </tr>
                                            <tr>
                                              <td>Authorisation Request Fee</td>
                                              <td>&pound;0.25</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    <h3>Remittance Fees</h3>
                                    <table>
                                      <tbody>
                                      <tr>
                                          <th>Remittance Type</th>
                                          <th width="15%">Cost Per Transfer</th>
                                        </tr>
                                        <tr>
                                          <td>Under £100,000 remittance from your CashFlows Merchant Account to UK Bank Account in GBP only.</td>
                                          <td>FREE</td>
                                        </tr>
                                        <tr>
                                          <td>Over £100,000 remittance from your CashFlows Merchant Account to UK Bank Account in GBP only.</td>
                                          <td>&pound;10.00</td>
                                        </tr>
                                        <tr>
                                          <td>EURO Remittance from your CashFlows Merchant Account to a Bank Account which accepts SEPA.</td>
                                          <td>&euro;4.00</td>
                                        </tr>
                                        <tr>
                                          <td>Remittance from your CashFlows Merchant Account to a Bank Account not in the Eurozone.</td>
                                          <td>&pound;15.00</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <p><small>* The transaction charges are based upon a default monthly card turnover, trading history, business background and risk sector. We can provide a more tailored pricing plan to your suit your business upon request to: <a href="mailto:sales@cashflows.com">sales@cashflows.com</a></small></p>
   								 </div></div>
                                 <div id="pricingpanes2" class="panes1">
								<div>
                               <a name="enterprise"></a> <h1 class="info-title">Business Address</h1>
    							<table>
                                     <tbody>
                                            <tr>
                                                <th colspan="2">Included in the pricing plan:</th>
                                            </tr>
                                        <tr>
                                          <td><a href="merchant-account.php">Merchant Account</a> for accepting credit and debit card payments</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="payment-gateway.php">Online Payment Gateway</a> for processing credit and debit card payments</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="e-invoicing.php">e-Invoicing</a></td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="mail-and-telephone-order.php">Virtual Terminal</a> for processing Mail and Telephone Orders</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td>3D secure enabled Hosted Payment Page or PCI DSS Approved Remote API</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    
                                    <table>
                                     <tbody>
                                            <tr>
                                                <th colspan="2">What you pay</th>
                                            </tr>
                                       
                                        <tr>
                                          <td>Monthly Fee</td>
                                          <td width="15%">&pound;19.00</td>
                                        </tr>
                                        
                                      </tbody>
                                    </table>
                                    <table>				
                                       <tbody>
                                       	<tr>
                                              <th>Transaction Charges*</th>
                                              <th width="15%">Cost Per Transaction</th>
                                            </tr>
                                            <tr>
                                              <td>Domestic Consumer Credit Cards (3D secure / non 3D Secure)</td>
                                              <td width="15%">1.79% / 1.99%</td>
                                            </tr>
                                            <tr>
                                              <td>Domestic Consumer/Corporate Debit Cards</td>
                                              <td>1.00%</td>
                                            </tr>
                                             <tr>
                                              <td>Domestic Corporate Credit Cards (3D secure / non 3D Secure)</td>
                                              <td>2.79% / 2.99%</td>
                                            </tr>
                                            <tr>
                                              <td>Regional Consumer Credit/Debit Cards (3D secure / non 3D Secure)</td>
                                              <td>1.79% / 1.99%</td>
                                            </tr>
                                            <tr>
                                               <td>Regional Corporate Credit/Debit Cards (3D secure / non 3D Secure)</td>
                                              <td>2.79% / 2.99%</td>
                                            </tr>
                                            <tr>
                                              <td>International Consumer Credit/Debit Cards (3D secure / non 3D Secure)</td>
                                              <td>3.05% / 3.29%</td>
                                            </tr>
                                            <tr>
                                               <td>International Corporate Credit/Debit Cards (3D secure / non 3D Secure)</td>
                                              <td>3.59% / 3.79%</td>
                                            </tr>
                                            <tr>
                                              <td>Amex Cards</td>
                                              <td>4.00%</td>
                                            </tr>
                                            <tr>
                                              <td>Authorisation Request Fee</td>
                                              <td>&pound;0.20</td>
                                            </tr>

                                          </tbody>
                                        </table>
                                    <h3>Remittance Fees</h3>
                                    <table>
                                      <tbody>
                                      <tr>
                                          <th>Remittance Type</th>
                                          <th width="15%">Cost Per Transfer</th>
                                        </tr>
                                        <tr>
                                          <td>Under £100,000 remittance from your CashFlows Merchant Account to UK Bank Account in GBP only.</td>
                                          <td>FREE</td>
                                        </tr>
                                        <tr>
                                          <td>Over £100,000 remittance from your CashFlows Merchant Account to UK Bank Account in GBP only.</td>
                                          <td>&pound;10.00</td>
                                        </tr>
                                        <tr>
                                          <td>EURO Remittance from your CashFlows Merchant Account to a Bank Account which accepts SEPA.</td>
                                          <td>&euro;4.00</td>
                                        </tr>
                                        <tr>
                                          <td>Remittance from your CashFlows Merchant Account to a Bank Account not in the Eurozone.</td>
                                          <td>&pound;15.00</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <p><small>* The transaction charges are based upon a default monthly card turnover, trading history, business background and risk sector. We can provide a more tailored pricing plan to your suit your business upon request to: <a href="mailto:sales@cashflows.com">sales@cashflows.com</a></small></p>
   								 </div></div>
                                 <div id="pricingpanes3" class="panes1">
								<div>
                                <a name="coporate"></a><h1 class="info-title">Telephone Service</h1>
    							<table>
                                     <tbody>
                                            <tr>
                                                <th colspan="2">Included in the pricing plan:</th>
                                            </tr>
                                        <tr>
                                          <td><a href="merchant-account.php">Merchant Account</a> for accepting credit and debit card payments</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="payment-gateway.php">Online Payment Gateway</a> for processing credit and debit card payments</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="e-invoicing.php">e-Invoicing</a></td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td><a href="mail-and-telephone-order.php">Virtual Terminal</a> for processing Mail and Telephone Orders</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                        <tr>
                                          <td>3D secure enabled Hosted Payment Page or PCI DSS Approved Remote API</td>
                                          <td><img src="img/tick.png" alt="Included" /></td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    
                                    <table>
                                     <tbody>
                                            <tr>
                                                <th colspan="2">What you pay</th>
                                            </tr>
                                        
                                        <tr>
                                          <td>Monthly Fee</td>
                                          <td width="15%">&pound;34.99</td>
                                        </tr>
                                        
                                      </tbody>
                                    </table>
                                    <table>				
                                       <tbody>
                                       	<tr>
                                              <th>Transaction Charges*</th>
                                              <th width="15%">Cost Per Transaction</th>
                                            </tr>
                                            <tr>
                                              <td>Domestic Consumer Credit Cards (3D secure / non 3D Secure)</td>
                                              <td width="15%">1.29% / 1.49%</td>
                                            </tr>
                                            <tr>
                                              <td>Domestic Consumer/Corporate Debit Cards</td>
                                              <td>1.00%</td>
                                            </tr>
                                             <tr>
                                              <td>Domestic Corporate Credit Cards (3D secure / non 3D Secure)</td>
                                              <td>2.29% / 2.49%</td>
                                            </tr>
                                            <tr>
                                              <td>Regional Consumer Credit/Debit Cards (3D secure / non 3D Secure)</td>
                                              <td>1.29% / 1.49%</td>
                                            </tr>
                                            <tr>
                                               <td>Regional Corporate Credit/Debit Cards (3D secure / non 3D Secure)</td>
                                              <td>2.29% / 2.49%</td>
                                            </tr>
                                            <tr>
                                              <td>International Consumer Credit/Debit Cards (3D secure / non 3D Secure)</td>
                                              <td>2.59% / 2.79%</td>
                                            </tr>
                                            <tr>
                                               <td>International Corporate Credit/Debit Cards (3D secure / non 3D Secure)</td>
                                              <td>3.59% / 3.79%</td>
                                            </tr>
                                            <tr>
                                              <td>Amex Cards</td>
                                              <td>4.00%</td>
                                            </tr>
                                            <tr>
                                              <td>Authorisation Request Fee</td>
                                              <td>&pound;0.15</td>
                                            </tr>
                                          </tbody>
                                        </table>
                                    <h3>Remittance Fees</h3>
                                    <table>
                                      <tbody>
                                      <tr>
                                          <th>Remittance Type</th>
                                          <th width="15%">Cost Per Transfer</th>
                                        </tr>
                                        <tr>
                                          <td>Under £100,000 remittance from your CashFlows Merchant Account to UK Bank Account in GBP only.</td>
                                          <td>FREE</td>
                                        </tr>
                                        <tr>
                                          <td>Over £100,000 remittance from your CashFlows Merchant Account to UK Bank Account in GBP only.</td>
                                          <td>&pound;10.00</td>
                                        </tr>
                                        <tr>
                                          <td>EURO Remittance from your CashFlows Merchant Account to a Bank Account which accepts SEPA.</td>
                                          <td>&euro;4.00</td>
                                        </tr>
                                        <tr>
                                          <td>Remittance from your CashFlows Merchant Account to a Bank Account not in the Eurozone.</td>
                                          <td>&pound;15.00</td>
                                        </tr>
                                      </tbody>
                                    </table>
                                    <p><small>* The transaction charges are based upon a default monthly card turnover, trading history, business background and risk sector. We can provide a more tailored pricing plan to your suit your business upon request to: <a href="mailto:sales@cashflows.com">sales@cashflows.com</a></small></p>
   								 </div></div>
								 </div>
                                 </section>
</section>
<?php include('footer.php'); ?>

