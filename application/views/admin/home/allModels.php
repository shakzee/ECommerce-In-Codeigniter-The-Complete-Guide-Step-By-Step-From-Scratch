<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 4/1/2018
 * Time: 5:33 PM
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
            <h2>All Models</h2>
            <div class="error">

            </div>
            <?php if($allmodels): ?>
                <table class="table table-dashed">
                    <th>Id</th>
                    <th>Product Name</th>
                    <th>Company</th>
                    <th>Edit</th>
                    <th>Delete</th>
                    <?php foreach($allmodels as $model): ?>
                        <tr class="ccat<?php echo $spec->mId;?>">
                            <td>
                                <?php echo $model->mId?>
                            </td>
                            <td>
                                <?php echo $model->mName?>
                            </td>
                            <td>
                                <?php echo $model->mDescription?>
                            </td>
                            <td>
                                <a href="<?php echo site_url('admin/editModel/'. $model->mId)?>" class="btn btn-info">
                                    Edit
                                </a>
                            </td>
                            <td>
                                <a href="javascript:void(0)" class="btn btn-danger delmodel" data-id="<?php echo $model->mId;?>" data-text="<?php echo $this->encryption->encrypt($model->mId)?>">
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
