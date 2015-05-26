<?php
if($nowpage){

	if(!$section){
		$section="pages";
	}

	$path=$section."/".$nowpage.".php";

	if(file_exists($path)){
		include($path);
	}else{
		echo "
		<div id='page-wrapper'>

            <div class='container-fluid'>

                <!-- Page Heading -->
                <div class='row'>
                    <div class='col-lg-12'>
                        <h1 class='page-header'>
                            해당페이지를 찾을수 없습니다.
                            <small>Page Not Found</small>
                        </h1>
                        <ol class='breadcrumb'>
                            <li>
                                <i class='fa fa-dashboard'></i>  <a href='./admin_index.php'>관리자</a>
                            </li>
                            <li class='active'>
                                <i class='fa fa-file'></i> 404 page not found.
                            </li>
                        </ol>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
				";
	}

}else{
	include("view/admin/main.php");
}
?>