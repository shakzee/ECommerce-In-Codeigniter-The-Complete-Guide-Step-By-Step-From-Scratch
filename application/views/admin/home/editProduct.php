<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/25/2018
 * Time: 7:30 PM
 */
?>

<div class="content-wrapper">
	<div class="row padtop">
		<div class="col-md-6 col-md-offset-1">
			<?php if($this->session->flashdata('class')):?>
				<div class="alert <?php echo $this->session->flashdata('class')?> alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $this->session->flashdata('message');?>
				</div>
			<?php endif; ?>
			<h3>Edit <?php echo $products[0]['pName'];?> Product</h3>
			<?php echo form_open_multipart('admin/updateProduct','','')?>
			<div class="form-group">
				<?php echo form_input('productName',$products[0]['pName'],array('placeholder'=>'Enter Model Name','class'=>'form-control')); ?>
			</div>
			<div class="form-group">
				<?php echo form_input('company',$products[0]['pCompany'],array('placeholder'=>'Enter Company Name','class'=>'form-control')); ?>
			</div>
				<input name="xid" type="hidden" value="<?php echo $products[0]['pId'] ?>">
				<input name="oldImg" type="hidden" value="<?php echo $products[0]['pDp'] ?>">
			<div class="form-group">
				<?php
				$categoiesOptions = array();
				foreach ($categories->result() as $category){
					$categoiesOptions[$category->cId] = $category->cName;
				}
				echo form_dropdown('categoryId',$categoiesOptions,$products[0]['categoryId'],'class="form-control"');
				?>
			</div>
			<div class="form-group">
				<?php echo form_upload('prodDp','','');  ?>
			</div>
			<div class="form-group">
				<?php echo form_submit('Update Product','Update Product','class="btn btn-primary"');  ?>
			</div>
			<?php echo form_close(); ?>
		</div>
		<div class="col-md-4">
			<img src="<?php echo base_url('assets/images/products/'.$products[0]['pDp']); ?>">
		</div>
	</div>
</div>
