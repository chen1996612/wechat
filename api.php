<?php
/**
  * wechat php test
  */

//define your token
//定义TOKEN密钥
define("TOKEN", "weixin");
//实例化一个微信对象
$wechatObj = new wechatCallbackapiTest();
//验证成功后注释掉valid方法
//$wechatObj->valid();
//开启自动回复功能
$wechatObj->responseMsg();
//定义类文件
class wechatCallbackapiTest
{
    //实现valid验证方法:实现对接微信公众平台
	public function valid()
    {
        //接收随机字符串
        $echoStr = $_GET["echostr"];

        //valid signature , option
        //进行用户数字签名验证
        if($this->checkSignature()){
        	echo $echoStr;
            echo '';
        	exit;
        }
    }
    //自动恢复功能
    public function responseMsg()
    {
		//get post data, May be due to the different environments
		//接收用户端发送过来的xml数据
        $postStr = $GLOBALS["HTTP_RAW_POST_DATA"];

      	//extract post data
        //判断xml数据是否为空
		if (!empty($postStr)){
                //通过simplexml进行xml解析
              	$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
                //接收微信的手机端
                $fromUsername = $postObj->FromUserName;
                //微信的公众平台
                $toUsername = $postObj->ToUserName;
                //接收用户发送的关键词
                $keyword = trim($postObj->Content);


                //接收用户消息类型
                $msgType = $postObj->MsgType;

                //时间戳
                $time = time();
                //文本发送模版
                $textTpl = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<Content><![CDATA[%s]]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>";
            //文本消息接口
            if($msgType=='text'){
                //判断发送关键词是否为空
				if(!empty( $keyword ))
                {
                    //回复类型，如果为text，代表文本类型
              		$msgType = "text";
                    //回复内容
                	$contentStr = "您发送的文本消息";
                    //格式化字符串
                	$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    //把xml数据返回给手机端
                	echo $resultStr;
                }else{
                	echo "Input something...";
                }
            }
            //图片消息接口
            elseif($msgType=='image'){
                    //回复类型，如果为text，代表文本类型
                    $msgType = "text";
                    //回复内容
                    $contentStr = "您发送的图片消息";
                    //格式化字符串
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    //把xml数据返回给手机端
                    echo $resultStr;
            }
            //语音消息接口
            elseif($msgType=='voice'){
                    //回复类型，如果为text，代表文本类型
                    $msgType = "text";
                    //回复内容
                    $contentStr = "您发送的语音消息";
                    //格式化字符串
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    //把xml数据返回给手机端
                    echo $resultStr;
            }
            //视频消息接口
            elseif($msgType=='voice'){
                    //回复类型，如果为text，代表文本类型
                    $msgType = "text";
                    //回复内容
                    $contentStr = "您发送的视频消息";
                    //格式化字符串
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    //把xml数据返回给手机端
                    echo $resultStr;
            }
            //音乐消息接口
            elseif($msgType=='voice'){
                    //回复类型，如果为text，代表文本类型
                    $msgType = "text";
                    //回复内容
                    $contentStr = "您发送的音乐消息";
                    //格式化字符串
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    //把xml数据返回给手机端
                    echo $resultStr;
            }
            //图文消息接口
            elseif($msgType=='voice'){
                    //回复类型，如果为text，代表文本类型
                    $msgType = "text";
                    //回复内容
                    $contentStr = "您发送的图文消息";
                    //格式化字符串
                    $resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
                    //把xml数据返回给手机端
                    echo $resultStr;
            }

        }else {
        	echo "";
        	exit;
        }
    }

	private function checkSignature()
	{
        //接收微信加密签名
        $signature = $_GET["signature"];
        //接收时间戳信息
        $timestamp = $_GET["timestamp"];
        //接收随机数
        $nonce = $_GET["nonce"];
        //把TOKEN常量复制给$token变量
		$token = TOKEN;
        //把相关参数组装为数组
		$tmpArr = array($token, $timestamp, $nonce);
        //通过字典法进行排序
		sort($tmpArr);
        //把排序后的数组转化字符串
		$tmpStr = implode( $tmpArr );
        //通过哈希算法对字符串进行加密操作
		$tmpStr = sha1( $tmpStr );
        //与加密签名进行比对
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>