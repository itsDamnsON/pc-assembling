<?php
class Monitor extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('M_monitor');
        $this->load->library('form_validation');
    }

    public function index()
    {
        if ($this->session->userdata('status') == NULL) {
            redirect('/');
        } else {
            $data['judul'] = 'Master Monitor';
            $data['monitor'] = $this->M_monitor->tampil_monitor()->result();
            $this->load->view('partials/header', $data);
            $this->load->view('partials/sidebar_admin');
            $this->load->view('monitor', $data);
            $this->load->view('partials/footer');
        }
    }

    public function tambah_monitor()
    {
        if ($this->session->userdata('status') == NULL) {
            redirect('/');
        } else {
            $this->form_validation->set_rules('nama_monitor', 'Monitor', 'required|trim|is_unique[m_monitor.nama_monitor]');

            if ($this->form_validation->run() == false) {
                $data['judul'] = 'Tambah Data Master Monitor';
                $this->load->view('partials/header', $data);
                $this->load->view('partials/sidebar_admin');
                $this->load->view('tambah_monitor', $data);
                $this->load->view('partials/footer');
            } else {
                $this->session->set_flashdata('flash', 'Ditambahkan');

                $nama_monitor = htmlspecialchars($this->input->post('nama_monitor', true));

                $data = ['nama_monitor' => $nama_monitor];

                $this->db->insert('m_monitor', $data);
                redirect('Monitor');
            }
        }
    }

    public function ubah_monitor($id)
    {
        if ($this->session->userdata('status') == NULL) {
            redirect('/');
        } else {
            $data['judul'] = 'Ubah Data Master Monitor';
            $where = ['id' => $id];
            $data['monitor'] = $this->M_monitor->ubah_monitor($where)->result();
            $this->load->view('partials/header', $data);
            $this->load->view('partials/sidebar_admin');
            $this->load->view('ubah_monitor', $data);
            $this->load->view('partials/footer');
        }
    }

    public function aksi_ubah_monitor()
    {
        if ($this->session->userdata('status') == NULL) {
            redirect('/');
        } else {
            $this->form_validation->set_rules('nama_monitor', 'Monitor', 'required|trim|is_unique[m_monitor.nama_monitor]');

            if ($this->form_validation->run() == false) {
                $id = htmlspecialchars($this->input->post('id'));

                $data['judul'] = 'Ubah Data Master Monitor';
                $where = ['id' => $id];
                $data['monitor'] = $this->M_monitor->ubah_monitor($where)->result();
                $this->load->view('partials/header', $data);
                $this->load->view('partials/sidebar_admin');
                $this->load->view('ubah_monitor', $data);
                $this->load->view('partials/footer');
            } else {
                $this->session->set_flashdata('flash', 'Diubah');

                $id = htmlspecialchars($this->input->post('id'));
                $nama_monitor = htmlspecialchars($this->input->post('nama_monitor'));

                $where = ['id' => $id];

                $data = ['nama_monitor' => $nama_monitor];

                $this->db->where($where);
                $this->db->update('m_monitor', $data);
                redirect('Monitor');
            }
        }
    }

    public function search_monitor()
    {
        if ($this->session->userdata('status') == NULL) {
            redirect('/');
        } else {
            $keyword = htmlspecialchars($this->input->post('keyword', true));
            $data['judul'] = 'Master Monitor';
            $data['id'] = $this->db->get('m_monitor')->row();
            $data['monitor'] = $this->M_monitor->get_keyword_monitor($keyword);
            $this->load->view('partials/header', $data);
            $this->load->view('partials/sidebar_admin');
            $this->load->view('search_monitor', $data);
            $this->load->view('partials/footer');
        }
    }

    public function hapus_monitor($id)
    {
        if ($this->session->userdata('status') == NULL) {
            redirect('/');
        } else {
            $this->session->set_flashdata('flash', 'Dihapus');

            $where = ['id' => $id];

            $this->db->where($where);
            $this->db->delete('m_monitor');
            redirect('Monitor');
        }
    }
}
