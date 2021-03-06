<?php
/**
 * 登陆管理
 */
namespace app\admin\controller;
use app\admin\model\RoleModel;
use app\admin\model\UserModel;
use think\Controller;
use org\Verify;

class Login extends Controller
{
    /**
     * 登录页面
     * @return mixed
     */
    public function index()
    {
        return $this->fetch('/login');
    }

    /**
     * 登录操作
     * @return \think\response\Json
     */
    public function doLogin()
    {
        $userName = input("param.user_name");
        $password = input("param.password");
        $code = input("param.code");
        $result = $this->validate(compact('userName', 'password', "code"), 'LoginValidate');
        if(true !== $result){
            return json(msg(-1, '', $result));
        }

        $verify = new Verify();
        if (!$verify->check($code)) {
            return json(msg(-2, '', '验证码错误'));
        }

        $userModel = new UserModel();
        $hasUser = $userModel->findUserByName($userName);
        if(empty($hasUser)){
            return json(msg(-3, '', '管理员不存在'));
        }

        if(md5($password) != $hasUser['password']){
            return json(msg(-4, '', '密码错误'));
        }

        if(1 != $hasUser['status']){
            return json(msg(-5, '', '该账号被禁用'));
        }

        // 获取该管理员的角色信息
        $roleModel = new RoleModel();
        $info = $roleModel->getRoleInfo($hasUser['role_id']);

        session('username', $userName);
        session('id', $hasUser['id']);
        session('role', $info['role_name']);  // 角色名
        session('rule', $info['rule']);  // 角色节点
        session('action', $info['action']);  // 角色权限

        // 更新管理员状态
        $param = [
            'login_times' => $hasUser['login_times'] + 1,
            'last_login_ip' => request()->ip(),
            'last_login_time' => time()
        ];
        $res = $userModel->updateStatus($param, $hasUser['id']);
        if(1 != $res['code']){
            return json(msg(-6, '', $res['msg']));
        }

        // ['code' => 1, 'data' => url('index/index'), 'msg' => '登录成功']
        return json(msg(1, url('index/index'), '登录成功'));
    }

    /**
     * 验证码
     */
    public function checkVerify()
    {
        $verify = new Verify();
        $verify->imageH = 32;
        $verify->imageW = 100;
        $verify->length = 4;
        $verify->useNoise = false;
        $verify->fontSize = 14;
        return $verify->entry();
    }

    /**
     * 退出操作
     */
    public function loginOut()
    {
        session('username', null);
        session('id', null);
        session('role', null);  // 角色名
        session('rule', null);  // 角色节点
        session('action', null);  // 角色权限

        $this->redirect(url('index'));
    }

    /**
     * 修改密码
     * @return array|\think\response\Json
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     */
    public function edit_password()
    {
        if (request()->isPost()) {
            $param = input('post.');
            //验证数据
            $result = $this->validate($param, 'CipherValidate');
            if (true !== $result) {
                // 验证失败 输出错误信息
                return msg(-1, '', $result);
            }
            $id = session('id');
            $param['used'] = md5($param['used']);
            $param['password'] = md5($param['password']);
            $user = new UserModel();
            //获取信息
            $users = $user
                ->where([
                    'id' => $id
                ])
                ->find();
            //验证旧密码是否正确
            if ($users['password'] != $param['used']) {
                return msg(-1, '', '原密码错误！');
            }
            //修改密码
            $flag = $user
                ->where([
                    'id' => $id
                ])
                ->setField([
                    'password' => $param['password'],
                    'update_time' => time()
                ]);
            if ($flag) {
                return msg(1, url('login/loginOut'), '修改成功');
            } else {
                return msg(-1, '', '修改失败');
            }
        }
        return msg(-2, '', '请求异常');
    }
}