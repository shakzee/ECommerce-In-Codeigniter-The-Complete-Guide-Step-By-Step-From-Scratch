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
            <h3>Add New Specs</h3>
            <?php echo form_open_multipart('admin/addSepc','','')?>
            <div class="form-group">
                <?php
                $categoiesOptions = array();
                foreach ($models->result() as $model){
                    $modelOptions[$model->mId] = $model->mName;
                }
                echo form_dropdown('modelId',$modelOptions,'','class="form-control"');
                ?>
            </div>
            <div class="form-group">
                <?php echo form_input('sp_name','',array('placeholder'=>'Enter Spec Name','class'=>'form-control')); ?>
            </div>
            <div class="htmlitmes">
                <div class="form-group contspecval">
                    <?php echo form_input('so_val[]','',array('placeholder'=>'Enter Spec Value','class'=>'form-control sp_cn')); ?>
                    <a href="javascript:void(0)" class="add_spec">+</a>
                </div>
            </div>


            <div class="form-group">
                <?php echo form_submit('Add Spec','Add Spec','class="btn btn-primary"');  ?>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>
