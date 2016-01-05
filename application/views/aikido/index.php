<h2><?php echo $title; ?></h2>

<?php 
$row_count = 0;
foreach ($config as $config_row): 
?>
	<h3>
		Row 
		<?=$row_count?> 
		<?php 	
			if($config_row['active'])
				echo 'ACTIVE';
			else echo 'inactive'; 
		?>
	</h3>
<?php 
	$row_count++;
	endforeach; 
?>