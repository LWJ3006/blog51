<?php
namespace app\admin\controller;

use app\admin\model\ModArticle;
use think\Controller;
use think\Request;

class CtlArticle extends Controller
{
    protected $middleware = ['admin'];
    public $request;
    public $mod;
    public function __construct()
    {
        parent::__construct();
        $this->request = new Request();
        $this->mod = new ModArticle();
    }

    public function index()
    {
        return view('article/index');
    }

    public function articleList()
    {
        $params = [
            'page' => $this->request->param('page', 1),
            'limit' => $this->request->param('limit', 15),
        ];
        $list = $this->mod->articleList($params);
        return $list;
    }

    public function addArticle()
    {
        $params['id'] = $this->request->param('id', 0);
        $out['data'] = '';
        if($params['id']) {
            $out['data'] = $this->mod->getArticle($params);
        }
        return view('article/addArticle', $out);
    }

    public function addArticleAction()
    {
        $params = $this->request->post();
        $ret = $this->mod->addArticleAction($params);
        if($ret) {
            return success('','操作完成');
        }
        return fail('发表失败！');
    }

}
