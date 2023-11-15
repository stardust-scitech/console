<?php
namespace app\admin\controller;

use think\facade\Db;

class AuthGroup extends Base
{
    public function index()
    {
        $authGroupData = Db::name('authGroup')->select();

        return view('admin/group', [
            'authGroupData' => $authGroupData,
            'left_menu' => 3
        ]);
    }

    /* 新增 */
    public function add()
    {
        if (request()->isPost()) {
            $data = input('post.');

            $add = Db::name('authGroup')->insert($data);
            if ($add) {
                return alert('操作成功！', 'index', 6, 3);
            } else {
                return alert('操作失败！', 'index', 5, 3);
            }
            return;
        }
        return view('admin/group_add', [
            'left_menu' => 3
        ]);
    }

    /* 编辑 */
    public function edit()
    {
        if (request()->isPost()) {
            $data = input('post.');

            $save = Db::name('auth_group')->update($data);
            if ($save !== false) {
                return alert('操作成功！', 'index', 6, 3);
            } else {
                return alert('操作失败！', 'index', 6, 3);
            }
            return;
        }
        $id = input('id');
        $authGroupData = Db::name('auth_group')->find($id);
        return view('admin/group_edit', [
            'authGroupData' => $authGroupData,
            'left_menu' => 3
        ]);
    }


    /* 删除 */
    public function del()
    {
        $id = input('id');
        $res = Db::name('auth_group')->delete($id);
        if ($res) {
            return alert('删除成功！', 'index', 6, 3);
        } else {
            return alert('删除失败！', 'index', 5, 3);
        }
    }

    /* 分配权限 */
    public function power()
    {
        if (request()->isPost()) {
            $data = input('post.');
            $rules = '';
            if (!empty($data['rules'])) {
                $rules = implode(',', $data['rules']);
            }

            $save = Db::name('auth_group')->where(array('id' => $data['id']))->update(['rules' => $rules]);
            if ($save !== false) {
                return alert('操作成功！', 'index', 6, 3);
            } else {
                return alert('操作失败！', 'index', 6, 3);
            }
            return;
        }
        $data = Db::name('auth_rule')->where(['parent_id' => 0])->select()->toArray();
        foreach ($data as $k => $v) {
            $data[$k]['children'] = Db::name('auth_rule')->where(['parent_id' => $v['id']])->select()->toArray();
            foreach ($data[$k]['children'] as $k1 => $v1) {
                $data[$k]['children'][$k1]['children'] = Db::name('auth_rule')->where(['parent_id' => $v1['id']])->select()->toArray();
            }
        }
        $id = input('id');
        $authGroupData = Db::name('auth_group')->find($id);
        $rules = explode(',', $authGroupData['rules']);

        return view('admin/group_power', [
            'authGroupData' => $authGroupData,
            'data' => $data,
            'rules' => $rules,
            'left_menu' => 3
        ]);
    }
}