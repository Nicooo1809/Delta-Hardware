function toggleStyle() {
  if (this.checked) {
    setCookie("style", "dark", 36500);
  } else {
    setCookie("style", "light", 36500);
  }
  if (getCookie("style") == "dark") {
    //document.getElementById("theme_css").remove()
    var fileref = document.createElement("link");
    fileref.setAttribute("rel", "stylesheet");
    fileref.setAttribute("type", "text/css");
    fileref.setAttribute("href", "/css/dark.css");
    //fileref.setAttribute("id", "theme_css");
    document.getElementsByTagName("head")[0].appendChild(fileref);
  } else {
    //document.getElementById("theme_css").remove()
    var fileref = document.createElement("link");
    fileref.setAttribute("rel", "stylesheet");
    fileref.setAttribute("type", "text/css");
    fileref.setAttribute("href", "/css/light.css");
    //fileref.setAttribute("id", "theme_css");
    document.getElementsByTagName("head")[0].appendChild(fileref);
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