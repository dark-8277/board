<?
// DB Connection
require_once $_SERVER['DOCUMENT_ROOT'] . '/../common/secret.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../common/class/DBConn.php';

if(!isset($GINIT['cronFlag']) || !$GINIT['cronFlag']) session_start();
define("_INI_", true);

//echo $_SERVER['PHP_SELF'];

//#################################################################################################
$GINIT['title'] = "빠른 폐차 서비스! 조인스오토";
$GINIT['company'] = "조인스오토";
$GINIT['siteKey'] = "joinsauto";
$GINIT['URL'] = "http://www.joinsauto.com";
$GINIT['siteGubunInit'] = "";
$GINIT['carImageFolder'] = "/data/";
$GINIT['carImageFolderIC'] = "/ic.php?f=/data/";
$GINIT['underPricePercent'] = 0.2;
$GINIT['updateDelay'] = 3 * 3600;
$GINIT['serverCommon'] = "homepage/emeye.co.kr/html";
$GINIT['gubunPrice2'] = 1790000;
$GINIT['gubunPrice3'] = 2390000;
$GINIT['gubunPrice4'] = 3000000;
$GINIT['gubunPrice5'] = 300000;
$GINIT['naverapi'] = "86050b8842c9e77c9bf4b9baa9785142";
$GINIT['carSiseGraphMax'] = 5;
$GINIT['randMax'] = 20;
$GINIT['carSettingOrder'] = "mb";
$GINIT['PWKEY1'] = "jOiNs";
$GINIT['PWKEY2'] = "aUtO";
$GINIT['SMSTEL'] = "1800-2072";

$GINIT['kmcertID'] = "JOAM1001";
$GINIT['kmcertCode'] = "MJOAM1001000";
$GINIT['kmcertPageCode'] = "001001"; // /_mc/car/write.html


############  GSM PUSH 서비스 키  #################

// 고객용 실서버
$GINIT['GSM_API_KEY'] = "AAAAchJRiZI:APA91bFDw2v8g4z06W0JbNjq8eXl5mFwjZ_JVzGD4F-uSRUQE6JX8RtHi56zpUIN2eP_0ibXhfr4lB6Xg-hhhVX3_LDbfDtozCvK_KRtbUsJB4XxF4kSc5Fdlof_P60U_iso6cLtJYTb";
$GINIT['GSM_API_ID'] = "481112765419";
// 고객용 DEV서버
//$GINIT['GSM_API_KEY'] = "AAAAchJRiZI:APA91bFDw2v8g4z06W0JbNjq8eXl5mFwjZ_JVzGD4F-uSRUQE6JX8RtHi56zpUIN2eP_0ibXhfr4lB6Xg-hhhVX3_LDbfDtozCvK_KRtbUsJB4XxF4kSc5Fdlof_P60U_iso6cLtJYTb";
//$GINIT['GSM_API_ID'] = "585654715201";

// 협력업체용 실서버
$GINIT['GSM_API_KEY2'] = "AAAAchJRiZI:APA91bFDw2v8g4z06W0JbNjq8eXl5mFwjZ_JVzGD4F-uSRUQE6JX8RtHi56zpUIN2eP_0ibXhfr4lB6Xg-hhhVX3_LDbfDtozCvK_KRtbUsJB4XxF4kSc5Fdlof_P60U_iso6cLtJYTb";
$GINIT['GSM_API_ID2'] = "36738789816";
// 협력업체용 DEV서버
//$GINIT['GSM_API_KEY2'] = "AAAAchJRiZI:APA91bFDw2v8g4z06W0JbNjq8eXl5mFwjZ_JVzGD4F-uSRUQE6JX8RtHi56zpUIN2eP_0ibXhfr4lB6Xg-hhhVX3_LDbfDtozCvK_KRtbUsJB4XxF4kSc5Fdlof_P60U_iso6cLtJYTb";
//$GINIT['GSM_API_ID2'] = "585654715201";


$GINIT['inicisMID'] = "joinsauto0";
//$GINIT['inicisMID'] = "INIpayTest";

############  할부관련 고정 요율  #################
$GINIT['i_first'] = 0;
$GINIT['i_percent'] = 10;
$GINIT['i_month'] = 36;

$hp_data = array('010','011','016','017','018','019');
$tel_data = array('02','031','032','033','041','042','043','051','052','053','054','055','061','062','063','064', '060', '070', '대표');
$area_data = array('전국','서울','인천','경기','대전','대구','부산','광주','울산','충북','충남','경북','경남','전북','전남','강원','제주');
$areaNo_data = array('전국','01','03','02','07','05','04','08','06','14','13','10','09','12','11','15','16');
$dealerLevel_data = array(
	array(10, "신입딜러", "White")
	, array(20, "열심딜러", "Blue")
	, array(30, "우수딜러", "Red")
	, array(40, "인증딜러", "Black")
);
$memLevel_data = array("비회원", "회원", "", "", "", "", "", "", "", "관리자");
$memGubun_data = array("", "고객", "협력업체");
$carGubun_data = array("", "일반차량", "우대", "추천");
$memGubunCode_data = array("", "", "vip", "vvip", "premium");
$carLevel_data = array("", "일반", "추천", "프리미엄", "급매");
$gear_data =  array('수동','자동' );
//$gas_data  =  array('휘발유','디젤','LPG 장애','LPG 일반');
$gas_data  =  array('LPG','가솔린','가솔린+전기','디젤', '전기');
$ap_carCnt_data = array(5, 10, 20, 30, 50);
$ap_month_data = array(1, 3, 6);
$apFlag_data = array(
	array("Y", "예"),
	array("N", "아니오"),
	array("Q", "잘모름")
);

$isAcc_data = array(
	array("Y", "예"),
	array("N", "아니오"),
	array("X", "잘모름")
);
$isAcc_data2 = array(
	array("X", "잘모름"),
	array("Y", "예"),
	array("N", "아니오")
);

