const visibilityBtn = document.getElementById("visibilityBtn");
visibilityBtn.addEventListener("click", toggleVisibility);

function toggleVisibility(){
	
	
	const passwordInput2 = document.getElementById("inputPassword2");
	const passwordInput3 = document.getElementById("inputPassword3");
	const icon = document.getElementById("icon");
	if(passwordInput2.type == "password") {
		passwordInput2.type = "text";
		passwordInput3.type = "text";
		icon.innerText = "visibility_off";
		
	}else{
		
		passwordInput2.type = "password";
		passwordInput3.type = "password"
		icon.innerText = "visibility";
	}
}

