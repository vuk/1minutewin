<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

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

    public function create () {
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

    public function save () {

    }

    public function edit ($id) {
        try {
            $product = Product::findOrFail($id);
            $pageContent = [
                'product'  => $product
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
            redirect('backoffice/product');
        }
    }

    public function update () {

    }

    public function publish ($id) {
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

    public function unpublish ($id) {
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

    public function delete ($id) {
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
}
