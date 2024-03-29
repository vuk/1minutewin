<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller
{

    protected $submenuItems;

    public function __construct()
    {
        parent::__construct();
        if (!($this->session->id > 0) || !($this->session->user_level == 1)) {
            redirect(base_url('404'));
        }
        $this->submenuItems = [
            'items' => [
                'All Products' => [
                    'url' => 'backoffice/products',
                    'icon' => 'fa fa-cubes'
                ],
                'New Product' => [
                    'url' => 'backoffice/products/create',
                    'icon' => 'fa fa-cube'
                ]
            ]
        ];
    }

    /**
     * Index Page for this controller.
     */
    public function index($page = 1)
    {

        $products = Product::orderBy('created_at', 'desc')->offset(($page - 1) * 20)->limit(20)->get();
        $count = Product::count();
        $pages = ceil($count / 20);

        if ($page > 1) {
            $pageLinks['First'] = base_url('/backoffice/products/index/1');
            $pageLinks['Previous'] = base_url('/backoffice/products/index/'.($page - 1));
        }

        for ($i = 1; $i <= $pages; $i ++) {
            if (abs($i - $page) < 4) {
                $pageLinks[$i] = base_url('/backoffice/products/index/'.$i);
            }
        }

        if ($page < $pages) {
            $pageLinks['Next'] = base_url('/backoffice/products/index/'.($page + 1));
            $pageLinks['Last'] = base_url('/backoffice/products/index/'.$pages);
        }

        $pageContent = [
            'products' => $products,
            'pageLinks' => $pageLinks
        ];

        $data = [
            'title' => 'Products | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/products', $pageContent, true)
        ];

        $this->load->view('admin/header', $data);
        $this->load->view('admin/home', $data);
        $this->load->view('footer', $data);
    }

    public function create()
    {
        try {
            $pageContent = [

            ];

            if ($this->session->flashdata('error')) {
                $pageContent['error'] = $this->session->flashdata('error');
            }

            if ($this->session->flashdata('success')) {
                $pageContent['success'] = $this->session->flashdata('success');
            }

            $data = [
                'title' => 'Edit product | 1 Minute Win',
                'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
                'pagecontent' => $this->load->view('admin/new_product', $pageContent, true)
            ];

            $this->load->view('admin/header', $data);
            $this->load->view('admin/home', $data);
            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/product');
        }
    }

    public function save()
    {
        //var_dump($_FILES['files']);
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
        $max_file_size = 1024 * 2048; //100 kb
        $path = "uploads/"; // Upload directory
        $count = 0;

        $files = [];

        $this->form_validation->set_rules('product_title', 'Product Title', 'required');
        $this->form_validation->set_rules('product_description', 'Product Description', 'required');
        $this->form_validation->set_rules('initial_price', 'Initial price', 'required');
        $this->form_validation->set_rules('stock', 'Stock', 'required');
        $this->form_validation->set_rules('shipping_price', 'Shipping price', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata([
                'error' => 'Invalid action',
                'errors' => 'errors'
            ]);
            $this->create();
        } else {
            try {
                foreach ($_FILES['files']['name'] as $f => $name) {
                    if ($_FILES['files']['error'][$f] == 4) {
                        continue; // Skip file if any error found
                    }
                    if ($_FILES['files']['error'][$f] == 0) {
                        if ($_FILES['files']['size'][$f] > $max_file_size) {
                            $message[] = "$name is too large!.";
                            continue; // Skip large files
                        } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                            $message[] = "$name is not a valid format";
                            continue; // Skip invalid file formats
                        } else { // No error found! Move uploaded files
                            if (!file_exists($path . date('Ym/', strtotime('now')))) {
                                mkdir($path . date('Ym/', strtotime('now')), 0775, true);
                            }
                            if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . date('Ym/', strtotime('now')) . str_replace(' ', '', $f.date('ymdHis', strtotime('now')).$name)))
                                $count++; // Number of successfully uploaded file

                            $files[] = $path . date('Ym/', strtotime('now')) . str_replace(' ', '', $f.date('ymdHis', strtotime('now')).$name);
                            $this->_create_thumbnail($path, date('ymdHis', strtotime('now')).$name, 200, 200);
                        }
                    }
                }
                $product = new Product;
                $product->product_title = $this->input->post('product_title');
                $product->product_description = $this->input->post('product_description');
                $product->initial_price = $this->input->post('initial_price');
                $product->stock = $this->input->post('stock');
                $product->shipping_price = $this->input->post('shipping_price');
                $product->shipping = $this->input->post('shipping');
                $product->published = 0;
                $product->pictures = json_encode($files);
                $product->save();
                $this->session->set_flashdata([
                    'success' => 'New product added'
                ]);
                redirect('backoffice/products/edit/' . $product->id);
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Unknown error occured: ' . $e->getMessage()
                ]);
                $this->create();
            }
        }
    }

    public function edit($id)
    {
        try {
            $product = Product::findOrFail($id);
            $pageContent = [
                'product' => $product
            ];

            if ($this->session->flashdata('error')) {
                $pageContent['error'] = $this->session->flashdata('error');
            }

            if ($this->session->flashdata('success')) {
                $pageContent['success'] = $this->session->flashdata('success');
            }

            $data = [
                'title' => 'Edit product | 1 Minute Win',
                'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
                'pagecontent' => $this->load->view('admin/edit_product', $pageContent, true)
            ];

            $this->load->view('admin/header', $data);
            $this->load->view('admin/home', $data);
            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/products');
        }
    }

    public function update()
    {
        $valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
        $max_file_size = 1024 * 2048; //100 kb
        $path = "uploads/"; // Upload directory
        $count = 0;

        $files = [];

        $this->form_validation->set_rules('product_title', 'Product Title', 'required');
        $this->form_validation->set_rules('product_description', 'Product Description', 'required');
        $this->form_validation->set_rules('initial_price', 'Initial price', 'required');
        $this->form_validation->set_rules('stock', 'Stock', 'required');
        $this->form_validation->set_rules('shipping_price', 'Shipping price', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata([
                'error' => 'Invalid action',
                'errors' => 'errors'
            ]);
            $this->create();
        } else {
            try {
                $product = Product::findOrFail($this->input->post('product_id'));
                if (sizeof(json_decode($product->pictures)) > 0) {
                    foreach (json_decode($product->pictures) as $picture) {
                        $files[] = $picture;
                    }
                }
                foreach ($_FILES['files']['name'] as $f => $name) {
                    if ($_FILES['files']['error'][$f] == 4) {
                        continue; // Skip file if any error found
                    }
                    if ($_FILES['files']['error'][$f] == 0) {
                        if ($_FILES['files']['size'][$f] > $max_file_size) {
                            $message[] = "$name is too large!.";
                            continue; // Skip large files
                        } elseif (!in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats)) {
                            $message[] = "$name is not a valid format";
                            continue; // Skip invalid file formats
                        } else { // No error found! Move uploaded files
                            if (!file_exists($path . date('Ym/', strtotime('now')))) {
                                mkdir($path . date('Ym/', strtotime('now')), 0775, true);
                            }
                            if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . date('Ym/', strtotime('now')) . str_replace(' ', '', $name)))
                                $count++; // Number of successfully uploaded file
                            $files[] = $path . date('Ym/', strtotime('now')) . str_replace(' ', '', $name);
                            $this->_create_thumbnail($path, $name, 200, 200);
                        }
                    }
                }

                $product->product_title = $this->input->post('product_title');
                $product->product_description = $this->input->post('product_description');
                $product->initial_price = $this->input->post('initial_price');
                $product->stock = $this->input->post('stock');
                $product->shipping_price = $this->input->post('shipping_price');
                $product->shipping = $this->input->post('shipping');
                $product->published = 0;
                $product->pictures = json_encode($files);
                $product->save();
                $this->session->set_flashdata([
                    'success' => 'Product updated'
                ]);
                redirect('backoffice/products/edit/' . $product->id);
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Error occured: '. $e->getMessage()
                ]);
                $this->create();
            }
        }
    }

    public function publish($id)
    {
        try {
            $id = (int)$id;
            $product = Product::findOrFail($id);
            /*Product::where('published', '=', 1)
                ->update(['published' => 0]);*/
            $product->published = 1;
            $product->save();
            $this->session->set_flashdata([
                'success' => 'Product published'
            ]);
            redirect('backoffice/products');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/products');
        }
    }

    public function unpublish($id)
    {
        try {
            $id = (int)$id;
            $product = Product::findOrFail($id);
            $product->published = 0;
            $product->save();
            $this->session->set_flashdata([
                'success' => 'Product published'
            ]);
            redirect('backoffice/products');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/products');
        }
    }

    public function delete($id)
    {
        try {
            $id = (int)$id;
            $product = Product::findOrFail($id);
            $product->delete();
            $this->session->set_flashdata([
                'success' => 'Successfully deleted'
            ]);
            redirect('backoffice/products');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/products');
        }
    }

    public function deleteimage($id, $folder, $subfolder, $image)
    {
        try {
            $product = Product::findOrFail($id);
            $images = json_decode($product->pictures);
            $newImages = [];
            foreach ($images as $img) {
                if ($img == $folder . '/' . $subfolder . '/' . $image) {
                    @unlink($img);
                    @unlink('_thumb/'.$img);
                } else {
                    $newImages[] = $img;
                }
            }
            $product->pictures = json_encode($newImages);
            $product->save();
            $this->session->set_flashdata([
                'success' => 'Deleted image'
            ]);
            redirect('backoffice/products/edit/' . $id);
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/products/edit/' . $id);
        }

    }

    function _create_thumbnail($path, $name, $width, $height)
    {
        $this->load->library('image_lib');
        $config['image_library'] = 'gd';
        $config['source_image'] = $path . date('Ym/', strtotime('now')) . str_replace(' ', '', $name);
        $config['create_thumb'] = TRUE;
        $config['thumb_marker'] = '';
        $config['maintain_ratio'] = TRUE;
        $config['width'] = $width;
        $config['height'] = $height;
        if (!file_exists('_thumb/' . $path . date('Ym/', strtotime('now')))) {
            mkdir('_thumb/' . $path . date('Ym/', strtotime('now')), 0775, true);
        }
        $config['new_image'] = '_thumb/' . $path . date('Ym/', strtotime('now')) . str_replace(' ', '', $name);
        $this->image_lib->initialize($config);
        if (!$this->image_lib->resize()) {
            echo $this->image_lib->display_errors();
        }
    }
}
