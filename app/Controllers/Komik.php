<?php

namespace App\Controllers;

use App\Models\KomikModel;

class Komik extends BaseController
{
    protected $komikModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->komikModel = new KomikModel();
    }

    public function index()
    {

        $currentPage = $this->request->getVar('page_komik') ? $this->request->getVar('page_komik') : 1;
        $data = [
            'title' => 'Daftar Komik | UAS Pemrograman Web',
            'komik' => $this->komikModel->paginate(3, 'komik'),
            'pager' => $this->komikModel->pager,
            'currentPage' => $currentPage
        ];

        return view('komik/index', $data);
    }

    public function detail($slug)
    {
        $data = [
            'title' => 'Detail Komik | UAS Pemrograman Web',
            'komik' => $this->komikModel->getKomik($slug)
        ];
        if (empty($data['komik'])) {
            throw new \CodeIgniter\Exceptions\PageNotFoundException('Judul Komik ' . $slug . ' Tidak Ditemukan');
        }

        return view('komik/detail', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Form Tambah Manhwa | UAS Pemrograman Web',
            'validation' => \Config\Services::validation()
        ];

        return view('komik/create', $data);
    }

    public function save()
    {
        if (!$this->validate([
            'judul' => [
                'rules' => 'required|is_unique[komik.judul]',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'is_unique' => 'Nama {field} sudah terdaftar!'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!'
                ]
            ],
            'genre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,5120]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran Sampul Terlalu Besar',
                    'is_image' => 'Yand Dipilih Bukan Gambar',
                    'mime_in' => 'Format Sampul Berupa .jpg .jpeg .png'
                ]
            ]
        ])) {
            session()->setFlashdata('gagal', 'Manhwa Gagal Ditambahkan');
            return redirect()->to(base_url() . '/komik/create')->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');
        if ($fileSampul->getError() == 4) {
            $namaSampul = 'default.png';
        } else {
            $namaSampul = $fileSampul->getName();
            $fileSampul->move('img');
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'genre' => $this->request->getVar('genre'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Manhwa Berhasil Ditambahkan.');

        return redirect()->to('/komik');
    }

    public function delete($id)
    {
        $komik = $this->komikModel->find($id);
        if ($komik['sampul'] != 'default.png') {
            unlink('img/' . $komik['sampul']);
        }

        $this->komikModel->delete($id);
        session()->setFlashdata('pesan', 'Manhwa Berhasil Dihapus.');
        return redirect()->to('/komik');
    }

    public function edit($slug)
    {
        $data = [
            'title' => 'Form Ubah Data Manhwa | UAS Pemrograman Web',
            'validation' => \Config\Services::validation(),
            'komik' => $this->komikModel->getKomik($slug)
        ];

        return view('komik/edit', $data);
    }

    public function update($id)
    {
        $komikLama = $this->komikModel->getKomik($this->request->getVar('slug'));
        if ($komikLama['judul'] == $this->request->getVar('judul')) {
            $rule_judul = 'required';
        } else {
            $rule_judul = 'required|is_unique[komik.judul]';
        }

        if (!$this->validate([
            'judul' => [
                'rules' => $rule_judul,
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!',
                    'is_unique' => 'Nama {field} sudah terdaftar!'
                ]
            ],
            'penulis' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!'
                ]
            ],
            'penerbit' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!'
                ]
            ],
            'genre' => [
                'rules' => 'required',
                'errors' => [
                    'required' => 'Kolom {field} harus diisi!'
                ]
            ],
            'sampul' => [
                'rules' => 'max_size[sampul,5120]|is_image[sampul]|mime_in[sampul,image/jpg,image/jpeg,image/png]',
                'errors' => [
                    'max_size' => 'Ukuran Sampul Terlalu Besar',
                    'is_image' => 'Yand Dipilih Bukan Sampul',
                    'mime_in' => 'Format Sampul Berupa .jpg .jpeg .png'
                ]
            ]
        ])) {
            session()->setFlashdata('gagal', 'Manhwa Gagal Ditambahkan');
            return redirect()->to(base_url() . '/komik/edit/' . $this->request->getVar('slug'))->withInput();
        }

        $fileSampul = $this->request->getFile('sampul');

        if ($fileSampul->getError() == 4) {
            $namaSampul = $this->request->getVar('sampulLama');
        } else {
            $namaSampul = $fileSampul->getName();
            $fileSampul->move('img');
            unlink('img/' . $this->request->getVar('sampulLama'));
        }

        $slug = url_title($this->request->getVar('judul'), '-', true);
        $this->komikModel->save([
            'id' => $id,
            'judul' => $this->request->getVar('judul'),
            'slug' => $slug,
            'penulis' => $this->request->getVar('penulis'),
            'penerbit' => $this->request->getVar('penerbit'),
            'genre' => $this->request->getVar('genre'),
            'sampul' => $namaSampul
        ]);

        session()->setFlashdata('pesan', 'Data Manhwa Berhasil Diubah.');

        return redirect()->to('/komik');
    }
}
