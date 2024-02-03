document.querySelector(".list li").addEventListener("click",function(){
    this.classList.toggle("active");
    
  });
  var sidebarOpen = false;
var sidebar = document.getElementById("sidebar");

function openSidebar() {
  if(!sidebarOpen) {
    sidebar.classList.add("sidebar-responsive");
    sidebarOpen = true;
  }
}

function closeSidebar() {
  if(sidebarOpen) {
    sidebar.classList.remove("sidebar-responsive");
    sidebarOpen = false;
  }
}

(function () {

  var partialsCache = {}

  function getContent(fragmentId, callback){

    if(partialsCache[fragmentId]) {

      callback(partialsCache[fragmentId]);

    } else {
    
      $.get(fragmentId + ".php", function (content) {

        partialsCache[fragmentId] = content;

        callback(content);
      });
    }
  }

  function setActiveLink(fragmentId){
    $("#navbar a").each(function (i, linkElement) {
      var link = $(linkElement),
          pageName = link.attr("href").substr(1);
      if(pageName === fragmentId) {
        link.attr("class", "active");
      } else {
        link.removeAttr("class");
      }
    });
  }

  function navigate(){

    var fragmentId = location.hash.substr(1);

    getContent(fragmentId, function (content) {
      $("#content").html(content);
    });

    setActiveLink(fragmentId);
  }

  if(!location.hash) {

    location.hash = "#dashboard";
  }

  navigate();

  $(window).bind('hashchange', navigate);
}());