$ccYear = date("Y", strtotime("-1 year"));
$ccMonth = date("m", strtotime("-1 year"));
$cc2Year = date("Y", strtotime("-5 year"));
$cc2Month = date("m", strtotime("-5 year"));
$saleSql_data = array(""
	, " and (prod_year>'$ccYear' or (prod_year='$ccYear' and prod_month >='$ccMonth')) "
	, " and 1 "
	, " and fuel='LPG' and (prod_year<'$cc2Year' or (prod_year='$cc2Year' and prod_month <='$cc2Month')) "
	, " and opt_memo like '%4륜%' "
	, " and gubun_id in (10,11) "
);

$baegi_data = array("-800", "801-1000", "1001-1300", "1301-1500", "1801-2000", "2001-2500", "2501-2700", "2701-3000", "3001-3500", "3501-4000", "4001-4500");

$priceNo_data = array(100, 200, 300, 400, 500, 600, 700, 800, 900, 1000, 1200, 1500, 1800, 2000, 2500, 3000, 3500, 4000, 4500, 5000, 5500, 6000, 7000, 8000, 9000, 10000);
$mileageNo_data = array(10000, 20000, 30000, 40000, 50000, 60000, 70000, 80000, 90000, 100000, 120000, 150000, 180000, 200000, 250000, 300000);

// 차량등록중 : 사용자가 저장하기 전 (현재쓰지않음)
// 승인대기중 : 사용자 저장 후 관리자 승인 전 (현재쓰지않음)
// 대기중 : aucSDate 도달 전. 차량을 등록하고 경매시작전
// 현재 입찰중 : 입찰가능한 상태
// 상담대기 : 견적시간이 종료되고 딜러 선택 전
// 결제대기 : 판매자가 딜러 선택 후
// 성사 : 딜러가 입금하고난 상태
// 견적실패 : 입찰이 없거나 판매자가 판매를 포기한 상태 (견적가 종료되고 관리자가 지정한 시간까지 딜러 선택이 없으면 유찰)
// 판매완료 : 딜러가 입금하고 모든 판매가 마무리된 상태
//$auctionStatus_data = array('', '등록중', '승인전', '대기중', '견적중', '상담대기', '결제대기', '성사', '견적실패', '판매완료');
$auctionStatus_data = array('', '등록중', '승인전', '경매대기', '경매 중', '선택대기', '거래 중', '금일예정', '거래완료', '경매종료');
//$auctionStatus_salecar_data = array('', '등록중', '승인전', '경매대기', '경매 중', '선택대기', '거래 중', '금일예정', '거래완료', '경매종료');
$auctionStatusTitle_data = array('', '차량등록중', '승인대기중', '대기중', '현재 입찰중', '견적종료', '낙찰', '판매완료', '견적실패', '견적종료', '즉시구매중');
$auctionStatusTitle_data = array('', '차량등록중', '승인대기중', '대기중', '현재 입찰중', '상담대기', '결제대기', '성사', '견적실패', '판매완료');

$price_data = array("100-200", "201-300", "301-400", "401-500", "501-800", "801-1000", "1001-2000", "2001-3000", "3001-5000", "5001-");
$price2_data = array("-500", "501-800", "801-1000", "1001-2000", "2001-3000", "3001-4000", "4001-5000", "5001-6000", "6001-7000", "7001-");
$pageSize_data = array("8", "12", "16", "20", "28", "36", "48", "52", "60");
$cash_data = array("" => "그외 입금", "CARD" => "신용카드", "BANK" => "계좌이체", "MOBILE" => "핸드폰결제", "DIRECT" => "무통장입금", "ADMIN" => "관리자승인"); // , "PROMO" => "프로모션"
$optionGubun_data  =  array('', '외관', '내장', '안전', '편의');
$service_data = array("" => "일반", "person" => "개인회원", "free" => "자유이용권", "vip" => "VIP회원", "vvip" => "VIP회원", "fm" => "무료회원");

$imageText_data = array('전면사진','측면사진','후면사진','실내사진','엔진사진','옵션사진1','옵션사진2','옵션사진3','옵션사진4','옵션사진5','옵션사진6','옵션사진7','옵션사진8','옵션사진9','옵션사진10','옵션사진11','옵션사진12','옵션사진13','옵션사진14','옵션사진15');

$hotIcon_data = array('', 'icon1', 'icon2', 'icon3', 'icon4', 'icon5', 'icon6', 'icon7');
$hotIconComment_data = array('',
	'신차급', '무사고', '짧은KM', '최상급', '튜닝', '풀옵션', '1인신조'
	);

$sellPoint_data = array(
	'타시던 차 급하다고 헐값에 팔지마세요!! 전차종 최고가에 삽니다.',
	'아끼셨던 차 파시려구요? 친절히 상담하고 정직하게 사겠습니다.',
	'놀라지 마세요!! 파격적인 가격으로 매입합니다.24시간출장견적.',
	'마지막으로 전화주세요. 원하시는 금액에 맞추어 드립니다.',
	'중고차무료매매상담.열심히 사겠습니다! 열심히 팔겠습니다!',
	'고객님의 재산 탐내지 않겠습니다.출장상담.폐차대행.매입판매.',
	'애매한 차값 정해 주는 남자. 중고차사고팔때 저한테 맡겨주세요.',
	'중고차가격 저보다 더 주는곳 있다면 조용히 간판 내리겠습니다.',
	'얼마를 더 드릴지는 아무도 모릅니다!! 최저가판매! 최고가매입!',
	'상담만 하셔도 좋은 인연이됩니다. 딱! 한번 믿어보시고 전화주세요!!'
);

$nowTime = time();
$nowDate = date("Y-m-d");
$nowDateTime = date("Y-m-d H:i:s");
$nextTime = strtotime("-1 day");
$nextDate = date("Y-m-d", $nextTime);
$nextDateTime = date("Y-m-d H:i:s", $nextTime);
$ingTime = strtotime("+7 day");
$ingDate = date("Y-m-d H:i:s", $ingTime);

//임시변수
$now_excute = $nowDateTime;

