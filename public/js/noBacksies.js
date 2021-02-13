"use strict";


window.noBacksies = {
  _hash: "|",
  onBack: null,
  onBackStack: [],

  PlantHash: function () {
    var inx = window.location.href.indexOf('#');
    if (inx == -1) 
      window.location.href += '#';

    if (inx == -1 || inx == window.location.href.length - 1) {
      setTimeout(function () {
        if (window.location.hash == '') 
          window.location.hash = noBacksies._hash;
      }, 10);
    }
  },
  
  callBackHandler: function (func) {
    if (func == null || typeof func != 'function') 
      return;
    func();
  },
  
  handleHashChange: function () {
    var backPressed = window.location.href.substr(-1, 1) == '#';
    if (window.location.hash == '') 
      window.location.hash = noBacksies._hash;

    if (backPressed) {
      noBacksies.callBackHandler(noBacksies.onBack);
      noBacksies.callBackHandler(noBacksies.onBackStack.pop());
    }
  }
};

window.addEventListener('load', noBacksies.PlantHash);
window.addEventListener('hashchange', noBacksies.handleHashChange);
