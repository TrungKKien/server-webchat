var io = require('socket.io')(6001)
console.log("connected to port 6001")

io.on("connetion", function (socket){
    console.log("co nguoi tham gia " + socket.id)
})

io.on('error', function (socket){
    console.log('errer')
})

var Redis = require('ioredis')
var redis = new Redis(1000)

redis.psubcribe("*", function (errer, count){

})

redis.on('pmessage', function (partner, channel, message){
    console.log(channel)
    console.log(message)
    console.log(partner)

    message = JSON.parse(message)
    io.emit(channel + ":" + message.event , message.data.message)

    console.log('sent')
})