// 플래시 변수

// 게시판 변수
$bbsMenuText_data = array("", "커뮤니티", "고객서비스", "고객센터");
$bbsMenuFolder_data = array("", "community", "service", "customer");
$bbsTopMenu_data = array("", "커뮤니티", "고객서비스", "고객센터");
$bbsAdminFolder_data = array("", "community", "service", "customer");

$bbsSkin_data = array("", "일반형", "이미지형", "협력업체", "FAQ");

$bannerType_data = array("", "이미지", "플래쉬", "텍스트");
$bbsBannerLinkType_data = array("링크없음", "홈페이지", "아이디검색");

$HOMEPAGETOPURL = "http://" . $_SERVER['HTTP_HOST'];

#######   관리자 Email 주소 #####
$webmasterMail = $ADMINEMAIL = "webmaster@joinsauto.co.kr";
$ADMINHP = "010-123-1234";

########## Image 서버 관련 설정 ###########

$IMAGEROOT = "";
$IMAGEROOTP = $_SERVER['DOCUMENT_ROOT'];

$IMAGEFRONT = $IMAGEROOT . "/data/";
$IMAGEFRONT = "/data/";
//$IMAGEFRONT = $FTP_IMAGE_TOP_HTML . $FTP_SITE_TOP . "/";

// 이미지 사이즈 줄일때 쓰이는 변수
$IMAGE_MAXSIZE_X = 800;
$IMAGE_MAXSIZE_Y = 800;
// Thumb 사이즈 줄일때 쓰이는 변수
$IMAGE_ICONSIZE_X = 200;
$IMAGE_ICONSIZE_Y = 200;
// 이미지 CROP할때 쓰이는 변수
$IMAGE_CROPSIZE_X = 800;
$IMAGE_CROPSIZE_Y = 600;

// 이미지 최대 갯수
$IMAGE_MAX_COUNT = 6;

// 워터마크 파일, 워터마크 위치
$IMAGE_WATERMARKFLAG = false;
$IMAGE_WATERMARK = "/images/watermark.png";
$IMAGE_WATERMARK_X = 20;
$IMAGE_WATERMARK_Y = 370;
$IMAGE_WATERMARK_POS = "RB";
$IMAGE_WATERMARK_PADDING = 30;

## ☎ 문자 처리 ID (문자를 사용할 때 반드시 필요합니다.)
$siteSMSID = "E_JoinsAuto";
$GINIT['car2bApiSmsUrl'] = "http://api.car2b.com/sms.php";
$GINIT['car2bApiKey'] = "2503ec85b796ef4ce615c8521a4db1c7306ee94b0b571f49b6433c68e75a8540";
## ☎ 문자 처리 ID (문자를 사용할 때 반드시 필요합니다.)


// [s] DB 기초변수 가져오기 ===============================================================================
if(defined("DB_SERVER")) {
$_ba_ = mysql_fetch_array(mysql_query("select * from AU_BASIC where ba_no='1'"));
$GINIT['title'] = $_ba_['ba_siteTitle'];
$GINIT['mobiletitle'] = $_ba_['ba_siteTitle'];
$GINIT['company'] = $_ba_['ba_siteName'];
$GINIT['URL'] = $_ba_['ba_siteUrl'];
$webmasterMail = $ADMINEMAIL = $_ba_['ba_siteEmail'];
$ADMINHP = $_ba_['ba_siteHp'];
$GINIT['copy_compNum'] = $_ba_['ba_compNum'];
$GINIT['copy_compName'] = $_ba_['ba_compName'];
$GINIT['copy_ceoName'] = $_ba_['ba_ceoName'];
$GINIT['copy_compAddress'] = $_ba_['ba_compAddress'];
$GINIT['copy_compAdd1'] = $_ba_['ba_compAdd1'];
$GINIT['copy_compAdd2'] = $_ba_['ba_compAdd2'];
$GINIT['copy_compTel'] = $_ba_['ba_compTel'];
$GINIT['copy_compFax'] = $_ba_['ba_compFax'];
$GINIT['copy_siteAdTel'] = $_ba_['ba_siteAdTel'];
$GINIT['copy_compShopNum'] = $_ba_['ba_compShopNum'];
}
// [e] DB 기초변수 가져오기 ===============================================================================



########### Login 관련 변수 ##############

if(isset($_SESSION['M_ID'])) $LM_ID = $_SESSION['M_ID']; else $LM_ID = "";
if(isset($_SESSION['M_NAME'])) $LM_NAME = $_SESSION['M_NAME']; else $LM_NAME = "";
if(isset($_SESSION['M_LEVEL'])) $LM_LEVEL = $_SESSION['M_LEVEL']; else $LM_LEVEL = "";
if(isset($_SESSION['M_GUBUN'])) $LM_GUBUN = $_SESSION['M_GUBUN']; else $LM_GUBUN = "";
if(isset($_SESSION['M_SUPERUSER'])) $LM_SUPERUSER = $_SESSION['M_SUPERUSER']; else $LM_SUPERUSER = "";
if(isset($_SESSION['M_SUPERUSERID'])) $LM_SUPERUSERID = $_SESSION['M_SUPERUSERID']; else $LM_SUPERUSERID = "";

######################### 이미지 마우스 오버시 색 처리 ##############################
$IMAGE_BGCOLOR = "#d0d0d0";
$IMAGE_BGCOLOROVER = "#4D8E1F";

########### 저장폴더 ##############
$GINIT['dealerSaveFolder'] = $IMAGEROOTP . "/data/__memberpic";
$GINIT['dealerFolder'] = $IMAGEROOT . "/data/__memberpic";
$GINIT['dealerFolderIC'] = "/ic.php?f=/data/__memberpic";
$GINIT['bannerSaveFolder'] = $IMAGEROOTP . "/data/__banner";
$GINIT['bannerFolder'] = $IMAGEROOT . "/data/__banner";
$GINIT['sGroupSaveFolder'] = $IMAGEROOTP . "/data/__sGroup";
$GINIT['sGroupFolder'] = $IMAGEROOT . "/data/__sGroup";

