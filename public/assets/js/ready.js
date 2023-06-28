
function readyLoad(cb) {
  if(typeof window.fn_ready_is !== 'undefined') {
    return cb();
  }
  if(typeof window.fn_ready === 'undefined') {
    window.fn_ready = [];
  }
  window.fn_ready.push(cb);
}
function callReadyLoad() {
  window.fn_ready_is = true;
  for(var index in window.fn_ready) {
    if(window.fn_ready.hasOwnProperty(index)) {
      window.fn_ready[index]();
    }
  }
}
