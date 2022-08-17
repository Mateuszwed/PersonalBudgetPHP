const visibilityBtn = document.getElementById("visibilityBtn");
const visibilityBtn2 = document.getElementById("visibilityBtn2");
visibilityBtn.addEventListener("click", toggleVisibility);
visibilityBtn2.addEventListener("click", toggleVisibility2);

function toggleVisibility(){
	
	
	const passwordInput = document.getElementById("password");
	const icon = document.getElementById("icon");
	if(passwordInput.type == "password") {
		passwordInput.type = "text";
		icon.innerText = "visibility_off";
		
	}else{
		
		passwordInput.type = "password";
		icon.innerText = "visibility";
	}
}

function toggleVisibility2(){
	
	
	const passwordInput = document.getElementById("password2");
	const icon = document.getElementById("icon2");
	if(passwordInput.type == "password") {
		passwordInput.type = "text";
		icon.innerText = "visibility_off";
		
	}else{
		
		passwordInput.type = "password";
		icon.innerText = "visibility";
	}
}
