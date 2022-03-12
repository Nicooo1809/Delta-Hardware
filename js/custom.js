function loadFile(path) {
    var fileref = document.createElement("link");
    fileref.setAttribute("rel", "stylesheet");
    fileref.setAttribute("type", "text/css");
    fileref.setAttribute("href", path);
    fileref.setAttribute("id", "theme");
    document.getElementsByTagName("head")[0].appendChild(fileref);
}