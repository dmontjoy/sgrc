<script LANGUAGE="javascript">

        function check(chequeado){
		document.getElementById(chequeado).style.visibility = "visible";
		document.getElementById(chequeado).style.display = "block";
	}

	function uncheck(chequeado){
		document.getElementById(chequeado).style.visibility = "hidden";
		document.getElementById(chequeado).style.display = "none";
	};
<!-- colocar en el check onclick="if (this.checked) {check()}else {uncheck()}" -->
</script>