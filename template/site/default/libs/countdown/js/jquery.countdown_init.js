$(function() {


    function calcTime(offset) {

        // create Date object for current location
        d = new Date();

        // convert to msec
        // add local time zone offset 
        // get UTC time in msec
        utc = d.getTime() + (d.getTimezoneOffset() * 60000);

        // create new Date object for different city
        // using supplied offset
        nd = new Date(utc + (3600000 * offset));

        // return time as a string
        return nd;

    }




    function liftOff() {
        document.getElementById("l2b_start_title").style.display = "none";
    }
    var year_l2b = 2047;
    var month_l2b = 12;
    var day_l2b = 30;
    var hour_l2b = 6;
    var minute_l2b = 18;
    var second_l2b = 00;
    var timezone_l2b = +3;
    var text_l2b = '<span class="over">Сервер успешно стартовал!</span>';
    var newDate = calcTime(timezone_l2b);

    month_l2b = month_l2b - 1;
    $(function() {
        var austDay = new Date(year_l2b, month_l2b, day_l2b, hour_l2b, minute_l2b, second_l2b);
        var nowDate = new Date();
        if (austDay.getTime() > newDate.getTime()) {
            $('#defaultCountdown').countdown({ until: austDay, format: 'dHMs', timezone: timezone_l2b, expiryText: text_l2b, onExpiry: liftOff });
            $('#year').text(austDay.getFullYear());
        } else {
            document.getElementById("l2b_start_title").innerHTML = text_l2b;
            document.getElementById("defaultCountdown").style.display = "none";
        }
    });
});