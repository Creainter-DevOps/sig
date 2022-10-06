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

var todo_lici = {};
var todoid = 0;

function user_navs(tenant_id, user_id) {
  if(typeof ls[tenant_id] === 'undefined') {
    return 0;
  }
  if(typeof ls[tenant_id][user_id] === 'undefined') {
    return 0;
  }
  var cc = 0;
  for (var key in ls[tenant_id][user_id].devices) {
    if (ls[tenant_id][user_id].devices.hasOwnProperty(key)) {
      cc++;
    }
  }
  return cc;
}
function sip_is_current(tenant_id, user_id) {
  for (var key in ls[tenant_id][user_id].devices) {
    if (ls[tenant_id][user_id].devices.hasOwnProperty(key)) {
      if(ls[tenant_id][user_id].devices[key].sip_current) {
        return key;
      }
    }
  }
  return false;
}
function sip_is_blocked(tenant_id, user_id) {
  for (var key in ls[tenant_id][user_id].devices) {
    if (ls[tenant_id][user_id].devices.hasOwnProperty(key)) {
      if(ls[tenant_id][user_id].devices[key].sip_blocked) {
        return true;
      }
    }
  }
  return false;
}
function sip_asignar_libre(tenant_id, user_id) {
  for (var key in ls[tenant_id][user_id].devices) {
    if (ls[tenant_id][user_id].devices.hasOwnProperty(key)) {
      if(ls[tenant_id][user_id].devices[key].sip_current) {
        return false;
      }
    }
  }
  for (var key in ls[tenant_id][user_id].devices) {
    if (ls[tenant_id][user_id].devices.hasOwnProperty(key)) {
      return key;
    }
  }
  return false;
}
function fell_get_list(tenant_id, user_id, with_client) {
  with_client = with_client || false;
  var rp = [];
  for (var tid in ls) {
    if(ls.hasOwnProperty(tid)) {
      if (tid == tenant_id) {
        for (var uid in ls[tid]) {
          if(ls[tid].hasOwnProperty(uid)) {
            if (uid != user_id) {
              for (var did in ls[tid][uid].devices) {
                if(ls[tid][uid].devices.hasOwnProperty(did)) {
                  if(with_client) {
                    rp.push(ls[tid][uid].devices[did]);
                  } else {
                    var tempo = ls[tid][uid].devices[did];
                    rp.push({
                      user: ls[tid][uid].name,
                      uid: uid,
                      sid: tempo.client.id,
                      link: tempo.link,
                    });
                  }
                }
              }
            }
          }
        }
      }
    }
  }
  return rp;
}

app.use(express.json())
app.post('/api/broadcast', (req, res) => {
  console.log('DATA', req.body);
  io.sockets.emit('caller', req.body);
  res.send('Ok');
});
io.on('connection', function(client) {
  var device = {
    id: client.id,
    user_id: null,
    tenant_id: null,
    name: null,
  };
  client.on('register', function(data) {
    console.log('Registrer', data);
    if(device.user_id !== null && false) {
      return client.emit('registred', {
        status: false,
        message: 'ya estás registrado: ' + device.user_id
      });
    }
    device.tenant_id = data.tid;
    device.user_id   = data.user_id;
    device.name      = data.user_name;

    if(typeof ls[device.tenant_id] == 'undefined') {
      ls[device.tenant_id] = [];
    }
    if(typeof ls[device.tenant_id][device.user_id] == 'undefined') {
      ls[device.tenant_id][device.user_id] = {
        user_id: device.user_id,
        name: device.name,
        devices: {},
      }
    }
    ls[device.tenant_id][device.user_id].devices[device.id] = {
      client: client,
      sip_blocked: false,
      sip_current: false,
      link: data.link,
    };

    var ll = fell_get_list(device.tenant_id, device.user_id, true);
    for(var ii in  ll) {
      if (ll[ii].client) {
        ll[ii].client.emit('fell_change', {
          type: 'add',
          sid:  client.id,
          uid:  device.user_id,
          tid:  device.tenant_id,
          link: data.link,
          name: device.name,
        });
      }
    }
    client.emit('registred', {
      type: 'register',
      status: true,
      id: device.id,
      sip: user_navs(data.user_id) == 1,
      fell: fell_get_list(device.tenant_id, data.user_id, false),
      todo: todo_lici[device.tenant_id],
    });
  });
  client.on('todo_add', function(data) {
    if(typeof data.url === 'undefined') {
      return null;
    }
    if(typeof todo_lici[device.tenant_id] === 'undefined') {
      todo_lici[device.tenant_id] = {};
    }
    data.desde = device.name;
    data.id    = ++todoid;
    todo_lici[device.tenant_id][data.id] = data;
    io.sockets.emit('todo', todo_lici[device.tenant_id]);
  });
  client.on('todo_mod', function(data) {
    if(typeof data.id === 'undefined') {
      return null;
    }
    todo_lici[device.tenant_id][data.id] = Object.assign(todo_lici[device.tenant_id][data.id], data);
    io.sockets.emit('todo_mod', todo_lici[device.tenant_id][data.id]);
  });
  client.on('todo_del', function(data) {
    if(typeof data.id === 'undefined') {
      return null;
    }
    delete todo_lici[device.tenant_id][data.id];
    io.sockets.emit('todo', todo_lici[device.tenant_id]);
  });
  client.on('sip_start', function() {
    ls[device.tenant_id][device.user_id].devices[device.id].sip_current = true;
  });
  client.on('sip_finalize', function() {
    ls[device.tenant_id][device.user_id].devices[device.id].sip_current = false;
  });
  client.on('sip_connect', function() {
    console.log('SIP:', device.user_id, device.id, true);
    ls[device.tenant_id][device.user_id].devices[device.id].sip_blocked = true;
  });
  client.on('sip_disconnect', function() {
    console.log('SIP:', device.user_id, device.id, false);
    ls[device.tenant_id][device.user_id].devices[device.id].sip_blocked = false;
  });
  client.on('sip_free', function() {
    var xfa = false;
    console.log('>>sip_free', device.id, sip_is_current(device.tenant_id, device.user_id));
    if(!sip_is_blocked(device.tenant_id, device.user_id)) {
      if((xda = sip_is_current(device.tenant_id, device.user_id)) !== false) {
        console.log('Solicitado', device.id, xda);
        ls[device.tenant_id][device.user_id].devices[xda].client.emit('sip_end', {});
        ls[device.tenant_id][device.user_id].devices[device.id].client.emit('sip_heredado', {});
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
      status: sip_is_blocked(device.tenant_id, device.user_id),
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
    if(typeof device.tenant_id === 'undefined') {
      return console.log('no registrado 0');
    }
    if(typeof device.user_id === 'undefined') {
      return console.log('no registrado 1');
    }
    if(typeof ls[device.tenant_id][device.user_id] === 'undefined') {
      return console.log('no registrado 2');
    }
    delete ls[device.tenant_id][device.user_id].devices[device.id];
    var next = null;
    if(next = sip_asignar_libre(device.tenant_id, device.user_id)) {
      ls[device.tenant_id][device.user_id].devices[next].client.emit('sip_heredado', {
        sip: true,
        heredado: true,
      });
    }
    var ll = fell_get_list(device.tenant_id, device.user_id, true);
    for(var ii in  ll) {
      if (ll[ii].client) {
        ll[ii].client.emit('fell_change', {
          type: 'del',
          uid: device.user_id,
          sid: client.id,
        });
      }
    }
  });
});

server.listen(port, () => {
  console.log('started server on port:', port);
});
