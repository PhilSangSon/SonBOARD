var ext  = ".php";
var form = document.MyForm;
//현재날짜,시간
var today=new Date();
//today=today.toLocaleDateString()+today.toLocaleTimeString();
today=today.toDateString()+","+today.toTimeString();
/**
 * 좌우 공백 제거
 */
String.prototype.trim = function(){
	return this.replace(/(^\s*)|(\s*$)/g, "");
};

/**
 * 숫자체크  onkeyup="chkNum(this);"
 * @param chk
 */
function chkNum(chk) {
   var comp="0123456789";
   var string = chk.value;
   var len = string.length;

   for (var i=0;i<len;i++) {
      if (comp.indexOf(string.substring(i,i+1))<0) {
           alert("숫자로만 입력 가능합니다. 다시 입력해 주십시오");
           chk.value = "";
           chk.focus();
           return;
      }
   }
}
function chkNum2(chk) {
   var comp="0123456789";
   var string = chk.value;
   var len = string.length;

   for (var i=0;i<len;i++) {
      if (comp.indexOf(string.substring(i,i+1))<0) {
           //alert("숫자로만 입력 가능합니다. 다시 입력해 주십시오");
           chk.value = "";
           chk.focus();
           return;
      }
   }
}

/**
 * MyForm 리셋
 */
function formReset(){
	$('#MyForm').each(function(){
		this.reset();
		$( ":input" ).css("border","1px solid silver");
	});
}
function projectReset(){
	$('#Profile').each(function(){
		this.reset();
		$( ":input" ).css("border","1px solid silver");
	});
}

function confirmSave(checkbox){
	var isRemember;
	if(checkbox.checked){
		isRemember = confirm("이 PC에 로그인 정보를 저장하시겠습니까? PC방등의 공공장소에서는 개인정보가 유출될 수 있으니 주의해주세요.");
		if(!isRemember){
			checkbox.checked = false;
		}
	}
}
function setsave(name, value, expiredays){
	var today = new Date();
	today.setDate(today.getDate() + expiredays);
	document.cookie = name + "=" + escape(value) + "; path=/; expires=" + today.toGMTString() + ";"
}
function saveLogin(id){
	if(id != ""){
		setsave("c_id", id, 7);
	}else{
		setsave("c_id", id, -1);
	}
}
function getLogin(){
	var cook = document.cookie + ";";
	var idx  = cook.indexOf("c_id", 0);
	var id = "";

	if(idx != -1){
		cook = cook.substring(idx, cook.length);
		begin = cook.indexOf("=", 0) + 1;
		end = cook.indexOf(";", begin);
		id = unescape(cook.substring(begin, end));
	}

	if(id != ""){
		$("#m_id").val(id);
		document.MyForm.idcheck.checked = true;
	}
}
/**
 * 설치체크
 * @returns {Boolean}
 */
function installCheck(){
	var form = document.MyForm;
	if($.trim($("#host").val()).length <= 0){
		alert("호스트명을 입력해주세요.");	
		$("#host").val("");
		$('#host').css("border","1px solid red");
		$("#host").focus();
		return false;
	}else{
		$('#host').css("border","1px solid green");
	}
	if($.trim($("#user").val()).length <= 0){
		alert("DB 사용자 ID를 입력해주세요.");	
		$("#user").val("");
		$('#user').css("border","1px solid red");
		$("#user").focus();
		return false;
	}else{
		$('#user').css("border","1px solid green");
	}
	if($.trim($("#pass").val()).length <= 0){
		alert("DB 비밀번호를 입력해주세요.");	
		$("#pass").val("");
		$('#pass').css("border","1px solid red");
		$("#pass").focus();
		return false;
	}else{
		$('#pass').css("border","1px solid green");
	}
	if($.trim($("#db_name").val()).length <= 0){
		alert("데이터베이스명을 입력해주세요.");	
		$("#db_name").val("");
		$('#db_name').css("border","1px solid red");
		$("#db_name").focus();
		return false;
	}else{
		$('#db_name').css("border","1px solid green");
	}
	if($.trim($("#admin_id").val()).length <= 0){
		alert("관리자 아이디를 입력해주세요.");	
		$("#admin_id").val("");
		$('#admin_id').css("border","1px solid red");
		$("#admin_id").focus();
		return false;
	}else{
		$('#admin_id').css("border","1px solid green");
	}
	if($.trim($("#admin_name").val()).length <= 0){
		alert("관리자 이름을 입력해주세요.");	
		$("#admin_name").val("");
		$('#admin_name').css("border","1px solid red");
		$("#admin_name").focus();
		return false;
	}else{
		$('#admin_name').css("border","1px solid green");
	}
	if($.trim($("#admin_pass").val()).length <= 0){
		alert("관리자 비밀번호를 입력해주세요.");	
		$("#admin_pass").val("");
		$('#admin_pass').css("border","1px solid red");
		$("#admin_pass").focus();
		return false;
	}else{
		$('#admin_pass').css("border","1px solid green");
	}
	form.action="./install"+ext;
	form.submit();
}
/**
 * 로그인 체크
 * @returns {Boolean}
 */
