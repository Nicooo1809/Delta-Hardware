// NOT CLEAR
setStyle();

var pressed = false;
document.onkeydown = function (e) {
  if (e['key'] == 's') { // ctrl
    pressed = true;
  }
};
document.onkeyup = function (e) {
  if (e['key'] == 's') { // ctrl
    pressed = false;
  }
};

function toggleStyle() {
  if (getCookie("style") == "light") {
    setCookie("style", "dark", 365);
  } else {
    setCookie("style", "light", 365);
  }
  if (pressed) {
    setCookie("style", "custom", 365);
  }
  setStyle();
}

function setStyle() {
  if (getCookie("style") == "custom") {
    setCookie("style", "custom", 365);

    var head = document.getElementsByTagName('head')[0];
    var style = document.createElement('link');
    style.href = '/css/custom.css';
    style.type = 'text/css';
    style.rel = 'stylesheet';
    head.append(style);

    document.querySelectorAll("link[href='/css/dark.css']")[0].disabled = true;
    document.querySelectorAll("link[href='/css/light.css']")[0].disabled = true;
  }
  if (getCookie("style") == "dark") {
    setCookie("style", "dark", 365);
    document.querySelectorAll("link[href='/css/dark.css']")[0].disabled = false;
    document.querySelectorAll("link[href='/css/light.css']")[0].disabled = true;
  } else if (getCookie("style") == "light") {
    setCookie("style", "light", 365);
    document.querySelectorAll("link[href='/css/dark.css']")[0].disabled = true;
    document.querySelectorAll("link[href='/css/light.css']")[0].disabled = false;
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
