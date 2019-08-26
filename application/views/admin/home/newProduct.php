<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/23/2018
 * Time: 5:35 PM
 */
?>


<div class="content-wrapper">
	<div class="row padtop">
		<div class="col-md-6 col-md-offset-3">
			<?php if($this->session->flashdata('class')):?>
				<div class="alert <?php echo $this->session->flashdata('class')?> alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $this->session->flashdata('message');?>
				</div>
			<?php endif; ?>
			<h3>Add New Product</h3>
			<?php echo form_open_multipart('admin/addProduct','','')?>
			<div class="form-group">
				<?php echo form_input('productName','',array('placeholder'=>'Enter Model Name','class'=>'form-control')); ?>
			</div>
			<div class="form-group">
				<?php echo form_input('company','',array('placeholder'=>'Enter Company Name','class'=>'form-control')); ?>
			</div>

			<div class="form-group">
				<?php
					$categoiesOptions = array();
					foreach ($categories->result() as $category){
						$categoiesOptions[$category->cId] = $category->cName;
					}
					echo form_dropdown('categoryId',$categoiesOptions,'','class="form-control"');
				?>
			</div>
			<div class="form-group">
				<?php echo form_upload('prodDp','','');  ?>
			</div>
			<div class="form-group">
				<?php echo form_submit('Add Product','Add Product','class="btn btn-primary"');  ?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
