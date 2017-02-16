$(document).ready(function () {
    // apply dropdownHover to all elements with the data-hover="dropdown" attribute
    $('[data-hover="dropdown"]').dropdownHover();
});

function getFAQ() {
    var pedido	= $.ajax({url: "?h=devolveFaq", type: "POST"});
    var faq = "";
    var p, r = "";
    pedido.done(function(saveresult){

        console.log(saveresult.length);
        for (i = 0; i < saveresult.length; i++) {
            p = saveresult[i]['Pergunta'];
            r = saveresult[i]['Resposta'];
            faq = faq + '<div class="col-xs-12 faq-entry-container clear-padding"><div id="faq-title-container" class="col-xs-12 clear-padding"><div class="col-xs-12 clear-margin clear-padding" id="faq-title"> <h5 id="faq-title-h">'+p+'</h5> </div> </div> <div id="faq-text-container" class="col-xs-12 clear-padding"> <p>'+r+'</p> </div> </div>';
        }
        $('#faq-content-container').append(faq);
    });
    pedido.fail(function(jqXHR, textStatus){
        alert("Ocorreu um erro na ligação!\nPor favor, tente novamente dentro de 1 minuto.");
    })
}

$( window ).resize(function() {
    if(!window.location.href.match(/p=/)) {
        var newest_container_height = $('#most-recent-header-container-parent').height() + $('.recent-text').height();
        $('#add_space_1').height(newest_container_height);
        $('#add_space_1').parent().height($('#most-recent-title-container').height()+newest_container_height);
    }
});



$("div#arc-cat-selector-container").on('click', '.cat', function (event) {
    event.preventDefault();
    var cat = 0;
    var section = Number($(this).parent().parent().attr('id').match(/\d+/)[0]);
    if($(this).attr('id')!="all")
    {
        cat = Number($(this).attr('id').match(/\d+/)[0]);
    }
    var campo = $(this).attr('id');
    var pedido	= $.ajax({url: "?h=printSeccao&section="+section+"&cat="+cat, type: "POST"});
    var faq = "";
    var p, r = "";
    pedido.done(function(saveresult){
        $('.cat').parent().removeClass('active');
        $('#'+campo).parent().addClass('active');
        $('#arc-list-container').html(saveresult);
        applyDDDComment();
    });
    pedido.fail(function(jqXHR, textStatus){
        alert("Ocorreu um erro na ligação!\nPor favor, tente novamente dentro de 1 minuto.");
    })
});

var bar = function (e)
{
    var container = $("#search-form-container");
    if(!$('#search-menu-li').is(e.target) && $('#search-menu-li').has(e.target).length === 0) {
        if (!container.is(e.target) // if the target of the click isn't the container...
            && container.has(e.target).length === 0) // ... nor a descendant of the container
        {
            console.log("fora");
            if ($( window ).width()>=768) {
                if($('#search-menu-btn').parent().parent().children().first().css("visibility")=="hidden") {
                    container.hide();
                    $('#search-menu-btn').parent().parent().children().css("visibility", "visible");
                }
            }
            else {
                container.toggle();
            }
            $(document).off('mouseup', bar);
        }
        else {
            console.log("dentro");
        }
    }
};

$("nav#top-menu").on('click', '#search-menu-btn', function (event) {
    event.preventDefault();
    if ($( window ).width()>=768) {
        if($(this).parent().parent().children().first().css("visibility")=="hidden") {
            $('#search-form-container').hide();
            $(this).parent().parent().children().css("visibility", "visible");
        }
        else {
            $('#search-form-container').show();
            $(this).parent().parent().children().css("visibility", "hidden");
            $(this).parent().css("visibility", "visible");
        }
    }
    else {
        $('#search-form-container').toggle();

    }
    $(document).on('mouseup', bar);
});

//search no menu do topo

