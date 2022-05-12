// NOT CLEAR
setStyle();

var pressedc = false;
var pressedr = false;
document.onkeydown = function (e) {
  if (e['key'] == 'c') {
    console.log('pressed');
    pressedc = true;
  }
  if (e['key'] == 'r') {
    pressedr = true;
  }
};
document.onkeyup = function (e) {
  if (e['key'] == 'c') {
    console.log('not pressed');
    pressedc = false;
  }
  if (e['key'] == 'r') {
    pressedr = false;
  }
};

function toggleStyle() {
  if (getCookie("style") == "light") {
    setCookie("style", "dark", 365);
  } else {
    setCookie("style", "light", 365);
  }
  if (pressedc) {
    setCookie("style", "custom", 365);
  }
  if (pressedr) {
    setCookie("style", "rainbow", 365);
  }
  setStyle();
}

function setStyle() {
  switch (getCookie("style")) {
    case ("custom"):
      setCookie("style", "custom", 365);
      if (document.querySelectorAll("link[href='/css/custom.css']").length > 0) {
        document.querySelectorAll("link[href='/css/custom.css']")[0].disabled = false;
      } else {
        var head = document.getElementsByTagName('head')[0];
        var style = document.createElement('link');
        style.href = '/css/custom.css';
        style.type = 'text/css';
        style.rel = 'stylesheet';
        head.append(style);
      }
      document.querySelectorAll("link[href='/css/dark.css']")[0].disabled = true;
      document.querySelectorAll("link[href='/css/light.css']")[0].disabled = true;
      if (document.querySelectorAll("link[href='/css/rainbow.css']").length > 0) {
        document.querySelectorAll("link[href='/css/rainbow.css']")[0].disabled = true;
      }
      break;
    case ("rainbow"):
      setCookie("style", "rainbow", 365);
      if (document.querySelectorAll("link[href='/css/rainbow.css']").length > 0) {
        document.querySelectorAll("link[href='/css/rainbow.css']")[0].disabled = false;
      } else {
        var head = document.getElementsByTagName('head')[0];
        var style = document.createElement('link');
        style.href = '/css/rainbow.css';
        style.type = 'text/css';
        style.rel = 'stylesheet';
        head.append(style);
      }
      document.querySelectorAll("link[href='/css/dark.css']")[0].disabled = true;
      document.querySelectorAll("link[href='/css/light.css']")[0].disabled = true;
      if (document.querySelectorAll("link[href='/css/custom.css']").length > 0) {
        document.querySelectorAll("link[href='/css/custom.css']")[0].disabled = true;
      }
      break;
    case ("dark"):
      setCookie("style", "dark", 365);
      document.querySelectorAll("link[href='/css/dark.css']")[0].disabled = false;
      document.querySelectorAll("link[href='/css/light.css']")[0].disabled = true;
      if (document.querySelectorAll("link[href='/css/custom.css']").length > 0) {
        document.querySelectorAll("link[href='/css/custom.css']")[0].disabled = true;
      }
      if (document.querySelectorAll("link[href='/css/rainbow.css']").length > 0) {
        document.querySelectorAll("link[href='/css/rainbow.css']")[0].disabled = true;
      }
      break;
    default:
      setCookie("style", "light", 365);
      document.querySelectorAll("link[href='/css/dark.css']")[0].disabled = true;
      document.querySelectorAll("link[href='/css/light.css']")[0].disabled = false;
      if (document.querySelectorAll("link[href='/css/custom.css']").length > 0) {
        document.querySelectorAll("link[href='/css/custom.css']")[0].disabled = true;
      }
      if (document.querySelectorAll("link[href='/css/rainbow.css']").length > 0) {
        document.querySelectorAll("link[href='/css/rainbow.css']")[0].disabled = true;
      }
      break;
  }
}

function setCookie(cname, cvalue, exdays) {
  const d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  let expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  let name = cname + "=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(';');
  for(let i = 0; i <ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function showPreview(event){
	var files = event.target.files;
	var preview = document.getElementById('preview');
	preview.innerHTML = '';
	for (var i = 0, f; f = files[i]; i++) { 
		preview.innerHTML += ['<div class="col"><div class="card prodcard bg-dark"><img src="', URL.createObjectURL(f), '" class="card-img-top img-fluid rounded" title="', escape(f.name), '" alt="', escape(f.name), '"></div></div>'].join('');
	}
}
