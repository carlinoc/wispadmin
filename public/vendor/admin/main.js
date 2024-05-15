function slugify(str) {
    return String(str)
      .normalize('NFKD')
      .replace(/[\u0300-\u036f]/g, '')
      .trim()
      .toLowerCase()
      .replace(/[^a-z0-9 -]/g, '')
      .replace(/\s+/g, '-')
      .replace(/-+/g, '-');
}

function emptyfy(elements) {
    let message='';
    let _element=null;
    for (i=0; i<elements.length; i++) {
        if(document.getElementById(elements[i][0]).value==''){
            message += '- ' + elements[i][1] + '<br>';  
            if(_element==null){
                _element = document.getElementById(elements[i][0]);         
            }
        }
    }
    if(_element != null){
      _element.focus();
      Swal.fire({
        title: "Atención",
        html: message,
        icon: "warning",
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Aceptar"
      });
      return false;  
    } 
    return true;
}

function showErrorMsg(message){
  Swal.fire({
      title: "Atención",
      html: message,
      icon: "error",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Aceptar"
  });
}

function showSuccessMsg(message){
  Swal.fire({
      title: "Muy bien",
      html: message,
      icon: "success",
      confirmButtonColor: "#3085d6",
      confirmButtonText: "Aceptar"
  });
}

function dateToYMD(date) {
  var strArray=['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'];
  var d = date.getDate();
  var m = strArray[date.getMonth()];
  var y = date.getFullYear();
  return '' + (d <= 9 ? '0' + d : d) + '-' + m + '-' + y;
}

function getPlanType(type){
  var _type = "Simple";
  switch(type) {
    case 1:
      _type = "Simple";
      break;
    case 2:
      _type = "Duo";
      break;
  }    
  return _type;
}

(function($) {
  $.fn.inputFilter = function(callback, errMsg) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop focusout", function(e) {
      if (callback(this.value)) {
        // Accepted value
        if (["keydown","mousedown","focusout"].indexOf(e.type) >= 0){
          $(this).removeClass("input-error");
          this.setCustomValidity("");
        }
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        // Rejected value - restore the previous one
        $(this).addClass("input-error");
        this.setCustomValidity(errMsg);
        this.reportValidity();
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        // Rejected value - nothing to restore
        this.value = "";
      }
    });
  };
}(jQuery));