function loginCheck(){
	var form = document.MyForm;
	if($.trim($("#m_id").val()).length <= 0){
		alert("아이디를 입력해주세요.");	
		$("#m_id").val("");
		$('#m_id').css("border","1px solid red");
		$("#m_id").focus();
		return false;
	}else{
		$('#m_id').css("border","1px solid green");
	}
	if($.trim($("#m_pass").val()).length <= 0){
		alert("비밀번호를 입력해주세요.");	
		$("#m_pass").val("");
		$('#m_pass').css("border","1px solid red");
		$("#m_pass").focus();
		return false;
	}else{
		$('#m_pass').css("border","1px solid green");
	}
	
	//form.action="?section=core/model&nowpage=memberController";
	form.action="./admin_index.php";
	form.submit();
}
/**
 * 게시판생성 체크
 * @returns {Boolean}
 */
function board_insertCheck(){
	var form = document.MyForm;
	if($.trim($("#bc_code").val()).length <= 0){
		alert("게시판코드를 입력해 주세요.");	
		$("#bc_code").val("");
		$('#bc_code').css("border","1px solid red");
		$("#bc_code").focus();
		return false;
	}else{
		$('#bc_code').css("border","1px solid green");
	}
	if($.trim($("#bc_name").val()).length <= 0){
		alert("게시판이름을 입력해 주세요.");	
		$("#bc_name").val("");
		$('#bc_name').css("border","1px solid red");
		$("#bc_name").focus();
		return false;
	}else{
		$('#bc_name').css("border","1px solid green");
	}
	
	form.action="./admin_index.php";
	form.submit();
}
/**
 * 게시판수정 체크
 * @returns {Boolean}
 */
function board_modifyCheck(){
	var form = document.MyForm;
	if($.trim($("#bc_code").val()).length <= 0){
		alert("게시판코드를 입력해 주세요.");	
		$("#bc_code").val("");
		$('#bc_code').css("border","1px solid red");
		$("#bc_code").focus();
		return false;
	}else{
		$('#bc_code').css("border","1px solid green");
	}
	if($.trim($("#bc_name").val()).length <= 0){
		alert("게시판이름을 입력해 주세요.");	
		$("#bc_name").val("");
		$('#bc_name').css("border","1px solid red");
		$("#bc_name").focus();
		return false;
	}else{
		$('#bc_name').css("border","1px solid green");
	}
	
	form.action="./admin_index.php";
	form.submit();
}
/**
 * 게시판삭제 체크
 * @returns {Boolean}
 */
function board_delete(bc_idx){
	if(confirm('게시글이 전부 삭제됩니다!\n정말 삭제하시겠습니까?')){
		var form = document.MyForm;
		$('#mode').val('boardDelete');
		form.action="./admin_index.php";
		form.submit();
	}else{
		return false;
	}
}
/**
 * 회원수정 체크
 * @returns {Boolean}
 */
