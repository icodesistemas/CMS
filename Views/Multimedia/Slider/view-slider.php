<script>
	$(document).ready(function(){
		$("#button-save").live("click",function(){
			$("#frm_slider").submit();
		});
		<?php
			if(isset($_REQUEST["slider_status"])){
				echo '$("#status option[value='.$_REQUEST["slider_status"].']").attr("selected",true);';
			}
		?>
	})
</script>
<?php
	if(!isset($_REQUEST["option"]) && !isset($_REQUEST["frm"])){
		require_once "list-slider.php";
	}elseif (isset($_REQUEST["frm"]) || isset($_REQUEST["option"])) {
		require_once "craete-slider.php";
	}
?>