$GINIT['makerSaveFolder'] = $IMAGEROOTP . "/data/__maker";
$GINIT['makerFolder'] = $IMAGEROOT . "/data/__maker";

$GINIT['pOptionSaveFolder'] = $IMAGEROOTP . "/data/__pOption";
$GINIT['pOptionFolder'] = $IMAGEROOT . "/data/__pOption";
$GINIT['partnerSaveFolder'] = $IMAGEROOTP . "/data/__partner";
$GINIT['partnerFolder'] = $IMAGEROOT . "/data/__partner";
$GINIT['consultSaveFolder'] = $IMAGEROOTP . "/data/__consult";
$GINIT['consultFolder'] = $IMAGEROOT . "/data/__consult";

########### 차량쿼리SQL ##############
$GINIT['SQLDEFAULT'] = "";
$GINIT['SQLVIEW'] = $GINIT['SQLDEFAULT'] . " and viewFlag='1' and confirmFlag=1 ";
$GINIT['SQLREADY'] = $GINIT['SQLDEFAULT'] . " and is_sold='N' and (viewFlag='1' and confirmFlag=0) ";
$GINIT['SQLSOLD'] = $GINIT['SQLDEFAULT'] . " and is_sold='Y' ";

$GINIT['SQLDEALER'] = " and MB_FLAG=1 and MB_CONFIRM=1 and MB_GUBUN in (2,3,4) and MB_CONSULTFLAG=0 ";
$GINIT['SQLSELLER'] = " and MB_FLAG=1 and MB_CONFIRM=1 and MB_CONSULTFLAG=1 ";

$GINIT['ingTopOrder'] = "";

//#################################################################################################
// 제목 : 사이트 전용 함수
// 내용 :
// 날짜 : 2010년 2월 17일 수요일 오전 11:00:54
// 작성 : 서정호
//#################################################################################################

function formatPhoneNumber($number) { // 휴대폰 번호 폼 함수
    // 1) 숫자만 추출
    $num = preg_replace('/\D/', '', $number);

    // 2) 길이에 따라 포맷 적용
    if (strlen($num) == 11) {
        // 01012345678 → 010-1234-5678
        return preg_replace('/(\d{3})(\d{4})(\d{4})/', '$1-$2-$3', $num);
    } elseif (strlen($num) == 10) {
        // 0312345678 → 03X-XXX-XXXX 또는 02-XXXX-XXXX
        if (substr($num, 0, 2) == '02') {
            // 02 지역번호
            return preg_replace('/(\d{2})(\d{4})(\d{4})/', '$1-$2-$3', $num);
        } else {
            // 일반지역번호 3자리
            return preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $num);
        }
    } elseif (strlen($num) == 9) {
        // 02-XXX-XXXX
        if (substr($num, 0, 2) == '02') {
            return preg_replace('/(\d{2})(\d{3})(\d{4})/', '$1-$2-$3', $num);
        }
    }

    return $number; // 포맷 불가능하면 원본 반환
}

function chkHoliday($date) {
	global $G_DB;
	$db = new DBConn($G_DB);

	$time = strtotime($date);
	$week = date("w", $time);

	if($week == 0 || $week == 6) return true;

	$chk = getValues($db, "select bv_no from basicVacation where bv_date=?", 0, [$date]);
	if($chk > 0) return true;

	return false;
}
/*
function makePriceNumber($m_no, $price, $bidCnt, $bidDCnt, $time, $soldFlag, $time2, $directFlag, $directResult) {
	$filename = $_SERVER['DOCUMENT_ROOT'].'/data/__auction/' . $m_no;

	if(($fh = fopen($filename,'w')) === FALSE){
		die('Failed to open file for writing!');
	}

	fwrite($fh, $price . ":" . $bidCnt . ":" . $bidDCnt . ":" . $time . ":" . $soldFlag . ":" . $time2 . ":" . $directFlag . ":" . $directResult);
	fclose($fh);
	@chmod($filename, 0666);
}*/

function ipBlock() {
	$arr = makeArray("select ib_ip from ipBlock where ib_flag=1");
	if(in_array($_SERVER['REMOTE_ADDR'], $arr)) {
		exit;
	}
}
function ipBlockRet() {
	$arr = makeArray("select ib_ip from ipBlock where ib_flag=1");
	if(in_array($_SERVER['REMOTE_ADDR'], $arr)) {
		return true;
	}
	return false;
}

function it() {
	return ($_SERVER['REMOTE_ADDR'] == "218.152.104.52");
}

