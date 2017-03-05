<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pages extends CI_Controller {
    protected $submenuItems;

    public function __construct()
    {
        parent::__construct();
        if (!($this->session->id > 0) || !($this->session->user_level == 1)) {
            redirect(base_url('404'));
        }
        $this->submenuItems = [
            'items' => [
                'All Pages' => [
                    'url' => 'backoffice/pages',
                    'icon' => 'fa fa-folder-open-o'
                ],
                'New Page' => [
                    'url' => 'backoffice/pages/create',
                    'icon' => 'fa fa-file'
                ]
            ]
        ];
    }

    /**
     * Index Page for this controller.
     */
    public function index()
    {
        $pages = Page::paginate(20);

        $pageContent = [
            'pages' => $pages
        ];

        $data = [
            'title' => 'All pages | 1 Minute Win',
            'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
            'pagecontent' => $this->load->view('admin/page_list', $pageContent, true)
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
                'title' => 'New page | 1 Minute Win',
                'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
                'pagecontent' => $this->load->view('admin/new_page', $pageContent, true)
            ];

            $this->load->view('admin/header', $data);
            $this->load->view('admin/home', $data);
            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/pages');
        }
    }

    public function edit ($id) {
        try {
            $page = Page::findOrFail($id);
            $pageContent = [
                'page' => $page
            ];

            if ($this->session->flashdata('error')) {
                $pageContent['error'] = $this->session->flashdata('error');
            }

            if ($this->session->flashdata('success')) {
                $pageContent['success'] = $this->session->flashdata('success');
            }

            $data = [
                'title' => 'Edit page | 1 Minute Win',
                'sidemenu' => $this->load->view('admin/sidemenu', $this->submenuItems, TRUE),
                'pagecontent' => $this->load->view('admin/edit_page', $pageContent, true)
            ];

            $this->load->view('admin/header', $data);
            $this->load->view('admin/home', $data);
            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/pages');
        }
    }

    public function update () {
        $this->form_validation->set_rules('page_title', 'Page title', 'required');
        $this->form_validation->set_rules('page_content', 'Page content', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata([
                'error' => 'Invalid action',
                'errors' => 'errors'
            ]);
            redirect('backoffice/pages');
        }
        else
        {
            try {
                $page = Page::findOrFail($this->input->post('page_id'));
                $page->page_title = $this->input->post('page_title');
                $page->page_content = $this->input->post('page_content');
                $page->show_menu = $this->input->post('show_menu');
                $page->fa_icon = $this->input->post('fa_icon');
                $page->slug = $this->input->post('slug');
                $page->save();
                $this->session->set_flashdata([
                    'success' => 'Page updated'
                ]);
                redirect('backoffice/pages/edit/'.$page->id);
            } catch (\Exception $e) {
                var_dump($e->getMessage());
                return;
                $this->session->set_flashdata([
                    'error' => 'Page does not exist'
                ]);
                redirect('backoffice/pages');
            }
        }
    }

    public function save () {
        $this->form_validation->set_rules('page_title', 'Page title', 'required');
        $this->form_validation->set_rules('page_content', 'Page content', 'required');
        $this->form_validation->set_rules('slug', 'Slug', 'required');

        if ($this->form_validation->run() == FALSE)
        {
            $this->session->set_flashdata([
                'error' => 'Invalid action',
                'errors' => 'errors'
            ]);
            redirect('backoffice/pages');
        }
        else
        {
            try {
                $page = new Page;
                $page->page_title = $this->input->post('page_title');
                $page->page_content = $this->input->post('page_content');
                $page->show_menu = $this->input->post('show_menu');
                $page->slug = $this->input->post('slug');
                $page->fa_icon = $this->input->post('fa_icon');
                $page->save();
                $this->session->set_flashdata([
                    'success' => 'Page updated'
                ]);
                redirect('backoffice/pages/edit/'.$page->id);
            } catch (\Exception $e) {
                $this->session->set_flashdata([
                    'error' => 'Page does not exist'
                ]);
                redirect('backoffice/pages');
            }
        }
    }

    public function delete ($id) {
        try {
            $id = (int)$id;
            $page = Page::findOrFail($id);
            $page->delete();
            $this->session->set_flashdata([
                'success' => 'Page deleted'
            ]);
            redirect('backoffice/pages');
        } catch (\Exception $e) {
            $this->session->set_flashdata([
                'error' => 'Invalid action'
            ]);
            redirect('backoffice/pages');
        }
    }
}
