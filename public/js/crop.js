function crop(e, img_src, confirmBtn, modalBox) {
    var x1, y1, x2, y2;
    var jcrop_api;

    function setApi() {
        $('#' + img_src).Jcrop({
            onChange: showCoords,
            onSelect: showCoords
        }, function () {
            jcrop_api = this;
            jcrop_api.setOptions({aspectRatio: 1 / 1});
            jcrop_api.setOptions({minSize: [100, 100]});
            jcrop_api.setOptions({setSelect: [0,0,100,100]});
        });

        function showCoords(c) {
            if(c.y < 0 || c.x < 0){
                x1 = 0;
                y1 = 0;
                x2 = 100;
                y2 = 100;
            }else{
                x1 = c.x;
                y1 = c.y;
                x2 = c.x2;
                y2 = c.y2;
            }
            changeJcropSelectionTopBack();
        }
    }

    if (e.currentTarget.files[0]) {
        var file = e.currentTarget.files[0];
        var reader = new FileReader();
        reader.onloadend = function () {
            $('.jcrop-active').replaceWith('');
            $('#' + img_src).replaceWith('<img id="'+ img_src +'" src="' + reader.result + '"/>');
            setApi();
        }
        reader.readAsDataURL(file);
    } else {
        $('#' + img_src).attr('src', '');
    }

    function changeJcropSelectionTop(){
        $('.jcrop-selection').addClass('jcrop-selection-top');
    }
    function changeJcropSelectionTopBack(){
        $('.jcrop-selection').removeClass('jcrop-selection-top');
    }

    setApi();
    setTimeout(changeJcropSelectionTop, 100);

    $(confirmBtn).click(function () {
        var wigth = $('.jcrop-active').width();         //width picture on screen
        var natural_width = $('canvas').attr('width');  //natural width picture
        var mas = [x1, y1, x2, y2, wigth, natural_width];
        $('.coords').attr('value', mas);
        jcrop_api.destroy();
        $('#' + img_src).removeAttr('style');
        $(modalBox).modal('hide');
    });

    $('#closeModalBtn').on('hidden.bs.modal', function () {
        $('.coords').attr('value', '');
        $("#img-src").replaceWith($("#img-src").val('').clone(true));
    })
}