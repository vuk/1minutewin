<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * @param $slug string
     * Index Page for this controller.
     */
    public function index($slug = '')
    {
        $data = [
            'title' => '1 Minute Win'
        ];

        $this->load->view('header', $data);

        $this->load->view('home', $data);

        $this->load->view('footer', $data);
    }

    public function not_found ()
    {
        $data = [
            'title' => 'Page not found | 1 Minute Win'
        ];

        $this->load->view('header', $data);

        $this->load->view('not_found', $data);

        $this->load->view('footer', $data);
    }

    public function page ($slug) {

        try {
            $page = Page::where('slug', 'LIKE', $slug)->firstOrFail();
            $data = [
                'title' => $page->page_title,
                'page'  => $page
            ];
            $this->load->view('header', $data);

            $this->load->view('page', $data);

            $this->load->view('footer', $data);
        } catch (\Exception $e) {
            //show_404();
            var_dump($e->getMessage());
        }
    }
}
