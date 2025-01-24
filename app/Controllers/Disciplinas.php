<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\DisciplinasModel;
use App\Models\MatrizCurricularModel;
use App\Models\GruposAmbientesModel;
use CodeIgniter\Exceptions\ReferenciaException;

class Disciplinas extends BaseController
{
    public function index()
    {
        
         $disciplinaModel = new DisciplinasModel();
         $matrizCurricularModel = new MatrizCurricularModel();
         $grupoAmbientesModel = new GruposAmbientesModel();
         $data['disciplinas'] = $disciplinaModel->orderBy('nome', 'asc')->getDisciplinaWithMatrizAndGrupo();
         $data['matrizes'] = $matrizCurricularModel->orderBy('nome', 'asc')->findAll();
         $data['gruposAmbientes'] = $grupoAmbientesModel->orderBy('nome', 'asc')->findAll();
         
         $data['content'] = view('sys/lista-disciplinas', $data);
         return view('dashboard', $data);
    }
    
    public function salvar()
    {
        $disciplinaModel = new DisciplinasModel();

        //coloca todos os dados do formulario no vetor dadosPost
        $dadosPost = $this->request->getPost();

        $dadosLimpos['nome'] = strip_tags($dadosPost['nome']);
        $dadosLimpos['codigo'] = strip_tags($dadosPost['codigo']);
        $dadosLimpos['matriz_id'] = strip_tags($dadosPost['matriz_id']);
        $dadosLimpos['ch'] = strip_tags($dadosPost['ch']);
        $dadosLimpos['max_tempos_diarios'] = strip_tags($dadosPost['max_tempos_diarios']);
        $dadosLimpos['periodo'] = strip_tags($dadosPost['periodo']);
        $dadosLimpos['abreviatura'] = strip_tags($dadosPost['abreviatura']);
        $dadosLimpos['grupo_de_ambientes_id'] = strip_tags($dadosPost['grupo_de_ambientes_id']) ?? "";

        //tenta cadastrar o nova disciplina no banco
        if ($disciplinaModel->insert($dadosLimpos)) {
            //se deu certo, direciona pra lista de disciplinas
            session()->setFlashdata('sucesso', 'Disciplina cadastrada com sucesso.');
            return redirect()->to(base_url('/sys/disciplina')); // Redireciona para a página de listagem
        } else {
            $data['erros'] = $disciplinaModel->errors(); //o(s) erro(s)
            return redirect()->to(base_url('/sys/disciplina'))->with('erros', $data['erros'])->withInput(); //retora com os erros e os inputs
        }
    }

    public function atualizar(){
        $dadosPost = $this->request->getPost();

        $dadosLimpos['id'] = strip_tags($dadosPost['id']);
        $dadosLimpos['nome'] = strip_tags($dadosPost['nome']);
        $dadosLimpos['codigo'] = strip_tags($dadosPost['codigo']);
        $dadosLimpos['matriz_id'] = strip_tags($dadosPost['matriz_id']);
        $dadosLimpos['ch'] = strip_tags($dadosPost['ch']);
        $dadosLimpos['max_tempos_diarios'] = strip_tags($dadosPost['max_tempos_diarios']);
        $dadosLimpos['periodo'] = strip_tags($dadosPost['periodo']);
        $dadosLimpos['abreviatura'] = strip_tags($dadosPost['abreviatura']);
        $dadosLimpos['grupo_de_ambientes_id'] = $dadosPost['grupo_de_ambientes_id'] ?? null;

        $disciplinaModel = new DisciplinasModel();
        if($disciplinaModel->save($dadosLimpos)){
            session()->setFlashdata('sucesso', 'Disciplina atualizada com sucesso.');
            return redirect()->to(base_url('/sys/disciplina')); // Redireciona para a página de listagem
        } else {
            $data['erros'] = $disciplinaModel->errors(); //o(s) erro(s)
            return redirect()->to(base_url('/sys/disciplina'))->with('erros', $data['erros']); //retora com os erros
        }
    }
    public function deletar(){
        
        $dadosPost = $this->request->getPost();
        $id = strip_tags($dadosPost['id']);

        $disciplinaModel = new DisciplinasModel();
        try {
            if ($disciplinaModel->delete($id)) {
                session()->setFlashdata('sucesso', 'Disciplina excluída com sucesso.');
                return redirect()->to(base_url('/sys/disciplina'));
            } else {
                return redirect()->to(base_url('/sys/disciplina'))->with('erro', 'Falha ao deletar disciplina');
            }
        } catch (ReferenciaException $e) {
            return redirect()->to(base_url('/sys/disciplina'))->with('erros', ['erro' => $e->getMessage()]);
        }
    }
}
