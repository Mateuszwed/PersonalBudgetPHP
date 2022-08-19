const visibilityBtn = document.getElementById("visibilityBtn");
visibilityBtn.addEventListener("click", toggleVisibility);


function toggleVisibility(){
	
	
	const inputPassword = document.getElementById("inputPassword");
	const icon = document.getElementById("icon");
	if(inputPassword.type == "password") {
		inputPassword.type = "text";
		icon.innerText = "visibility_off";
		
	}else{
		
		inputPassword.type = "password";
		icon.innerText = "visibility";
	}
}

