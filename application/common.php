<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

//发送邮箱方法
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


function mailto($to,$title,$content) {
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPDebug = 0;
        //使用STMP服务
        $mail->isSMTP();

        //这里使用我们第二步设置的stmp服务地址
        $mail->Host = "smtp.qq.com";

        //设置是否进行权限校验
        $mail->SMTPAuth = true;

        //第二步中登录网易邮箱的账号
        $mail->Username = "706709960@qq.com";

        //客户端授权密码，注意不是登录密码
        $mail->Password = "byuychvxdrnibbbe";

        //使用ssl协议
        $mail->SMTPSecure = 'ssl';

        //端口设置
        $mail->Port = 465;

        //字符集设置，防止中文乱码
        $mail->CharSet= "utf-8";

        //设置邮箱的来源，邮箱与$mail->Username一致，名称随意
        $mail->setFrom("706709960@qq.com", "是是是是");

        //设置收件的邮箱地址
        $mail->addAddress($to);

        //设置回复地址，一般与来源保持一直
        $mail->addReplyTo("70670960@qq.com", "是是是是");

        $mail->isHTML(true);
        //标题
        $mail->Subject = $title;
        //正文
        $mail->Body    = $content;
        $mail->send();

        return 1;
//            return array('errCode'=>0,'msg'=>'ok');
    } catch (Exception $e) {
        exception($mail->ErrorInfo,100);
//            return array('errCode'=>-1,'msg'=>$mail->ErrorInfo);
    }
}