function tel_Format($str) {
	$str = str_replace("-", "", $str);
	$lHP1 = substr($str, 0, 1);
	$lHP2 = substr($str, 0, 2);
	if($lHP2 == "01") { // 휴대폰
		$tTextHP = substr($str, 3);
		$len = strlen($tTextHP);
		$tTextHP2 = substr($str, -4);
		$tTextHP = substr($tTextHP, 0, $len - 4);

		return substr($str, 0, 3) . "-" . $tTextHP . "-" . $tTextHP2;
	}
	elseif($lHP1 == "0") { // 지역번호 포함
		if($lHP2 == "02")  {
			$tTextHP = substr($str, 2);
			$index = 2;
		} else {
			$tTextHP = substr($str, 3);
			$index = 3;
		}

		$len = strlen($tTextHP);
		$tTextHP2 = substr($str, -4);
		$tTextHP = substr($tTextHP, 0, $len - 4);

		return substr($str, 0, $index) . "-" . $tTextHP . "-" . $tTextHP2;
	} else {
		$len = strlen($str);
		if($len > 8) return $str;
		$tTextHP2 = substr($str, -4);
		$tTextHP = substr($str, 0, $len - 4);

		return $tTextHP . "-" . $tTextHP2;
	}
}
/*
function saveAlarmList($m_id, $subject, $message, $mNo, $code) {
	global $G_DB, $now_excute;
	$db = new DBConn($G_DB);
	$insertQuery = "insert into alarmList (a_mId, a_subject, a_message, a_mNo, a_code, a_regDate) values (?, ?, ?, ?, ?, ?)";
	//mysql_query($insertQuery);
	$insertResult = $db->execute($insertQuery, [$m_id, $subject, $message, $mNo, $code, $now_excute]);
}*/
function pushProcess($os, $code, $gsm_msg, $gsm_title = '', $gsm_uid = 0, $ids = '', $noIds = '') {
	global $GINIT, $G_DB;
	$db = new DBConn($G_DB);

	$sql_param=[];
	$sqlIDs = "";
	$sql_param[] = $os;
	if($ids != "") {
		$arrIDs = explode("|", $ids);
		$sqlIDs = " and mm_mId in (";
		for($i = 0; $i < count($arrIDs); $i ++) {
			if($i != 0) $sqlIDs .= ",";
			$sqlIDs .= "?";
			$sql_param[] = $arrIDs[$i];
		}
		$sqlIDs .= ")";
	}
	$sqlNoIDs = "";
	if($noIds != "") {
		$arrNoIDs = explode("|", $noIds);
		$sqlNoIDs = " and mm_mId not in (";
		for($i = 0; $i < count($arrNoIDs); $i ++) {
			if($i != 0) $sqlNoIDs .= ",";
			$sqlNoIDs .= "?";
			$sql_param[] = $arrNoIDs[$i];
		}
		$sqlNoIDs .= ")";
	}

	if($gsm_title == "") {
		$gsm_title = $GINIT['mobiletitle'];
	}
	//$mobilekey_data = makeArray("select distinct MB_MOBILEKEY from Mbr_Members where MB_VIBFLAG=0 and MB_ALARMFLAG=1 and MB_MOBILEGUBUN='{$os}'" . $sqlIDs . $sqlNoIDs);
	//$mIdArr_data = makeArray($db, "select MB_ID, MB_MOBILEKEY, MB_ALARMFLAG, MB_VIBFLAG from Mbr_Members where MB_MOBILEGUBUN=?" . $sqlIDs . $sqlNoIDs, $sql_param);
	$mIdArr_data = makeArray($db, "select mm_mId, mm_pushKey, mm_alarm1Flag, mm_vibFlag from memberMobile where mm_registOS=?" . $sqlIDs . $sqlNoIDs, $sql_param);
	//print_r("select mm_mId, mm_pushKey, mm_alarm1Flag, mm_vibFlag from memberMobile where mm_registOS=?" . $sqlIDs . $sqlNoIDs);die;
	
	if(is_array($mIdArr_data) && count($mIdArr_data) > 0){
		$mIdArr_data = array_map('array_values', $mIdArr_data);

		for($i = 0; $i < count($mIdArr_data); $i ++) {
			$m_id = $mIdArr_data[$i][0];
			$m_mobileKey = $mIdArr_data[$i][1];
			$m_alarmFlag = $mIdArr_data[$i][2];
			$m_vibFlag = $mIdArr_data[$i][3];
			saveAlarmList($m_id, $gsm_title, $gsm_msg, $gsm_uid, $code);

			$m_vibFlagStr = ($m_vibFlag > 0) ? "Y" : "N";

			if($m_alarmFlag > 0) {
				if($os == "android") {
					$apiKey = $GINIT['GSM_API_KEY'];
					$headers = array(
						'Content-Type:application/json',
						'Authorization:key=' . $apiKey
					);

					$arr   = array();
					$arr['data'] = array();
					$arr['data']['collapse_key'] = time();
					$arr['data']['subject'] = iconv("utf-8", "utf-8", $gsm_title);
					$arr['data']['m_no'] = $gsm_uid;
					$arr['data']['code'] = $code;
					$arr['data']['vib'] = $m_vibFlagStr;
					$arr['data']['msg'] = iconv("utf-8", "utf-8", $gsm_msg);
					//$arr['data']['type'] = "CON";

					$arr['registration_ids'] = array();
					$arr['registration_ids'][0] = $m_mobileKey;
					$arr['sender_id'] = $GINIT['GSM_API_ID'];

					//echo json_encode($arr) . "\n";
					//if(count($mobilekey_data) == 0) return;

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,    'https://fcm.googleapis.com/fcm/send');
					curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
					curl_setopt($ch, CURLOPT_POST,    true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));
					$response = curl_exec($ch);
					curl_close($ch);
					//echo $response;
					_cronLogSave($response, $m_id);

				} elseif($os == "androidCom") {
					$apiKey = $GINIT['GSM_API_KEY2'];
					$headers = array(
						'Content-Type:application/json',
						'Authorization:key=' . $apiKey
					);

					$arr   = array();
					$arr['data'] = array();
					$arr['data']['collapse_key'] = time();
					$arr['data']['subject'] = iconv("utf-8", "utf-8", $gsm_title);
					$arr['data']['m_no'] = $gsm_uid;
					$arr['data']['code'] = $code;
					$arr['data']['vib'] = $m_vibFlagStr;
					$arr['data']['msg'] = iconv("utf-8", "utf-8", $gsm_msg);
					//$arr['data']['type'] = "CON";

					$arr['registration_ids'] = array();
					$arr['registration_ids'][0] = $m_mobileKey;
					$arr['sender_id'] = $GINIT['GSM_API_ID2'];

					//echo json_encode($arr) . "\n";
					//if(count($mobilekey_data) == 0) return;

					$ch = curl_init();
					curl_setopt($ch, CURLOPT_URL,    'https://fcm.googleapis.com/fcm/send');
					curl_setopt($ch, CURLOPT_HTTPHEADER,  $headers);
					curl_setopt($ch, CURLOPT_POST,    true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arr));
					$response = curl_exec($ch);
					curl_close($ch);
					if($_SERVER['REMOTE_ADDR'] == "121.130.50.175") {
					echo $response;
					}
					_cronLogSave($response, $m_id);

				} else {
					_cronLogSave($os, $code, $gsm_msg, $gsm_title, $gsm_uid, $ids);
				}

				$arr = json_decode($response);
				//print_r($arr);
				if($arr->failure == "1") {
					$updateResult = $db->execute("update Mbr_Members set MB_FAILKEY=1 where MB_ID=?", [$m_id]);
					//_cronLogSave("실패 ID : " . $m_id, $code, $gsm_msg, $gsm_title, $gsm_uid, $ids);
				}
				if($arr->success == "1") {
					//_cronLogSave("성공 ID : " . $m_id, $code, $gsm_msg, $gsm_title, $gsm_uid, $ids);
				}
			}
		}
	}
}
/*
function _cronLogSave($f1 = '', $f2 = '', $f3 = '', $f4 = '', $f5 = '', $f6 = '', $f7 = '', $f8 = '') {
	global $G_DB;
	$db = new DBConn($G_DB);
	$sql_param = [$f1, $f2, $f3, $f4, $f5, $f6, $f7, $f8];
	$flag = false;
	if($f1 != "") {
		$flag = true;
	}
	if($f2 != "") {
		$flag = true;
	}
	if($f3 != "") {
		$flag = true;
	}
	if($f4 != "") {
		$flag = true;
	}
	if($f5 != "") {
		$flag = true;
	}
	if($f6 != "") {
		$flag = true;
	}
	if($f7 != "") {
		$flag = true;
	}
	if($f8 != "") {
		$flag = true;
	}
	if($flag) {
		$insertQuery = "insert into _cronLog set ";
		$insertQuery .= " cl_regDate=now()";
		$insertQuery .= ",cl_1=?";
		$insertQuery .= ",cl_2=?";
		$insertQuery .= ",cl_3=?";
		$insertQuery .= ",cl_4=?";
		$insertQuery .= ",cl_5=?";
		$insertQuery .= ",cl_6=?";
		$insertQuery .= ",cl_7=?";
		$insertQuery .= ",cl_8=?";
		$db->execute($insertQuery, $sql_param);
	}
}*/
function makeXML($list, $useKey, $tag) {
	if($useKey == "") return false; // 사용할 필드명을 # 으로 구분한다.
	if($tag == "") return false;
	$arrKey = explode("#", $useKey);
	$cntKey = count($arrKey);
	$xml = "";
	$xml .= "<{$tag}>";
	for($i = 0; $i < $cntKey; $i ++) {
		$key = $arrKey[$i];
		$value = $list[$arrKey[$i]];
		if(!is_numeric($value)) { // 숫자가 아니라면
			$xml .= "<{$key}><![CDATA[{$value}]]></{$key}>";
		} else {
			$xml .= "<{$key}>{$value}</{$key}>";
		}
	}
	$xml .= "</{$tag}>";
	return $xml;
}

