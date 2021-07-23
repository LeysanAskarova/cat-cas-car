import $ from 'jquery';

$(function () {

  $('[data-item=likes]').each(function () {
    const $container = $(this);

    $container.on('click', function (e) {
      e.preventDefault();
      
      const type = $container.data('type');
      const href = $container.data(type + 'Href');
      
      $.ajax({
        url: href,
        method: 'POST'
      }).then(function (data) {
        $container.find('.fa-heart').toggleClass('far fas');
        $container.data('type', type === 'like' ? 'dislike' : 'like');
        $container.find('[data-item=likesCount]').text(data.likes);
      });
    });
  });
});