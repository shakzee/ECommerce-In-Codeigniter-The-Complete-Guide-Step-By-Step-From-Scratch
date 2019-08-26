<?php
/**
 * Created by PhpStorm.
 * User: dell
 * Date: 1/27/2018
 * Time: 4:50 PM
 */

class Admin extends CI_Controller
{

	public function index()
	{

			if ($this->session->userdata('aId')) {
			$this->load->view('admin/header/header');
			$this->load->view('admin/header/css');
			$this->load->view('admin/header/navtop');
			$this->load->view('admin/header/navleft');
			$this->load->view('admin/home/index');
			$this->load->view('admin/header/footer');
			$this->load->view('admin/header/htmlclose');
		} else {
			setFlashData('alert-danger','Please login first to access your admin panel.','admin/login');
		}

	}

	public function login()
	{
		$this->load->view('admin/login');
	}

	public function checkAdmin()
	{
		$data['aEmail'] = $this->input->post('email',true);
		$data['aPassword'] = $this->input->post('password',true);

		if (!empty($data['aEmail']) && !empty($data['aPassword'])) {
			$admindata = $this->modAdmin->checkAdmin($data);
			if (count($admindata) == 1) {
				$forSession = array(
					'aId'=>$admindata[0]['aId'],
					'aName'=>$admindata[0]['aName'],
					'aEmail'=>$admindata[0]['aEmail'],
				);
				$this->session->set_userdata($forSession);
				if ($this->session->userdata('aId')) {
					redirect('admin');
				}
				else{
					echo 'session not created..';
				}
			} else {
				setFlashData('alert-warning','Email or Password is not matched please check your email and password.','admin/login');
			}

		}
		else{
			setFlashData('alert-warning','Please check the required fields.','admin/login');
		}
	}

	public function logOut()
	{
		if ($this->session->userdata('aId')) {
			$this->session->set_userdata('aId','');
			$this->session->set_flashdata('error','You have successfully logged out.');
			redirect('admin/login');
		}
		else{
			$this->session->set_flashdata('error','Please login now.');
			redirect('admin/login');
		}
	}

	public function newCategory()
	{
		/*echo phpinfo();
		die();*/
		if (adminLoggedIn()) {
			$this->load->view('admin/header/header');
			$this->load->view('admin/header/css');
			$this->load->view('admin/header/navtop');
			$this->load->view('admin/header/navleft');
			$this->load->view('admin/home/newCategory');
			$this->load->view('admin/header/footer');
			$this->load->view('admin/header/htmlclose');
		} else {
			setFlashData('alert-danger','Please login first to add your category.','admin/login');
		}

	}

	public function adddCategory()
	{
		if (adminLoggedIn()) {
			 $data['cName'] = $this->input->post('categoryName',true);
			if (!empty($data['cName'])) {
				$path = realpath(APPPATH.'../assets/images/categories/');
				$config['upload_path'] = $path ;
				$config['max_size'] = 100;
				$config['allowed_types'] = 'jpeg|gif|jpg|png' ;
				$this->load->library('upload',$config);
				if (!$this->upload->do_upload('catDp')) {
					$error = $this->upload->display_errors();
					setFlashData('alert-danger',$error,'admin/newCategory');
				}
				else{
					$fileName = $this->upload->data();
					$data['cDp'] = $fileName['file_name'];
					$data['cDate'] = date('Y-M-d h:i:sa');
					$data['adminId'] =  getAdminId();
				}
				$addDAta = $this->modAdmin->checkCategory($data);
				if ($addDAta->num_rows() > 0) {
					setFlashData('alert-danger','The category already exist.','admin/newCategory');
				}
				else{
					$addDAta = $this->modAdmin->addCategory($data);
					if ($addDAta) {
						setFlashData('alert-success','You have successfully added your category.','admin/newCategory');
					} else {
						setFlashData('alert-danger','You can\'t add your category right now.','admin/newCategory');
					}
				}


			} else {
				setFlashData('alert-danger','Category Name is required.','admin/newCategory');
			}

		} else {
			setFlashData('alert-danger','Please login first to add your category.','admin/login');
		}
	}