function member_modifyCheck(){
	var form = document.MyForm;
	if($.trim($("#m_name").val()).length <= 0){
		alert("회원이름을 입력해 주세요.");	
		$("#m_name").val("");
		$('#m_name').css("border","1px solid red");
		$("#m_name").focus();
		return false;
	}else{
		$('#m_name').css("border","1px solid green");
	}
	if($.trim($("#m_pass").val()).length <= 0){
		alert("비밀번호를 입력해주세요.");	
		$("#m_pass").val("");
		$('#m_pass').css("border","1px solid red");
		$("#m_pass").focus();
		return false;
	}else{
		$('#m_pass').css("border","1px solid green");
	}
	form.action="./admin_index.php";
	form.submit();
}
/**
 * 회원삭제 체크
 * @returns {Boolean}
 */
function member_delete(m_idx){
	if(confirm('회원정보가 완전히 삭제됩니다!\n정말 삭제하시겠습니까?')){
		var form = document.MyForm;
		$('#mode').val('memberDelete');
		form.action="./admin_index.php";
		form.submit();
	}else{
		return false;
	}
}
/**
 * Ajax 회원 아이디 검사
 * @param value
 */
function AjaxIdCheck(value){
	//$(document).ready(function(){
		$.ajax({
			type: "POST",
			url: "./AjaxIdCheck.php",
			data: "m_id="+value,
			success: function(result){
				if(value!=""){
					if(result){
						$('#OutputId').css("color","blue");
						$('#OutputId')[0].value=value+ ' 는 사용가능 합니다.';
						$('#id_chk').val("0");
					}else{
						$('#OutputId').css("color","red");
						$('#OutputId')[0].value=value+ ' 는 사용불가 합니다.';
						$('#id_chk').val("1");
					}
				}
			},
			error: function(request, status, error){
				alert("code:"+request.status+"\n"+"message:"+request.responseText+"\n"+"error:"+error);
			}
		});
	//});
}
/**
 * 회원등록 체크
 * @returns {Boolean}
 */
function member_insertCheck(){
	var form = document.MyForm;
	if($.trim($("#m_id").val()).length <= 0){
		alert("회원아이디를 입력해 주세요.");	
		$("#m_id").val("");
		$('#m_id').css("border","1px solid red");
		$("#m_id").focus();
		return false;
	}else{
		$('#m_id').css("border","1px solid green");
	}
	if($.trim($("#m_id").val()).length <= 4 || $.trim($("#m_id").val()).length >= 20){
		alert("5 ~ 20자로 입력해 주세요.");	
		$('#m_id').css("border","1px solid red");
		$("#m_id").focus();
		return false;
	}else{
		$('#m_id').css("border","1px solid green");
	}
	if($("#id_chk").val()=="1"){
		alert("이미 사용중인 아이디 입니다.\n아이디를 확인해 주세요.");
		return false;
	}
	if($.trim($("#m_name").val()).length <= 0){
		alert("회원이름을 입력해 주세요.");	
		$("#m_name").val("");
		$('#m_name').css("border","1px solid red");
		$("#m_name").focus();
		return false;
	}else{
		$('#m_name').css("border","1px solid green");
	}
	if($.trim($("#m_pass").val()).length <= 0){
		alert("비밀번호를 입력해주세요.");	
		$("#m_pass").val("");
		$('#m_pass').css("border","1px solid red");
		$("#m_pass").focus();
		return false;
	}else{
		$('#m_pass').css("border","1px solid green");
	}
	if($.trim($("#m_passRe").val()).length <= 0){
		alert("비밀번호 확인을 입력해주세요.");	
		$("#m_passRe").val("");
		$('#m_passRe').css("border","1px solid red");
		$("#m_passRe").focus();
		return false;
	}else{
		$('#m_passRe').css("border","1px solid green");
	}
	if($("#m_pass").val() != $("#m_passRe").val()){
		alert("비밀번호가 다릅니다.");
		$('#m_pass').css("border","1px solid red");
		$("#m_passRe").val("");
		$('#m_passRe').css("border","1px solid red");
		$("#m_passRe").focus();
		return false;
	}else{
		$('#m_pass').css("border","1px solid green");
		$('#m_passRe').css("border","1px solid green");
	}
	form.action="./admin_index.php";
	form.submit();
}
/**
 * Profile 체크
 * @returns {Boolean}
 */
