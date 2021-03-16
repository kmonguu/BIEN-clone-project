<?
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

$call = sql_fetch("SELECT COUNT(*) cnt FROM g4_call_log");
?>

<?if($bo_table){?>
	</div>
<?}?>




<style>
#snsArea { position:fixed; left:0; top:0; width:100%; height:100%; background:rgba(0,0,0,0.7); display:none; z-index:400; }

#right_q { width:611px; height:150px; position:relative; }
.rq_1 { position:absolute; top: 100px; display:none; }
.rq_2 { position:absolute; left: 222px; top:100px; z-index:999; display:none; }

.rq_btn { position:absolute; top:0px; right:0; z-index:999; }
.rq_gotop { position:absolute; bottom:0px; right:0; z-index:999; }
.rq_chat { position:absolute; bottom:87px; left:20px; z-index:999; }
</style>


<footer class="copy">
	<div class="bottom_div">
		<a href="tel:010-6226-5736" class="bottom_img"><img src="/m/images/bottom/call.jpg" /></button></a>
		<img src="/m/images/bottom/message.jpg" class="message" style="margin: 0px 10px 0px 10px;"/>
		<img src="/m/images/bottom/kakaotalk.jpg" class="kakaotalk" />
	</div>
	
	<!--
	<map name="copy" id="copy">
		<area shape="rect" coords="260,255,380,285" href="javascript:<?=$member["mb_id"] ? "adm" : "login"?>();" alt="관리자">
	</map>
	-->

	<?preg_match("/오늘:(.*),어제:(.*),최대:(.*),전체:(.*)/", $config['cf_visit'], $visit);settype($visit[0], "integer");settype($visit[1], "integer");settype($visit[2], "integer");settype($visit[3], "integer");?>

	<div style="width:640px;height:36px;font-size:18px;background:#9a958a;text-align:center;z-index:20;margin-top:20px; line-height:36px;">
					
			<div style="text-align:center; position:relative;">
				<img src="/m/images/bottom/phonecall.png" alt="전화사진" style=" margin:-3px 8px 0 0;display:inline-block; vertical-align:middle;" />
				<span style=" font-family:RixGo M; color:#fff; line-height:36px; margin:0 auto;">전화걸기를 명이 눌러보셨습니다.</span>
			</div>

			<!--
			<div style="margin:6px 0 0 30px;display:inline-block;">
				<span>Total</span>
				<span style="font-weight:bold;margin-left:8px;"><?=$visit[4]?></span>
			</div>
			-->
	</div>
	<div class="footer_div1">
		<div class="footer_div2">
			<p>
				비양 <span class="dat">·</span>
				대표자 : 심대중<br>
				주소 : 63012 제주특별자치도 제주시 옹포3길 25-2<br>
				지번주소 : 제주시 한림읍 옹포리 489번지<br>
				예약문의:010-6226-5736<span class="dat">·</span>사업자등록번호:616-86-27531<br>
				BIEN <span class="dat">·</span>Address : 25-2 Ongop 3-gil Hallim-eup Jeju-si Jeju-do Korea 63012<br>
				Tel : +82-10-6226-5736(Reservation only)<br>
				개인정보책임자 : 심대중 <span>·</span>개인정보관리자 : 심대중
			</p>
		</div>
		<div class="footer_div3">
			<span>COPYRiGHT 2020 &copy; <?=$g4['title']?> <span>BIEN</span>. ALL RIGHT RESERVED. 
			<a href="javascript:adm()"><img src="/res/images/bottom/admin.jpg" alt="admin" /></a>
			DESIGN BY <a href="javascript:m_it9()"><img src="/res/images/bottom/itnine.jpg" alt="아이티나인 로고" />
			</span>
		</div>
	</div>

</footer>
</div><!-- #menu_cover_area -->

</div><!-- #wrap -->



<?if($config["cf_kakao_key"]){?>
<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
<script>
// 사용할 앱의 Javascript 키를 설정해 주세요.
Kakao.init('<?=$config["cf_kakao_key"]?>');
</script>
<?}?>


<!--
<script>
// 카카오톡 링크 버튼을 생성합니다. 처음 한번만 호출하면 됩니다.
Kakao.Link.createTalkLinkButton({
  container: '#kakao-link-btn',
  label: '안녕하세요. <?=$config[cf_title]?>입니다.',
  image: {
    src: 'http://<?=$_SERVER[SERVER_NAME]?>/m/images/kakao_img.jpg',
    width: '300',
    height: '150'
  },
  webButton: {
	text: '<?=$config[cf_title]?>',
	url: 'http://antispam.1937.co.kr/kakaolink.php?link_url=http://<?=$_SERVER[SERVER_NAME]?>/m/' // 앱 설정의 웹 플랫폼에 등록한 도메인의 URL이어야 합니다.
  }
});
</script> -->

<?
include_once($g4[mpath]."/tail.sub.php");
?>
