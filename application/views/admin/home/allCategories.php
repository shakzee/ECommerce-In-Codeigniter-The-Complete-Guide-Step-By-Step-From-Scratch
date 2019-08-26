

<div class="content-wrapper">
	<div class="row padtop">
		<div class="col-md-6 col-md-offset-3">
			<?php if($this->session->flashdata('class')):?>
				<div class="alert <?php echo $this->session->flashdata('class')?> alert-dismissible" role="alert">
					<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
					<?php echo $this->session->flashdata('message');?>
				</div>
			<?php endif; ?>
			<h2>All Categories</h2>
			<div class="error">

			</div>
			<?php if($allCategories): ?>
				<table class="table table-dashed">
				<?php foreach($allCategories as $category ): ?>
					<tr class="ccat<?php echo $category->cId;?>">
						<td>
							<?php echo $category->cId?>
						</td>
						<td>
							<?php echo $category->cName?>
						</td>
						<td>
							<a href="<?php echo site_url('admin/editCategory/'. $category->cId)?>" class="btn btn-info">
								Edit
							</a>
						</td>
						<td>
							<a href="javascript:void(0)" class="btn btn-danger delcat" data-id="<?php echo $category->cId;?>" data-text="<?php echo $this->encryption->encrypt($category->cId)?>">
								Delete
							</a>
						</td>
					</tr>
				<?php endforeach;?>
					</table>
			<?php echo $links; ?>
			<?php else: ?>
				Categories not available
			<?php endif; ?>
		</div>
	</div>
</div>
