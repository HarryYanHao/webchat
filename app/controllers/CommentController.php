<?php

/**
* \HomeController
*/

use App\Services\YoudaoService;
use App\Services\RequestService;
use App\Services\TranslateService;
use App\Providers\MongoDB;

class CommentController extends BaseController
{
  public function weiboComment(){
    $url_param = time().rand(100,999);
    $url = 'https://weibo.com/aj/v6/comment/add?ajwvr=6&__rnd='.$url_param;
    $header = ['Accept: */*',
'Accept-Encoding: gzip, deflate, br',
'Accept-Language: zh-CN,zh;q=0.9,en;q=0.8',
'Connection: keep-alive',
'Content-Length: 165',
'Content-Type: application/x-www-form-urlencoded',
'Cookie: SINAGLOBAL=7963345934989.805.1498839290620; wb_cmtLike_1768044267=1; SSOLoginState=1537524399; YF-Ugrow-G0=ea90f703b7694b74b62d38420b5273df; YF-V5-G0=4955da6a9f369238c2a1bc4f70789871; YF-Page-G0=ab26db581320127b3a3450a0429cde69; _s_tentry=-; Apache=4235625544824.817.1537598823700; ULV=1537598823719:35:2:2:4235625544824.817.1537598823700:1537166595612; WBtopGlobal_register_version=9744cb1b8d390b27; UOR=database.51cto.com,widget.weibo.com,ent.ifeng.com; login_sid_t=f2dc726f2701100f44567a1517526654; cross_origin_proto=SSL; wb_view_log=1280*8002; SCF=AnKLVW0qIyUFHPEb3MEI5fiPXy3MM86jjSHKMDtKOqxgfdQcEkNutJ6zj4OnYEzn_QYWAayNbfzGl1VvAJkLI5Q.; SUB=_2A252uCNFDeRhGedJ7VoR9CrOzTuIHXVVzBONrDV8PUNbmtBeLULmkW9NUdv63w3EzXhQUef4FJwb5UJ27jvJgVE7; SUBP=0033WrSXqPxfM725Ws9jqgMF55529P9D9W5JMb39eCC.0B_VRYJiPA5g5JpX5K2hUgL.Fo2NSon7ShBESoM2dJLoIpzLxKBLBonLBK-LxKqLBoML12qt; SUHB=0auBI5_5wvJqjm; ALF=1539673493; un=13713954032; wvr=6; wb_view_log_1768044267=1280*8002',
'DNT: 1',
'Host: weibo.com',
'Origin: https://weibo.com',
'Referer: https://weibo.com/1768044267/profile?rightmod=1&wvr=6&mod=personinfo&is_all=1',
'User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/69.0.3497.100 Safari/537.36',
'X-Requested-With: XMLHttpRequest'];
    $post_data = ['act'=>'post',
    'mid'=>4263877925193447,
    'uid'=>1768044267,
    'forward'=> 0,
    'isroot'=> 0,
    'content'=>'harryTestByCurl',
    'location'=>'page_100505_home',
    'module'=>'scommlist',
    'group_source'=>'', 
    'pdetail'=>1005051768044267,
    '_t'=> 0
    ];
    $res = RequestService::post($url,$header,$post_data,3);
    dump($res);
  }
  

}
  

