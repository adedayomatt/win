ROOT = '';
$('document').ready(function(){

    // initialize all tooltips
    $(function () {
    $('[data-toggle="tooltip"]').tooltip({
        html: true,
  
    })
  });
// initialize all popovers
$(function () {
    $('[data-toggle="popover"]').popover({
        html: true,
        trigger: 'hover',        
    })
  });
  $('select').select2(); //use the select2 for all selects


  $(function(){
    $('.auto-page').each(function(){
      var container = $(this);
      container.scroll(function(){
        var content = container.find('.content');
        if(content != null){
            if($(container).scrollTop() + $(container).height() >= $(content).height() - 50){
              var page = new autoPage({
                container: content
              });
              
            }
          }
      })
    })
  });

  var autoPage = function(
    options = {
    container: null,
    loadingHtml: '<div class="text-center text-muted small">loading...</div>',
    nextSelector: '',
    callback: null
  }){
      var url = $(options.nextSelector).attr('href');
      var newContentContainer = $('<div>').addClass('auto-page');
      if(url !== null){
        newContentContainer.load(url, function(response, status, xhr){
          if ( status == "error" ) {
            newContentContainer.addClass('bg-danger my-1').html( 'failed to load more' + xhr.status + " " + xhr.statusText );
          }
        });
        options.container.append(newContentContainer)
      }
    }

})

function request(url,method,data,success = null, fail = null){   //make a request asynchronously
  $.ajax({
      url: url,
      method: method,
      data: data,
      dataType: 'json'
  })
  .done(function (response, textStatus, jqXHR){
          if(success !== null){
              success(response);
          }
  })
  .fail(function (jqXHR, textStatus, errorThrown){
    if(fail !== null){
      console.log(`An error occured >>> ${textStatus}:${errorThrown}`);
      fail(textStatus);
    }
  })
}


