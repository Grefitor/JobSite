function checkLoginForm(form) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9_\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if (form.email.value == "") {
    alert("Please insert an EMAIL/USER ID.");

    form.email.focus();

    return false;
  } else if (!filter.test(form.email.value)) {
    alert("Please insert a valid EMAIL/USERID. (e.g. user@domain.ext)");
    
    form.email.focus();

    return false;
  } else if (form.password.value == "") {
    alert("Please insert a PASSWORD.");

    form.password.focus();

    return false;
  }

  return true;
}

function checkRegisterForm(form) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9_\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if (form.email.value == "") {
    alert("Please insert an EMAIL/USER ID.");

    form.email.focus();

    return false;
  } else if (!filter.test(form.email.value)) {
    alert("Please insert a valid EMAIL/USERID. (e.g. user@domain.ext)");
    
    form.email.focus();

    return false;
  } else if (form.password1.value == "") {
    alert("Please insert a PASSWORD.");

    form.password1.focus();

    return false;
  } else if (form.password2.value == "") {
    alert("Please retype the PASSWORD.");

    form.password2.focus();

    return false;
  } else if (form.password1.value != form.password2.value) {
    alert("Please insert a PASSWORD and retype the PASSWORD.");
    
    form.password1.value = "";
    form.password2.value = "";
    
    form.password1.focus();

    return false;
  }

  return true;
}

function checkForgotForm(form) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9_\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if (form.email.value == "") {
    alert("Please insert an EMAIL/USER ID.");

    form.email.focus();

    return false;
  } else if (!filter.test(form.email.value)) {
    alert("Please insert a valid EMAIL/USERID. (e.g. user@domain.ext)");
    
    form.email.focus();

    return false;
  }
  
  return true;
}

function checkInsertForm(form) {
  if (form.title.value == "") {
    alert("Please insert a TITLE.");

    form.title.focus();

    return false;
  } else if (form.description.value == "") {
    alert("Please insert a DESCRIPTION.");

    form.description.focus();
    
    return false;
  }

  return true;
}

function checkUpdateForm(form) {
  if (form.title.value == "") {
    alert("Please insert a TITLE.");

    form.title.focus();

    return false;
  } else if (form.description.value == "") {
    alert("Please insert a DESCRIPTION.");

    form.description.focus();
    
    return false;
  }

  var answer = confirm("Are you sure you want to update JOB?");
  
  if (answer) {
    return true;
  } else {
    return false;
  }
}

function popUp(address) {
  day = new Date();
  id = day.getTime();
  
  eval("page" + id + " = window.open(address, '" + id + "', 'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,width=550,height=500,left=200,top=200');");
}

function redirect(pk) {
  window.location = "./modify.php?pk=" + pk;
}

function checkDeleteForm() {
  var valid = 0;

  for (var i = 0;
       i < document.forms[0].elements.length - 1;
       i++) {
    if (document.forms[0].elements[i].checked == true) {
      valid = 1;
      
      break;
    }
  }

  if (valid == 0) {
    alert("Please select JOB(S).");

    return false;
  }

  var answer = confirm("Are you sure you want to delete JOB(S)?");
  
  if (answer) {
    return true;
  } else {
    return false;
  }
}

function checkApplyForm(form) {
  var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9_\-])+\.)+([a-zA-Z0-9]{2,4})+$/;

  if (form.name.value == "") {
    alert("Please insert a NAME.");

    form.name.focus();

    return false;
  } else if (form.email.value == "") {
    alert("Please insert an EMAIL/USER ID.");

    form.email.focus();

    return false;
  } else if (!filter.test(form.email.value)) {
    alert("Please insert a valid EMAIL/USERID. (e.g. user@domain.ext)");
    
    form.email.focus();

    return false;
  } else if (form.resume.value == "") {
    alert("Please insert a RESUME.");
    
    form.resume.focus();

    return false;
  }
  
  if (form.resume.value != "") {
    var valid = new Array('.doc', '.docx', '.mcw', '.odt', '.pdf', '.rtf', '.txt', '.wps');
	var fileName = form.resume.value;
	var fileName = fileName.toLowerCase();
	var fileValid = 0;
	
	for (i = 0;
	     i < valid.length;
		 i++) {
      if (fileName.indexOf(valid[i]) != -1)
	    fileValid = 1;
	}

    if (fileValid == 0) {
	  alert("Please insert a valid RESUME. (e.g. .doc, .docx, .mcw, .odt, .pdf, .rtf, .txt, .wps)");
	  
	  form.resume.focus();

      return false;
	}
  }
  
  if (form.message.value == "") {
    var answer = confirm("Are you sure you want to apply for this job without sending a MESSAGE?");
    
    if (!answer) {
      form.message.focus();

      return false;
    }
  }
  
  return true;
}
