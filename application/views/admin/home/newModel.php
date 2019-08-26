<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 3/23/2018
 * Time: 5:11 PM
 */
?>

<div class="content-wrapper">
	<div class="row padtop">
		<?php if($this->session->flashdata('class')):?>
			<div class="alert <?php echo $this->session->flashdata('class')?> alert-dismissible" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<?php echo $this->session->flashdata('message');?>
			</div>
		<?php endif; ?>
		<div class="col-md-6 col-md-offset-3">
			<?php echo form_open_multipart('admin/addModel','','')?>
			<div class="form-group">
				<?php echo form_input('productName','',array('class'=>'form-control','placeholder'=>'Enter the Model')); ?>
			</div>
			<div class="form-group">
				<?php echo form_input('companyName','',array('class'=>'form-control','placeholder'=>'Enter the Company Name')); ?>
			</div>
			<div class="form-group">
				<?php
					$cateOptions = array();
					foreach ($categories->result() as $category){
						$cateOptions[$category->cId] = $category->cName;
					}
					echo form_dropdown('category',$cateOptions, '','class="form-control"');
				?>
			</div>
			<div class="form-group">
				<?php echo form_upload('modDp','','');  ?>
			</div>
			<div class="form-group">
				<?php echo form_submit('Add Model','Add Model','class="btn btn-primary"');  ?>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
</div>