//#################################################################################################
// 제목 : DB 관련 함수
// 내용 :
// 날짜 : 2008년 7월 29일 화요일 오후 6:14:55
// 작성 : 서정호
//#################################################################################################

function getMemberRS($db, $m_id) {
	if(!$m_id) return false;
	$row = $db->fetch("SELECT * FROM Mbr_Members WHERE MB_ID = ?", [$m_id]);
	return $row;
}
// DB에서 기본 정보를 가져온다. (ba_no=1)
function getBasicInfo($db) {
	global $_ba_;
	if($_ba_) return $_ba_;
	$row = $db->fetch("select * from AU_BASIC where ba_no='1'", []);
	return $row;
}

// 값 하나 가져오는 함수 (DB값은 기본 값으로 가져온다.
function getValues($db, $sql, $ret, $params = []) {
	$row = $db->fetch($sql, $params);
	if ($row && count($row) > 0) {
		return array_values($row)[0];
	} else {
		return $ret;
	}
}
// 쿼리를 실행하여 첫번째 데이터를 추출하여 배열로 리턴한다.
function makeArray($db, $sql, $params = []) {
	$arrData = array();
	$rows = $db->fetchAll($sql, $params);
	if(!$rows) return $arrData;
	foreach($rows as $row) {
		if (count($row) == 1) {
			$arrData[] = array_values($row)[0];
		} else {
			$arrData[] = $row;
		}
	}
	return $arrData;
}

//#################################################################################################
// 제목 : 이동관련함수
// 내용 :
// 날짜 : 2008년 7월 29일 화요일 오후 6:17:02
// 작성 : 서정호
//#################################################################################################

function getTargetLink($url,$target,$alert) {
	echo '<meta http-equiv=\'content-type\' content=\'text/html; charset=utf-8\'>';
	echo '<script>';
	if ( $alert ) echo 'alert(\''.$alert.'          \');';
	if ( $url   ) echo $target.'location.href=\''.$url.'\';';
	echo '</script>';
	exit;
}
function getLink($url,$alert) {
	echo '<meta http-equiv=\'content-type\' content=\'text/html; charset=utf-8\'>';
	echo '<script>';
	if ( $alert ) echo 'alert(\''.$alert.'          \');';
	if ( $url   ) echo 'location.href=\''.$url.'\';';
	echo '</script>';
	exit;
}
function getLinkReload($url,$alert) {
	echo '<meta http-equiv=\'content-type\' content=\'text/html; charset=utf-8\'>';
	echo '<script>';
	if ( $alert ) echo 'alert(\''.$alert.'          \');';
	if ( $url   ) echo 'location.replace(\''.$url.'\');';
	echo '</script>';
	exit;
}
function AlertBack($alert) {
	echo '<meta http-equiv=\'content-type\' content=\'text/html; charset=utf-8\'>';
	echo '<script>';
	if ( $alert ) echo 'alert(\''.$alert.'          \');';
	echo 'history.back();';
	echo '</script>';
	exit;
}
function AlertClose($alert) {
	echo '<meta http-equiv=\'content-type\' content=\'text/html; charset=utf-8\'>';
	echo '<script>';
	if ( $alert ) echo 'alert(\''.$alert.'          \');';
	echo 'self.close();';
	echo '</script>';
	exit;
}
function AlertStop($alert) {
	echo '<meta http-equiv=\'content-type\' content=\'text/html; charset=utf-8\'>';
	echo '<script>';
	if ( $alert ) echo 'alert(\''.$alert.'          \');';
	echo '</script>';
	exit;
}
function AlertCloseReload($alert) {
	echo '<meta http-equiv=\'content-type\' content=\'text/html; charset=utf-8\'>';
	echo '<script>';
	if ( $alert ) echo 'alert(\''.$alert.'          \');';
	echo "opener.document.location.reload();\n";
	echo 'self.close();';
	echo '</script>';
	exit;
}
function AlertCloseReloadParent($alert) {
	echo '<meta http-equiv=\'content-type\' content=\'text/html; charset=utf-8\'>';
	echo '<script>';
	if ( $alert ) echo 'alert(\''.$alert.'          \');';
	echo "parent.document.location.reload();\n";
	echo 'self.close();';
	echo '</script>';
	exit;
}