function profileCheck(){
	var form = document.Profile;
	if($.trim($("#ProjectName").val()).length <= 0){
		//alert("프로젝트명을 입력해주세요.");	
		$("#ProjectName").val("");
		$('#ProjectName').css("border","1px solid red");
		$("#ProjectName").focus();
		return false;
	}else{
		$('#ProjectName').css("border","1px solid green");
	}
	if($.trim($("#CompanyName").val()).length <= 0){
		//alert("회사명을 입력해주세요.");	
		$("#CompanyName").val("");
		$('#CompanyName').css("border","1px solid red");
		$("#CompanyName").focus();
		return false;
	}else{
		$('#CompanyName').css("border","1px solid green");
	}
	if($.trim($("#CompanyYear").val()).length <= 0){
		//alert("설립년도를 입력해주세요.");	
		$("#CompanyYear").val("");
		$('#CompanyYear').css("border","1px solid red");
		$("#CompanyYear").focus();
		return false;
	}else{
		$('#CompanyYear').css("border","1px solid green");
	}
	if($.trim($("#SiteTitle").val()).length <= 0){
		//alert("타이틀을 입력해주세요.");	
		$("#SiteTitle").val("");
		$('#SiteTitle').css("border","1px solid red");
		$("#SiteTitle").focus();
		return false;
	}else{
		$('#SiteTitle').css("border","1px solid green");
	}
	form.action="./profileProc"+ext;
	form.submit();
}
/**
 * 푸시 메세지
 * @returns {Boolean}
 */
function pushSendCheck(pushIdx){
	$("#pushIdx").val(pushIdx);
	var form = document.Push;
	if($.trim($("#title").val()).length <= 0){
		alert("제목을 입력해주세요.");	
		$("#title").val("");
		$('#title').css("border","1px solid red");
		$("#title").focus();
		return false;
	}else{
		$('#title').css("border","1px solid green");
	}
	if($.trim($("#msg").val()).length <= 0){
		alert("내용을 입력해주세요.");	
		$("#msg").val("");
		$('#msg').css("border","1px solid red");
		$("#msg").focus();
		return false;
	}else{
		$('#msg').css("border","1px solid green");
	}
	if($.trim($("#msg").val()).length > 2000){
		alert("글자수는 영문2000, 한글1000자로 제한됩니다.");
		$("#msg").val($("#msg").val().substring(0,2000));
		$('#msg').css("border","1px solid red");
		$("#msg").focus();
		return false;
	}else{
		$('#msg').css("border","1px solid green");
	}
	form.encoding="multipart/form-data";
	form.action="./pushSend"+ext;
	form.submit();
}
/**
 * POST 페이지이동
 * @param action
 * @param section
 * @param nowpage
 * @param mode
 * @param idx
 */
function pageGo(action, section, nowpage, mode, idx, page){
	var form = document.PageForm;
	form.section.value=section;
	form.nowpage.value=nowpage;
	form.mode.value=mode;
	form.idx.value=idx;
	form.page.value=page;
	form.action=action+ext;
	form.submit();
}
function pageDateGo(action, section, nowpage, mode, idx, page, nyear, nmonth, nday){
	var form = document.PageDateForm;
	form.section.value=section;
	form.nowpage.value=nowpage;
	form.mode.value=mode;
	form.idx.value=idx;
	form.page.value=page;
	form.nyear.value=nyear;
	form.nmonth.value=nmonth;
	form.nday.value=nday;
	form.action=action+ext;
	form.submit();
}
function pageArticleGo(action, section, nowpage, mode, idx, page){
	var form = document.PageArticleForm;
	form.section.value=section;
	form.nowpage.value=nowpage;
	form.mode.value=mode;
	form.idx.value=idx;
	form.articlePage.value=page;
	form.action=action+ext;
	form.submit();
}