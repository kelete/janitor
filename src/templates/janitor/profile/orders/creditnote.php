<?php
global $action;
global $model;


$order_id = $action[2];

$SC = new Shop();
$order = $SC->getOrders(array("order_id" => $action[2]));

if($order && $order["status"] >= 2) {

	$this->bodyClass("invoice");

	$creditnote_no = $SC->getCreditnoteNo(["order_id" => $order_id]);
	$this->pageTitle("Creditnote ".$creditnote_no);

	$total_order_price = $SC->getTotalOrderPrice($order["id"]);
}

?>
<div class="scene i:scene invoice">
<? if($order && $order["status"] >= 2): ?>

	<div class="basics">

		<? include("templates/janitor/shop/order/invoice-seller.php") ?>

		<h2>Creditnote: <?= $creditnote_no ?></h2>
		<dl class="info">
			<dt>Order No</dt>
			<dd><?= $order["order_no"] ?></dd>
			<dt>Created</dt>
			<dd><?= $order["created_at"] ?></dd>
			<? if($order["modified_at"]): ?>
			<dt>Completed</dt>
			<dd><?= $order["modified_at"] ?></dd>
			<? endif; ?>
		</dl>

	</div>

	<div class="buyer">
		<h2>Buyer</h2>

		<ul class="info">
			<li><?= $order["billing_name"] ?></li>
			<? if($order["billing_att"]): ?><li><?= $order["billing_att"] ?></li><? endif; ?>
			<? if($order["billing_address1"]): ?><li><?= $order["billing_address1"] ?></li><? endif; ?>
			<? if($order["billing_address2"]): ?><li><?= $order["billing_address2"] ?></li><? endif; ?>
			<? if($order["billing_postal"]): ?><li><?= $order["billing_postal"] ?> <?= $order["billing_city"] ?></li><? endif; ?>
			<? if($order["billing_state"]): ?><li><?= $order["billing_state"] ?></li><? endif; ?>
			<? if($order["billing_country"]): ?><li><?= $order["billing_country"] ?></li><? endif; ?>
		</ul>
	</div>

	<div class="all_items">
		<h2><?= pluralize(count($order["items"]), "item", "items") ?></h2>
		<? if($order["items"]): ?>
		<ul class="items">
			<? foreach($order["items"] as $order_item): ?>
			<li class="item <?= superNormalize($model->order_statuses[$order["status"]]) ?><?= ($order_item["shipped_by"] ? " shipped" : "") ?>">
				<h3>

					<span class="quantity"><?= $order_item["quantity"] ?></span>
					<span class="name">x <?= $order_item["name"] ?> á</span>
					<span class="unit_price">
						-<?= formatPrice(array(
								"price" => $order_item["unit_price"], 
								"vat" => $order_item["unit_vat"], 
								"currency" => $order["currency"], 
								"country" => $order["country"]
						)) ?>
					</span>
					<span class="total_price">
						-<?= formatPrice(array(
								"price" => $order_item["total_price"], 
								"vat" => $order_item["total_vat"], 
								"currency" => $order["currency"], 
								"country" => $order["country"]
							)
						) ?>
					</span>
				</h3>

			</li>
			<? endforeach; ?>
			<li class="order_total">
				<span>Total</span> <span class="amount">-<?= formatPrice($total_order_price, ["vat" => false]) ?></span>
			</li>
			<li class="order_vat">
				<span>VAT</span> <span class="amount">-<?= formatPrice(["price" => $total_order_price["vat"], "currency" => $total_order_price["currency"]], ["vat" => false]) ?>
			</li>
		</ul>
		<? else: ?>
		<p>No Items in order</p>
		<? endif; ?>

	</div>



<? else: ?>

	<h1>Creditnote</h1>
	<ul class="actions i:defaultEditActions">
		<?= $HTML->link("Order", "/janitor/admin/shop/order/edit/".$order_id, array("class" => "button", "wrapper" => "li.order")) ?>
	</ul>

	<p>Creditnote does not exist. Creditnotes can only be viewed for cancelled orders.</p>

<? endif; ?>

</div>
