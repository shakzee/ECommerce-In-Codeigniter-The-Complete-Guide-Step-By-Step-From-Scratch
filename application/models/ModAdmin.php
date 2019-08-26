<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 1/27/2018
 * Time: 6:24 PM
 */

class ModAdmin extends CI_Model
{
	public function checkAdmin($data)
	{
		return $this->db->get_where('admin',$data)
			->result_array();
	}
	public function checkCategory($data)
	{
		return $this->db->get_where('categories',array('cName'=>$data['cName']));
	}
	public function addCategory($data)
	{
		return $this->db->insert('categories',$data);
	}

	public function getAllCategories()
	{
		return $this->db->get_where('categories',array('cStatus'=>1))->num_rows();
	}

	public function fetchAllCategories($limit,$start)
	{
		$this->db->limit($limit,$start);
		$query = $this->db->get_where('categories',array('cStatus'=>1));
		if ($query->num_rows() > 0 ) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;

	}

	public function checkCatetgoryById($cId)
	{
		return $this->db->get_where('categories',array('cId'=>$cId))->result_array();
	}

	public function updateCategory($data,$cId)
	{
		$this->db->where('cId',$cId);
		return $this->db->update('categories',$data);
	}

	public function deleteCatetory($cId)
	{
		$this->db->where('cId',$cId);
		return $this->db->delete('categories');
	}

	public function getCategoryImage($cId)
	{
		return $this->db->select('cDp')
			->from('categories')
			->where('cId',$cId)
			->get()
		->result_array();
	}

	public function getCategories()
	{
		return $this->db->get_where('categories',array('cStatus'=>1));
	}

	public function checkProduct($data)
	{
		return $this->db->get_where('products',array(
			'pName'=>$data['pName'],
			'categoryId'=>$data['categoryId']
		));
	}

	public function addProduct($data)
	{
		return $this->db->insert('products',$data);
	}

	public function getAllProducts()
	{
		return $this->db->get_where('products',array('pStatus'=>1))->num_rows();
	}

	public function fetchAllProducts($limit,$start)
	{
		$this->db->limit($limit,$start);
		$query = $this->db->get_where('products',array('pStatus'=>1));
		if ($query->num_rows() > 0 ) {
			foreach ($query->result() as $row) {
				$data[] = $row;
			}
			return $data;
		}
		return false;

	}
	public function getProductImage($pId)
	{
		return $this->db->select('pDp')
			->from('products')
			->where('pId',$pId)
			->get()
			->result_array();
	}
	public function deleteProduct($pId)
	{
		$this->db->where('pId',$pId);
		return $this->db->delete('products');
	}

	public function checkProductById($pId)
    {
        return $this->db->get_where('products',array('pId'=>$pId))->result_array();
    }

	public function updateProduct($data,$pId)
	{
		$this->db->where('pId',$pId);
		return $this->db->update('products',$data);
	}

    public function getProducts()
    {
        return $this->db->select('pId,pName')
            ->from('products')
            ->where('pStatus',1)
            ->get();
	}

    public function checkModel($data)
    {
        return $this->db->get_where('models',array(
            'mName'=>$data['mName'],
            'productId'=>$data['productId']
        ));
    }

    public function addModel($data)
    {
        return $this->db->insert('models',$data);
    }

    public function getAllModels()
    {
        return $this->db->get_where('models',array('mStatus'=>1))->num_rows();
    }

    public function fetchAllModels($limit,$start)
    {
        $this->db->limit($limit,$start);
        $this->db->order_by('mId','desc');
        $query = $this->db->get_where('models',array('mStatus'=>1));
        if ($query->num_rows() > 0 ) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }

    public function getModelImage($mId)
    {
        return $this->db->select('mDp')
            ->from('models')
            ->where('mId',$mId)
            ->get()
            ->result_array();
    }
    public function deleteModel($mId)
    {
        $this->db->where('mId',$mId);
        return $this->db->delete('models');
    }

    public function checkModelById($mId)
    {
        return $this->db->get_where('models',array('mId'=>$mId))->result_array();
    }

    public function updateModel($data,$modeId)
    {
        $this->db->where('mId',$modeId);
        return $this->db->update('models',$data);
    }

    public function getModel()
    {
        return $this->db->get_where('models',array('mStatus'=>1));
    }

    public function checkSpecs($data)
    {
        return $this->db->get_where('specs',array(
            'spName'=>$data['spName'],
            'modelId'=>$data['modelId']
        ));
    }

    public function checkSpecName($value)
    {
        $this->db->insert('specs',$value);
        return $this->db->insert_id();

    }

    public function checkSpecValues($value)
    {
        return  $this->db->insert_batch('spec_values',$value);
    }


    public function getAllSpecs()
    {
        return $this->db->get_where('specs',array('spStatus'=>1))->num_rows();
    }

    public function fetchAllSpecs($limit,$start)
    {
        $this->db->limit($limit,$start);
        $query = $this->db->select('specs.*,models.mName')
            ->from('specs')
            ->where('specs.spStatus','1')
            ->join('models','models.mId  = specs.modelId')
            ->get();
        //$query = $this->db->get_where('specs',array('spStatus'=>1));

        if ($query->num_rows() > 0 ) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return false;

    }


    public function deleteSpec($mId)
    {
        $this->db->where('spId',$mId);
        return $this->db->delete('specs');
    }

    public function checkSpecById($pId)
    {
        return $this->db->get_where('specs',array('spId'=>$pId))->result_array();
    }

    public function updateSpec($value,$specId)
    {
        $this->db->where('spId',$specId);
        return $this->db->update('specs',$value);
    }
}//classs