function AlertBackReload($alert) {
    echo '<meta http-equiv="content-type" content="text/html; charset=utf-8">';
    echo '<script>';
    if ($alert) echo 'alert("'.$alert.'");';
    echo 'location.replace(document.referrer);'; // 이전 페이지를 새로 로드
    echo '</script>';
    exit;
}

function _mtp() {
	$a = microtime();
	$arr = explode(" ", $a);
	return $arr[0] + $arr[1];
}

// 배열을 검색한다. 1번 필드를 검색하고 $key 필드의 값을 리턴. 값이 없을 경우 $return 값을 리턴
function SearchArray($arrayValue, $value, $key, $return) {
	$arraySize = count($arrayValue);
	
	for($i = 0; $i < $arraySize; $i ++) {
		if($arrayValue[$i][0] == $value) return $arrayValue[$i][$key];
	}

	return $return;
}
// 배열을 검색한다. $pos번 필드를 검색하고 $key 필드의 값을 리턴. 값이 없을 경우 $return 값을 리턴
function SearchArrayPos($arrayValue, $pos, $value, $key, $return) {
	$arraySize = count($arrayValue);

	for($i = 0; $i < $arraySize; $i ++) {
		if($arrayValue[$i][$pos] == $value) return $arrayValue[$i][$key];
	}

	return $return;
}

function postTrimAll($str) {
	$arr = explode("#", $str);
	for($i = 0; $i < count($str); $i ++) {
		$_POST[$arr[$i]] = trim($_POST[$arr[$i]]);
	}
}

function str_cut($msg,$cut_size) {
	return strcut_utf8($msg, $cut_size);
}
function strcut_utf8($str, $len, $checkmb=false, $tail='...') {
  preg_match_all('/[\xEA-\xED][\x80-\xFF]{2}|./', $str, $match);
  $m    = $match[0];
  $slen = strlen($str);  // length of source string
  $tlen = strlen($tail); // length of tail string
  $mlen = count($m);    // length of matched characters

  if ($slen <= $len) return $str;
  if (!$checkmb && $mlen <= $len) return $str;

  $ret  = array();
  $count = 0;

  for ($i=0; $i < $len; $i++) {
	$count += ($checkmb && strlen($m[$i]) > 1)?2:1;
	if ($count + $tlen > $len) break;
	$ret[] = $m[$i];
  }
  return join('', $ret).$tail;
}


##### 지정한 길이 이상의 문자열을 자르는 함수.
function str_cut_notDot($msg,$cut_size) {
	return strcut_utf8($msg, $cut_size, false, '');
}

// 업로드용 폴더가 없을 때 권한 777짜리 폴더를 만든다.
function makeUploadFolder($folder) {
	if(!file_exists($folder)) {

		// 하위폴더를 체크한다.
		$arrFolder = explode("/", $folder);
		array_pop($arrFolder);
		$folder2 = implode("/", $arrFolder);
		if(!file_exists($folder)) {
			makeUploadFolder($folder2);
		}

		@mkdir($folder);
		@chmod($folder, 0777);
	}
}

function thumnail($file, $save_filename, $max_width, $max_height) {
	   $img_info = getImageSize($file);
	   if($img_info[2] == 1)
	   {
			  $src_img = ImageCreateFromGif($file);
			  }elseif($img_info[2] == 2){
			  $src_img = ImageCreateFromJPEG($file);
			  }elseif($img_info[2] == 3){
			  $src_img = ImageCreateFromPNG($file);
			  }else{
			  return 0;
	   }
	   $img_width = $img_info[0];
	   $img_height = $img_info[1];

	   if($img_width > $max_width || $img_height > $max_height)
	   {
			  if($img_width == $img_height)
			  {
					 $dst_width = $max_width;
					 $dst_height = $max_height;
			  }elseif($img_width > $img_height){
					 $dst_width = $max_width;
					 $dst_height = ceil(($max_width / $img_width) * $img_height);
			  }else{
					 $dst_height = $max_height;
					 $dst_width = ceil(($max_height / $img_height) * $img_width);
			  }
	   }else{
			  $dst_width = $img_width;
			  $dst_height = $img_height;
	   }
//       if($dst_width < $max_width) $srcx = ceil(($max_width - $dst_width)/2); else $srcx = 0;
  //     if($dst_height < $max_height) $srcy = ceil(($max_height - $dst_height)/2); else $srcy = 0;

	   if($img_info[2] == 1)
	   {
			  $dst_img = imagecreate($dst_width, $dst_height);
	   }else{
			  $dst_img = imagecreatetruecolor($dst_width, $dst_height);
	   }
	   $srcx = 0; 
	   $srcy = 0;
	   $bgc = ImageColorAllocate($dst_img, 255, 255, 255);
	   ImageFilledRectangle($dst_img, 0, 0, $dst_width, $dst_height, $bgc);
	   ImageCopyResampled($dst_img, $src_img, $srcx, $srcy, 0, 0, $dst_width, $dst_height, ImageSX($src_img),ImageSY($src_img));

	   if($img_info[2] == 1)
	   {
			  ImageInterlace($dst_img);
			  ImagePNG($dst_img, $save_filename);
//              ImageGIF($dst_img, $save_filename); 지원안함.
	   }elseif($img_info[2] == 2){
			  ImageInterlace($dst_img);
			  ImageJPEG($dst_img, $save_filename);
	   }elseif($img_info[2] == 3){
			  ImagePNG($dst_img, $save_filename);
	   }
	   ImageDestroy($dst_img);
	   ImageDestroy($src_img);
}

