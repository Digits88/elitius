<?php
/***************************************************************************
 *
 *	 PROJECT: eLitius Open Source Affiliate Software
 *	 VERSION: 1.0
 *	 LISENSE: GNU GPL (http://www.opensource.org/licenses/gpl-license.html)
 *
 *   This program is free software; you can redistribute it and/or modify
 *   it under the terms of the GNU General Public License as published by
 *   the Free Software Foundation.
 *
 *   Link to eLitius.com can not be removed from the software pages without
 *	 permission of the eLitius respective owners. It is the only requirement
 *	 for using this software.
 *
 *   Copyright 2009 Intelliants LLC
 *   http://www.intelliants.com/
 *
 ***************************************************************************/

require_once('./init.php');
$gDesc = $gXpLang['pay_affiliates'];
$gPage = $gXpLang['pay_affiliates'];
$gPath = 'pay-affiliates';
require_once('header.php');

$items = (int)$_GET['items'];
$items = $items ? $items : 5 ;

define(ITEMS_PER_PAGE, $items);

$page = (int)$_GET['page'];
$page = ($page < 1) ? 1 : $page;
$start = ($page - 1) * ITEMS_PER_PAGE;

$commissions =& $gXpAdmin->getAccountsToBePaid($start, ITEMS_PER_PAGE);
$commissions_num = count($gXpAdmin->getAccountsToBePaid(0, 0));
?>

<br />
		<form action="pay-affiliate.php" method="post" name="adminForm">

			<table class="adminlist" style="text-align: left;">

				<tr>
					<th>ID</th>
					<th><?php echo $gXpLang['username']; ?></th>
					<th><?php echo $gXpLang['sales']; ?></th>
					<th><?php echo $gXpLang['balance']; ?></th>
					<th><?php echo $gXpLang['process']; ?></th>
				</tr>
<?php
	for($i=0; $i<count($commissions); $i++)
	{
		$account = $gXpAdmin->getAffiliateById($commissions[$i]['aff_id']);

?>	
				<tr class="row<?php echo ($i%2? 1:0);?>">
					<td><?php echo $account['id'];?></td>
					<td><a href="manage-account.php?id=<?php echo $account['id'];?>" title="<?php echo $gXpLang['edit_account']; ?>"><?php echo $account['username'];?></a></td>
					<td><?php echo $commissions[$i]['Sales'];?></td>
					<td><?php echo format($commissions[$i]['Total']*$gXpConfig['payout_percent']/100);?></td>
					<td><a href="manage-payment.php?id=<?php echo $account['id'];?>"><?php echo $gXpLang['continue']; ?></a></td>
				</tr>
<?php
	}
	if(count($commissions)==0)
	{ ?>
		<tr class="row0">
			<td colspan="5" align="center">No Items</td>
		</tr>
	<?php
	}
?>
			</table>

			<input type="hidden" name="task" value="" />
		</form>

		<div style="height: 30px;"></div>
<?php
	$url = "pay-affiliates.php?items=".ITEMS_PER_PAGE;
	navigation($commissions_num, $start, count($commissions), $url, ITEMS_PER_PAGE);

?>

	<!--main part ends-->
	
<?php
require_once('footer.php');	
?>
