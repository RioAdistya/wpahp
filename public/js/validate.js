// Example starter JavaScript for disabling form submissions if there are invalid fields
(() => {
	"use strict";
	// Fetch all the forms we want to apply custom Bootstrap validation styles to
	const forms = document.querySelectorAll(".needs-validation");
	Array.from(forms).forEach((form) => {
		// Loop over them and prevent submission
		form.addEventListener(
			"submit",
			(event) => {
				if (!form.checkValidity()) {
					event.preventDefault();
					event.stopPropagation();
				} else submitform(event);
				form.classList.add("was-validated");
			}, false
		);
	});
})();
function switchvalidation() {
	let forms = document.querySelectorAll(".needs-validation");
	for (let a = 0; a < forms.length; a++) forms[a].noValidate = true;
}
function resetvalidation() {
	const forms = document.querySelectorAll(".needs-validation"),
		forminput = document.getElementsByTagName("input");
	Array.from(forms).forEach((containedform) => {
		containedform.classList.remove("was-validated");
	}, false);
	for (let a = 0; a < forminput.length; a++) 
		forminput[a].classList.remove("is-invalid");
}