	public function allCategories()
	{

		if (adminLoggedIn()) {
			$config['base_url'] = site_url('admin/allCategories');
			$totalRows = $this->modAdmin->getAllCategories();

			$config['total_rows'] = $totalRows;
			$config['per_page'] = 10 ;
			$config['uri_segment'] = 3;
			$this->load->library('pagination');
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3))? $this->uri->segment(3):0;
			$data['allCategories'] = $this->modAdmin->fetchAllCategories($config['per_page'],$page);
			$data['links'] = $this->pagination->create_links();
			$this->load->view('admin/header/header');
			$this->load->view('admin/header/css');
			$this->load->view('admin/header/navtop');
			$this->load->view('admin/header/navleft');
			$this->load->view('admin/home/allCategories',$data);
			$this->load->view('admin/header/footer');
			$this->load->view('admin/header/htmlclose');

		} else {
			setFlashData('alert-danger','Please login first to add your category.','admin/login');

		}
		
	}

	public function editCategory($cId)
	{
		if (adminLoggedIn()) {
			if (!empty($cId) && isset($cId)) {
				$data['category'] = $this->modAdmin->checkCatetgoryById($cId);
				if (count($data['category']) == 1) {
					$this->load->view('admin/header/header');
					$this->load->view('admin/header/css');
					$this->load->view('admin/header/navtop');
					$this->load->view('admin/header/navleft');
					$this->load->view('admin/home/editCategory',$data);
					$this->load->view('admin/header/footer');
					$this->load->view('admin/header/htmlclose');
				} else {
					setFlashData('alert-danger','Category not found.','admin/allCategories');
				}
			} else {
				setFlashData('alert-danger','Something went wrong','admin/allCategories');
			}

		} else {
			setFlashData('alert-danger','Please login first to edit your category.','admin/login');
		}


	}

	public function updateCategory()
	{
		if (adminLoggedIn()) {
			$data['cName'] = $this->input->post('categoryName',true);
			$cId = $this->input->post('xid',true);
			$oldImg = $this->input->post('oldImg',true);
			if (!empty($data['cName']) && isset($data['cName'])) {
					if (isset($_FILES['catDp']) && is_uploaded_file($_FILES['catDp']['tmp_name'])) {
						$path = realpath(APPPATH.'../assets/images/categories/');
						$config['upload_path'] = $path ;
						$config['max_size'] = 100;
						$config['allowed_types'] = 'jpeg|gif|jpg|png' ;
						$this->load->library('upload',$config);
						if (!$this->upload->do_upload('catDp')) {
							$error = $this->upload->display_errors();
							setFlashData('alert-danger',$error,'admin/allCategories');
						}
						else{
							$fileName = $this->upload->data();
							$data['cDp'] = $fileName['file_name'];
						}
					}//image checking here

				$reply = $this->modAdmin->updateCategory($data,$cId);
				if ($reply) {
					if (!empty($data['cDp']) && isset($data['cDp'])) {
						if (file_exists($path.'/'.$oldImg)) {
							unlink($path.'/'.$oldImg);
						}
					}
					setFlashData('alert-success','You have successfully updated the category.','admin/allCategories');
				} else {
					setFlashData('alert-danger','You can\'t update your category right now.','admin/allCategories');
				}
			}
			else{
				setFlashData('alert-danger','Category name is required.','admin/allCategories');
			}

		} else {
			setFlashData('alert-danger','Please login first to edit your category.','admin/login');
		}
	}

	public function deleteCategory()
	{
		if (adminLoggedIn()) {
			if ($this->input->is_ajax_request()) {
				$this->input->post('id',true);
				$cId  = $this->input->post('text',true);
				if (!empty($cId) && isset($cId)) {
					 $cId = $this->encryption->decrypt($cId);
					 $oldImge = $this->modAdmin->getCategoryImage($cId);
						if (!empty($oldImge) && count($oldImge) == 1) {
							$realImgage = $oldImge[0]['cDp'];
						}
					$checkMd = $this->modAdmin->deleteCatetory($cId);
					if ($checkMd) {
						if (!empty($realImgage) && isset($realImgage)) {
							$path = realpath(APPPATH.'../assets/images/categories/');
							if (file_exists($path.'/'.$realImgage)) {
								unlink($path.'/'.$realImgage);
							}
						}
						$data['return'] = true;
						$data['message'] = 'successfully deleted';
						echo json_encode($data);
					} else {
						$data['return'] = false;
						$data['message'] = 'you can\'t delete your category right now';
						echo json_encode($data);
					}
				}
				else{
					$data['return'] = false;
					$data['message'] = 'value not exist';
					echo json_encode($data);
				}
			}
			else{
				setFlashData('alert-danger','Something went wrong.','admin');
			}
		} else {
			setFlashData('alert-danger','Please login first.','admin/login');
		}
	}

	public function newProduct()
	{
		if (adminLoggedIn()) {
			$data['categories'] = $this->modAdmin->getCategories();
			$this->load->view('admin/header/header');
			$this->load->view('admin/header/css');
			$this->load->view('admin/header/navtop');
			$this->load->view('admin/header/navleft');
			$this->load->view('admin/home/newProduct',$data);
			$this->load->view('admin/header/footer');
			$this->load->view('admin/header/htmlclose');
		} else {
			setFlashData('alert-danger','Please login first to add your category.','admin/login');
		}

	}

	public function addProduct()
	{
		if (adminLoggedIn()) {
			$data['pName'] = $this->input->post('productName',true);
			$data['pCompany'] = $this->input->post('company',true);
			$data['categoryId'] = $this->input->post('categoryId',true);

			if (
				!empty($data['pName']) && !empty($data['pCompany']) && !empty($data['categoryId'])
			)
			{
				$path = realpath(APPPATH.'../assets/images/products/');
				$config['upload_path'] = $path ;
				$config['max_size'] = 100;
				$config['allowed_types'] = 'jpeg|gif|jpg|png' ;
				$this->load->library('upload',$config);
				if (!$this->upload->do_upload('prodDp')) {
					$error = $this->upload->display_errors();
					setFlashData('alert-danger',$error,'admin/newProduct');
				}
				else{
					$fileName = $this->upload->data();
					$data['pDp'] = $fileName['file_name'];
					$data['pDate'] = date('Y-m-d H:i:s');
					$data['adminId'] =  getAdminId();
				}
				$addDAta = $this->modAdmin->checkProduct($data);
				if ($addDAta->num_rows() > 0) {
					setFlashData('alert-danger','The Product already exist.','admin/newProduct');
				}
				else{
					$addDAta = $this->modAdmin->addProduct($data);
					if ($addDAta) {
						setFlashData('alert-success','You have successfully added your Product.','admin/newProduct');
					} else {
						setFlashData('alert-danger','You can\'t add your Product right now.','admin/newProduct');
					}
				}


			} else {
				setFlashData('alert-danger','Please check the required fields and try again','admin/newProduct');
			}

		} else {
			setFlashData('alert-danger','Please login first to add your category.','admin/login');
		}
	}

	public function allProducts()
	{

		if (adminLoggedIn()) {
			$config['base_url'] = site_url('admin/allProducts');
			$totalRows = $this->modAdmin->getAllProducts();

			$config['total_rows'] = $totalRows;
			$config['per_page'] = 10 ;
			$config['uri_segment'] = 3;
			$this->load->library('pagination');
			$this->pagination->initialize($config);

			$page = ($this->uri->segment(3))? $this->uri->segment(3):0;
			$data['allProducts'] = $this->modAdmin->fetchAllProducts($config['per_page'],$page);
			$data['links'] = $this->pagination->create_links();
			$this->load->view('admin/header/header');
			$this->load->view('admin/header/css');
			$this->load->view('admin/header/navtop');
			$this->load->view('admin/header/navleft');
			$this->load->view('admin/home/allProducts',$data);
			$this->load->view('admin/header/footer');
			$this->load->view('admin/header/htmlclose');

		} else {
			setFlashData('alert-danger','Please login first to add your category.','admin/login');

		}

	}
	public function deleteProduct()
	{
		if (adminLoggedIn()) {
			if ($this->input->is_ajax_request()) {
				$this->input->post('id',true);
				$pId  = $this->input->post('text',true);
				if (!empty($pId) && isset($pId)) {
					$pId = $this->encryption->decrypt($pId);
					$oldImge = $this->modAdmin->getProductImage($pId);
					if (!empty($oldImge) && count($oldImge) == 1) {
						$realImgage = $oldImge[0]['pDp'];
					}
					$checkMd = $this->modAdmin->deleteProduct($pId);
					if ($checkMd) {
						if (!empty($realImgage) && isset($realImgage)) {
							$path = realpath(APPPATH.'../assets/images/products/');
							if (file_exists($path.'/'.$realImgage)) {
								unlink($path.'/'.$realImgage);
							}
						}
						$data['return'] = true;
						$data['message'] = 'successfully deleted';
						echo json_encode($data);
					} else {
						$data['return'] = false;
						$data['message'] = 'you can\'t delete your Product right now';
						echo json_encode($data);
					}
				}
				else{
					$data['return'] = false;
					$data['message'] = 'value not exist';
					echo json_encode($data);
				}
			}
			else{
				setFlashData('alert-danger','Something went wrong.','admin');
			}
		} else {
			setFlashData('alert-danger','Please login first.','admin/login');
		}
	}

	public function editProduct($pId)
	{
		if (adminLoggedIn()) {
			if (!empty($pId) && isset($pId)) {
				$data['products'] = $this->modAdmin->checkProductById($pId);
				if (count($data['products']) == 1) {
					$data['categories'] = $this->modAdmin->getCategories();
					$this->load->view('admin/header/header');
					$this->load->view('admin/header/css');
					$this->load->view('admin/header/navtop');
					$this->load->view('admin/header/navleft');
					$this->load->view('admin/home/editProduct',$data);
					$this->load->view('admin/header/footer');
					$this->load->view('admin/header/htmlclose');
				} else {
					setFlashData('alert-danger','Category not found.','admin/allProducts');
				}
			} else {
				setFlashData('alert-danger','Something went wrong','admin/allProducts');
			}

		} else {
			setFlashData('alert-danger','Please login first to edit your category.','admin/login');
		}


	}

	public function updateProduct()
	{
		if (adminLoggedIn()) {
			$data['pName'] = $this->input->post('productName',true);
			$data['pCompany'] = $this->input->post('company',true);
			$data['categoryId'] = $this->input->post('categoryId',true);
			$pId = $this->input->post('xid',true);//product id
			$oldImage = $this->input->post('oldImg',true);
			if (
				!empty($data['pName']) && !empty($data['pCompany']) && !empty($data['categoryId'])
			)
			{

				if (isset($_FILES['prodDp']) && is_uploaded_file($_FILES['prodDp']['tmp_name'])) {
					$path = realpath(APPPATH.'../assets/images/products/');
					$config['upload_path'] = $path ;
					$config['max_size'] = 100;
					$config['allowed_types'] = 'jpeg|gif|jpg|png' ;
					$this->load->library('upload',$config);
					if (!$this->upload->do_upload('prodDp')) {
						$error = $this->upload->display_errors();
						setFlashData('alert-danger',$error,'admin/allProducts');
					}
					else{
						$fileName = $this->upload->data();
						$data['pDp'] = $fileName['file_name'];
					}
				}//image checking here

				$addDAta = $this->modAdmin->checkProduct($data);
				if ($addDAta->num_rows() > 0) {
					setFlashData('alert-danger','The Product already exist.','admin/allProducts');
				}
				else{
					$addDAta = $this->modAdmin->updateProduct($data,$pId);
					if ($addDAta) {
						if (!empty($data['pDp']) && isset($data['pDp'])) {
							if (file_exists($path.'/'.$oldImage)) {
								unlink($path.'/'.$oldImage);
							}
						}
						setFlashData('alert-success','You have successfully updated your Product.','admin/allProducts');
					} else {
						setFlashData('alert-danger','You can\'t update your Product right now.','admin/allProducts');
					}
				}


			} else {
				setFlashData('alert-danger','Please check the required fields and try again','admin/allProducts');
			}

		} else {
			setFlashData('alert-danger','Please login first to add your category.','admin/login');
		}
	}

    public function newModel()
    {
        if (adminLoggedIn()) {
            $data['products'] = $this->modAdmin->getProducts();
            $this->load->view('admin/header/header');
            $this->load->view('admin/header/css');
            $this->load->view('admin/header/navtop');
            $this->load->view('admin/header/navleft');
            $this->load->view('admin/home/newModel2',$data);
            $this->load->view('admin/header/footer');
            $this->load->view('admin/header/htmlclose');
        } else {
            setFlashData('alert-danger','Please login first to add your category.','admin/login');
        }

    }

    public function addModel()
    {
        if (adminLoggedIn()) {
            $data['mName'] = $this->input->post('modelName',true);
            $data['mDescription'] = $this->input->post('md',true);
            $data['productId'] = $this->input->post('productId',true);
            //var_dump($data);
            //die();
            if (
                !empty($data['mName']) && !empty($data['mDescription']) && !empty($data['productId'])
            )
            {
                $path = realpath(APPPATH.'../assets/images/models/');
                $config['upload_path'] = $path ;
                $config['max_size'] = 100;
                $config['allowed_types'] = 'jpeg|gif|jpg|png' ;
                $this->load->library('upload',$config);
                if (!$this->upload->do_upload('modelDp')) {
                    $error = $this->upload->display_errors();
                    setFlashData('alert-danger',$error,'admin/newModel');
                }
                else{
                    $fileName = $this->upload->data();
                    $data['mDp'] = $fileName['file_name'];
                    $data['mDate'] = date('Y-m-d H:i:s');
                    $data['adminId'] =  getAdminId();
                }
                $addDAta = $this->modAdmin->checkModel($data);
                if ($addDAta->num_rows() > 0) {
                    setFlashData('alert-danger','The Model already exist.','admin/newModel');
                }
                else{
                    $addDAta = $this->modAdmin->addModel($data);
                    if ($addDAta) {
                        setFlashData('alert-success','You have successfully added your Model.','admin/newModel');
                    } else {
                        setFlashData('alert-danger','You can\'t add your Model right now.','admin/newModel');
                    }
                }


            } else {
                setFlashData('alert-danger','Please check the required fields and try again','admin/newModel');
            }

        } else {
            setFlashData('alert-danger','Please login first to add your Model.','admin/login');
        }
    }

    public function allModels()
    {

        if (adminLoggedIn()) {
            $config['base_url'] = site_url('admin/allModels');
            $totalRows = $this->modAdmin->getAllModels();

            $config['total_rows'] = $totalRows;
            $config['per_page'] = 10 ;
            $config['uri_segment'] = 3;
            $this->load->library('pagination');
            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3))? $this->uri->segment(3):0;
            $data['allmodels'] = $this->modAdmin->fetchAllModels($config['per_page'],$page);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('admin/header/header');
            $this->load->view('admin/header/css');
            $this->load->view('admin/header/navtop');
            $this->load->view('admin/header/navleft');
            $this->load->view('admin/home/allModels',$data);
            $this->load->view('admin/header/footer');
            $this->load->view('admin/header/htmlclose');

        } else {
            setFlashData('alert-danger','Please login first to add your category.','admin/login');

        }

    }
    public function deleteModel()
    {
        if (adminLoggedIn()) {
            if ($this->input->is_ajax_request()) {
                $this->input->post('id',true);
                $mId  = $this->input->post('text',true);
                if (!empty($mId) && isset($mId)) {
                    $mId = $this->encryption->decrypt($mId);
                    $oldImge = $this->modAdmin->getModelImage($mId);
                    if (!empty($oldImge) && count($oldImge) == 1) {
                        $realImgage = $oldImge[0]['mDp'];
                    }
                    $checkMd = $this->modAdmin->deleteModel($mId);
                    if ($checkMd) {
                        if (!empty($realImgage) && isset($realImgage)) {
                            $path = realpath(APPPATH.'../assets/images/models/');
                            if (file_exists($path.'/'.$realImgage)) {
                                unlink($path.'/'.$realImgage);
                            }
                        }
                        $data['return'] = true;
                        $data['message'] = 'successfully deleted';
                        echo json_encode($data);
                    } else {
                        $data['return'] = false;
                        $data['message'] = 'you can\'t delete your Model right now';
                        echo json_encode($data);
                    }
                }
                else{
                    $data['return'] = false;
                    $data['message'] = 'value not exist';
                    echo json_encode($data);
                }
            }
            else{
                setFlashData('alert-danger','Something went wrong.','admin');
            }
        } else {
            setFlashData('alert-danger','Please login first.','admin/login');
        }
    }

    public function editModel($mId)
    {
        if (adminLoggedIn()) {
            if (!empty($mId) && isset($mId)) {
                $data['models'] = $this->modAdmin->checkModelById($mId);
                if (count($data['models']) == 1) {
                    $data['products'] = $this->modAdmin->getProducts();
                    $this->load->view('admin/header/header');
                    $this->load->view('admin/header/css');
                    $this->load->view('admin/header/navtop');
                    $this->load->view('admin/header/navleft');
                    $this->load->view('admin/home/editModel',$data);
                    $this->load->view('admin/header/footer');
                    $this->load->view('admin/header/htmlclose');
                } else {
                    setFlashData('alert-danger','Model not found.','admin/allModels');
                }
            } else {
                setFlashData('alert-danger','Something went wrong','admin/allModels');
            }

        } else {
            setFlashData('alert-danger','Please login first to edit your category.','admin/login');
        }


    }

    public function updateModel()
    {
        if (adminLoggedIn()) {
            $data['mName'] = $this->input->post('modelName',true);
            $data['mDescription'] = $this->input->post('md',true);
            $data['productId'] = $this->input->post('productId',true);
            $modeId = $this->input->post('mDi',true);//model id
            $oldImg = $this->input->post('oldimg',true);//old img

            //var_dump($oldImg);
            //die();
            if (
                !empty($data['mName']) && !empty($data['mDescription']) && !empty($data['productId'])
            )
            {

                if (isset($_FILES['modelDp']) && is_uploaded_file($_FILES['modelDp']['tmp_name'])) {
                    $path = realpath(APPPATH.'../assets/images/models/');
                    $config['upload_path'] = $path ;
                    $config['max_size'] = 100;
                    $config['allowed_types'] = 'jpeg|gif|jpg|png' ;
                    $this->load->library('upload',$config);
                    if (!$this->upload->do_upload('modelDp')) {
                        $error = $this->upload->display_errors();
                        setFlashData('alert-danger',$error,'admin/allModels');
                    }
                    else{
                        $fileName = $this->upload->data();
                        $data['mDp'] = $fileName['file_name'];
                    }

                }//image checking

                $addDAta = $this->modAdmin->checkModel($data);
                if ($addDAta->num_rows() > 0) {

                    setFlashData('alert-danger','The Model already exist.','admin/allModels');
                }
                else{
                    $addDAta = $this->modAdmin->updateModel($data,$modeId);
                    if ($addDAta) {
                        if (!empty($data['mDp']) && isset($data['mDp'])) {
                            if (file_exists($path.'/'.$oldImg)) {
                                unlink($path.'/'.$oldImg);
                            }
                        }
                        setFlashData('alert-success','You have successfully updated your Model.','admin/allModels');
                    } else {
                        setFlashData('alert-danger','You can\'t add your Model right now.','admin/allModels');
                    }
                }


            } else {
                setFlashData('alert-danger','Please check the required fields and try again','admin/newModel');
            }

        } else {
            setFlashData('alert-danger','Please login first to add your Model.','admin/login');
        }
    }

    public function newSpec()
    {
        if (adminLoggedIn()) {
            $data['models'] = $this->modAdmin->getModel();
            $this->load->view('admin/header/header');
            $this->load->view('admin/header/css');
            $this->load->view('admin/header/navtop');
            $this->load->view('admin/header/navleft');
            $this->load->view('admin/home/newSpec',$data);
            $this->load->view('admin/header/footer');
            $this->load->view('admin/header/htmlclose');
        } else {
            setFlashData('alert-danger','Please login first to add your category.','admin/login');
        }

    }

    public function addSepc()
    {
        if (adminLoggedIn()) {
            $data['spName'] = $this->input->post('sp_name',true);
            $secValues = $this->input->post('so_val',true);//array
            $secValues = array_filter($secValues);
            $data['modelId'] = $this->input->post('modelId',true);
           // var_dump($secValues);

            if (
                !empty($data['spName']) && !empty($secValues) && !empty($data['modelId'])
            )
            {

                $data['spDate'] = date('Y-m-d H:i:s');
                $data['adminId'] =  getAdminId();


                $addDAta = $this->modAdmin->checkSpecs($data);
                if ($addDAta->num_rows() > 0) {
                    setFlashData('alert-danger','The Product already exist.','admin/newSpec');
                }
                else{

                    $specId = $this->modAdmin->checkSpecName($data);
                    //var_dump($specId);
                    //die();
                    if (is_numeric($specId)) {
                        $spec_values = array();
                        foreach ($secValues as $scpecVal) {
                            $spec_values[] = array(
                                'specId'=>$specId,
                                'adminId'=>$data['adminId'],
                                'spvDate'=> date('Y-m-d H:i:s'),
                                'spvName'=>$scpecVal
                            );
                        }//foreachLoop here

                         $specValStatus = $this->modAdmin->checkSpecValues($spec_values);
                        if ($specValStatus) {
                            setFlashData('alert-success','You have successfully added your Spec.','admin/newSpec');
                        }
                        else{
                            setFlashData('alert-danger','You can\'t add your Spec Values right now.','admin/newSpec');
                        }


                    }
                    else{
                        setFlashData('alert-danger','You can\'t add your Spec Name right now.','admin/newSpec');
                    }

                }


            } else {
                setFlashData('alert-danger','Please check the required fields and try again','admin/newSpec');
            }

        } else {
            setFlashData('alert-danger','Please login first to add your category.','admin/login');
        }
    }


    public function allSpecs()
    {

        if (adminLoggedIn()) {
            $config['base_url'] = site_url('admin/allSpecs');
            $totalRows = $this->modAdmin->getAllSpecs();

            $config['total_rows'] = $totalRows;
            $config['per_page'] = 10 ;
            $config['uri_segment'] = 3;
            $this->load->library('pagination');
            $this->pagination->initialize($config);

            $page = ($this->uri->segment(3))? $this->uri->segment(3):0;
            $data['allSpecs'] = $this->modAdmin->fetchAllSpecs($config['per_page'],$page);
            $data['links'] = $this->pagination->create_links();
            $this->load->view('admin/header/header');
            $this->load->view('admin/header/css');
            $this->load->view('admin/header/navtop');
            $this->load->view('admin/header/navleft');
            $this->load->view('admin/home/allSpecs',$data);
            $this->load->view('admin/header/footer');
            $this->load->view('admin/header/htmlclose');

        } else {
            setFlashData('alert-danger','Please login first to add your category.','admin/login');

        }

    }

    public function deleteSpec()
    {
        if (adminLoggedIn()) {
            if ($this->input->is_ajax_request()) {
                $this->input->post('id',true);
                $mId  = $this->input->post('text',true);
                if (!empty($mId) && isset($mId)) {
                    $mId = $this->encryption->decrypt($mId);
                    $checkMd = $this->modAdmin->deleteSpec($mId);
                    if ($checkMd) {

                        $data['return'] = true;
                        $data['message'] = 'successfully deleted';
                        echo json_encode($data);
                    } else {
                        $data['return'] = false;
                        $data['message'] = 'you can\'t delete your Spec right now';
                        echo json_encode($data);
                    }
                }
                else{
                    $data['return'] = false;
                    $data['message'] = 'value not exist';
                    echo json_encode($data);
                }
            }
            else{
                setFlashData('alert-danger','Something went wrong.','admin');
            }
        } else {
            setFlashData('alert-danger','Please login first.','admin/login');
        }
    }


    public function editSpec($pId)
    {
        if (adminLoggedIn()) {
            if (!empty($pId) && isset($pId)) {
                $data['Spec'] = $this->modAdmin->checkSpecById($pId);
                if (count($data['Spec']) == 1) {
                    $data['models'] = $this->modAdmin->getModel();
                    $this->load->view('admin/header/header');
                    $this->load->view('admin/header/css');
                    $this->load->view('admin/header/navtop');
                    $this->load->view('admin/header/navleft');
                    $this->load->view('admin/home/editSpec',$data);
                    $this->load->view('admin/header/footer');
                    $this->load->view('admin/header/htmlclose');
                } else {
                    setFlashData('alert-danger','Category not found.','admin/allProducts');
                }
            } else {
                setFlashData('alert-danger','Something went wrong','admin/allProducts');
            }

        } else {
            setFlashData('alert-danger','Please login first to edit your category.','admin/login');
        }


    }



    public function updateSpec()
    {
        if (adminLoggedIn()) {
            $data['spName'] = $this->input->post('sp_name',true);
            $data['modelId'] = $this->input->post('modelId',true);
            $SpecId = $this->input->post('specId',true);
            // var_dump($secValues);

            if (
                !empty($data['spName']) && !empty($SpecId) && !empty($data['modelId'])
            )
            {

                $addDAta = $this->modAdmin->checkSpecs($data);
                if ($addDAta->num_rows() > 0) {
                    setFlashData('alert-danger','The Product already exist.','admin/newSpec');
                }
                else{

                    $updateSpec = $this->modAdmin->updateSpec($data,$SpecId);
                    if ($updateSpec){
                        setFlashData('alert-success','You have successfully updated your Spec.','admin/allSpecs');
                    }

                    else{
                        setFlashData('alert-danger','You can\'t updated your Spec  right now.','admin/allSpecs');
                    }

                }

            } else {
                setFlashData('alert-danger','Please check the required fields and try again','admin/newSpec');
            }

        } else {
            setFlashData('alert-danger','Please login first to add your category.','admin/login');
        }
    }
}//class ends here