function cropImageThum($nw, $nh, $sourceFile, $save_filename) {
	global $_SERVER;
	$source = $sourceFile; // 원본 그림 디렉토리 설정.
	if(!is_file($source)) return false;
	//echo $source;
	$size = getimagesize($source);
	$w = $size[0]; // 실제 넓이
	$h = $size[1]; // 실제 높이

	$img_info = getImageSize($source);

	switch($img_info[2]) {
	case 1:
		$simg = imagecreatefromgif($source);
		break;
	case 2:
		$simg = imagecreatefromjpeg($source);
		break;
	case 3:
		$simg = imagecreatefrompng($source);
		break;
	}

	$dimg = imagecreatetruecolor($nw, $nh); // 이미지 크기 생성

	$mw = $w/$nw; // 넓이 비율
	$mh = $h/$nh; // 높이 비율

	// 무조건 고정비율로 처리
	if($w > $nw) $rW = ($w - $nw) / 2;
	else $rW = $w;
	if($h > $nh) $rH = ($h - $nh) / 2;
	else $rH = $h;

// 비율이 큰 것을 기준으로 잡는다.
// 계산
// $w = 400;
// $h = 300;
// $nw = 200;
// $nh = 80;
// $mw = 2;
// $mh = 3.75;
// $vX = 0;
// $vW = 200;
// $vY = 80 - (300 / 2);
// $vH = 300 / 2
//
	if($mw < $mh) {
		$vW = $nw;
		$vX = 0;
		$vH = $h / $mw;
		$vY = 0 - (($vH - $nh) / 2);

	} else {
		$vW = (int) round($w / $mh);
		//$vX = 0 - (($vW - $nw) / 2);
		$vX = (int) round(0 - (($vW - $nw) / 2));
		$vH = (int) round($nh);
		$vY = 0;
	}
	// imagecopy ( resource $dst_im , resource $src_im , int $dst_x , int $dst_y , int $src_x , int $src_y , int $src_w , int $src_h )
	// imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
	imagecopyresampled($dimg,$simg,$vX,$vY,0,0,$vW,$vH,$w,$h);

	if($img_info[2] == 1) {
		ImageInterlace($dimg);
		ImagePNG($dimg, $save_filename);
	}elseif($img_info[2] == 2){
		ImageInterlace($dimg);
		ImageJPEG($dimg, $save_filename);
	}elseif($img_info[2] == 3){
		ImagePNG($dimg, $save_filename);
	}
	ImageDestroy($dimg);
	ImageDestroy($simg);
}

// $srcFile : src 파일명
// $targetFile : target 파일명
// $conn_id : FTP_ConnectProc 에서 생성한 변수
$fullTFolderSave = ""; // 같은 폴더에 여러번 접근을 막기위한 변수
function FileMoveEx($srcFile, $targetFile) {
	global $_SERVER, $fullTFolderSave;

	$fullSFile = $_SERVER['DOCUMENT_ROOT']."/data/".$srcFile;
	$fullTFile = $_SERVER['DOCUMENT_ROOT']."/data/".$targetFile;

	$arrFolder = explode("/", $fullTFile);
	array_pop($arrFolder);
	$fullTFolder = implode("/", $arrFolder);

	if(file_exists($fullSFile)) {
		// 파일이 존재할 때 폴더를 생성한다.
		if($fullTFolderSave != $fullTFolder) {
			if(!file_exists($fullTFile)) {
				makeUploadFolder($fullTFolder);
			}
			$fullTFolderSave = $fullTFolder;
		}
		@rename($fullSFile, $fullTFile);
	}
}

//#################################################################################################
// 제목 : 문자 전송 수정사항
// 내용 : 기존 소켓을 이용한 방식이 아닌 DB를 이용한 방식으로 변경.
// 날짜 : 2008년 3월 20일 목요일 오전 11:15:53
// 작성 : 서정호
//#################################################################################################
function sangsaSms($hp, $callback, $memo) {
	global $GINIT;

	$hp = str_replace("-", "", $hp);
	$callback = str_replace("-", "", $callback);

	$headers = array(
	'Accept: */*',
	'Content-type: application/x-www-form-urlencoded; charset=EUC-KR',
	'car2b-api-key: ' . $GINIT['car2bApiKey']
	);

	$smsContent = tel_Format($callback) . "\n{$memo}";
	//if(empty($callback)){ // 회신번호를 입력할 수 있게 조건문 추가 25.08.21 안슬지
	$callback = $GINIT['SMSTEL'];
	//}

	$user_agent = "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; .NET CLR 1.0.3705; .NET CLR 1.1.4322; Media Center PC 4.0)";

	$url = $GINIT['car2bApiSmsUrl'];

	$smsSubject = "";
	$sendDateTime = ""; // 예약일시

	// 인코딩에 따라 처리
	// $smsSubject = iconv("EUC-KR", "UTF-8", $smsSubject);
	// $smsContent = iconv("EUC-KR", "UTF-8", $smsContent);

	$data = array();
	$data['hp'] = $hp;
	$data['callback'] = $callback;
	$data['smsSubject'] = $smsSubject;
	$data['smsContent'] = $smsContent;
	$data['sendDateTime'] = $sendDateTime;

	$ch = curl_init();
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($ch, CURLOPT_USERAGENT, $user_agent);
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_REFERER, "");
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$tempStr = curl_exec($ch);
	curl_close($ch);
	return true;
}
?>