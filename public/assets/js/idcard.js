(function(window) {

var lastReadSuccess = false,
    readCardTimer = null,
    successTimes = 0;

var parseDate = function(str) {
    var arr = [];
    if (str) {
        var arr = str.split(/[^\d]+/);
    }
    return arr.join('-');
};

var IDCard = {

    params: {
        container: $('#idcard-object-container'),
        html: '<object classid="clsid:10946843-7507-44FE-ACE8-2B3483D179B7" id="CVR_IDCard" name="CVR_IDCard" width="0" height="0"></object>',
        interval: 300,
        stopCallback: null,
        messageCallback: null,
        times: 0
    },

    set: function() {
        if (arguments.length == 1) {
            for (var key in arguments[0]) {
                this.params[key] = arguments[0][key];
            }
        } else {
            this.params[ arguments[0] ] = arguments[1];
        }
        return this;
    },

    create: function() {
        if (this.params.container.length != 1)
            return false;
        this.params.container.html(this.params.html);
        return document.getElementById("CVR_IDCard");
    },

    support: function() {
        var card = this.create();
        return card && card.ReadCard;
    },

    read: function(successCallback, messageCallback) {
        var card = this.create();
        var self = this;
        messageCallback = messageCallback || this.params.messageCallback;
        readCardTimer = setTimeout(function() {
            var strReadResult = card.ReadCard();
            if(strReadResult == "0") {
                successCallback({
                    type: 'Resident',
                    cardNo: card.CardNo,
                    name: card.Name,
                    sex: card.Sex,
                    nation: card.Nation,
                    born: parseDate(card.Born),
                    address: card.Address,
                    issuedAt: card.IssuedAt,
                    effectedDate: parseDate(card.EffectedDate),
                    expiredDate: parseDate(card.ExpiredDate),
                    picture: card.Picture,
                    pictrueSrc: 'data:image/png;base64,' + card.Picture,
                    samId: card.SAMID
                });
                lastReadSuccess = true;
                ++successTimes;
                messageCallback('读卡成功');
                if (self.params.times <= 0 || successTimes < self.params.times ) {
                    self.read(successCallback, messageCallback);
                } else {
                    self.stop();
                }
            } else {
                if (lastReadSuccess) {
                    messageCallback('请放下一张卡片');
                } else {
                    var useless = '卡认证失败，';
                    if (strReadResult && strReadResult.indexOf(useless) == 0) {
                        strReadResult = strReadResult.substr(useless.length);
                    }
                    messageCallback(strReadResult);
                }
                lastReadSuccess = false;
                self.read(successCallback, messageCallback);
            }
        }, this.params.interval);
    },

    supportRead: function(successCallback, messageCallback) {
        messageCallback = messageCallback || this.params.messageCallback;
        if (! this.support()) {
            var func = messageCallback || alert;
            return func('此浏览器不支持身份证核验仪');
        }
        this.read(successCallback, messageCallback);
    },

    stop: function() {
        if (readCardTimer) {
            clearTimeout(readCardTimer);
            readCardTimer = null;
        }
        if (typeof this.params.stopCallback == 'function') {
            this.params.stopCallback();
        }
    }

};

if (typeof define === 'function' && define.amd) {
    define( function() { return IDCard; } );
}
else if (typeof module === 'object' && module.exports) {
    module.exports = IDCard;
}
else {
    window.IDCard = IDCard;
}

}(window));