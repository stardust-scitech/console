<?php
namespace app\admin\controller;

use think\Controller;

use think\facade\Db;
use app\common\model\AuthRule as AuthRuleModel;

class Authrule extends Base
{
    public function index()
    {
        $where = [];
        $searchkey = input('searchkey') ? input('searchkey') : '';
        if ($searchkey) {
            $where[] = [
                ['title', 'like', '%' . $searchkey . '%'],
            ];
        }
        $ruleRes = Db::name('auth_rule')->where($where)->select();
        $AuthRuleModel = new AuthRuleModel();
        $ruleDataTree = $AuthRuleModel->ruletree($ruleRes, $searchkey);
        return view('admin/authrule', [
            'ruleDataTree' => $ruleDataTree,
            'left_menu' => 3,
            'searchkey' => $searchkey
        ]);
    }

    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');

            $add = Db::name('auth_rule')->insert($data);
            if ($add) {
                return alert('操作成功！', 'index', 6, 3);
            } else {
                return alert('操作失败！', 'index', 5, 3);
            }
            return;
        }
        $ruleRes = Db::name('auth_rule')->select();
        $AuthRuleModel = new AuthRuleModel();
        $ruleDataTree = $AuthRuleModel->ruletree($ruleRes);
        return view('admin/authrule_add', [
            'ruleDataTree' => $ruleDataTree,
            'left_menu' => 3
        ]);
    }

    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $save = Db::name('auth_rule')->update($data);
            if ($save !== false) {
                return alert('操作成功！', 'index', 6, 3);
            } else {
                return alert('操作失败！', 'index', 5, 3);
            }

        }
        $id = input('id');
        $ruleData = Db::name('auth_rule')->find($id);
        $ruleRes = Db::name('auth_rule')->select();
        $AuthRuleModel = new AuthRuleModel();
        $ruleDataTree = $AuthRuleModel->ruletree($ruleRes);
        return view('admin/authrule_edit', [
            'ruleDataTree' => $ruleDataTree,
            'ruleData' => $ruleData,
            'left_menu' => 3
        ]);
    }

    public function del()
    {
        $id = input('id');
        $res = Db::name('auth_rule')->delete($id);
        if ($res !== false) {
            return alert('操作成功！', 'index', 6, 3);
        } else {
            return alert('操作失败！', 'index', 5, 3);
        }
    }

    //加号展开与收缩
    public function ajaxlst()
    {
        if (request()->isAjax()) {
            $ruleid = input('ruleid');
            $AuthRuleModel = new AuthRuleModel();
            $sonids = $AuthRuleModel->childrenids($ruleid);
            echo json_encode($sonids);
        } else {
            $this->error('非法操作！');
        }
    }
}