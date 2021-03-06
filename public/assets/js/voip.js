class WebPhoneSession {
  constructor(session, web, index, display_name) {
    let ce = this;
    this.display_name = this.display_name || session.remote_identity.display_name;
    this.index = index;
    this.session = session;
    this.web = web;
    this.interval = null;
    this.card = null;
    this.is_connect = false;
    this.is_connect_time = 0;
    this.is_muted = false;


    this.render();


    this.session.on("accepted", function(){
      console.log('SESSION: Accep');
      ce.card.find('.sip_header .sip_header_bottom').text('ACEPTADO');
    });
    this.session.on("confirmed", function(){
      ce.is_connect = true;
      console.log('SESSION: Confirm');
      ce.card.find('.sip_header .sip_header_bottom').text('CONECTADO');
      ce._start();
    });
    this.session.on("ended", function(){
      ce.is_connect = false;
      console.log('SESSION: End');
      ce.card.find('.sip_header .sip_header_bottom').text('FINALIZADO ' + ce.is_connect_time);
      ce._end();
    });
    this.session.on("failed", function() {
      ce.is_connect = false;
      console.log('SESSION: Fail');
      ce.card.find('.sip_header .sip_header_bottom').text('FALLÓ');
      ce._end();
    });
    this.session.on('addstream', function(e){
      var inaudio = web.bocina;
      inaudio.srcObject = data.stream;
    });

    this.card.find('.sip_header .sip_header_middle').text(this.display_name);
    this.card.find('.sip_header .sip_header_bottom').text('CONECTANDO...');

    if(this.session._direction == 'incoming') {
      console.log('ENTRADA DE LLAMADA', this.session);
      this.card.find('.sip_header .sip_header_top').text('LLAMADA ENTRANTE');
      this.card.find('.sip_button_call').on('click', function() {
        console.log('CONTESTAR!', ce.web._options);
        ce.session.answer(ce.web._options);
        ce.web.ring_call.pause();
        ce.session.connection.onaddstream = function(data){
          ce.web.sound_out(data.stream);
        };
      });

    } else if(this.session._direction == 'outgoing') {
      console.log('SALIDA DE LLAMADA', this.session);
      this.card.find('.sip_header .sip_header_top').text('LLAMADA SALIENTE');
      ce.session.connection.onaddstream = function(data) {
        ce.web.sound_out(data.stream);
      };
      this._start();
    }
    this._intent();
  }
  _intent() {
    let ce = this;
    if(this.session._direction == 'incoming') {
      ce.web.ring_audio.play();
    }
    this.card.find('.sip_button_end').on('click', function() {
      ce.session.terminate();
    });
    this.card.find('.sip_button_mute').on('click', function() {
      ce.mute();
    });
  }
  _start() {
    console.log('=====> _START()');
    let ce = this;
    ce.web.ring_audio.pause();
    ce.web.socketWeb.emit('sip_connect', {});
    this.interval = setInterval(() => {
      if(ce.session.isEstablished()) {
        ce.is_connect_time ++;
        ce.card.find('.sip_header .sip_header_bottom').text('CONECTADO ' + ce.is_connect_time);
      } else {
        ce.is_connect_time = 0;
      }
    }, 1000);
  }
  _end() {
    if(this.session.isEstablished()) {
      this.session.terminate();
    }
    let ce = this;
    ce.web.socketWeb.emit('sip_disconnect', {});
    ce.web.ring_audio.pause();
    this.card.find('.sip_button_end').on('click', function() {
      ce.end();
    });
    this.card.find('.sip_keypad').slideUp(700);
    this.card.find('.sip_actions').slideUp(800, () => {
      ce.card.addClass('sip_terminate');
    });
    if(this.interval) {
      clearInterval(this.interval);
    }
  }
  body() {
    return this.web.conf.dom;
  }
  container() {
    return $(this.body()).find('.sip_sessions')[0];
  }
  direction() {
    return this.session.direction;
  }

  render() {
    let ce = this;
    console.log('RENDERIZAR PARA: ', this.session._direction);
    console.log('SESSION', this.session);
    this.card = $('<div>').addClass('sip_card');
    let display = this.display_name || this.session.remote_identity.display_name;

    this.card.addClass('sip_' + this.session._direction);

    let header = $('<div>').addClass('sip_header');
    header.append($('<div>').addClass('sip_header_top'));
    header.append($('<div>').addClass('sip_header_middle'));
    header.append($('<div>').addClass('sip_header_bottom'));
    this.card.append(header);


    let actionsc = $('<div>').addClass('sip_actions');
    let actions  = $('<div>').addClass('row no-wrap is-gapless is-mobile');
    actions
      .append($('<div>')
        .html($('<div>').addClass('sip_button sip_button_call').html('<i class="bx bxs-phone"></i>')));
      actions.append($('<div>')
        .html($('<div>').addClass('sip_button sip_button_end').html('<i class="bx bxs-phone"></i>')));
      actions.append($('<div>')
        .html($('<div>').addClass('sip_button sip_button_mute').html('<i class="bx bxs-volume-mute"></i>')));
      actions.append($('<div>')
        .html($('<div>').addClass('sip_button sip_button_pad').html('<i class="bx bx-dialpad"></i>')));
      actions.append($('<div>')
        .html($('<div>').addClass('sip_button sip_button_conf disabled').html('<i class="bx bx-at"></i>')));
      actions.append($('<div>')
        .html($('<div>').addClass('sip_button sip_button_dire disabled').html('<i class="bx bxs-send"></i>')));
    actionsc.append(actions);
    this.card.append(actionsc);

    let keys = [1,2,3,4,5,6,7,8,9,0,'*','#'];
    let keypad = $('<div>').addClass('sip_keypad');
    for(var i = 0; i < keys.length; i++) {
      keypad.append($('<div>').addClass('sip_pad_row')
        .html($('<div>').addClass('sip_pad_key').attr('data-key', keys[i]).text(keys[i]).on('click', function() {
        ce.key($(this).attr('data-key'));
      })));
    }
    this.card.append(keypad);

    $(this.container()).prepend(this.card);
    return this;
  }

  key(c) {
    this.session.sendDTMF(c);
    return this;
  }
  mute() {
    console.log('Muted', this.is_muted, this.session.isEstablished());
    if(this.session.isEstablished() || true) {
      if(!this.is_muted) {
        this.session.mute({audio: true});
        this.card.find('.sip_button_mute').addClass('selected');
      } else {
        this.session.unmute({audio: true});
        this.card.find('.sip_button_mute').removeClass('selected');
      }
      this.is_muted = !this.is_muted;
    }
    if(sessioncall){
                          if(mutear == 0){
                               sessioncall.mute({audio: true});
                               mutear = "1";
                          }
                          else{
                               //mutear call
                               this.sessioncall.unmute({audio: true});
                               mutear = "0";
                          }
         }
  }
}

