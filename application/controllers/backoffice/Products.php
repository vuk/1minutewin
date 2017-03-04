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
    public function index()
    {
        $products = Product::paginate(20);

        $pageContent = [
            'products' => $products
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
        $valid_formats = array("jpg", "png", "gif", "bmp");
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
                            if (move_uploaded_file($_FILES["files"]["tmp_name"][$f], $path . date('Ym/', strtotime('now')) . str_replace(' ', '', $name)))
                                $count++; // Number of successfully uploaded file
                            $files[] = $path . date('Ym/', strtotime('now')) . str_replace(' ', '', $name);
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
                    'success' => 'New user added'
                ]);
                redirect('backoffice/products/edit/' . $product->id);
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Duplicate email address'
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
        $valid_formats = array("jpg", "png", "gif", "bmp");
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
                    foreach(json_decode($product->pictures) as $picture) {
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
                    'success' => 'New user added'
                ]);
                redirect('backoffice/products/edit/' . $product->id);
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Duplicate email address'
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
            Product::where('published', '=', 1)
                ->update(['published' => 0]);
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

    public function deleteimage($id, $folder, $subfolder, $image) {
        try {
            $product = Product::findOrFail($id);
            $images = json_decode($product->pictures);
            $newImages = [];
            foreach($images as $img) {
                if ($img == $folder.'/'.$subfolder.'/'.$image) {
                    @unlink($img);
                } else {
                    $newImages[] = $img;
                }
            }
            $product->pictures = json_encode($newImages);
            $product->save();
            $this->session->set_flashdata([
                'success' => 'Deleted image'
            ]);
            redirect('backoffice/products/edit/'.$id);
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/products/edit/'.$id);
        }

    }
}
