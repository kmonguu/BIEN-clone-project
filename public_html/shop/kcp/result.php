<?
    /* ============================================================================== */
    /* =   PAGE : 결과 처리 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   pp_cli_hub.php 파일에서 처리된 결과값을 출력하는 페이지입니다.           = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2016  NHN KCP Inc.   All Rights Reserverd.                = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   지불 결과                                                                = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd          = $_POST[ "site_cd"        ];      // 사이트코드
    $req_tx           = $_POST[ "req_tx"         ];      // 요청 구분(승인/취소)
    $use_pay_method   = $_POST[ "use_pay_method" ];      // 사용 결제 수단
    $bSucc            = $_POST[ "bSucc"          ];      // 업체 DB 정상처리 완료 여부
    /* = -------------------------------------------------------------------------- = */
    $res_cd           = $_POST[ "res_cd"         ];      // 결과코드
    $res_msg          = $_POST[ "res_msg"        ];      // 결과메시지
    $res_msg_bsucc    = "";
    /* = -------------------------------------------------------------------------- = */
    $amount           = $_POST[ "amount"         ];      // 금액
    $ordr_idxx        = $_POST[ "ordr_idxx"      ];      // 주문번호
    $tno              = $_POST[ "tno"            ];      // KCP 거래번호
    $good_mny         = $_POST[ "good_mny"       ];      // 결제금액
    $good_name        = $_POST[ "good_name"      ];      // 상품명
    $buyr_name        = $_POST[ "buyr_name"      ];      // 구매자명
    $buyr_tel1        = $_POST[ "buyr_tel1"      ];      // 구매자 전화번호
    $buyr_tel2        = $_POST[ "buyr_tel2"      ];      // 구매자 휴대폰번호
    $buyr_mail        = $_POST[ "buyr_mail"      ];      // 구매자 E-Mail
    /* = -------------------------------------------------------------------------- = */
    // 공통
    $pnt_issue        = $_POST[ "pnt_issue"      ];      // 포인트 서비스사
    $app_time         = $_POST[ "app_time"       ];      // 승인시간 (공통)
    /* = -------------------------------------------------------------------------- = */
    // 신용카드
    $card_cd          = $_POST[ "card_cd"        ];      // 카드코드
    $card_name        = $_POST[ "card_name"      ];      // 카드명
    $noinf            = $_POST[ "noinf"          ];      // 무이자 여부
    $quota            = $_POST[ "quota"          ];      // 할부개월
    $app_no           = $_POST[ "app_no"         ];      // 승인번호
    /* = -------------------------------------------------------------------------- = */
    // 계좌이체
    $bank_name        = $_POST[ "bank_name"      ];      // 은행명
    $bank_code        = $_POST[ "bank_code"      ];      // 은행코드
    /* = -------------------------------------------------------------------------- = */
    // 가상계좌
    $bankname         = $_POST[ "bankname"       ];      // 입금할 은행
    $depositor        = $_POST[ "depositor"      ];      // 입금할 계좌 예금주
    $account          = $_POST[ "account"        ];      // 입금할 계좌 번호
    $va_date          = $_POST[ "va_date"        ];      // 가상계좌 입금마감시간
    /* = -------------------------------------------------------------------------- = */
    // 포인트
    $add_pnt          = $_POST[ "add_pnt"        ];      // 발생 포인트
    $use_pnt          = $_POST[ "use_pnt"        ];      // 사용가능 포인트
    $rsv_pnt          = $_POST[ "rsv_pnt"        ];      // 총 누적 포인트
    $pnt_app_time     = $_POST[ "pnt_app_time"   ];      // 승인시간
    $pnt_app_no       = $_POST[ "pnt_app_no"     ];      // 승인번호
    $pnt_amount       = $_POST[ "pnt_amount"     ];      // 적립금액 or 사용금액
    /* = -------------------------------------------------------------------------- = */
    //상품권
    $tk_van_code      = $_POST[ "tk_van_code"    ];      // 발급사 코드
    $tk_app_no        = $_POST[ "tk_app_no"      ];      // 승인 번호
    /* = -------------------------------------------------------------------------- = */
    //휴대폰
    $commid           = $_POST[ "commid"         ];      // 통신사 코드
    $mobile_no        = $_POST[ "mobile_no"      ];      // 휴대폰 번호
    /* = -------------------------------------------------------------------------- = */
    // 현금영수증
    $cash_yn          = $_POST[ "cash_yn"        ];      //현금영수증 등록 여부
    $cash_authno      = $_POST[ "cash_authno"    ];      //현금영수증 승인 번호
    $cash_tr_code     = $_POST[ "cash_tr_code"   ];      //현금영수증 발행 구분
    $cash_id_info     = $_POST[ "cash_id_info"   ];      //현금영수증 등록 번호
    /* = -------------------------------------------------------------------------- = */

    $req_tx_name = "";

    if( $req_tx == "pay" )
    {
        $req_tx_name = "지불";
    }
    else if( $req_tx == "mod" )
    {
        $req_tx_name = "매입/취소";
    }

    /* ============================================================================== */
    /* =   가맹점 측 DB 처리 실패시 상세 결과 메시지 설정                           = */
    /* = -------------------------------------------------------------------------- = */

    if($req_tx == "pay")
    {
        //업체 DB 처리 실패
        if($bSucc == "false")
        {
            if ($res_cd == "0000")
            {
                $res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였습니다. <br> 업체로 문의하여 확인하시기 바랍니다.";
            }
            else
            {
                $res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였으나, <br> <b>취소가 실패 되었습니다.</b><br> 업체로 문의하여 확인하시기 바랍니다.";
            }
        }
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   가맹점 측 DB 처리 실패시 상세 결과 메시지 설정 끝                        = */
    /* ============================================================================== */


	$res_msg = iconv("cp949", "utf8", $res_msg);
    $reg_desc = iconv("cp949", "utf8", $reg_desc);
    $good_name = iconv("cp949", "utf8", $good_name);
    $buyr_name = iconv("cp949", "utf8", $buyr_name);
	$card_name = iconv("cp949", "utf8", $card_name);

?>
    
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <title>*** NHN KCP [AX-HUB Version] ***</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link href="css/style.css" rel="stylesheet" type="text/css" id="cssLink"/>
    <script type="text/javascript">
        /* 신용카드 영수증 */ 
        /* 실결제시 : "https://admin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" */
        /* 테스트시 : "https://testadmin8.kcp.co.kr/assist/bill.BillAction.do?cmd=card_bill&tno=" */
         function receiptView( tno, ordr_idxx, amount )
        {
            receiptWin = "https://admin8.kcp.co.kr/assist/bill.BillActionNew.do?cmd=card_bill&tno=";
            receiptWin += tno + "&";
            receiptWin += "order_no=" + ordr_idxx + "&"; 
            receiptWin += "trade_mony=" + amount ;

            window.open(receiptWin, "", "width=455, height=815"); 
        }
         
        /* 현금 영수증 */ 
        /* 실결제시 : "https://admin.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp" */ 
        /* 테스트시 : "https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp" */
        function receiptView2( site_cd, order_id, bill_yn, auth_no )
        {
            receiptWin2 = "https://testadmin8.kcp.co.kr/Modules/Service/Cash/Cash_Bill_Common_View.jsp";
            receiptWin2 += "?"; 
            receiptWin2 += "term_id=PGNW" + site_cd + "&";
            receiptWin2 += "orderid=" + order_id + "&";
            receiptWin2 += "bill_yn=" + bill_yn + "&";
            receiptWin2 += "authno=" + auth_no ;

            window.open(receiptWin2, "", "width=370, height=625");
        }
        /* 가상 계좌 모의입금 페이지 호출 */
        /* 테스트시에만 사용가능 */
        /* 실결제시 해당 스크립트 주석처리 */
        function receiptView3()
        {
            receiptWin3 = "http://devadmin.kcp.co.kr/Modules/Noti/TEST_Vcnt_Noti.jsp";
            window.open(receiptWin3, "", "width=520, height=300");
        }
    </script>
</head>

<body>


<?if($res_cd == "0000") {?>
	
	<script>
        function goResult()
        {
            var openwin = window.open( 'proc_win.html', 'proc_win', '' );
            document.pay_info.submit();
            openwin.close();
        }

		window.onload = function(){
			goResult();
		}
    </script>

	<form name="pay_info" method="post" action="../settleresult.php">
		
		    <input type="hidden" name="on_uid" value="<?=$_POST["on_uid"]?>" />

         <input type="hidden" name="site_cd"           value="<?=$g_conf_site_cd ?>">     <!-- 사이트코드 -->
        <input type="hidden" name="req_tx"            value="<?=$req_tx         ?>">     <!-- 요청 구분 -->
        <input type="hidden" name="use_pay_method"    value="<?=$use_pay_method ?>">     <!-- 사용한 결제 수단 -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc          ?>">     <!-- 쇼핑몰 DB 처리 성공 여부 -->

        <input type="hidden" name="res_cd"            value="<?=$res_cd         ?>">     <!-- 결과 코드 -->
        <input type="hidden" name="res_msg"           value="<?=$res_msg        ?>">     <!-- 결과 메세지 -->
        <input type="hidden" name="res_en_msg"        value="<?=$res_en_msg      ?>">     <!-- 결과 영문 메세지 -->
        <input type="hidden" name="ordr_idxx"         value="<?=$ordr_idxx      ?>">     <!-- 주문번호 -->
        <input type="hidden" name="tno"               value="<?=$tno            ?>">     <!-- KCP 거래번호 -->
        <input type="hidden" name="good_mny"          value="<?=$good_mny       ?>">     <!-- 결제금액 -->
        <input type="hidden" name="good_name"         value="<?=$good_name      ?>">     <!-- 상품명 -->
        <input type="hidden" name="buyr_name"         value="<?=$buyr_name      ?>">     <!-- 주문자명 -->
        <input type="hidden" name="buyr_tel1"         value="<?=$buyr_tel1      ?>">     <!-- 주문자 전화번호 -->
        <input type="hidden" name="buyr_tel2"         value="<?=$buyr_tel2      ?>">     <!-- 주문자 휴대폰번호 -->
        <input type="hidden" name="buyr_mail"         value="<?=$buyr_mail      ?>">     <!-- 주문자 E-mail -->

        <input type="hidden" name="app_time"          value="<?=$app_time       ?>">     <!-- 승인시간 -->
        <!-- 신용카드 정보 -->
        <input type="hidden" name="card_cd"           value="<?=$card_cd        ?>">     <!-- 카드코드 -->
        <input type="hidden" name="card_name"         value="<?=$card_name      ?>">     <!-- 카드명 -->
        <input type="hidden" name="app_no"            value="<?=$app_no         ?>">     <!-- 승인번호 -->
        <input type="hidden" name="noinf"             value="<?=$noinf          ?>">     <!-- 무이자여부 -->
        <input type="hidden" name="quota"             value="<?=$quota          ?>">     <!-- 할부개월 -->
        <input type="hidden" name="partcanc_yn"       value="<?=$partcanc_yn    ?>">     <!-- 부분취소가능유무 -->
        <input type="hidden" name="card_bin_type_01"  value="<?=$card_bin_type_01 ?>">   <!-- 카드구분1 -->
        <input type="hidden" name="card_bin_type_02"  value="<?=$card_bin_type_02 ?>">   <!-- 카드구분2 -->
        <!-- 계좌이체 정보 -->
        <input type="hidden" name="bank_code"         value="<?=$bank_code      ?>">     <!-- 은행코드 -->
        <input type="hidden" name="bank_name"         value="<?=$bank_name      ?>">     <!-- 은행명 -->
        <!-- 가상계좌 정보 -->
        <input type="hidden" name="bankname"          value="<?=$bankname       ?>">     <!-- 입금할 은행 -->
        <input type="hidden" name="depositor"         value="<?=$depositor      ?>">     <!-- 입금할 계좌 예금주 -->
        <input type="hidden" name="account"           value="<?=$account        ?>">     <!-- 입금할 계좌 번호 -->
        <input type="hidden" name="va_date"           value="<?=$va_date        ?>">     <!-- 가상계좌 입금마감시간 -->
        <!-- 포인트 정보 -->
        <input type="hidden" name="pnt_issue"         value="<?=$pnt_issue      ?>">     <!-- 포인트 서비스사 -->
        <input type="hidden" name="pt_idno"		      value="<?=$pt_idno        ?>">     <!-- 결제 및 인증 아이디 -->
        <input type="hidden" name="pnt_amount"        value="<?=$pnt_amount     ?>">     <!-- 적립금액 or 사용금액 -->
        <input type="hidden" name="pnt_app_time"      value="<?=$pnt_app_time   ?>">     <!-- 승인시간 -->
        <input type="hidden" name="pnt_app_no"        value="<?=$pnt_app_no     ?>">     <!-- 승인번호 -->
        <input type="hidden" name="add_pnt"           value="<?=$add_pnt        ?>">     <!-- 발생 포인트 -->
        <input type="hidden" name="use_pnt"           value="<?=$use_pnt        ?>">     <!-- 사용가능 포인트 -->
        <input type="hidden" name="rsv_pnt"           value="<?=$rsv_pnt        ?>">     <!-- 총 누적 포인트 -->

        <!-- 휴대폰 정보 -->
        <input type="hidden" name="commid"            value="<?=$commid         ?>">     <!-- 통신사 코드 -->
        <input type="hidden" name="mobile_no"         value="<?=$mobile_no      ?>">     <!-- 휴대폰 번호 -->
        <!-- 상품권 정보 -->
        <input type="hidden" name="tk_van_code"       value="<?=$tk_van_code    ?>">     <!-- 발급사 코드 -->
        <input type="hidden" name="tk_app_no"         value="<?=$tk_app_no      ?>">     <!-- 승인 번호 -->
        <!-- 현금영수증 정보 -->
        <input type="hidden" name="cash_yn"           value="<?=$cash_yn        ?>">     <!-- 현금 영수증 등록 여부 -->
        <input type="hidden" name="cash_authno"       value="<?=$cash_authno    ?>">     <!-- 현금 영수증 승인 번호 -->
        <input type="hidden" name="cash_tr_code"      value="<?=$cash_tr_code   ?>">     <!-- 현금 영수증 발행 구분 -->
        <input type="hidden" name="cash_id_info"      value="<?=$cash_id_info   ?>">     <!-- 현금 영수증 등록 번호 -->

        <!-- 에스크로 정보 -->
        <input type="hidden" name="escw_yn"           value="<?= $escw_yn       ?>">     <!-- 에스크로 유무 -->
        <input type="hidden" name="deli_term"         value="<?= $deli_term     ?>">     <!-- 배송 소요일 -->
        <input type="hidden" name="bask_cntx"         value="<?= $bask_cntx     ?>">     <!-- 장바구니 상품 개수 -->
        <input type="hidden" name="good_info"         value="<?= $good_info     ?>">     <!-- 장바구니 상품 상세 정보 -->
        <input type="hidden" name="rcvr_name"         value="<?= $rcvr_name     ?>">     <!-- 수취인 이름 -->
        <input type="hidden" name="rcvr_tel1"         value="<?= $rcvr_tel1     ?>">     <!-- 수취인 전화번호 -->
        <input type="hidden" name="rcvr_tel2"         value="<?= $rcvr_tel2     ?>">     <!-- 수취인 휴대폰번호 -->
        <input type="hidden" name="rcvr_mail"         value="<?= $rcvr_mail     ?>">     <!-- 수취인 E-Mail -->
        <input type="hidden" name="rcvr_zipx"         value="<?= $rcvr_zipx     ?>">     <!-- 수취인 우편번호 -->
        <input type="hidden" name="rcvr_add1"         value="<?= $rcvr_add1     ?>">     <!-- 수취인 주소 -->
        <input type="hidden" name="rcvr_add2"         value="<?= $rcvr_add2     ?>">     <!-- 수취인 상세주소 -->
    </form>


<?} else {?>



    <form name="cancel" method="post">
    <div id="sample_wrap">
        <h1>[결과출력]<span> 이 페이지는 결제 결과를 출력하는 페이지입니다.</span></h1>
    <div class="sample">
       
<?
    /* ============================================================================== */
    /* =   결제 결과 코드 및 메시지 출력(결과페이지에 반드시 출력해주시기 바랍니다.)= */
    /* = -------------------------------------------------------------------------- = */
    /* =   결제 정상 : res_cd값이 0000으로 설정됩니다.                              = */
    /* =   결제 실패 : res_cd값이 0000이외의 값으로 설정됩니다.                     = */
    /* = -------------------------------------------------------------------------- = */
?>
                    <h2>&sdot; 처리 결과</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                        <!-- 결과 코드 -->
                        <tr>
                          <th>결과 코드</th>
                          <td><?=$res_cd?></td>
                        </tr>
                              <!-- 결과 메시지 -->
                        <tr>
                          <th>결과 메세지</th>
                          <td><?=$res_msg?> <?=$reg_desc?></td>
                        </tr>
<?
    // 처리 페이지(pp_cli_hub.php)에서 가맹점 DB처리 작업이 실패한 경우 상세메시지를 출력합니다.
    if( !$res_msg_bsucc == "")
    {
?>
                         <tr>
                           <th>결과 상세 메세지</th>
                           <td><?=$res_msg_bsucc?></td>
                         </tr>
<?
    }
?>
                    </table>

<?
    /* = -------------------------------------------------------------------------- = */
    /* =   결제 결과 코드 및 메시지 출력 끝                                         = */
    /* ============================================================================== */

    /* ============================================================================== */
    /* =  01. 결제 결과 출력                                                        = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )                           // 거래 구분 : 승인
    {
        /* ============================================================================== */
        /* =  01-1. 업체 DB 처리 정상 (bSucc값이 false가 아닌 경우)                     = */
        /* = -------------------------------------------------------------------------- = */
        if ( $bSucc != "false" )                      // 업체 DB 처리 정상
        {
            /* ============================================================================== */
            /* =  01-1-1. 정상 결제시 결제 결과 출력 (res_cd값이 0000인 경우)               = */
            /* = -------------------------------------------------------------------------- = */
            if ( $res_cd == "0000" )                  // 정상 승인
            {
?>
                    <h2>&sdot; 주문 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                        <!-- 주문번호 -->
                        <tr>
                          <th>주문 번호</th>
                          <td><?=$ordr_idxx ?></td>
                        </tr>
                        <!-- KCP 거래번호 -->
                        <tr>
                          <th>KCP 거래번호</th>
                          <td><?=$tno ?></td>
                        </tr>
                        <!-- 결제금액 -->
                        <tr>
                          <th>결제 금액</th>
                          <td><?=$good_mny ?>원</td>
                        </tr>
                        <!-- 상품명(good_name) -->
                        <tr>
                          <th>상 품 명</th>
                          <td><?=$good_name ?></td>
                        </tr>
                        <!-- 주문자명 -->
                        <tr>
                          <th>주문자명</th>
                          <td><?=$buyr_name ?></td>
                        </tr>
                        <!-- 주문자 전화번호 -->
                        <tr>
                          <th>주문자 전화번호</th>
                          <td><?=$buyr_tel1 ?></td>
                        </tr>
                        <!-- 주문자 휴대폰번호 -->
                        <tr>
                          <th>주문자 휴대폰번호</th>
                          <td><?=$buyr_tel2 ?></td>
                        </tr>
                        <!-- 주문자 E-mail -->
                        <tr>
                          <th>주문자 E-mail</th>
                          <td><?=$buyr_mail ?></td>
                        </tr>
                    </table>
<?
                /* ============================================================================== */
                /* =  신용카드 결제결과 출력                                                    = */
                /* = -------------------------------------------------------------------------- = */
                if ( $use_pay_method == "100000000000" )       // 신용카드
                {
?>
                    <h2>&sdot; 신용카드 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                        <!-- 결제수단 : 신용카드 -->
                        <tr>
                          <th>결제 수단</th>
                          <td>신용 카드</td>
                        </tr>
                        <!-- 결제 카드 -->
                        <tr>
                          <th>결제 카드</th>
                          <td><?=$card_cd ?> / <?=$card_name ?></td>
                        </tr>
                        <!-- 승인시간 -->
                        <tr>
                          <th>승인 시간</th>
                          <td><?=$app_time ?></td>
                        </tr>
                        <!-- 승인번호 -->
                        <tr>
                          <th>승인 번호</th>
                          <td><?=$app_no ?></td>
                        </tr>
                        <!-- 할부개월 -->
                        <tr>
                          <th>할부 개월</th>
                          <td><?=$quota ?></td>
                        </tr>
                        <!-- 무이자 여부 -->
                        <tr>
                          <th>무이자 여부</th>
                          <td><?=$noinf ?></td>
                        </tr>
<?
                    /* ============================================================================== */
                    /* =  복합결제 (포인트 + 신용카드) 승인 결과 처리                                 = */
                    /* = -------------------------------------------------------------------------- = */
                    if ( $pnt_issue == "SCSK" || $pnt_issue == "SCWB" )
                    {
?>
                    </table>
                    <h2>&sdot; 포인트 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 포인트사 -->
                        <tr>
                          <th>포인트사</th>
                          <td><?=$pnt_issue ?></td>
                        </tr>
                    <!-- 포인트 승인 시간 -->
                        <tr>
                          <th>포인트 승인시간</th>
                          <td><?=$pnt_app_time ?></td>
                        </tr>
                    <!-- 포인트 승인번호 -->
                        <tr>
                          <th>포인트 승인번호</th>
                          <td><?=$pnt_app_no ?></td>
                        </tr>
                    <!-- 적립금액 or 사용금액 -->
                        <tr>
                          <th>적립금액 or 사용금액</th>
                          <td><?=$pnt_amount ?></td>
                        </tr>
                    <!-- 발생 포인트 -->
                        <tr>
                          <th>발생 포인트</th>
                          <td><?=$add_pnt ?></td>
                        </tr>
                    <!-- 사용가능 포인트 -->
                        <tr>
                          <th>사용가능 포인트</th>
                          <td><?=$use_pnt ?></td>
                        </tr>
                    <!-- 총 누적 포인트 -->
                        <tr>
                          <th>총 누적 포인트</th>
                          <td><?=$rsv_pnt ?></td>
                        </tr>
<?
                    }
                    /* ============================================================================== */
                    /* =  신용카드 영수증 출력                                                      = */
                    /* = -------------------------------------------------------------------------- = */
                    /*    실제 거래건에 대해서 영수증을 출력 할 수 있습니다.                        = */
                    /* = -------------------------------------------------------------------------- = */
?>
                    <tr>
                    <th>영수증 확인</th>
                        <td class="sub_content1"><a href="javascript:receiptView('<?=$tno?>','<?=$ordr_idxx?>','<?=$amount?>')"><img src="./img/btn_receipt.png" alt="영수증을 확인합니다." />
                    </td>
                </table>
<?
                }
                /* ============================================================================== */
                /* =   계좌이체 결제 결과 출력                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "010000000000" )       // 계좌이체
                {
?>
                    <h2>&sdot; 계좌이체 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 결제수단 : 계좌이체 -->
                        <tr>
                          <th>결제 수단</th>
                          <td>계좌이체</td>
                        </tr>
                    <!-- 이체 은행 -->
                        <tr>
                          <th>이체 은행</th>
                          <td><?=$bank_name ?></td>
                        </tr>
                    <!-- 이체 은행 코드 -->
                        <tr>
                          <th>이체 은행코드</th>
                          <td><?=$bank_code ?></td>
                        </tr>
                    <!-- 승인시간 -->
                        <tr>
                          <th>승인 시간</th>
                          <td><?=$app_time ?></td>
                        </tr>
                    </table>
<?
                }
                /* ============================================================================== */
                /* =   가상계좌 결제 결과 출력                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "001000000000" )       // 가상계좌
                {
?>
                    <h2>&sdot; 가상계좌 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 결제수단 : 가상계좌 -->
                        <tr>
                          <th>결제 수단</th>
                          <td>가상계좌</td>
                        </tr>
                    <!-- 입금은행 -->
                        <tr>
                          <th>입금 은행</th>
                          <td><?=$bankname ?></td>
                        </tr>
                    <!-- 입금계좌 예금주 -->
                        <tr>
                          <th>입금할 계좌 예금주</th>
                          <td><?=$depositor ?></td>
                        </tr>
                    <!-- 입금계좌 번호 -->
                        <tr>
                          <th>입금할 계좌 번호</th>
                          <td><?=$account ?></td>
                        </tr>
                    <!-- 가상계좌 입금마감시간 -->
                        <tr>
                          <th>가상계좌 입금마감시간</th>
                          <td><?=$va_date ?></td>
                        </tr>
                    <!-- 가상계좌 모의입금(테스트시) -->
                        <tr>
                          <th>가상계좌 모의입금</br>(테스트시 사용)</th>
                          <td class="sub_content1"><a href="javascript:receiptView3()"><img src="./img/btn_vcn.png" alt="모의입금 페이지로 이동합니다." />
                        </tr>
                    </table>
<?
                }
                /* ============================================================================== */
                /* =   포인트 결제 결과 출력                                                    = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000100000000" )         // 포인트
                {
?>
                    <h2>&sdot; 포인트 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 결제수단 : 포인트 -->
                        <tr>
                          <th>결제수단</th>
                          <td>포 인 트</td>
                        </tr>
                    <!-- 포인트사 -->
                        <tr>
                          <th>포인트사</th>
                          <td><?=$pnt_issue ?></td>
                        </tr>
                    <!-- 포인트 승인시간 -->
                        <tr>
                          <th>포인트 승인시간</th>
                          <td><?=$pnt_app_time ?></td>
                        </tr>
                    <!-- 포인트 승인번호 -->
                        <tr>
                          <th>포인트 승인번호</th>
                          <td><?=$pnt_app_no ?></td>
                        </tr>
                    <!-- 적립금액 or 사용금액 -->
                        <tr>
                          <th>적립금액 or 사용금액</th>
                          <td><?=$pnt_amount ?></td>
                        </tr>
                    <!-- 발생 포인트 -->
                        <tr>
                          <th>발생 포인트</th>
                          <td><?=$add_pnt ?></td>
                        </tr>
                    <!-- 사용가능 포인트 -->
                        <tr>
                          <th>사용가능 포인트</th>
                          <td><?=$use_pnt ?></td>
                        </tr>
                    <!-- 총 누적 포인트 -->
                        <tr>
                          <th>총 누적 포인트</th>
                          <td><?=$rsv_pnt ?></td>
                        </tr>
                </table>
<?
                }
                /* ============================================================================== */
                /* =   휴대폰 결제 결과 출력                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000010000000" )       // 휴대폰
                {
?>
                    <h2>&sdot; 휴대폰 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 결제수단 : 휴대폰 -->
                        <tr>
                          <th>결제 수단</th>
                          <td>휴 대 폰</td>
                        </tr>
                    <!-- 승인시간 -->
                        <tr>
                          <th>승인 시간</th>
                          <td><?=$app_time ?></td>
                        </tr>
                    <!-- 통신사코드 -->
                        <tr>
                          <th>통신사 코드</th>
                          <td><?=$commid ?></td>
                        </tr>
                    <!-- 승인시간 -->
                        <tr>
                          <th>휴대폰 번호</th>
                          <td><?=$mobile_no ?></td>
                        </tr>
                </table>
<?
                }
                /* ============================================================================== */
                /* =   상품권 결제 결과 출력                                                  = */
                /* = -------------------------------------------------------------------------- = */
                else if ( $use_pay_method == "000000001000" )       // 상품권
                {
?>
                    <h2>&sdot; 상품권 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                    <!-- 결제수단 : 상품권 -->
                        <tr>
                          <th>결제 수단</th>
                          <td>상 품 권</td>
                        </tr>
                    <!-- 발급사 코드 -->
                        <tr>
                          <th>발급사 코드</th>
                          <td><?=$tk_van_code ?></td>
                        </tr>
                    <!-- 승인시간 -->
                        <tr>
                          <th>승인 시간</th>
                          <td><?=$app_time ?></td>
                        </tr>
                    <!-- 승인번호 -->
                        <tr>
                          <th>승인 번호</th>
                          <td><?=$tk_app_no ?></td>
                        </tr>
                </table>
<?
                }
                /* ============================================================================== */
                /* =  현금영수증 정보 출력                                                      = */
                /* = -------------------------------------------------------------------------- = */
                if ( $cash_yn != "" )
                {

?>
                <!-- 현금영수증 정보 출력-->
                    <h2>&sdot; 현금영수증 정보</h2>
                    <table class="tbl" cellpadding="0" cellspacing="0">
                        <tr>
                          <th>현금영수증 등록여부</th>
                          <td><?=$cash_yn ?></td>
                        </tr>
<?
                    // 현금영수증이 등록된 경우 승인번호 값이 존재
                        if ($cash_authno != "")
                        {
?>
                        <tr>
                          <th>현금영수증 승인번호</th>
                          <td><?=$cash_authno ?></td>
                        </tr>
                    <tr>
                        <th>영수증 확인</th>
                        <td class="sub_content1"><a href="javascript:receiptView2('<?=$site_cd?>','<?=$ordr_idxx?>', '<?=$cash_yn?>', '<?=$cash_authno?>')"><img src="./img/btn_receipt.png" alt="현금영수증을  확인합니다." />
                        </td>
<?

                        }
?>
                </table>
<?
                    }
                }
            }
            /* = -------------------------------------------------------------------------- = */
            /* =   01-1-1. 정상 결제시 결제 결과 출력 END                                   = */
            /* ============================================================================== */
        }
        /* = -------------------------------------------------------------------------- = */
        /* =   01-1. 업체 DB 처리 정상 END                                              = */
        /* ============================================================================== */
    /* = -------------------------------------------------------------------------- = */
    /* =   01. 결제 결과 출력 END                                                   = */
    /* ============================================================================== */
?>
                    <!-- 매입 요청/처음으로 이미지 버튼 -->
                <tr>

                <div class="btnset">
                <a href="/" class="home">처음으로</a>
                </div>
                </tr>
              </tr>
            </div>
        <div class="footer">
                Copyright (c) NHN KCP INC. All Rights reserved.
        </div>
    </div>

	</form>
	<?}?>


  </body>
</html>