$("nav#top-menu").on('click', '#search-button', function (event) {
    event.preventDefault();
    var terms =  $('#search-box').val().replace(/['"]+/g, '').split(" ");
    var length =0;
    var search_terms = "";
    for(i=0; i<terms.length; i++) {
        if ($.trim(terms[i])!="") {
            search_terms = search_terms+"&pal"+i+"="+terms[i];
            length++;
        }
    }
    console.log("?p=search&num="+length+search_terms);
    window.location.href = "?p=search&num="+length+search_terms;
});

$('#search-form input').on('keyup keypress', function(event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        var terms = $('#search-box').val().replace(/['"]+/g, '').split(" ");
        var length = 0;
        var search_terms = "";
        for (i = 0; i < terms.length; i++) {
            if ($.trim(terms[i]) != "") {
                search_terms = search_terms + "&pal" + i + "=" + terms[i];
                length++;
            }
        }
        window.location.href = "?p=search&num=" + length + search_terms;
    }
});


//pesquisa nas páginas de secção\categoria
$('#arc-search-container').on('click', '#arc-search-button', function (event) {
    event.preventDefault();
    var terms =  $('#arc-search-box').val().replace(/['"]+/g, '').split(" ");
    var length =0;
    var search_terms = "";
    for(i=0; i<terms.length; i++) {
        if ($.trim(terms[i])!="") {
            search_terms = search_terms+"&pal"+i+"="+terms[i];
            length++;
        }
    }
    var cat = 0;
    var pedido;
    if(typeof ($('#arc-cat-selector-container').children('ul').attr('id')) === 'undefined') {
        pedido	= $.ajax({url: "?h=printSearch&num="+length+search_terms, type: "POST"});
    }
    else {
        var section = Number($('#arc-cat-selector-container').children('ul').attr('id').match(/\d+/)[0]);
        if($('#arc-cat-selector-container').children('ul').find('li.active').children('.cat').attr('id')!="all")
        {
            cat = Number($('#arc-cat-selector-container').children('ul').find('li.active').children('.cat').attr('id').match(/\d+/)[0]);
        }
        pedido	= $.ajax({url: "?h=printSearch&section="+section+"&cat="+cat+"&num="+length+search_terms, type: "POST"});
    }

    pedido.done(function(saveresult){
        $('#arc-list-container').html(saveresult);
        applyDDDComment();
    });
    pedido.fail(function(jqXHR, textStatus){
        alert("Ocorreu um erro na ligação!\nPor favor, tente novamente dentro de 1 minuto.");
    })
});


$('#arc-search-form input').on('keyup keypress', function(event) {
    if (event.keyCode == 13) {
        event.preventDefault();
        var terms =  $('#arc-search-box').val().replace(/['"]+/g, '').split(" ");
        var length =0;
        var search_terms = "";
        for(i=0; i<terms.length; i++) {
            if ($.trim(terms[i])!="") {
                search_terms = search_terms+"&pal"+i+"="+terms[i];
                length++;
            }
        }
        var cat = 0;
        var pedido;
        if(typeof ($('#arc-cat-selector-container').children('ul').attr('id')) === 'undefined') {
            pedido	= $.ajax({url: "?h=printSearch&num="+length+search_terms, type: "POST"});
        }
        else {
            var section = Number($('#arc-cat-selector-container').children('ul').attr('id').match(/\d+/)[0]);
            if($('#arc-cat-selector-container').children('ul').find('li.active').children('.cat').attr('id')!="all")
            {
                cat = Number($('#arc-cat-selector-container').children('ul').find('li.active').children('.cat').attr('id').match(/\d+/)[0]);
            }
            pedido	= $.ajax({url: "?h=printSearch&section="+section+"&cat="+cat+"&num="+length+search_terms, type: "POST"});
        }
        pedido.done(function(saveresult){
            $('#arc-list-container').html(saveresult);
            applyDDDComment();
        });
        pedido.fail(function(jqXHR, textStatus){
            alert("Ocorreu um erro na ligação!\nPor favor, tente novamente dentro de 1 minuto.");
        })
    }
});


$("nav#top-menu").on('click', '.dropdown-toggle', function (event) {
    window.location.href = $(this).attr('href');
});

$(".arc-entry-info-container p").dotdotdot({
    ellipsis: '...',
    wrap: 'word',
    fallbackToLetter: true,
    watch: 'window',
    height: '100px'
});

function applyDDDComment() {
    $(".arc-entry-info-container p").dotdotdot({
        ellipsis: '...',
        wrap: 'word',
        fallbackToLetter: true,
        watch: 'window',
        height: '100px'
    });
}

$(".top-five-entry-title-container a h6").dotdotdot({
    ellipsis: '...',
    wrap: 'word',
    fallbackToLetter: true,
    watch: 'window',
    height: '70px'
});