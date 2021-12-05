const fs = require('fs');
const express = require("express");
const https = require('https');


var app = express();
var server = https.createServer({
  key: fs.readFileSync('/etc/letsencrypt/live/sig.creainter.com.pe/privkey.pem'),
  cert: fs.readFileSync('/etc/letsencrypt/live/sig.creainter.com.pe/fullchain.pem')
}, app);
var io = require('socket.io')(server, {
  cors: {
    origin: '*',
  }
});
var port = 4001;

var ls = {};


function user_navs(user_id) {
  if(typeof ls[user_id] === 'undefined') {
    return 0;
  }
  var cc = 0;
  for (var key in ls[user_id].devices) {
    if (ls[user_id].devices.hasOwnProperty(key)) {
      cc++;
    }
  }
  return cc;
}
function sip_is_current(user_id) {
  for (var key in ls[user_id].devices) {
    if (ls[user_id].devices.hasOwnProperty(key)) {
      if(ls[user_id].devices[key].sip_current) {
        return key;
      }
    }
  }
  return false;
}
function sip_is_blocked(user_id) {
  for (var key in ls[user_id].devices) {
    if (ls[user_id].devices.hasOwnProperty(key)) {
      if(ls[user_id].devices[key].sip_blocked) {
        return true;
      }
    }
  }
  return false;
}
function sip_asignar_libre(user_id) {
  for (var key in ls[user_id].devices) {
    if (ls[user_id].devices.hasOwnProperty(key)) {
      if(ls[user_id].devices[key].sip_current) {
        return false;
      }
    }
  }
  for (var key in ls[user_id].devices) {
    if (ls[user_id].devices.hasOwnProperty(key)) {
      return key;
    }
  }
  return false;
}

io.on('connection', function(client) {
  var device = {
    id: client.id,
    user_id: null,
  };
  client.on('register', function(data) {
    console.log('Registrer', data);
    if(device.user_id !== null) {
      return client.emit('registred', {
        status: false,
        message: 'ya estás registrado: ' + device.user_id
      });
    }
    device.user_id = data.user_id;
    if(typeof ls[device.user_id] == 'undefined') {
      ls[device.user_id] = {
        user_id: device.user_id,
        devices: {},
      }
    }
    ls[device.user_id].devices[device.id] = {
      client: client,
      sip_blocked: false,
      sip_current: false,
    };
    client.emit('registred', {
      type: 'register',
      status: true,
      sip: user_navs(data.user_id) == 1,
    });
  });
  client.on('sip_start', function() {
    ls[device.user_id].devices[device.id].sip_current = true;
  });
  client.on('sip_finalize', function() {
    ls[device.user_id].devices[device.id].sip_current = false;
  });
  client.on('sip_connect', function() {
    console.log('SIP:', device.user_id, device.id, true);
    ls[device.user_id].devices[device.id].sip_blocked = true;
  });
  client.on('sip_disconnect', function() {
    console.log('SIP:', device.user_id, device.id, false);
    ls[device.user_id].devices[device.id].sip_blocked = false;
  });
  client.on('sip_free', function() {
    var xfa = false;
    console.log('>>sip_free', device.id, sip_is_current(device.user_id));
    if(!sip_is_blocked(device.user_id)) {
      if((xda = sip_is_current(device.user_id)) !== false) {
        console.log('Solicitado', device.id, xda);
        ls[device.user_id].devices[xda].client.emit('sip_end', {});
        ls[device.user_id].devices[device.id].client.emit('sip_heredado', {});
        return true;
      } else {
        console.log('casss1: no se encuentra un current');
      }
    } else {
      console.log('casss2: no es posible ya que está bloqueado');
    }
    return console.log('No disponible');
    client.emit('sip_free', {
      type: 'blocked',
      status: sip_is_blocked(device.user_id),
    });
  });
  client.on('broadcast', function(data) {
    io.sockets.emit('broadcast', data);
  });
  client.on('message', function(data) {
    console.log('mensaje', data);
  });
  client.on('disconnect', function(){
    console.log('desconectado');
    if(typeof device.user_id === 'undefined') {
      return console.log('no registrado 1');
    }
    if(typeof ls[device.user_id] === 'undefined') {
      return console.log('no registrado 2');
    }
    delete ls[device.user_id].devices[device.id];
    var next = null;
    if(next = sip_asignar_libre(device.user_id)) {
      ls[device.user_id].devices[next].client.emit('sip_heredado', {
        sip: true,
        heredado: true,
      });
    }
  });
});

server.listen(port, () => {
  console.log('started server on port:', port);
});
