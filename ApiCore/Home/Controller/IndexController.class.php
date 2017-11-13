<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends APIController {

	/**
	 * API控制器默认入口回显
	 */
    public function index(){
        $result = array(
            'code'  =>  200,
            'message'   =>  '系统API运行正常！使用方法参见系统技术文档。',
            'requestId' =>  date('YmdHis',time())
        );
        APIController::api($result);
	}
	
	/**
	 * 用户登录过程
	 */
    public function login(){
        $user = I('param.user','','htmlspecialchars');
        $pswd = I('param.pswd','','htmlspecialchars');
        if ($user == '' || $pswd == '') {
            $result = array(
                'code'  =>  405,
                'message'   =>  '用户名或密码不能为空，请重试。',
                'requestId' =>  date('YmdHis',time())
            );
            APIController::api($result);
        }
        $users = M('myalbum_users');
		$userinfo = $users -> where('username="'.$user.'" AND userpwd="'.sha1($pswd).'"') -> select();
		if ($userinfo) {
			session("myalbum_token",$userinfo[0]["usertoken"]);
			cookie("myalbum_token",$userinfo[0]["usertoken"]);
			session("myalbum_user",$userinfo[0]["username"]);
			session("myalbum_email",$userinfo[0]["email"]);
			$result = array(
				'code'  =>  200,
				'message'   =>  '用户登录成功！',
				'requestId' =>  date('YmdHis',time())
			);
			APIController::api($result);
		}
		else {
			$result = array(
				'code'  =>  403,
				'message'   =>  '用户名或密码不正确！',
				'requestId' =>  date('YmdHis',time())
			);
			APIController::api($result);
		}
	}
	
	/**
	 * 用户信息的注册登记
	 */
	public function register() {
		$user = I('param.user','','htmlspecialchars');
		$pswd = I('param.pswd','','htmlspecialchars');
		$mail = I('param.mail','','htmlspecialchars');
		if ($user == '' || $pswd == '' || $mail == '') {
			$result = array(
                'code'  =>  405,
                'message'   =>  '用户信息不完整，无法继续注册。请重试！',
                'requestId' =>  date('YmdHis',time())
            );
            APIController::api($result);
		}
		$users = M('myalbum_users');
		$ucheck = $users -> where('username="'.$user.'"') -> select();
		if ($ucheck) {
			$result = array(
                'code'  =>  502,
                'message'   =>  '已有相同用户名的账号，请换一个更有创意的名字吧。',
                'requestId' =>  date('YmdHis',time())
            );
            APIController::api($result);
		}
		$udata = array(
			'username'	=>	$user,
			'userpwd'	=>	sha1($pswd),
			'usertoken'	=>	sha1($user.$pswd),
			'email'	=>	$mail
		);
		$op_result = $users -> data($udata) -> add();
		if ($op_result) {
			$result = array(
                'code'  =>  200,
                'message'   =>  '恭喜您，用户注册成功！',
                'requestId' =>  date('YmdHis',time())
            );
            APIController::api($result);
		}
		else {
			$result = array(
                'code'  =>  500,
                'message'   =>  '用户注册失败！后台数据库处于忙碌状态，请稍后再次尝试。',
                'requestId' =>  date('YmdHis',time())
            );
            APIController::api($result);
		}
	}

	/**
	 * 用户会话的退出
	 */
	public function logout() {
		session("myalbum_token",null);
		session("myalbum_user",null);
		session("myalbum_email",null);
		cookie("myalbum_token",null);
		$result = array(
			'code'  =>  200,
			'message'   =>  '操作成功结束，当前用户会话已从本机注销！',
			'requestId' =>  date('YmdHis',time())
		);
		APIController::api($result);
	}

	public function operate() {
		if (I('token','','htmlspecialchars') == '') {
			$result = array(
				'code'  =>  401,
				'message'   =>  '会话密钥非法，请不要恶意攻击本系统。',
				'requestId' =>  date('YmdHis',time())
			);
			APIController::api($result);
		}
		else if (I('token','','htmlspecialchars') != session('myalbum_token')) {
			$result = array(
				'code'  =>  403,
				'message'   =>  '无效的密钥，可能您本次会话已经过期。请尝试重新登录！',
				'requestId' =>  date('YmdHis',time())
			);
			APIController::api($result);
		}
		else {
			switch(I('mod','','htmlspecialchars')) {
				case "baseinfo":
				if (I('type','','htmlspecialchars') != 'write') {
					$baseinfo = M('myalbum_basicinfo');
					$baseinfo = $baseinfo -> select();
					APIController::api($baseinfo);
				}
				else {
					if(I('data','','htmlspecialchars') == '') {
						$result = array(
							'code'  =>  -1,
							'message'   =>  '没有传入任何配置参数，本次配置更新操作已被取消。',
							'requestId' =>  date('YmdHis',time())
						);
						APIController::api($result);
					}
					/*
					else {
						$data_array = json_decode(@$_POST['data']);
						
						if($data_array['name'] == null || $data_array['nickname'] == null || $data_array['icon'] == null || $data_array['logo'] == null || $data_array['saying'] == null || $data_array['author'] == null || $data_array['copyright'] == null) {
							$result = array(
								'code'  =>  -2,
								'message'   =>  '配置参数字符串无效，请联系站点管理员获取正确的配置信息格式。',
								'requestId' =>  date('YmdHis',time())
							);
							APIController::api($result);
						}
						print_r($data_array);
						exit();
					}
					*/
				}
				break;
				default:
				$result = array(
					'code'  =>  405,
					'message'   =>  '无效的操作类，请确认是否传入了合法的mod。',
					'requestId' =>  date('YmdHis',time())
				);
				APIController::api($result);
				break;
			}
		}
	}

	public function mainsubmit(){
		$mainsubmit = M('myalbum_basicinfo');
		$data['myalbum_name'] = I('param.myalbum_name','','htmlspecialchars');
		$data['myalbum_nickname'] = I('param.myalbum_nickname','','htmlspecialchars');
		$data['myalbum_saying'] = I('param.myalbum_saying','','htmlspecialchars');
		$data['myalbum_author'] = I('param.myalbum_author','','htmlspecialchars');
		$data['myalbum_copyright'] = I('param.myalbum_copyright','','htmlspecialchars');
		$data['myalbum_icon'] = I('param.myalbum_icon','','htmlspecialchars');
		$data['myalbum_logo'] = I('param.myalbum_logo','','htmlspecialchars');
		$up_result = $mainsubmit->save($data);
		if ($up_result) {
			$result = array(
                'code'  =>  200,
                'message'   =>  '成功更新数据！'
            );
            APIController::api($result);
		}
		else {
			$result = array(
                'code'  =>  500,
                'message'   =>  '更新数据失败！'
            );
            APIController::api($result);
		}
	}
}