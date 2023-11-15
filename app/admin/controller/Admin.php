<?php
namespace app\admin\controller;

use think\facade\Db;
use think\facade\Request;

class Admin extends Base
{
	/**
	 * @return 管理员管理
	 */
	public function index()
	{

		$loginAdmin = session('adminAccount');
		if ($loginAdmin['group_id'] == 1) {
			$adminData = Db::name('admin')->alias('a')->field('a.*,b.title')->join('auth_group b', 'a.group_id=b.id')->select();
		} else {
			$adminData = Db::name('admin')->alias('a')->field('a.*,b.title')->join('auth_group b', 'a.group_id=b.id')->where('a.id', $loginAdmin['id'])->select();
		}
		return view('', [
			'adminData' => $adminData,
			'left_menu' => 3,
			'group_id' => $loginAdmin['group_id']
		]);
	}

	public function add()
	{
		if (request()->post()) {
			$data = input('post.');

			$data['password'] = password_salt($data['password']);
			$data['create_time'] = time();

			$id = Db::name('admin')->insertGetId($data);
			$res = Db::name('auth_group_access')->insert(['uid' => $id, 'group_id' => $data['group_id']]);
			if ($res && $id) {
				return alert('添加成功！', 'index', 6, 3);
			} else {
				return alert('添加失败！', 'index', 5, 3);
			}
		}
		$authGroupData = Db::name('auth_group')->select();
		return view('', [
			'authGroupData' => $authGroupData,
			'left_menu' => 3
		]);
	}

	public function edit()
	{
		$id = input('id');

		if (request()->post()) {
			$data = input('post.');

			if (!empty($data['password'])) {
				$data['password'] = password_salt($data['password']);
			} else {
				unset($data['password']);
			}

			$res1 = Db::name('admin')->update($data);
			$res2 = Db::name('auth_group_access')->where('uid', $id)->update(['group_id' => $data['group_id']]);
			if ($res1 || $res2) {
				return alert('修改成功！', 'index', 6, 3);
			} else {
				return alert('修改失败！', 'index', 5, 3);
			}
		}

		$adminData = Db::name('admin')->find($id);
		$authGroupData = Db::name('auth_group')->select();
		return view('', [
			'adminData' => $adminData,
			'authGroupData' => $authGroupData,
			'left_menu' => 3
		]);
	}

	public function del()
	{
		$id = input('id');
		$res = Db::name('admin')->delete($id);
		if ($res) {
			return alert('删除成功！', 'index', 6, 3);
		} else {
			return alert('删除失败！', 'index', 5, 3);
		}
	}

	//更改状态
	public function status()
	{
		$id = Request::instance()->param('id', 'intval');
		$status = Request::instance()->param('status', 'intval');

		$res = Db::name('admin')->where('id', $id)->update(['status' => $status]);

		if ($res) {
			return alert('操作成功！', 'index', 6, 3);
		} else {
			return alert('操作失败！', 'index', 5, 3);
		}
	}
}