class WebPhone {
  constructor(config) {
    let ce  = this;
    this.conf  = config;
    this._socket    = null;
    this._ososes1   = null;

    this.sessions = {};
    this.csessions = 0;

    this.socketWeb = config.socket || false;

    this.ring_audio = new Audio("/sounds/sounds_ringing.mp3");
    this.ring_call = new Audio("/sounds/sounds_calling.mp3");
    this.ring_audio.loop = true;
    this.ring_call.loop = true;

    this.bocina = document.createElement("audio");
    this.bocina.setAttribute("id","audioelement");

    this._eventHandlers = {
      'progress': function(e) {
        console.log('call is in progress');
      },
      'failed': function(e) {
        console.log('call failed with cause: '+ e.cause);
        ce.ring_call.pause();
      },
      'ended': function(e) {
        console.log('call ended with cause: '+ e.cause);
        ce.ring_call.pause();
      },
      'confirmed': function(e) {
        console.log('call confirmed');
        ce.ring_call.pause();
      }
    };
    this._options = {
      'eventHandlers': this._eventHandlers,
      mediaConstraints: {
        'audio': true,
        'video': false,
      },
      rtcOfferConstraints: {
        'offerToReceiveAudio': true,
        'offerToReceiveVideo': false
      },
      sessionTimersExpires: 7200
    };
  }
  configure() {
    JsSIP.debug.enable('JsSIP:WebSocketInterface');
    this._socket = new JsSIP.WebSocketInterface(this.conf.wsif);
    let configuration = {
      sockets  : [ this._socket ],
      uri      : 'sip:' + this.conf.username + '@' + this.conf.server,
      authorization_user: this.conf.username,
      password : this.conf.password,
      register_expires: 20,
      contact_uri: 'sip:' + this.conf.username + '@' + this.conf.server,
    };
    this._ososes1 = new JsSIP.UA(configuration);
    return this;
  }
  connect() {
    let ce = this;
    this._ososes1.start();
    this._ososes1.on("registered", function() {
      console.log('se registró');
      $(ce.conf.dom).find('.sip_connection').attr('data-sip-status', 'ok').text('Linea conectada');
    });
    this._ososes1.on("unregistered", function() {
      $(ce.conf.dom).find('.sip_connection').attr('data-sip-status', 'bad').text('Linea desconectada');
      console.log("se des-registro");
    });
    this._ososes1.on("newRTCSession", function(data) {
      console.log('newRTC', data);
      navigator.mediaDevices.getUserMedia({ audio: true }).then(function(stream) {
        console.log('se usara solo el mic');
          let session = ce.session(data.session);
      }).catch(function(err) {
        console.log('No habra mic :(');
      });
    });
    return this;
  }
  disconnect() {
    let ce = this;
    this._ososes1.stop();
    this._ososes1 = null;
  }
  sound_out(stream) {
    this.bocina.srcObject = stream;
    this.bocina.play();
  }
  containter() {
    return this.conf.dom;
  }
  render() {
    let ce = this;
    $(this.conf.dom).addClass('sip_body sip_close');
    $(this.conf.dom).append($("<div>").addClass('sip_connection').attr('data-sip-status','loading').text('Conectando...').on('click', function() {
      if($(ce.conf.dom).hasClass('sip_open')) {
        $(ce.conf.dom).removeClass('sip_open').addClass('sip_close');
      } else {
        $(ce.conf.dom).removeClass('sip_close').addClass('sip_open');
      }
    }));
    $(this.conf.dom).append($("<div>").addClass('sip_sessions'));
    $(this.conf.dom).slideDown();
    return this;
  }
  start() {
    this.socketWeb.emit('sip_start', {});
    return this.configure().connect().render();
  }
  finalize() {
    this.socketWeb.emit('sip_finalize', {});
    $(this.conf.dom).empty().slideUp();
    return this.disconnect();
  }
  session(se) {
    console.log('CLICK SESSION');
    this.csessions ++;
    let sess = new WebPhoneSession(se, this, this.csessions, this.display_name);
    this.sessions[this.csessions] = sess;
    delete this.display_name;
    this.open();
    return sess;
  }
  socket() {
    return this._socket;
  }
  ososes1() {
    return this._ososes1;
  }
  outgoing(number, display_name) {
    var ce = this;
    if(!this.ososes1()) {
      if(!this.socketWeb) {
        return alert('No existe un conexión');
      } else {
        console.log('solicitando permiso');
        setTimeout(function() {
          if(!ce.ososes1()) {
            alert('No es posible conectarse');
          } else {
            ce.outgoing(number, display_name);
          }
        }, 800);
        return this.socketWeb.emit('sip_free', {});
      }
    }
    console.log('this.is_connect', this._ososes1.isConnected());
    this.display_name = display_name;
    this.ososes1().call("sip:" + number + "@" + this.conf.server, this._options);
    return this;
  }
  open() {
    $(this.containter()).removeClass('sip_close').addClass('sip_open');
  }
  close() {
    $(this.containter()).removeClass('sip_open').addClass('sip_close');
  }
}
